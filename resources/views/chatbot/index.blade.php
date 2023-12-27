@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0"> Main ChatBot </h5>
                    </div>
                    @if (Session::has('message'))
                        {!! Session::get('message') !!}
                    @endif
                    <div class="card-body">
                        @if ($result)
                            <p class="card-text">{{ $result->description }}</p>
                        @else
                            <p class="card-text">Konten Main belum tersedia, harap menambahkannya</p>
                            <a href="{{ route('chatbot.create') }}" class="btn btn-success">
                                <i class="nav-icon fas fa-plus"></i> Tambah
                            </a>
                        @endif
                    </div>

                    @if ($result)
                        <div class="card-footer clearfix">
                            <a href="{{ route('chatbot.detail', $result->id) }}" class="btn btn-success">
                                <i class="fa fa-plus" aria-hidden="true"></i> Tambah Detail ChatBot
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
