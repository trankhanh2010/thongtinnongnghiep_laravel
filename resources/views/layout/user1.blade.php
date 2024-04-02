<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>

        <title>@yield('title')</title>

    <style type="text/css">


    </style>
    @yield('css')

</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark p-4 justify-content-between" style="background: #6f42c1">
    <a class="navbar-brand" href="#">
      <img src="/docs/4.0/assets/brand/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top" alt="">
      Thông tin nông nghiệp
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="#">Trang chủ </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Tin tức</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Giống lúa</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Sâu bệnh</a>
        </li>
        

      </ul>
    </div>
    <a type="button" class="btn btn-success d-none d-lg-inline-block mb-3 mb-md-0 ml-md-3" href="#">Đăng nhập</a>
    <a type="button" class="btn btn-warning d-none d-lg-inline-block mb-3 mb-md-0 ml-md-3" href="#">Đăng ký</a>


  </nav>
    <div class="container-fluid">
        {{-- <div class="row">
            <div class="col-lg-2">
            </div>
            <div class="col-8">
                @yield('content')
            </div>
            <div class="col-lg-2">
            </div>
        </div> --}}
          <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Danh mục</li>
              </ol>
          </nav>
       
      <!-- Nội dung chính -->
          <div class="row">
              <!-- Cột trái -->
              <div class="col-md-2">
                  <div class="bg-light p-3 sticky-top">
                     @IF($tintuc_moi!=null)
                     <h4>Tin tức mới</h4>
                     <ul>
                         @foreach($tintuc_moi as $key => $item)
                         <li><a href="#">{{ $item->ten }}</a></li>
                         @endforeach
                     </ul>
                     @endif
                  </div>
              </div>
               
              <!-- Cột nội dung ở giữa -->
              <div class="col-md-8">
                <div class="bg-light p-3">
                  <form>
                      <div class="form-group">
                          <input type="text" class="form-control" placeholder="Tìm kiếm...">
                      </div>
                  </form>
              </div>
                  @yield('content')

              </div>
       
              <!-- Cột phải -->
              <div class="col-md-2">
                <div class="bg-light p-3 sticky-top">
                  @IF($tintuc_noibat!=null)
                  <h4>Tin tức nổi bật</h4>
                  <ul>
                      @foreach($tintuc_noibat as $key => $item)
                      <li><a href="#">{{ $item->ten }}</a></li>
                      @endforeach
                  </ul>
                  @endif
                </div>
            </div>
          </div>
       

    </div>
      <!-- Footer -->
      <footer class="bg-dark text-white text-center py-3">
        <p>Thông tin nông nghiệp </p>
    </footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
            <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    @yield('js')
</body>

</html>





<script>
    var botmanWidget = {
        aboutText: 'Write Something',
        introMessage: "✋ Hi! I'm form Code Solution Stuff"
    };
</script>

<script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
