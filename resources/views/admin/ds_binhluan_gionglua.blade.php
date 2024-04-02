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
                    <th >Thời gian bình luận</th>
                    <th >Nội dung</th>
                    <th >Email người bình luận</th>
                    <th >Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @if ($ds != null)
                    @foreach ($ds as $key => $item)
                        <tr>
                            <td>{{ date("H:i:s d-m-Y", $item->ngay_binhluan) }}</td>
                            <td>{{ $item->noidung }}</td>
                            <td>{{ $item->email }}</td>
                            <td class="text-white">
                                @if($item->trangthai)                   <a type="button" class="btn btn-danger mt-1" href="{{route('admin.an_binhluan',['ma'=> $item->ma])}}" onclick="return confirm('Tiếp tục ?')">Ẩn</a> 
                                @else                                   <a type="button" class="btn btn-success mt-1" href="{{route('admin.hien_binhluan',['ma'=> $item->ma])}}" onclick="return confirm('Tiếp tục ?')">Hiện</a> 
                                @endif
                            </td>
                        </tr>
                    @endforeach
            @endif
            </tbody>
            <tfoot>
                <tr>
                    <th >Thời gian bình luận</th>
                    <th >Nội dung</th>
                    <th >Email người bình luận</th>
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
