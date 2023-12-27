const { Client, LegacySessionAuth, LocalAuth } = require("whatsapp-web.js");
const fs = require("fs");
const express = require("express");
const qrPlugin = require("qrcode");
const path = require("path");
var emitter = require("events").EventEmitter;
var eventLocal = new emitter();

const app = express();
const PORT = process.env.PORT || 3000;

app.use(express.json());
app.use(express.urlencoded({ extended: false }));

var dirQR = "./qr";
if (!fs.existsSync(dirQR)) fs.mkdirSync(dirQR);

let dateTime = new Date();
const axios = require("axios");

let authType = new LocalAuth({ clientId: "pertama" });

const puppeteerOptions = {
    qrTimeoutMs: 60000, //Timeout for qr code selector in puppeteer
    authStrategy: authType,
    puppeteer: {
        headless: true, //for not show engine activity in window
    },
    args: [
        "--disable-setuid-sandbox",
        "--no-sandbox",
        "--unhandled-rejections=strict",
        "--disable-dev-shm-usage",
        "--disable-accelerated-2d-canvas",
        "--no-first-run",
        "--no-zygote",
        "--disable-gpu",
    ],
    userAgent:
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36",
};
const client = new Client(puppeteerOptions);

client.on("qr", (qr) => {
    qrPlugin.toDataURL(qr, (err, src) => {
        var base64Data = src.replace(/^data:image\/png;base64,/, "");
        fs.writeFile(
            __dirname + "/qr/qr_utama.png",
            base64Data,
            "base64",
            function (err) {
                console.log(dateTime + " [+] Generate New QR");
            }
        );
    });
});

client.on("authenticated", (session) => {
    console.log(dateTime + ` [+] Saved Auth Session`);

    eventLocal.emit("utama", "ACTIVE");
    const state = "SUCCESS_CREATE_INSTANCE";
    sendWebHook("INSTANCE", state);
});

client.on("auth_failure", async (msg) => {
    console.log(dateTime + " [+] auth_failure", msg);
});

client.on("ready", () => {
    console.log(dateTime + " [+] Client Is Active");
    deleteFile(__dirname + "/qr/qr_utama.png");
});

client.on("message", async (msg) => {
    console.log(dateTime + " [INBOX] Receive New Message");

    let message = await msg.body;
    //send webhook
    let dataMsg = {
        id_msg: await msg.id.id,
        type: "text",
        from: await msg.from,
        content: message,
    };
    if (message !== "") {
        sendWebHook("INBOX_MESSAGE", "", dataMsg);
    }
});

client.on("message_ack", (msg, ack) => {
    console.log(dateTime + " [+] DLR, ID : " + msg.id.id, ", ACK : " + ack);

    data = {
        destination: msg.to,
        msg: "null",
        ack: msg.ack,
        id: msg.id.id,
    };

    sendWebHook("DLR", "", data);

    /*
        == ACK VALUES ==
        ACK_ERROR: -1
        ACK_PENDING: 0              //waiting network
        ACK_SERVER: 1               //ceklis 1
        ACK_DEVICE: 2               //ceklist 2
        ACK_READ: 3                 //ceklist 2 and read
        ACK_PLAYED: 4
    */
});

client.on("disconnected", (reason) => {
    console.log(dateTime + " [+] Client is disconnect", reason);

    const state = "DISCONNECT";
    sendWebHook("INSTANCE", state);
    client.destroy();
    deleteFolderSWCache();
});

client.initialize();

/* app.get("/qr", function (req, res) {
    try {
        let qrPathFile = __dirname + `/qr/qr_utama.png`;
        if (fs.existsSync(qrPathFile)) {
            res.sendFile(qrPathFile);
        } else {
            res.status(404);
            res.send({ code: 404, details: "QR Not Found", data: [] });
        }
    } catch (e) {
        res.send({ code: 500, details: "Internal Server Error", data: e });
    }
}); */

function checkHeader(req, res, next) {
    const AUTH_TOKEN = process.env.AUTH_TOKEN || "PuRn4nD1990";
    if (req.headers["x-purnand-token"] !== AUTH_TOKEN) {
        return res.status(401).json({ error: "Auth Headers Unauthorized" });
    }
    next();
}

app.get("/qr", checkHeader, async (req, res) => {
    try {
        let qrPathFile = path.join(__dirname, `qr/qr_utama.png`);
        fs.readFile(qrPathFile, (err, data) => {
            if (err) {
                res.status(404).send({
                    code: 404,
                    details: "Image not found",
                    data: [],
                });
            } else {
                const base64Image = Buffer.from(data).toString("base64");
                const mimeType = "image/png";
                const imageSrc = `<img src='data:${mimeType};base64,${base64Image}'/>`;
                res.status(200).send({
                    code: 200,
                    details: "Success get QR Code",
                    data: imageSrc,
                });
            }
        });
    } catch (error) {
        const response = {
            code: 500,
            details: "Instance Not Available",
            data: error,
        };
        res.status(500).json(response);
    }
});

app.get("/status", checkHeader, function (req, res, next) {
    let dateTime = new Date();
    try {
        client
            .getState()
            .then((result) => {
                res.status(200);
                res.send({ code: 200, details: "Ok", data: result });

                sendWebHook("INSTANCE", result);
                console.log(dateTime + " [+] GET INSTANCE STATUS: ", result);
            })
            .catch((err) => {
                res.status(500);
                res.send({
                    code: 500,
                    details: "Instance Not Rensponse",
                    data: err,
                });
            });
    } catch (e) {
        res.status(500);
        res.send({ code: 500, details: "Internal Server Error", data: e });
    }
});

app.post("/send-message", checkHeader, async (req, res) => {
    const bodyData = req.body;
    try {
        const respMsg = await client.sendMessage(
            `${bodyData.destination}@c.us`,
            bodyData.message
        );

        const response = {
            code: 200,
            details: "Ok",
            data: {
                destination: bodyData.destination,
                destination_in_wa: `${bodyData.destination}@c.us`,
                id_message: respMsg.id.id,
            },
        };
        res.status(200).json(response);
    } catch (error) {
        const response = {
            code: 500,
            details: "Instance Not Available",
            data: error,
        };
        res.status(500).json(response);
    }
});

app.get("/instance-refresh", checkHeader, function (req, res) {
    client.initialize();
    res.status(200).json({
        code: 200,
        details: "Refresh...",
        data: [],
    });

    eventLocal.once("utama", async function (payload) {
        if (payload == "ACTIVE") {
            try {
                console.log(dateTime + " [CLEANING] Cleaning WA Page");

                const mainPage = await client.pupBrowser.newPage();
                await mainPage.goto("https://web.whatsapp.com", {
                    waitUntil: "load",
                    timeout: 0,
                    referer: "https://whatsapp.com/",
                });
                console.log(dateTime + " [CLEANING] Success Cleaning WA Page");
                await sleep(5000);

                await mainPage.close();

                client.destroy();
                client.initialize();

                console.log(dateTime + " [REFRESH] Success Refresh WA Page");
            } catch (e) {
                console.log(
                    dateTime + " [REFRESH FAILED] Failed Refresh WA Page"
                );
            }
        }
    });
});

app.get("/disconnect", checkHeader, function (req, res) {
    client.destroy();
    client.initialize();
    deleteFolderSWCache();
    res.status(200).json({
        code: 200,
        details: "Disconnect...",
        data: [],
    });
});

async function sendWebHook(type, state = null, data = {}) {
    var url = "http://localhost:8000/api/dlr/listen-dlr";
    let dateTime = new Date();

    await axios
        .post(url, {
            type: type,
            state: state,
            data: data,
        })
        .then((resp) => {
            console.log(dateTime + "[+] Send WebHook Success");
        })
        .catch((err) => {
            console.log(dateTime + "[+] Error SendWebHook");
            // console.log(err);
        });
}

function deleteFile(path) {
    fs.unlink(path, (err) => {
        if (err) {
            return true;
        }
    });
}

function deleteFolderSWCache() {
    let dateTime = new Date();

    try {
        fs.rm(__dirname + "/.wwebjs_auth", { recursive: true }, (err) => {
            if (err) {
                console.error(err);
                console.log(" [+] Failed Deleted Session SWCache Folder");
            } else {
                console.log(" [+] Success Deleted Session SWCache Folder");
            }
        });
    } catch (e) {
        console.log(dateTime + " [+] Error deleteFolderSWCache");
    }
}

const server = process.env.SERVER || "http://localhost";
app.listen(PORT, () => {
    console.log(`Server is running on ${server}:${PORT}`);
}).on("error", (err) => {
    console.log(err);
});
