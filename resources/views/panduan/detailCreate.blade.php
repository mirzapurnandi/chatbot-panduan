@extends('layouts.main')
@section('content')

<div class="container my-5">
    <h2 class="text-center">Tambah Detail</h2>

<form action="{{route('panduan.detail.store')}}" method="POST" enctype="multipart/form-data">
@csrf
<input type="hidden" name="panduan_id" value="{{$id}}">
<div class="my-3">
    <label for="exampleFormControlInput1" class="form-label">Nama</label>
    <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="">
</div>

<div class="my-3">
    <label for="exampleFormControlInput1" class="form-label">Deskripsi</label>
    <input type="text" name="description" class="form-control" id="exampleFormControlInput1" placeholder="">
</div>

<div class="my-3">
    <label for="exampleFormControlInput1" class="form-label">Masukkan Foto</label>
    <input type="file" name="image" class="form-control">
</div>

<div class="my-3">
    <label for="exampleFormControlInput1" class="form-label">urutan</label>
    <input type="text" name="urutan" class="form-control" id="exampleFormControlInput1" placeholder="">
</div>

  <button type="submit" class="btn btn-primary">Simpan</button>
</form>

</form>

</div>

@endsection
