@extends('layouts.main')
@section('content')


{{-- ['panggil_aku' => $panduan] --}}

<div class="container my-5">
    <h2 class="text-center">
       {{$panduan->title}}
    </h2>
    <div class="text-center">
        <img src="{{ asset('img/'.$panduan->gambar) }}" width="200px" alt="">
    </div>

<div class="container my-5">
<div class="col-auto">
    <a href="{{route('panduan.detail.create', ['id' => $id])}}" class="btn btn-primary">Tambah</a>
</div>
<div class="container my-3">
    <table class="table table-success table-striped">
        <thead>
            <tr>
            <th scope="col">NO</th>
            <th scope="col">NAMA</th>
            <th scope="col">DESKRIPSI</th>
            <th scope="col">IMAGE</th>
            <th scope="col">URUTAN</th>
            <th scope="col">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($panduandetail as $key => $detail)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$detail->name}}</td>
                <td>{{$detail->description}}</td>
                <td>
                    @if ($detail->image!= "")
                    <img src="{{ asset('img/'.$detail->image) }}" width="50px" alt="">
                    @endif
                </td>
                <td>{{$detail->urutan}}</td>
                <td>
                    <a href="{{route('panduan.detail.edit', $detail->id)}}" class="btn btn-primary">Edit</a>

                    <a href="{{route('panduan.detail.destroy', $detail->id)}}" class="btn btn-danger">Hapus</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
