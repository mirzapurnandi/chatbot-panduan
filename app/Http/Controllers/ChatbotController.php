<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chatbot;


class ChatbotController extends Controller
{
    public function index()
    {
        $result = Chatbot::where('parent_id', null)->first();

        return view('chatbot.index', [
            'result' => $result
        ]);
    }

    public function create(Request $request)
    {
        $chatbot_id = $request->id ? $request->id : null;
        return view('chatbot.add', [
            'chatbot_id' => $chatbot_id
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'keyword' => 'required',
            'description' => 'required'
        ]);

        $parent_id = $request->parent_id ? $request->parent_id : null;

        $chatbot = new Chatbot();
        $chatbot->status = $request->status;
        $chatbot->keyword = $request->keyword;
        $chatbot->description = $request->description;
        $chatbot->parent_id = $parent_id;
        $chatbot->save();

        if ($parent_id) {
            return redirect()->route('chatbot.detail', $parent_id)->with('message', '<div class="alert alert-success alert-dismissible">ChatBot Berhasil ditambahkan</div>');
        } else {
            return redirect()->route('chatbot.index')->with('message', '<div class="alert alert-success alert-dismissible">ChatBot Berhasil ditambahkan</div>');
        }
    }

    public function detail(Request $request)
    {
        $detail = Chatbot::find($request->id);
        $result = Chatbot::where('parent_id', $request->id)->get();
        return view('chatbot.detail', [
            'detail' => $detail,
            'result' => $result
        ]);
    }

    public function edit(Request $request)
    {
        $result = Chatbot::find($request->id);
        return view('chatbot.edit', compact('result'));
    }

    public function update_store(Request $request)
    {
        $request->validate([
            'keyword' => 'required',
            'description' => 'required'
        ]);

        $parent_id = $request->parent_id ? $request->parent_id : null;

        $chatbot = Chatbot::find($request->id);
        $chatbot->status = $request->status;
        $chatbot->keyword = $request->keyword;
        $chatbot->description = $request->description;
        $chatbot->parent_id = $parent_id;
        $chatbot->save();

        if ($parent_id) {
            return redirect()->route('chatbot.detail', $parent_id)->with('message', '<div class="alert alert-success alert-dismissible">ChatBot Berhasil diperbaharui</div>');
        } else {
            return redirect()->route('chatbot.index')->with('message', '<div class="alert alert-success alert-dismissible">ChatBot Berhasil diperbaharui</div>');
        }
    }

    public function destroy($id)
    {
        $result = Chatbot::find($id);
        if ($result->delete()) {
            return redirect()->back()->with('message', '<div class="alert alert-info alert-dismissible">Detail ChatBot terhapus...</div>');
        }
    }
}
