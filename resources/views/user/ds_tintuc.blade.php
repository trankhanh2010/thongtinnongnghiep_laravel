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
    {{-- <form id ="timkiem" action="" method="GET" class="mb3">
        <div id="timkiem" class="input-group mb-3">
            <input type="search" class="form-control" placeholder="Nhập từ khóa" name="key" value={{ request()->key }}>
            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
        </div>

    </form> --}}
    <div class="row ">
        {!! $text !!}

        @foreach ($ds_tintuc as $item)
            <div class="row d-flex ">
                <div class="card border-0  zoom ">
                    <div class="row g-0 ">
                        <div class="col-md-4 mt-2">
                            <img src="/hinhanh/hinhanh_tintuc/{{ $item->ten_hinhanh }}" class="img-fluid " alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $item->ten }}</h5>
                                <div class="card-text overflow-hidden" style="height: 100px">{!! $item->noidung !!}</div>

                                <p class="card-text"><small>Viết lúc {{ date('H:i d-m-Y', $item->ngaytao) }} </small></p>
                                @foreach ($item->loai_tintuc as $item2)
                                <span class="badge text-bg-warning">{{ $item2->ten_tintuc }}</span>
                                @endforeach
                                @foreach ($item->gionglua_lienquan as $item2)
                                <span class="badge text-bg-success">{{ $item2->ten_gionglua_lienquan }}</span>
                                @endforeach
                                <a href="{{ route('tintuc', ['ma' => $item->ma]) }}" class="stretched-link"></a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <br>
    <div id="phantrang">{{ $ds_tintuc->appends(request()->all())->links() }}</div>




   
@endsection



@section('css')
    <style type="text/css">

    </style>
@endsection

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
      function check_item($id) {
        let item = document.getElementById("gionglua" + $id);
        let input1 = document.getElementById("key_ds_gionglua");
        if (item.className == "btn btn-list btn-light border-secondary") {
            item.className = "btn btn-list btn-secondary border-secondary";
            input1.value += item.value + ",";

        } else {
            item.className = "btn btn-list btn-light border-secondary";
            input1.value = input1.value.replace(item.value + ",", "");


        }

    }

    function check_item2($id) {
        let item = document.getElementById("loai_tintuc" + $id);
        let input1 = document.getElementById("key_ds_loai_tintuc");
        if (item.className == "btn btn-list btn-light border-secondary") {
            item.className = "btn btn-list btn-secondary border-secondary";
            input1.value += item.value + ",";

        } else {
            item.className = "btn btn-list btn-light border-secondary";
            input1.value = input1.value.replace(item.value + ",", "");


        }

    }
    </script>
@endsection
