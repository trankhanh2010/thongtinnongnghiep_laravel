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
    {{-- @if ($tintuc_noibat_nhat != null)
        <div>
            <div class="card mb-3 zoom border border-4">
                <div class="row g-0">
                    <div class="col-md-8">
                        <img src="/hinhanh/hinhanh_tintuc/{{ $tintuc_noibat_nhat[0]->ten_hinhanh }}"
                            class="img-fluid rounded-start" alt="..." style="height: 350px; width:100%">
                    </div>
                    <div class="col-md-4">
                        <div class="card-body">
                            <div class="card-body overflow-hidden" style="height: 315px">
                                <p class="fw-lighter fs-6">{{ date("d-m-Y H:i", $tintuc_noibat_nhat[0]->ngaytao) }}</p>

                                <h5 class="card-title">{{ $tintuc_noibat_nhat[0]->ten }}</h5>
                                <p class="card-text">{!! $tintuc_noibat_nhat[0]->noidung !!}</p>
                                <a href="{{ route('tintuc', ['ma' => $tintuc_noibat_nhat[0]->ma]) }}"
                                    class="stretched-link"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    @endif --}}

    {{-- <div id="data-wrapper" class="row row-cols-1 row-cols-md-3 g-4">
        @include('user.load_more_tintuc')
    </div> --}}
    <div id="data-wrapper" class="row ">
        @include('user.load_more_tintuc')
    </div>
    <br>
    <div class="text-center">
        <button class="btn btn-success load-more-data"><i class="fa fa-refresh"></i> Xem thêm ...</button>
    </div>
    <br>
    <!-- Data Loader -->
    <div class="auto-load text-center" style="display: none;">
        <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
            <path fill="#000"
                d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50"
                    to="360 50 50" repeatCount="indefinite" />
            </path>
        </svg>
    </div>
@endsection



@section('css')
    <style type="text/css">

    </style>
@endsection

@section('js')

    <script>
        var ENDPOINT = "{{ route('home') }}";
        var page = 1;

        $(".load-more-data").click(function() {
            page++;
            infinteLoadMore(page);
        });

        /*------------------------------------------
        --------------------------------------------
        call infinteLoadMore()
        --------------------------------------------
        --------------------------------------------*/
        function infinteLoadMore(page) {
            $.ajax({
                    url: ENDPOINT + "?page=" + page,
                    datatype: "html",
                    type: "get",
                    beforeSend: function() {
                        $('.auto-load').show();
                    }
                })
                .done(function(response) {
                    if (response.html == '') {
                        $('.auto-load').html("Không có dữ liệu :(");
                        return;
                    }
                    $('.auto-load').hide();
                    $("#data-wrapper").append(response.html);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
        }

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
