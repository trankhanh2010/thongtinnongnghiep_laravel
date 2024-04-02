<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    </style>
    @yield('css')

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark p-4 " aria-label="Fifth navbar example"
        style="background-color:#6f42c1 ">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
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
                        <a class="nav-link @if ($url == 'home') active @endif" aria-current="page"
                            href="{{ route('home') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if ($url == 'ds_gionglua') active @endif" aria-current="page"
                            href="{{ route('ds_gionglua') }}">Giống lúa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if ($url == 'ds_saubenh') active @endif" aria-current="page"
                            href="{{ route('ds_saubenh') }}">Sâu bệnh</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if ($url == 'ds_tintuc') active @endif" aria-current="page"
                            href="{{ route('ds_tintuc') }}">Tin tức</a>
                    </li>
                </ul>
                <div>
                    @if (Auth::user())
                        <a type="button" class="btn btn-success">Xin chào {{ Auth::user()->name }}</a>
                        <a href="{{ route('dangxuat') }}" type="button" class="btn btn-warning">Đăng xuất</a>
                    @else
                        <a href="{{ route('dangnhap') }}" type="button" class="btn btn-primary">Đăng nhập</a>
                        <a href="{{ route('dangky') }}" type="button" class="btn btn-success">Đăng ký</a>
                    @endif

                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid bg-light">
        <br>
        <div class="row bg-white">
            <div class="col-2 d-block"></div>
            <div class="col-8 p-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"
                                class="link-underline link-underline-opacity-0">Trang chủ</a></li>
                        @if ($url != 'home')
                            <li class="breadcrumb-item " disabled aria-current="page"><a href="#"
                                    class="link-dark link-underline link-underline-opacity-0">{{ $title }}</a>
                            </li>
                        @endif
                    </ol>
                </nav>
            </div>
            <div class="col-2 d-block"></div>
        </div>
        <br>

        <!-- Nội dung chính -->
        <div class="row ">
            <!-- Cột trái -->
            @yield('cot_trai')

            <!-- Cột nội dung ở giữa -->
            <div class="col-md-6  bg-white">
                @yield('content')

            </div>

            <!-- Cột phải -->
            @yield('cot_phai')
        </div>


        <br>
    </div>
    <!-- Footer -->

    <footer class="bg-dark text-white text-center py-3">
        <p>Thông tin nông nghiệp </p>
    </footer>

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
