@extends('layout.admin')

@section('title')
    {{ $title }}
@endsection


@section('content')
    <br>
    <div>
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th >Tên</th>
                    <th >Ngày tạo</th>
                    <th >Cập nhật gần nhất</th>
                    <th >Lượt xem</th>
                    <th >Bình luận</th>

                    <th >Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @if ($ds != null)
                    @foreach ($ds as $key => $item)
                        <tr>
                            <td>{{ $item->ten }}</td>
                            <td>{{ date("H:i:s d-m-Y", $item->ngaytao) }}</td>
                            <td>{{ date("H:i:s d-m-Y", $item->ngaycapnhat) }}</td>
                            <td>{{ $item->tong_luotxem }}</td>
                            <td>@if($item->tong_binhluan>0)<a href="{{route('admin.ds_binhluan_saubenh',['ma'=> $item->ma])}}" type="button" class="btn btn-success mt-1 item-center">{{ $item->tong_binhluan }} bình luận</a>  @else <a  type="button" class="btn btn-warning mt-1 item-center disabled">{{ $item->tong_binhluan }} bình luận</a> @endif</td>

                            <td class="text-white">
                                <a type="button" class="btn btn-danger mt-1" href="{{route('admin.delete_saubenh',['ma_saubenh'=> $item->ma])}}" onclick="return confirm('Bạn có chắc chắn muốn xóa ?')">Xóa</a> 
                                <a type="button" class="btn btn-warning mt-1" href="{{route('admin.edit_saubenh',['ma_saubenh'=> $item->ma])}}">Sửa</a> 
                                <a type="button" class="btn btn-primary mt-1" href="{{route('admin.ds_thongtin_capnhat_saubenh',['ma_saubenh'=> $item->ma])}}">Lịch sử</a>
                            </td>
                        </tr>
                    @endforeach
            @endif
            </tbody>
            <tfoot>
                <tr>
                    <th >Tên</th>
                    <th >Ngày tạo</th>
                    <th >Cập nhật gần nhất</th>
                    <th >Lượt xem</th>
                    <th >Bình luận</th>

                    <th >Thao tác</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <br>

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
