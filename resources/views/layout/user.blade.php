<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
                    
    <link rel="shortcut icon" href="/hinhanh/logo/logo1.png" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <title>@yield('title')</title>

    <style type="text/css">
        .zoom {
            transition: transform .2s;
            /* Animation */
            margin: 0 auto;
        }

        .zoom:hover {
            transform: scale(1.05);
            /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
        }

        .overflow-show {
            max-height: 300px;
            overflow: auto;
        }

        .btn-list {
            margin-bottom: 5px;
        }
    </style>
    @yield('css')

</head>

<body>

    <div class="container-fluid bg-light">
        <nav class="navbar navbar-expand-lg navbar-dark p-5 " aria-label="Fifth navbar example"
            style="background-color:#032a63 ">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                    <img src="/hinhanh/logo/logo1.png" width="30" height="30" class="d-inline-block align-top"
                        alt="">
                    Thông tin nông nghiệp
                </a> <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarsExample05">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link fw-bold @if ($url == 'home') active @endif"
                                aria-current="page" href="{{ route('home') }}">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-bold @if ($url == 'ds_tintuc') active @endif"
                                aria-current="page" href="{{ route('ds_tintuc') }}">Tin tức</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-bold @if ($url == 'ds_gionglua') active @endif"
                                aria-current="page" href="{{ route('ds_gionglua') }}">Giống lúa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-bold @if ($url == 'ds_saubenh') active @endif"
                                aria-current="page" href="{{ route('ds_saubenh') }}">Sâu bệnh</a>
                        </li>

                    </ul>
                    <div>
                        @if (Auth::user())
                            <a type="button" class="btn btn-success fw-bold">Xin chào {{ Auth::user()->name }}</a>
                            <a href="{{ route('dangxuat') }}" class="btn btn-warning fw-bold">Đăng xuất</a>
                        @else
                            <a href="{{ route('dangnhap') }}" class="btn btn-primary fw-bold">Đăng nhập</a>
                            <a href="{{ route('dangky') }}" class="btn btn-success fw-bold">Đăng ký</a>
                        @endif

                    </div>
                </div>
            </div>
        </nav>

        <div class=" bg-white ">
            <div class="row ">
                <div class="col-1 d-block ">
                </div>
                <div class="col-8 p-1">
                    <nav aria-label="breadcrumb ">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"
                                    class="link-underline link-underline-opacity-0 fw-bold">Thông tin nông nghiệp</a>
                            </li>
                            @if ($url != '')
                                <li class="breadcrumb-item " disabled aria-current="page"><a href="#"
                                        class="link-dark link-underline link-underline-opacity-0 fw-bold">{{ $title }}</a>
                                </li>
                            @endif

                        </ol>

                    </nav>
                </div>
                <div class="col-3 d-block p-1">
                    @if (Auth::user())
                        <a href="{{ route('ds_phanhoi') }}" class="link-info link-underline-opacity-0 fw-bold">Danh
                            sách phản hồi</a>
                    @endif
                </div>
            </div>
            <div class="row ">

                <div class="col-2 d-block ">

                </div>
                <div class="col-8  ">
                    @if ($url == 'home' || $url == 'ds_tintuc' || $url == 'tintuc')
                        <form id ="timkiem" action="{{ route('ds_tintuc') }}" method="GET" class="mb3">
                            <div class="">


                            </div>
                            <div class="row ">
                                <div class="col-md-5 d-flex justify-content-center ">
                                    <button class="btn btn-warning ms-1 mt-1 d-flex" type="button"
                                        data-bs-toggle="modal" data-bs-target="#ds_loai_tintuc">Loại tin
                                        tức</button>
                                    <button class="btn btn-success ms-1 mt-1 d-flex"
                                        type="button"data-bs-toggle="modal" data-bs-target="#ds_gionglua">Giống
                                        lúa
                                        liên quan</button>
                                </div>
                                <div class="col-md-5 d-flex justify-content-center ">
                                    <textarea name="key_ds_gionglua" id="key_ds_gionglua" class="form-control d-none" readonly rows="2"
                                        value={{ request()->key_ds_gionglua }}></textarea>
                                    <textarea name="key_ds_loai_tintuc" id="key_ds_loai_tintuc" class="form-control d-none" readonly rows="2"
                                        value={{ request()->key_ds_loai_tintuc }}></textarea>
                                    <input type="search" class="form-control ms-1 pt-1  mt-1 d-flex"
                                        placeholder="Nhập từ khóa" name="key" value={{ request()->key }}>
                                </div>
                                <div class="col-md-2 d-flex justify-content-center ">
                                    <button class="btn btn-primary ms-1 pt-1 mt-1 d-flex" type="submit">Tìm
                                        kiếm</button>

                                </div>
                            </div>
                        </form>
                    @else
                        @if ($url == 'ds_gionglua' )
                            <form id ="timkiem" action="/ds_gionglua" method="GET" class="mb3">
                                <div class="">


                                </div>
                                <div class="row ">
                                    <div class="col-md-5 d-flex justify-content-center ">
                                        <button class="btn btn-success ms-1 mt-1 d-flex" type="button"
                                            data-bs-toggle="modal" data-bs-target="#ds_chongchiutot">Chống chịu tốt
                                        </button>
                                        <button class="btn btn-warning ms-1 mt-1 d-flex"
                                            type="button"data-bs-toggle="modal" data-bs-target="#ds_debinhiem">Dễ bị nhiễm</button>
                                    </div>
                                    <div class="col-md-5 d-flex justify-content-center ">
                                        <textarea name="key_ds_chongchiutot" id="chongchiutot" class="form-control d-none" readonly rows="2"
                                            value={{ request()->key_ds_gionglua }}></textarea>
                                        <textarea name="key_ds_debinhiem" id="debinhiem" class="form-control d-none" readonly rows="2"
                                            value={{ request()->key_ds_loai_tintuc }}></textarea>
                                        <input type="search" class="form-control ms-1 pt-1  mt-1 d-flex"
                                            placeholder="Nhập từ khóa" name="key" value={{ request()->key }}>
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center ">
                                        <button class="btn btn-primary ms-1 pt-1 mt-1 d-flex" type="submit">Tìm
                                            kiếm</button>

                                    </div>
                                </div>
                            </form>
                            {{-- <form id ="timkiem" action="" method="GET" class="mb3">
                                <div id="timkiem" class="row">
                                    <div class="col-md-10 d-flex justify-content-center ">
                                        <input type="search" class="form-control ms-1 pt-1  mt-1 d-flex"
                                            placeholder="Nhập từ khóa" name="key" value={{ request()->key }}>
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center ">
                                        <button class="btn btn-primary ms-1 pt-1 mt-1 d-flex" type="submit">Tìm
                                            kiếm</button>

                                    </div>

                                </div>

                            </form> --}}
                            @else
                               <form id ="timkiem" action="" method="GET" class="mb3">
                                <div id="timkiem" class="row">
                                    <div class="col-md-10 d-flex justify-content-center ">
                                        <input type="search" class="form-control ms-1 pt-1  mt-1 d-flex"
                                            placeholder="Nhập từ khóa" name="key" value={{ request()->key }}>
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center ">
                                        <button class="btn btn-primary ms-1 pt-1 mt-1 d-flex" type="submit">Tìm
                                            kiếm</button>

                                    </div>

                                </div>

                            </form>
                           
                            @endif

                        @endif
                        <br>
                </div>

                <div class="col-2 d-block ">
                </div>
                {{-- <div class="col-2 d-block"></div> --}}
            </div>
        </div>
        <br>

        <div class="container-fluid">
            @if ($url == 'home')
                <!-- Nội dung phụ -->
                <div class="row">
                    {{-- <div class="col-1 d-block"></div> --}}
                    @if ($ds_tintuc_moi_nhat != null)
                        @foreach ($ds_tintuc_moi_nhat as $key => $item)
                            <div class="col-md-8">
                                <div class="card bg-dark text-white border-0 zoom">
                                    <img src="/hinhanh/hinhanh_tintuc/{{ $item->ten_hinhanh }}" class="card-img"
                                        alt="...">
                                    <div class="card-img-overlay">
                                        <h5 class="card-title fw-bold">{{ $item->ten }}</h5>
                                        <div class="card-text overflow-hidden" style="height: 40%">
                                            {!! $item->noidung !!}
                                        </div>
                                        <p class="card-text">Viết lúc {{ date('H:i d-m-Y', $item->ngaytao) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <div class="col-md-4 bg-white">
                        <div class="">
                            @if ($ds_tintuc_moi_nhat2 != null)
                                <div class=" ">
                                    <h4 class="mt-2 text-center fw-bold">Tin tức mới</h4>
                                    @foreach ($ds_tintuc_moi_nhat2 as $key => $item)
                                        @if ($key != 0)
                                            <div class="card border-0  zoom">
                                                <div class="row g-0 ">
                                                    <div class="col-md-8">
                                                        <div class="card-body">
                                                            <h5 class="card-title fw-bold">{{ $item->ten }}</h5>
                                                            <p class="card-text">Viết lúc
                                                                {{ date('H:i d-m-Y', $item->ngaytao) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <img src="/hinhanh/hinhanh_tintuc/{{ $item->ten_hinhanh }}"
                                                            class="img-fluid " alt="...">
                                                    </div>
                                                    <a href="{{ route('tintuc', ['ma' => $item->ma]) }}"
                                                        class="stretched-link"></a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- <div class="col-1 d-block"></div> --}}
                </div>
                <br>
            @endif
            <!-- Nội dung chính -->
            <div class="row ">
                {{-- <div class="col-md-1 .d-block"></div> --}}
                <!-- Cột trái -->
                @yield('cot_trai')

                <!-- Cột nội dung ở giữa -->
                <div class=" col-md-6  bg-white ">
                    @yield('content')
                </div>

                <!-- Cột phải -->
                @yield('cot_phai')
                {{-- <div class="col-md-1 .d-block"></div> --}}
            </div>
        </div>


        <br>
        <!-- Footer -->

        <footer class=" text-white text-center p-5" style="background-color:#032a63">
            <p class="fw-bold">Thông tin nông nghiệp </p>
        </footer>
    </div>




    @if ($url == 'home' || $url == 'ds_tintuc')
        <!-- Modal -->
        <div class="modal fade modal-lg" id="ds_loai_tintuc" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Chọn thể loại tin tức mà bạn muốn tìm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <br>
                        <div class="overflow-show">
                            @foreach ($ds_loai_tintuc as $key => $item)
                                <button value="{{ $item->ten }}" type="button"
                                    class="btn btn-list btn-light border-secondary"
                                    id="loai_tintuc{{ $key }}" onclick="check_item2({{ $key }})">
                                    {{ $item->ten }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-lg" id="ds_gionglua" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Chọn các giống lúa có liên quan đến tin tức bạn
                            muốn tìm
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <br>
                        <div class="overflow-show">
                            @foreach ($ds_cac_gionglua as $key => $item)
                                <button value="{{ $item->ten }}" type="button"
                                    class="btn btn-list btn-light border-secondary" id="gionglua{{ $key }}"
                                    onclick="check_item({{ $key }})">
                                    {{ $item->ten }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($url == 'ds_gionglua')
    <!-- Modal -->
    <div class="modal fade modal-lg" id="ds_chongchiutot" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Giống lúa chống chịu tốt với</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="search_chongchiutot" class="form-control" placeholder="Nhập tên sâu bệnh">
                    <br>
                    <div class="overflow-show">
                        @foreach ($ds_cac_saubenh as $key => $item)
                        <button value="{{ $item->ten }}" type="button" class="btn btn-list btn-light border-secondary"
                            id="saubenh{{ $key }}" onclick="check_item({{ $key }})">
                            {{ $item->ten }}
                        </button>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-lg" id="ds_debinhiem" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Giống lúa dễ bị nhiễm bởi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="search_debinhiem" class="form-control" placeholder="Nhập tên sâu bệnh">
                    <br>
                    <div class="overflow-show">
                        @foreach ($ds_cac_saubenh as $key => $item)
                        <button value="{{ $item->ten }}" type="button" class="btn btn-list btn-light border-secondary"
                            id="saubenht{{ $key }}" onclick="check_item2({{ $key }})">
                            {{ $item->ten }}
                        </button>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endif

    @if (Session::has('msgDkSuc'))
        <script>
            swal({
                title: "Thành công!",
                text: "Đăng ký thành công!",
                icon: "success",
                button: "Đóng",
            });
        </script>
    @endif

    @if (Session::has('msgDnSuc'))
        <script>
            swal({
                title: "Thành công!",
                text: "Đăng nhập thành công!",
                icon: "success",
                button: "Đóng",
            });
        </script>
    @endif

    @if (Session::has('msgDnErr'))
        <script>
            swal({
                title: "Thất bại!",
                text: "Sai tài khoản hoặc mật khẩu!",
                icon: "error",
                button: "Đóng",
            });
        </script>
    @endif

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    @yield('js')
</body>

</html>





<script>
    var botmanWidget = {
        placeholderText: "Gõ gì đó!",
        aboutText: 'Nhập câu hỏi!',
        introMessage: "✋ Xin chào",
        title: "Nhắn tin",

    };


    
</script>

<script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
