@extends('layout.admin')

@section('title')
    {{ $title }}
@endsection


@section('content')
<br>
<div class="col-6">
    <form id ="add" class="add" action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="exampleInputEmail1" class="h4">Nhập địa chỉ Email</label>
          <input required="required" name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nhập địa chỉ Email" value="{{ old('email') ?? '' }}">
          @error('email')
          <span style="color:red">{{ $message }}</span>
             @enderror
        </div>
        <br>
        <div class="form-group">
            <label for="exampleInputEmail1" class="h4">Nhập tên người dùng</label>
            <input required="required" name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nhập tên người dùng" value="{{ old('name') ?? '' }}">
            @error('name')
            <span style="color:red">{{ $message }}</span>
               @enderror
          </div>
          <br>
        <div class="form-group">
          <label for="exampleInputPassword1" class="h4">Mật khẩu</label>
          <input required="required" name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Mật khẩu">
          @error('password')
          <span style="color:red">{{ $message }}</span>
      @enderror
        </div>
        <br>
        <div class="form-group">
            <label for="exampleInputPassword1" class="h4">Nhập lại mật khẩu</label>
            <input  required="required" name="password_confirmation" type="password" class="form-control" id="exampleInputPassword1" placeholder="Nhập lại mật khẩu">
        </div>
<br>
    <div>
        <button type="submit" class="btn btn-primary">Thêm mới</button>
    </div>
    <br>
    @csrf
</form>
</div>
<br>
<div>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th >Tên</th>
                <th >Email</th>
                <th >Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @if ($ds != null)
                @foreach ($ds as $key => $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td class="text-white">
                            @if($item->status_comment)                   <a type="button" class="btn btn-danger mt-1" href="{{route('admin.chan_binhluan',['ma'=> $item->id])}}" onclick="return confirm('Tiếp tục ?')">Chặn bình luận</a> 
                            @else                                   <a type="button" class="btn btn-success mt-1" href="{{route('admin.chophep_binhluan',['ma'=> $item->id])}}" onclick="return confirm('Tiếp tục ?')">Cho phép bình luận</a> 
                            @endif
                        </td>
                    </tr>
                @endforeach
        @endif
        </tbody>
        <tfoot>
            <tr>
                <th >Tên</th>
                <th >Email</th>
                <th >Thao tác</th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection

@section('css')
    <style type="text/css">
        .btn-list {
            margin-bottom: 5px;
        }
    </style>
@endsection

@section('js')
<script>
    new DataTable('#example');
 </script>
@endsection
