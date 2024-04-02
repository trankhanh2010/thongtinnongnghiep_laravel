<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
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
        <a class="navbar-brand" href="#">
          <img src="/docs/4.0/assets/brand/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top" alt="">
          Thông tin nông nghiệp
          {{ Auth::user()->name }}
          {{ Auth::user()->is_admin }}
        </a>
        <a type="button" class="btn btn-warning d-none d-lg-inline-block mb-3 mb-md-0 ml-md-3" href="{{ route('admin_logout') }}">Đăng xuất</a>
      </nav>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3">
                <button class="btn-dark" type="button" >
                <span class=""><</span>
              </button>
            <h2>Trang quản trị</h2>
            <nav class="navbar navbar-light nav-pills bg-white sticky-top d-block">
                <a class="w-100  nav-link @if(isset($url) && $url == "home") active @endif" href="{{ route("admin.home") }}">Trang chủ</a>
                <a class="w-100  nav-link @if(isset($url) && $url == "ds_gionglua") active @endif" href="{{ route("admin.ds_gionglua") }}">Danh sách giống lúa</a>
                <a class="w-100  nav-link @if(isset($url) && $url == "add_gionglua") active @endif" href="{{ route("admin.add_gionglua") }}">Thêm mới giống lúa</a>
                <a class="w-100  nav-link @if(isset($url) && $url == "ds_saubenh") active @endif" href="{{ route("admin.ds_saubenh") }}">Danh sách sâu bệnh</a>
                <a class="w-100  nav-link @if(isset($url) && $url == "add_saubenh") active @endif" href="{{ route("admin.add_saubenh") }}">Thêm mới sâu bệnh</a>
                <a class="w-100  nav-link @if(isset($url) && $url == "ds_tintuc") active @endif" href="{{ route("admin.ds_tintuc") }}">Danh sách tin tức</a>
                <a class="w-100  nav-link @if(isset($url) && $url == "add_tintuc") active @endif" href="{{ route("admin.add_tintuc") }}">Thêm mới tin tức</a>
                <a class="w-100  nav-link @if(isset($url) && $url == "ds_cauhoi") active @endif" href="#">Danh sách câu hỏi</a>
                <a class="w-100  nav-link @if(isset($url) && $url == "add_cauhoi") active @endif" href="#">Thêm mới câu hỏi</a>
                <a class="w-100  nav-link @if(isset($url) && $url == "ds_phanhoi") active @endif" href="#">Danh sách phản hồi</a>
                <a class="w-100  nav-link @if(isset($url) && $url == "ds_nguoidung") active @endif" href="#">Danh sách người dùng</a>
                <a class="w-100  nav-link @if(isset($url) && $url == "add_nguoidung") active @endif" href="{{ route("admin.add_nguoidung") }}">Thêm mới người dùng</a>
            </nav>
        </div>
        <div class="col-lg-9 bg-light">
            <div class="container-fluid">
                <div class="w-100 p-3 bg-white">
                    <div class="navbar-brand " >
                        <p class="font-weight-bold text-uppercase text-center" style="color: #007bff" >{{ $title }}</p>
                    </div>
                </div>
                @yield('content')
            </div>
        </div>
    </div>
</div>
    
@if(Session::has('msgSuc'))
<script>
    swal({
title: "Thành công!",
text: "Thao tác thành công!",
icon: "success",
button: "Đóng",
});
</script>
@endif
@if(!empty($errors->any()) || Session::has('msgErr'))
<script>
    swal({
title: "Thất bại!",
text: "Vui lòng kiểm tra lại!",
icon: "error",
button: "Đóng",
});
</script>
@endif

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    @yield('js')
</body>

</html>




