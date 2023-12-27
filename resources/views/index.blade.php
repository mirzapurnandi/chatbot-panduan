@extends('layouts.main')

@section('content')

<div class="container my-3">
<h1 class="text-center">SELAMAT DATANG</h1>

<div class="container my-5">
    <table class="table table-success table-striped">
        <thead>
          <tr>
            <th class="text-center" scope="col">DAFTAR PANDUAN</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($panduan as $val)
            <tr>
                <td>
                    <a href="{{route('blog', ['title_seo' => $val->title_seo])}}"> {{$val->title}}</a>
                </td>
              </tr>
            @endforeach
        </tbody>
      </table>
    </div>

@endsection


