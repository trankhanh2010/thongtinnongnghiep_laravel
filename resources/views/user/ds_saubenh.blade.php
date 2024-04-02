@extends('layout.user')

@section('title')
    {{ $title }}
@endsection

@section('cot_trai')
    @include('user.cot_trai')
@endsection
@section('cot_phai')
    @include('user.cot_phai')
@endsection

@section('content')
<br>

    <div class="row ">

        @foreach ($ds_saubenh as $item)
        <div class="row d-flex ">
            <div class="card border-0  zoom ">
                <div class="row g-0 ">
                  <div class="col-md-4 mt-2">
                    <img src="/hinhanh/hinhanh_saubenh/{{ $item->ten_hinhanh }}" class="img-fluid " alt="...">
                  </div>
                  <div class="col-md-8">
                    <div class="card-body">
                      <h5 class="card-title fw-bold">{{ $item->ten }}</h5>
                      <div class="card-text overflow-hidden" style="height: 100px">{!! $item->thongtinkhac !!}</div>
                      
                      <p class="card-text"><small>Viết lúc {{ date("H:i d-m-Y", $item->ngaytao) }}</small></p>
                      <a href="{{route('saubenh',['ma'=> $item->ma])}}" class="stretched-link"></a>
          
                    </div>
                  </div>
                </div>
              </div>
          </div>
        @endforeach
    </div>
    <br>
    <div id="phantrang">{{ $ds_saubenh->appends(request()->all())->links() }}</div>
@endsection



@section('css')
    <style type="text/css">

    </style>
@endsection

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script></script>
@endsection
