@extends('layouts.main')
@section('content')

<div class="container my-5">
    <div class="row">
        <div class="col">
            <h2>Panduan</h2>
        </div>
        <div class="col-auto">
            <a href="{{route('panduan.create')}}" class="btn btn-primary">Tambah</a>
        </div>
    </div>

<div class="container my-3">
<table class="table table-success table-striped">
    <thead>
      <tr>
        <th scope="col">NO</th>
        <th scope="col">DAFTAR PANDUAN</th>
        <th scope="col">GAMBAR</th>
        <th scope="col">AKSI</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($panduan as $key => $val)
        <tr>
            <th scope="row">{{$key+1}}</th>
            <td>{{$val->title}}</td>
            <td>
                @if ($val->gambar != "")
                <img src="{{ asset('img/'.$val->gambar) }}" width="50px" alt="">
                @endif
            </td>

            <td>
                <a href="{{route('panduan.detail', $val->id)}}" class="btn btn-info">Detail</a>

               <a href="{{route('panduan.edit', $val->id)}}" class="btn btn-primary">Edit</a>

                <a href="{{route('panduan.destroy', $val->id)}}" class="btn btn-danger">Hapus</a>
            </td>
        </tr>
        @endforeach

    </tbody>
  </table>
</div>

@endsection
