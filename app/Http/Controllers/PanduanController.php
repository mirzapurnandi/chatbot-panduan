<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Panduan;
use App\Models\PanduanDetail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\Return_;

class PanduanController extends Controller
{
    public function index(){

        $panduan = Panduan::get();

        return view('panduan.index', ['panduan' => $panduan]);
    }

    public function create(){
        return view('panduan.create');
    }

    public function store(Request $request){

        $filename = null;
        if ($request->hasfile('gambar')){
            $file = $request->file('gambar');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('img/', $filename);
        }

        $panduan = new Panduan;
        $panduan->title = $request->title;
        $panduan->title_seo = Str::slug($request->title);
        $panduan->gambar = $filename;
        $panduan->save();

        return Redirect::route('panduan.index');
    }

    public function edit($id){
        $panduan = Panduan::findOrFail($id);

        return view('panduan.edit', compact('panduan'));
    }

    public function update(Request $request){
        $panduan = Panduan::findOrFail($request->panduan_id);
        $panduan->title = $request->title;
        if($request->hasfile('gambar')){
            if($panduan->gambar !=''){
                File::delete('img/'.$panduan->gambar);
            }

            $file = $request->file('gambar');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('img/', $filename);
            $panduan->gambar=$filename;
        }
        $panduan->save();

        return Redirect::route('panduan.index');

    }

    public function destroy($id){

        $panduan = Panduan::findOrFail($id);
        if($panduan->gambar !=''){
            File::delete('img/'.$panduan->gambar);
        }
        $panduan->delete();
        return Redirect::route('panduan.index');

    }

    public function detail($id){
       $panduan = Panduan::findOrFail($id);
       $panduandetail = PanduanDetail::where('panduan_id', $id)->get();


        return view('panduan.detail', compact('panduan', 'id', 'panduandetail'));
    }

    public function detailCreate($id){
        $panduan = Panduan::findOrFail($id);

        return view('panduan.detailCreate', compact('panduan', 'id'));
    }

    public function detailStore(Request $request){

        $filename = null;
        if($request->hasfile('image')){
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('img/', $filename);
        }

        $panduandetail = new PanduanDetail;
        $panduandetail->panduan_id = $request->panduan_id;
        $panduandetail->name = $request->name;
        $panduandetail->description = $request->description;
        $panduandetail->image = $filename;
        $panduandetail->urutan = $request->urutan;
        $panduandetail->save();

        return Redirect::route('panduan.detail', ['id' => $request->panduan_id]);

    }

    public function detailEdit($id){
        $panduandetail = PanduanDetail::findOrFail($id);

        return view('panduan.detailEdit', compact('panduandetail', 'id'));
    }

    public function detailUpdate(Request $request){
        $panduandetail = PanduanDetail::findOrFail($request->id);
        $panduandetail->name = $request->name;
        $panduandetail->description = $request->description;
        $panduandetail->urutan = $request->urutan;
        if($request->hasfile('image')){
            if($panduandetail->image !=''){
                File::delete('img/'.$panduandetail->image);
            }

            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('img/', $filename);
            $panduandetail->image=$filename;
        }
        $panduandetail->save();

        return Redirect::route('panduan.detail', ['id'=>$panduandetail->panduan_id]);

    }

    public function detailDestroy($id){

        $panduandetail = PanduanDetail::findOrFail($id);
        if($panduandetail->image !=''){
            File::delete('img/'.$panduandetail->image);
        }
        $panduandetail->delete();
        return Redirect::route('panduan.detail', ['id' => $panduandetail->panduan_id]);

    }


}
