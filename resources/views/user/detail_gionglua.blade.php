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
    <p class="h3 fw-bold">{{ $detail[0]->ten }}</p>
    <hr>
    @if ($ds_hinhanh_detail != null)
        <div>
            <h4 class="fw-bold">Các hình ảnh liên quan</h4>
            <div class="hinhanh_detail">
                @foreach ($ds_hinhanh_detail as $key => $item)
                    <img src="/hinhanh/hinhanh_gionglua/{{ $item->ten }}" class="img-thumbnail" alt="..."
                        style="width:100% ; height: 400px">
                @endforeach
            </div>
            <div class="ds_hinhanh_detail border border-5">
                @foreach ($ds_hinhanh_detail as $key => $item)
                    <img src="/hinhanh/hinhanh_gionglua/{{ $item->ten }}" class="img-thumbnail border border-5" alt="..."
                        style="width:200px ; height: 200px">
                @endforeach
            </div>
        </div>
    @endif
    <hr>
    <h4 class="fw-bold ">Đặc điểm</h4>
    <div class="container fw-lighter">
        {!! $detail[0]->dacdiem !!}
    </div>
    <hr>
    <h4 class="fw-bold ">Thông tin khác</h4>
    <div class="container fw-lighter">
        {!! $detail[0]->thongtinkhac !!}
    </div>
    <br>
    @if (count($ds_chongchiutot) > 0)
    <h4 class="fw-bold">Các sâu bệnh giống lúa chống chịu tốt</h4>
    @foreach ($ds_chongchiutot as $item2)
    <a href="{{route('saubenh',['ma'=> $item2->ma_saubenh])}}"><span class="badge text-bg-warning">{{ $item2->ten }}</span></a>
    @endforeach
@endif
@if (count($ds_debinhiem) > 0)
<h4 class="fw-bold">Các sâu bệnh giống lúa dễ bị nhiễm</h4>
@foreach ($ds_debinhiem as $item2)
   <a href="{{route('saubenh',['ma'=> $item2->ma_saubenh])}}"> <span class="badge text-bg-success">{{ $item2->ten}}</span></a>
@endforeach
@endif

<hr>
<h4 class="fw-bold">Bình luận</h4>
@if (Auth::user())
    <form id ="ajaxform" class="add">
        <div class="panel">
            <div class="panel-body">
                <input type="text" class="d-none" value="{{ $detail[0]->ma }}" name="ma_gionglua" id="ma_gionglua">
                <input type="text" class="d-none" value="{{ Auth::user()->id }}" name="ma_user" id="ma_user">
                <textarea class="form-control" rows="2" placeholder="Nhập bình luận" required name="noidung" id="noidung"></textarea>
                <div class="mt-2">
                    <button class="btn btn-sm btn-primary pull-right save-data" type="submit"> Bình luận</button>
                </div>
            </div>
        </div>
    </form>
@endif

<br>
<div id="data-wrapper">
    @include('user.load_more_binhluan')
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

   {{-- @if($ds_chongchiutot!=null)
   <hr>
   <div>
       <h4>Các loại sâu bệnh giống lúa chống chịu tốt</h4>
   </div>
   <div class="row   ds_chongchiutot">
       @foreach ($ds_chongchiutot as $item)
           <div class="col border border-5">
               <div class="card zoom" style="height: 405px">
                   <img src="/hinhanh/hinhanh_saubenh/{{ $item->ten_hinhanh }}" class="card-img-top" alt="..."
                       style="width: 100%; height:200px">
                   <div class="card-body overflow-hidden" style="height: 160px">
                       <p class="fw-lighter fs-6">{{ date("d-m-Y H:i", $item->ngaytao) }}</p>

                       <h5 class="card-title fw-bolder">{{ $item->ten }}</h5>
                       <p class="card-text">{!! $item->thongtinkhac !!}</p>
                       <a href="{{ route('saubenh', ['ma' => $item->ma_saubenh]) }}" class="stretched-link"></a>
                   </div>
               </div>
           </div>
       @endforeach
   </div>
   @endif --}}

   {{-- @if($ds_debinhiem !=null)
   <hr>
   <div>
       <h4>Các loại sâu bệnh giống lúa dễ bị nhiễm</h4>
   </div>
   <div class="row   ds_debinhiem">
       @foreach ($ds_debinhiem as $item)
           <div class="col border border-5">
               <div class="card zoom" style="height: 405px">
                   <img src="/hinhanh/hinhanh_saubenh/{{ $item->ten_hinhanh }}" class="card-img-top" alt="..."
                       style="width: 100%; height:200px">
                   <div class="card-body overflow-hidden" style="height: 160px">
                       <p class="fw-lighter fs-6">{{ date("d-m-Y H:i", $item->ngaytao) }}</p>

                       <h5 class="card-title fw-bolder">{{ $item->ten }}</h5>
                       <p class="card-text">{!! $item->thongtinkhac !!}</p>
                       <a href="{{ route('saubenh', ['ma' => $item->ma_saubenh]) }}" class="stretched-link"></a>
                   </div>
               </div>
           </div>
       @endforeach
   </div>
   @endif

    <hr>
    <div>
        <h4>Các bài viết tin tức khác</h4>
    </div>
    <div class="row   ds_tintuc_khac">
        @foreach ($ds_tintuc_khac as $item)
            <div class="col border border-5">
                <div class="card zoom" style="height: 405px">
                    <img src="/hinhanh/hinhanh_tintuc/{{ $item->ten_hinhanh }}" class="card-img-top" alt="..."
                        style="width: 100%; height:200px">
                    <div class="card-body overflow-hidden" style="height: 160px">
                        <p class="fw-lighter fs-6">{{ date("d-m-Y H:i", $item->ngaytao) }}</p>

                        <h5 class="card-title fw-bolder">{{ $item->ten }}</h5>
                        <p class="card-text">{!! $item->noidung !!}</p>
                        <a href="{{ route('tintuc', ['ma' => $item->ma]) }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div> --}}

@endsection
@section('css')
    <style type="text/css">

    </style>
@endsection

@section('js')
    <script>
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var ENDPOINT = "{{ route('gionglua', ['ma' => $detail[0]->ma]) }}";
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
                    // if (response.html == '') {
                    //     $('.auto-load').html("Không có dữ liệu :(");
                    //     return;
                    // }

                    $('.auto-load').hide();
                    $("#data-wrapper").append(response.html);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
        }




        // $(document).ready(function() {
        $('#ajaxform').on('submit', function(event) {

            event.preventDefault();
            // Get Alll Text Box Id's
            noidung = $('#noidung').val();
            ma_user = $('#ma_user').val();
            ma_gionglua = $('#ma_gionglua').val();


            $.ajax({
                url: "{{ route('binhluan_gionglua', ['ma' => $detail[0]->ma]) }}", //Define Post URL
                type: "POST",
                data: {
                    noidung: noidung,
                    ma_user: ma_user,
                    ma_gionglua: ma_gionglua

                },
                //Display Response Success Message
                success: function(response) {
                    // response.html == '';
                    if(response.err == 'Lỗi'){
                        swal({
                                title: "Bạn đã bị chặn bình luận!",
                                icon: "error",
                                type: 'error',
                            })
                            return;
                    }
                    document.getElementById("ajaxform").reset();
                    page = 1;
                    $("#data-wrapper").html("");
                    infinteLoadMore(1)
                    // location.reload();
                }

            });
        });
        // });

        $(document).on('submit', '.xoa-binh-luan', function() {
            // $('.xoa-binh-luan').on('submit', function(event) {
            event.preventDefault();
            var id = $(this).attr("data_id");
            swal({
                title: "Xóa bình luận!",
                text: "***",
                icon: "warning",
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "{{ route('delete_binhluan', ['ma' => $detail[0]->ma]) }}",
                        type: 'delete',
                        dataType: 'json',
                        data: {
                            _token: "{{ csrf_token() }}",
                            ma: id
                        },

                        success: function() {
                            $("#data-wrapper").html("");
                            page = 1;
                            infinteLoadMore(page)
                            swal({
                                title: "Đã xóa bình luận",
                                icon: "success",
                                type: 'success',
                            })
                        }
                    })
                }
            })
        });

        $('.hinhanh_detail').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.ds_hinhanh_detail'
        });
        $('.ds_hinhanh_detail').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.hinhanh_detail',
            arrows: false,
            centerMode: true,
            focusOnSelect: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
            ]
        });

        $('.ds_tintuc_khac').slick({
            autoplay: true,
            autoplaySpeed: 2000,
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: false,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
            ]
        });
        $('.ds_chongchiutot').slick({
            autoplay: true,
            autoplaySpeed: 2000,
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: false,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
            ]
        });
        $('.ds_debinhiem').slick({
            autoplay: true,
            autoplaySpeed: 2000,
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: false,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
            ]
        });
    </script>
@endsection
