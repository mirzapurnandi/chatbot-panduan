@extends('layouts.main')
@section('content')

<div class="container my-5">
<h2 class="text-center">Ubah Panduan</h2>

<form action="{{route('panduan.update')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="panduan_id" value="{{$panduan->id}}">
<div class="my-3">
    <label for="exampleFormControlInput1" class="form-label">Title</label>
    <input type="text" name="title" value="{{$panduan->title}}" class="form-control" id="exampleFormControlInput1" placeholder="">
</div>

<div class="my-3">
    <label for="exampleFormControlInput1" class="form-label">Masukkan Gambar</label>
    <input type="file" name="gambar" class="form-control">
</div>

@if ($panduan->gambar !='')
<div class="my-3">
    <img src="{{ asset('img/'.$panduan->gambar) }}" width="100px" alt="">
</div>
@endif


  <button type="submit" class="btn btn-primary">Edit</button>
</form>

@endsection
