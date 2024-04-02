@extends('layout.user')


@section('title')
    {{ $title }}
@endsection
@section('cot_trai')
    <div class="col-md-3  d-inline">
    </div>
@endsection
@section('cot_phai')
    <div class="col-md-3  d-inline">
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-3  d-inline">
        </div>
        <div class="col-md-6 border  mt-5 border-1">
            <br>
            <h4 class="text-center">ĐĂNG KÝ TÀI KHOẢN</h4>
            <br>
            <form id ="add" class="add" action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <input required="required" name="email" type="email" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="Nhập địa chỉ Email" value="{{ old('email') ?? '' }}">
                    @error('email')
                        <span style="color:red">{{ $message }}</span>
                    @enderror
                </div>
                <br>
                <div class="form-group">
                    <input required="required" name="name" type="text" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="Nhập tên người dùng" value="{{ old('name') ?? '' }}">
                    @error('name')
                        <span style="color:red">{{ $message }}</span>
                    @enderror
                </div>
                <br>
                <div class="form-group">
                    <input required="required" name="password" type="password" class="form-control" id="exampleInputPassword1"
                        placeholder="Mật khẩu">
                    @error('password')
                        <span style="color:red">{{ $message }}</span>
                    @enderror
                </div>
                <br>
                <div class="form-group">
                    <input required="required" name="password_confirmation" type="password" class="form-control"
                        id="exampleInputPassword1" placeholder="Nhập lại mật khẩu">
                </div>
                <br>
                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Tiếp tục</button>
                </div>
                <br>
                @csrf
            </form>
        </div>
        <div class="col-md-3  d-inline">
        </div>
    </div>
    <br>
<br>
<br>
@endsection
@section('css')
    <style type="text/css">

    </style>
@endsection

@section('js')
    <script></script>
@endsection
