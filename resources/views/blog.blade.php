@extends('layouts.main')

@push('styles')
    <link rel="stylesheet" href="{{asset('fonts/icomoon/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
@endpush

@section('content')


  <div class="container">
    <div class="my-5 text-center">
    <h1 class="link-success">{{$panduan->title}}</h1>
  </div>


    <div class="d-flex carousel-nav">
    @foreach ($panduandetail as $key => $detail)
    <a href="#" class="col">{{$key+1}} Tab</a>
    @endforeach
      {{-- <a href="#" class="col active">First Tab</a>
      <a href="#" class="col">Second Tab</a>
      <a href="#" class="col">Third Tab</a> --}}
    </div>


    <div class="owl-carousel owl-1">
@foreach ($panduandetail as $val)


      <div class="media-29101 d-md-flex w-100">
        <div class="img">
          <img src="{{asset('img/'.$val->image)}}" alt="Image" class="img-fluid">
        </div>
        <div class="text">
          <h2><a href="#">{{$val->name}}</a></h2>
          <p>{{$val->description}}</p>
        </div>
      </div> <!-- .item -->
      @endforeach
    </div>
  </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
@endpush
