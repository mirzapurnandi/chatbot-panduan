@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0"> Info Parent Detail ChatBot </h5>
                    </div>

                    <div class="card-body">
                        <p class="card-text">{!! nl2br($detail->description) !!}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                @if (Session::has('message'))
                    {!! Session::get('message') !!}
                @endif
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0"> Detail ChatBot </h5>
                    </div>

                    <div class="card-body">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Keyword</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result as $key => $val)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $val->keyword }}</td>
                                        <td>{!! nl2br($val->description) !!}</td>
                                        <td>Pesan Keyword {{ $val->status == 1 ? 'Benar' : 'Salah' }}</td>
                                        <td class="text-right py-0 align-middle">
                                            <div class="d-flex">
                                                @if ($val->status == 1)
                                                    <a href="{{ route('chatbot.detail', $val->id) }}"
                                                        class="btn btn-primary m-1" role="button">
                                                        <i class="fa fa-share" aria-hidden="true"></i>
                                                    </a>
                                                @endif
                                                <a href="{{ route('chatbot.edit', $val->id) }}" class="btn btn-success m-1"
                                                    role="button">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                </a>
                                                <form action="{{ route('chatbot.destroy', $val->id) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger m-1"
                                                        onclick="return confirm('Yakin Hapus User ini... ?')">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer clearfix">
                        <a href="{{ route('chatbot.create', $detail->id) }}" class="btn btn-success">
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Detail ChatBot
                        </a> &nbsp;
                        <a class="text-decoration-none"
                            href="{{ $detail->parent_id ? route('chatbot.detail', $detail->parent_id) : route('chatbot.index') }}">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
