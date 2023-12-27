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
                                <a href="{{ route('blog', ['title_seo' => $val->title_seo]) }}"> {{ $val->title }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="card">
                <div class="card-header">
                    INFORMASI MELALUI LINK WHATSAPP
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 text-center mt-2">
                            <h5 class="card-title">MAHASISWA BARU</h5>
                            <a href="{{ $link_wa }}?text=mahasiswa_baru" target="_blank">
                                <img src="{{ asset('img/whatsapp.png') }}" alt="" height="100">
                            </a>
                        </div>
                        <div class="col-md-6 text-center mt-2">
                            <h5 class="card-title">MAHASISWA LAMA</h5>
                            <a href="{{ $link_wa }}?text=mahasiswa_lama" target="_blank">
                                <img src="{{ asset('img/whatsapp.png') }}" alt="" height="100">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
