@extends('layout.admin')

@section('title')
    {{ $title }}
@endsection


@section('content')
    <form id ="add" class="add" action="" method="POST" enctype="multipart/form-data">

        <div>
            <label class="form-label h4">Tên loại tin tức</label>
            <textarea class="form-control" rows="1" id="ten" name="ten" placeholder="Nhập tên loại tin tức">{{ old('ten') }}</textarea>
            @error('ten')
                <span style="color:red">{{ $message }}</span>
            @enderror
        </div>
        <br>
        <div>
            <button type="submit" class="btn btn-primary">Thêm mới</button>
        </div>
        <br>
        @csrf
    </form>
    <br>
    <div>
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th >Tên</th>
                    <th >Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @if ($ds != null)
                    @foreach ($ds as $key => $item)
                        <tr>
                            <td>{{ $item->ten }}</td>
                            <td class="text-white">
                                <a type="button" class="btn btn-danger" href="{{route('admin.delete_loai_tintuc',['ma'=> $item->ma])}}" onclick="return confirm('Bạn có chắc chắn muốn xóa ?')">Xóa</a> 
                            </td>
                        </tr>
                    @endforeach
            @endif
            </tbody>
            <tfoot>
                <tr>
                    <th >Tên</th>
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
