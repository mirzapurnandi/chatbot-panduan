<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EngineController extends Controller
{
    public function index()
    {
        return view('engine.index');
    }

    public function getStatus()
    {
        try {
            $url = env('ENGINE_URL', 'http://localhost:3000');
            $key = env('ENGINE_KEY', 'PuRn4nD1990');

            $response = Http::withHeaders([
                'x-purnand-token' => $key,
            ])->get($url . '/status');

            return [
                'status' => true,
                'result' => json_decode($response->body(), true)
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'result' => [
                    'message' => $th->getMessage(),
                    'line' => $th->getLine(),
                    'file' => $th->getFile()
                ]
            ];
        }
    }

    public function getQR()
    {
        $url = env('ENGINE_URL', 'http://localhost:3000');
        $key = env('ENGINE_KEY', 'PuRn4nD1990');

        $response = Http::withHeaders([
            'x-purnand-token' => $key,
        ])->get($url . '/qr');

        return json_decode($response->body(), true);
    }

    public function Disconnect()
    {
        $url = env('ENGINE_URL', 'http://localhost:3000');
        $key = env('ENGINE_KEY', 'PuRn4nD1990');

        $response = Http::withHeaders([
            'x-purnand-token' => $key,
        ])->get($url . '/disconnect');

        return json_decode($response->body(), true);
    }
}
