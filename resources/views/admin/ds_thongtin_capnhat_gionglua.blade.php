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
                    <th >Thời gian</th>
                    <th >Hành động</th>
                    <th >Bởi</th>
                    <th >Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @if ($ds != null)
                    @foreach ($ds as $key => $item)
                        <tr>
                            <td>{{ $item->ten }}</td>
                            <td>{{ date("H:i:s d-m-Y", $item->ngaycapnhat) }}</td>
                            @if($item->ma_thongtin_capnhat!=null)<td style="color:#007bff" class="h4">Cập nhật </td> @else <td style="color: #4CAF50" class="h4">Tạo mới</td> @endif
                            <td>{{ $item->email }}</td>
                            <td class="text-white">
                                <a type="button" class="btn btn-primary" href="{{route('admin.detail_thongtin_capnhat_gionglua',['ma'=> $item->ma])}}" >Xem chi tiết</a>
                            </td>
                        </tr>
                    @endforeach
            @endif
            </tbody>
            <tfoot>
                <tr>
                    <th >Tên</th>
                    <th >Thời gian</th>
                    <th >Hành động</th>
                    <th >Bởi</th>
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
