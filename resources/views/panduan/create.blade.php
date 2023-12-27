@extends('layouts.main')
@section('content')

<div class="container my-5">
<h2 class="text-center">Tambah Data Panduan</h2>

<form action="{{route('panduan.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
<div class="my-3">
    <label for="exampleFormControlInput1" class="form-label">Title</label>
    <input type="text" name="title" class="form-control" id="exampleFormControlInput1" placeholder="">
  </div>

  <div class="my-3">
    <label for="exampleFormControlInput1" class="form-label">Masukkan Gambar</label>
    <input type="file" name="gambar" class="form-control">
  </div>

  <button type="submit" class="btn btn-primary">Simpan</button>
</form>

@endsection
