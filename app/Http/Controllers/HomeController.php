<?php

namespace App\Http\Controllers;

use App\Models\Panduan;
use App\Models\PanduanDetail;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $panduan = Panduan::orderBy('created_at', 'DESC')->get();
        return view('index', [
            'panduan' => $panduan
        ]);
    }

    public function blog($title_seo)
    {
        $panduan = Panduan::where('title_seo', $title_seo)->first();

        $panduandetail = PanduanDetail::where('panduan_id', $panduan->id)->get();

        return view('blog', compact('panduan', 'panduandetail'));
    }

}
