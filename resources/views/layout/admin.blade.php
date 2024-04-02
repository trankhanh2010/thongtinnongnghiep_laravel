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

    <title>@yield('title')</title>

    <style type="text/css">
        .ck-editor__editable_inline {
            min-height: 200px;
        }

        .overflow-show {
            max-height: 300px;
            overflow: auto;
        }
    </style>
    @yield('css')

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark p-4 justify-content-between bg-dark">
        <a class="navbar-brand fw-bold" href="{{ route('admin.home') }}">
            <img src="/hinhanh/logo/logo1.png" width="30" height="30"
                class="d-inline-block align-top " alt="">
            Thông tin nông nghiệp
        </a>
        <a type="button" class="btn btn-warning d-none d-lg-inline-block mb-3 mb-md-0 ml-md-3 fw-bold"
            href="{{ route('admin_logout') }}">Đăng xuất</a>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 ">
                <div class="flex-shrink-0 p-3 sticky-top">
                    <a href="{{ route('admin.home') }}"
                        class="fw-bold d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                        <h3>Trang quản trị</h3>
                    </a>
                    <br>
                    <h5 class="lead">Xin chào {{ Auth::user()->name }}</h5>
                    <hr>
                    <ul class="list-unstyled ps-0">

                        <li class="mb-1">
                            <button
                                class="fw-bold fs-4 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                                data-bs-toggle="collapse" data-bs-target="#gionglua-collapse" aria-expanded="false">
                                Giống lúa
                            </button>
                            <div class="collapse @if (isset($url) && ($url == 'ds_gionglua' || $url == 'add_gionglua')) show @endif" id="gionglua-collapse">
                                <ul class="nav nav-pills flex-column mb-auto">
                                    <li class="nav-item">
                                        <a class="w-100  nav-link @if (isset($url) && $url == 'ds_gionglua') active @endif"
                                            href="{{ route('admin.ds_gionglua') }}">Danh sách</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="w-100  nav-link @if (isset($url) && $url == 'add_gionglua') active @endif"
                                            href="{{ route('admin.add_gionglua') }}">Thêm mới</a>
                                    </li>
                            </div>
                        </li>

                        <li class="mb-1">
                            <button
                                class="fw-bold fs-4 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                                data-bs-toggle="collapse" data-bs-target="#saubenh-collapse" aria-expanded="false">
                                Sâu bệnh
                            </button>
                            <div class="collapse @if (isset($url) && ($url == 'ds_saubenh' || $url == 'add_saubenh')) show @endif" id="saubenh-collapse">
                                <ul class="nav nav-pills flex-column mb-auto">
                                    <li class="nav-item">
                                        <a class="w-100  nav-link @if (isset($url) && $url == 'ds_saubenh') active @endif"
                                            href="{{ route('admin.ds_saubenh') }}">Danh sách</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="w-100  nav-link @if (isset($url) && $url == 'add_saubenh') active @endif"
                                            href="{{ route('admin.add_saubenh') }}">Thêm mới</a>
                                    </li>
                            </div>
                        </li>
                        <li class="mb-1">
                            <button
                                class="fw-bold fs-4 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                                data-bs-toggle="collapse" data-bs-target="#tintuc-collapse" aria-expanded="false">
                                Tin tức
                            </button>
                            <div class="collapse @if (isset($url) && ($url == 'ds_tintuc' || $url == 'add_tintuc')) show @endif" id="tintuc-collapse">
                                <ul class="nav nav-pills flex-column mb-auto">
                                    <li class="nav-item">
                                        <a class="w-100  nav-link @if (isset($url) && $url == 'ds_tintuc') active @endif"
                                            href="{{ route('admin.ds_tintuc') }}">Danh sách</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="w-100  nav-link @if (isset($url) && $url == 'add_tintuc') active @endif"
                                            href="{{ route('admin.add_tintuc') }}">Thêm mới</a>
                                    </li>
                            </div>
                        </li>
                        <hr>
                        <li class="mb-1">
                            <button
                                class="fw-bold fs-4 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                                data-bs-toggle="collapse" data-bs-target="#loai_tintuc-collapse" aria-expanded="false">
                                Loại tin tức
                            </button>
                            <div class="collapse @if (isset($url) && ( $url == 'add_loai_tintuc')) show @endif" id="loai_tintuc-collapse">
                                <ul class="nav nav-pills flex-column mb-auto">
                                    <li class="nav-item">
                                        <a class="w-100  nav-link @if (isset($url) && $url == 'add_tintuc') active @endif"
                                            href="{{ route('admin.add_loai_tintuc') }}">Thêm mới</a>
                                    </li>
                            </div>
                        </li>
                        <li class="mb-1">
                            <button
                                class="fw-bold fs-4 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                                data-bs-toggle="collapse" data-bs-target="#cauhoi-collapse" aria-expanded="false">
                                Câu hỏi
                            </button>
                            <div class="collapse @if (isset($url) && ( $url == 'add_cauhoi')) show @endif" id="cauhoi-collapse">
                                <ul class="nav nav-pills flex-column mb-auto">
                                    <li class="nav-item">
                                        <a class="w-100  nav-link @if (isset($url) && $url == 'add_cauhoi') active @endif"
                                            href="{{ route('admin.add_cauhoi') }}">Thêm mới</a>
                                    </li>
                            </div>
                        </li>
                        <li class="mb-1">
                            <button
                                class="fw-bold fs-4 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                                data-bs-toggle="collapse" data-bs-target="#phanhoi-collapse" aria-expanded="false">
                                Phản hồi
                            </button>
                            <div class="collapse @if (isset($url) && ($url == 'ds_phanhoi' )) show @endif" id="phanhoi-collapse">
                                <ul class="nav nav-pills flex-column mb-auto">
                                    <li class="nav-item">
                                        <a class="w-100  nav-link @if (isset($url) && $url == 'ds_phanhoi') active @endif"
                                            href="{{ route('admin.ds_phanhoi') }}">Danh sách</a>
                                    </li>
                            </div>
                        </li>
                        
                        <li class="mb-1">
                            <button
                                class="fw-bold fs-4 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                                data-bs-toggle="collapse" data-bs-target="#nguoidung-collapse" aria-expanded="false">
                                Người dùng
                            </button>
                            <div class="collapse @if (isset($url) && ($url == 'ds_nguoidung' || $url == 'add_nguoidung')) show @endif" id="nguoidung-collapse">
                                <ul class="nav nav-pills flex-column mb-auto">
                                    <li class="nav-item">
                                        <a class="w-100  nav-link @if (isset($url) && $url == 'add_nguoidung') active @endif"
                                            href="{{ route('admin.add_nguoidung') }}">Thêm mới</a>
                                    </li>
                            </div>
                        </li>
                        <hr>
                        <li class="mb-1">
                            <button
                                class="fw-bold fs-4 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                                data-bs-toggle="collapse" data-bs-target="#thongke-collapse" aria-expanded="false">
                                Thống kê
                            </button>
                            <div class="collapse @if (isset($url) && ($url == 'thongke_baiviet' || $url == 'thongke_cauhoi')) show @endif" id="thongke-collapse">
                                <ul class="nav nav-pills flex-column mb-auto">
                                    <li class="nav-item">
                                        <a class="w-100  nav-link @if (isset($url) && $url == 'thongke_baiviet') active @endif"
                                            href="{{ route('admin.thongke_baiviet') }}">Bài viết</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="w-100  nav-link @if (isset($url) && $url == 'thongke_cauhoi') active @endif"
                                            href="{{ route('admin.thongke_cauhoi') }}">Câu hỏi</a>
                                    </li>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-10 bg-light">
                <div class="container-fluid">
                    <br>
                    <div class="w-100 p-3 bg-white">
                        <div class=" ">
                            <p class="h4 text-uppercase text-center" style="color: #007bff">{{ $title }}</p>
                        </div>
                    </div>
                    <br>
                    @if($url == 'home')
                    <div class="row row-cols-1 row-cols-md-5 g-4">

                        <div class="col">
                          <div class="card border-0">
                            <div class="card-body">
                              <h5 class="card-title fw-lighter">TỔNG SỐ NGƯỜI DÙNG</h5>
                              <h3 class="card-text fw-bold ">{{ $tong_nguoidung }}</h3>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                            <div class="card border-0">
                              <div class="card-body">
                                <h5 class="card-title fw-lighter">TỔNG BÀI VIẾT TIN TỨC</h5>
                                <h3 class="card-text fw-bold ">{{ $tong_tintuc }}</h3>
                              </div>
                            </div>
                          </div>
                          <div class="col">
                            <div class="card border-0">
                              <div class="card-body">
                                <h5 class="card-title fw-lighter">TỔNG SỐ LOẠI TIN TỨC</h5>
                                <h3 class="card-text fw-bold ">{{ $tong_loai_tintuc }}</h3>
                              </div>
                            </div>
                          </div>
                          <div class="col">
                            <div class="card border-0">
                              <div class="card-body">
                                <h5 class="card-title fw-lighter">TỔNG BÀI VIẾT GIỐNG LÚA</h5>
                                <h3 class="card-text fw-bold ">{{ $tong_gionglua }}</h3>
                              </div>
                            </div>
                          </div>
                          <div class="col">
                            <div class="card border-0">
                              <div class="card-body">
                                <h5 class="card-title fw-lighter">TỔNG BÀI VIẾT SÂU BỆNH</h5>
                                <h3 class="card-text fw-bold ">{{ $tong_saubenh }}</h3>
                              </div>
                            </div>
                          </div>
                          <div class="col">
                            <div class="card border-0">
                              <div class="card-body">
                                <h5 class="card-title fw-lighter">TỔNG SỐ CÂU HỎI</h5>
                                <h3 class="card-text fw-bold ">{{ $tong_cauhoi }}</h3>
                              </div>
                            </div>
                          </div>

                      </div>
                      <br>
                      <div class="row">
                        <div class="col-md-4">
                            <div class="card border-0">
                                <div class="card-body">
                                  <h5 class="card-title fw-lighter">CÁC BÀI VIẾT TIN TỨC NỔI BẬT</h5>
                                  @foreach ($ds_tintuc_10 as $key => $item)
                                  <p class="card-text fst-italic ">{{ ($key+1).'. '.$item->ten }}</p>
                                 @endforeach
                                </div>
                              </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0">
                                <div class="card-body">
                                  <h5 class="card-title fw-lighter">CÁC BÀI VIẾT GIỐNG LÚA NỔI BẬT</h5>
                                  @foreach ($ds_gionglua_10 as $key => $item)
                                  <p class="card-text fst-italic ">{{ ($key+1).'. '.$item->ten }}</p>
                                 @endforeach
                                </div>
                              </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0">
                                <div class="card-body">
                                  <h5 class="card-title fw-lighter">CÁC BÀI VIẾT SÂU BỆNH NỔI BẬT</h5>
                                  @foreach ($ds_saubenh_10 as $key => $item)
                                  <p class="card-text fst-italic ">{{ ($key+1).'. '.$item->ten }}</p>
                                 @endforeach
                                </div>
                              </div>
                        </div>
                      </div>
                      <br>
                    @endif
                    <div class="w-100 p-3 bg-white">
                        @yield('content')
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 ">
        <p class="fw-bold">Thông tin nông nghiệp </p>
    </footer>

    @if (Session::has('msgSuc'))
        <script>
            swal({
                title: "Thành công!",
                text: "Thao tác thành công!",
                icon: "success",
                button: "Đóng",
            });
        </script>
    @endif
    @if (!empty($errors->any()) || Session::has('msgErr'))
        <script>
            swal({
                title: "Thất bại!",
                text: "Vui lòng kiểm tra lại!",
                icon: "error",
                button: "Đóng",
            });
        </script>
    @endif
    @if (Session::has('msgErrTK'))
    <script>
        swal({
            title: "Lỗi!",
            text: "Kiểm tra lại thao tác!",
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
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    @yield('js')
</body>

</html>
