@extends('layouts.main')
@section('content')

<div class="container my-5">
<h2 class="text-center">Ubah Panduan</h2>

<form action="{{route('panduan.detail.update')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{$id}}">
<div class="my-3">
    <label for="exampleFormControlInput1" class="form-label">Nama</label>
    <input type="text" name="name" value="{{$panduandetail->name}}" class="form-control" id="exampleFormControlInput1" placeholder="">
</div>

<div class="my-3">
    <label for="exampleFormControlInput1" class="form-label">Deskripsi</label>
    <input type="text" name="description" value="{{$panduandetail->description}}" class="form-control" id="exampleFormControlInput1" placeholder="">
</div>

<div class="my-3">
    <label for="exampleFormControlInput1" class="form-label">Masukkan Foto</label>
    <input type="file" name="image" class="form-control">
</div>

<div class="my-3">
    <label for="exampleFormControlInput1" class="form-label">Urutan</label>
    <input type="text" name="urutan" value="{{$panduandetail->urutan}}" class="form-control" id="exampleFormControlInput1" placeholder="">
</div>


@if ($panduandetail->image !='')
<div class="my-3">
    <img src="{{ asset('img/'.$panduandetail->image) }}" width="100px" alt="">
</div>
@endif


  <button type="submit" class="btn btn-primary">Edit</button>
</form>

@endsection
