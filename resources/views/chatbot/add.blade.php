@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Tambah ChatBot</div>

                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('chatbot.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $chatbot_id }}">
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label for="kota_berangkat" class="col-sm-3 col-form-label">Status</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="status">
                                            <option value="1">Pesan Berhasil</option>
                                            <option value="0">Pesan Gagal</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="keyword" class="col-sm-3 col-form-label">Keyword</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="keyword" value="{{ old('keyword') }}"
                                            class="form-control @error('keyword') is-invalid @enderror"
                                            placeholder="Masukan Keyword">
                                        @error('keyword')
                                            <code>{{ $message }}</code>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="description" class="col-sm-3 col-form-label">Deskripsi</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" rows="3"
                                            name="description">{{ old('description') }}</textarea>
                                        @error('description')
                                            <code>{{ $message }}</code>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="nama" class="col-sm-3 col-form-label"> </label>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary"> Tambah </button>
                                        <a href="{{ $chatbot_id ? route('chatbot.detail', $chatbot_id) : route('chatbot.index') }}"
                                            class="btn btn-default float-right">
                                            Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
