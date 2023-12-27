@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0"> Engine Service </h5>
                    </div>
                    @if (Session::has('message'))
                        {!! Session::get('message') !!}
                    @endif
                    <div class="card-body">
                        <span class="load_data">Info Data</span>
                    </div>

                    <div class="card-footer clearfix">
                        <button class="btn btn-warning" id="btn_get_status" onclick="getStatus()"> Check Status </button>
                        &nbsp;
                        <button class="btn btn-success" id="btn_get_qr" onclick="getQR()"> Proses QR Code </button> &nbsp;
                        <button class="btn btn-danger" id="btn_disconnect" onclick="disconnect()"> Disconnect </button>
                        &nbsp;
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $("#btn_get_qr").hide();
        $("#btn_disconnect").hide();
        $(function() {
            /* $("#saveLaporkan").on("submit", function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                saveDataLaporkan(formData);
            }); */
        });

        function getStatus() {
            $.ajax({
                url: `{{ route('engine.get-status') }}`,
                type: "GET",
                dataType: "json",
                cache: false,
                beforeSend: function() {
                    $("#btn_get_status").html(
                        '<div class="spinner-border spinner-border-sm text-danger" role="status"><span class="sr-only">Loading...</span></div>'
                    ).attr("disabled", true);
                },
                success: function(response) {
                    if (response.status == false) {
                        $(".load_data").html(`Message: ${response.result.message}`);
                        $('#btn_get_status').html('Check Status').attr("disabled", false);
                    } else {
                        $('#btn_get_status').html('Check Status').attr("disabled", false);
                        if (response.result.data == null) {
                            $('#btn_get_status').hide();
                            $('#btn_get_qr').show();
                            $(".load_data").html("Engine tersedia");
                        } else if (response.result.data == "CONNECTED") {
                            $('#btn_get_status').hide();
                            $('#btn_disconnect').show();
                            $(".load_data").html("WA Sudah terpasang");
                        }
                    }
                },
            });
        }

        function getQR() {
            $.ajax({
                url: `{{ route('engine.get-qr') }}`,
                type: "GET",
                dataType: "json",
                cache: false,
                beforeSend: function() {
                    $("#btn_get_qr").html(
                        '<div class="spinner-border spinner-border-sm text-danger" role="status"><span class="sr-only">Loading...</span></div>'
                    ).attr("disabled", true);
                },
                success: function(response) {
                    if (response.code == 200) {
                        $('#btn_get_qr').html('Proses QR Code').attr("disabled", false);
                        $(".load_data").html(response.data);
                    } else {
                        $('#btn_get_qr').hide();
                        $(".load_data").html("WA sudah terpasang");
                        $("#btn_disconnect").show();
                    }
                },
            });
        }

        function disconnect() {
            $.ajax({
                url: `{{ route('engine.disconnect') }}`,
                type: "GET",
                dataType: "json",
                cache: false,
                beforeSend: function() {
                    $("#btn_disconnect").html(
                        '<div class="spinner-border spinner-border-sm text-danger" role="status"><span class="sr-only">Loading...</span></div>'
                    ).attr("disabled", true);
                },
                success: function(response) {
                    $('#btn_disconnect').hide();
                    $('#btn_get_status').show();
                    $(".load_data").html("WA Disconnect");
                },
            });
        }
    </script>
@endpush
