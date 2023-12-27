<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Chatbot;
use App\Models\ChatbotSession;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DlrController extends Controller
{
    public function index(Request $request)
    {
        if ($request['type'] == 'INBOX_MESSAGE') {
            $data = $request['data'];
            $no_hp = explode("@", $data['from']);

            //check session
            $check = ChatbotSession::where('no_hp', $data['from'])->first();
            $status = true;
            if ($check) {
                if (strtolower(trim($data['content'])) == 'back' || strtolower(trim($data['content'])) == '0') {
                    $chatbot_ = Chatbot::where('id', $check->chatbot_id)->first();
                    $chatbot = Chatbot::where('id', $chatbot_->parent_id)->first();
                    $chatbot_id = $chatbot->id;
                    $description = $chatbot->description;
                } else if (strtolower(trim($data['content'])) == 'exit') {
                    ChatbotSession::where('id', $check->id)->delete();
                    $description = 'terimakasih telah menggunakan chatbot kami.';
                } else {
                    $chatbot = Chatbot::where([
                        'parent_id' => $check->chatbot_id,
                        'keyword' => trim($data['content']),
                        'status' => 1
                    ])->first();
                    if ($chatbot) {
                        $description = $chatbot->description;
                        $chatbot_id = $chatbot->id;
                    } else {
                        $chatbot = Chatbot::where([
                            'parent_id' => $check->chatbot_id,
                            'keyword' => trim($data['content']),
                            'status' => 0
                        ])->first();
                        if ($chatbot) {
                            $chatbot_id = $chatbot->id;
                            $description = $chatbot->description;
                        } else {
                            $description = 'keyword salah';
                            $status = false;
                        }
                    }
                }

                $this->sendMessage($no_hp[0], $description);

                if ($status == true) {
                    $save_session = ChatbotSession::find($check->id);
                    $save_session->no_hp = $data['from'];
                    $save_session->chatbot_id = $chatbot_id;
                    $save_session->message = $description;
                    $save_session->keyword = trim($data['content']);
                    $save_session->save();
                }
            } else {
                //Ambil data ChatBot
                $chatbot = Chatbot::where('parent_id', null)->first();
                if (strtolower($data['content']) == 'mahasiswa_baru') {
                    $chatbot = Chatbot::where(['parent_id' => $chatbot->id, 'keyword' => 1])->first();
                } elseif (strtolower($data['content']) == 'mahasiswa_lama') {
                    $chatbot = Chatbot::where(['parent_id' => $chatbot->id, 'keyword' => 2])->first();
                }


                $this->sendMessage($no_hp[0], $chatbot->description);

                $save_session = new ChatbotSession();
                $save_session->no_hp = $data['from'];
                $save_session->chatbot_id = $chatbot->id;
                $save_session->message = $chatbot->description;
                $save_session->keyword = trim($data['content']);
                $save_session->save();
            }

            //save Report
            $report = new Report();
            $report->id_wa = $data['id_msg'];
            $report->from = $data['from'];
            $report->message = trim($data['content']);
            $report->save();

            return json_encode($request['data'], true);
        }
        //return json_encode($data, true);
    }

    public function sendMessage($no_hp, $message)
    {
        $url = env('ENGINE_URL', 'http://localhost:3000');
        $key = env('ENGINE_KEY', 'PuRn4nD1990');

        $response = Http::withHeaders([
            'x-purnand-token' => $key,
        ])->post($url . '/send-message', [
            "destination" => $no_hp,
            "message" => $message
        ]);

        return json_encode($response->body(), true);
    }
}
