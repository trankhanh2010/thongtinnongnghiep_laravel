@extends('layout.admin')

@section('title')
    {{ $title }}
@endsection


@section('content')
    <form id ="add" class="add" action="" method="POST" enctype="multipart/form-data">

        <div>
            <label class="form-label h4">Câu hỏi</label>
            <textarea class="form-control" rows="1" id="ten" name="ten" placeholder="Nhập tên câu hỏi">{{ old('ten') }}</textarea>
            @error('ten')
                <span style="color:red">{{ $message }}</span>
            @enderror
            <div>
                <label class="form-label h4">Câu trả lời</label>
                <textarea class="form-control" rows="10" id="traloi" name="traloi" placeholder="Nhập câu trả lời">{{ old('traloi') }}</textarea>
                @error('traloi')
                    <span style="color:red">{{ $message }}</span>
                @enderror
            </div>
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
        <div class="card">
            <div class="card-body">
                {{-- @if (session('message'))
                    <h6 class="alert alert-warning">{{ session('message') }}</h6>
                @endif --}}
                <a href="{{ route('admin.tai_file') }}" class="m-2">Tải mẫu</a>
                <form action="/admin/add_cauhoi_excel" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <input type="file" name="file" required class="form-control"
                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                    </div>
                    <button type="submit" class="btn btn-success">Thêm</button>
                </form>
            </div>
        </div>
    </div>
    <br>
    <div>
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Trả lời</th>

                    <th>Lượt hỏi</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @if ($ds != null)
                    @foreach ($ds as $key => $item)
                        <tr>
                            <input type="text" id="ma{{ $key }}" value="{{ $item->ma }}" class="d-none">
                            <td>{{ $item->ten }}</td>
                            <td>{!! $item->traloi !!}</td>

                            <td>{{ $item->tong_luothoi }}</td>
                            <td class="text-white">
                                <a type="button" class="btn btn-primary  mt-1" data-bs-toggle="modal"
                                    data-bs-target="#edit_cauhoi" onclick="check_item({{ $key }})">Sửa</a>
                                <a type="button" class="btn btn-danger mt-1"
                                    href="{{ route('admin.delete_cauhoi', ['ma' => $item->ma]) }}"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa ?')">Xóa</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th>Tên</th>
                    <th>Trả lời</th>

                    <th>Lượt hỏi</th>
                    <th>Thao tác</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <form action="{{ route('admin.edit_cauhoi') }}" method="POST" id="form">
        <div class="modal fade modal-lg " id="edit_cauhoi" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Câu trả lời</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="overflow-show">
                            <div id="traloi_cu"> </div>
                            <div>
                                <input type="text" name="ma" id="ma" value="" class="d-none">
                                
                                <label class="form-label h4">Câu trả lời</label>
                                <textarea class="form-control" rows="10" id="edit_traloi" name="edit_traloi" placeholder="Nhập câu trả lời">{{ old('traloi') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>

                    </div>
                </div>
            </div>
        </div>
        @csrf
    </form>
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
        ClassicEditor
            .create(document.querySelector('#traloi'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#edit_traloi'))
         
            .catch(error => {
                console.error(error);
            });


        function check_item($key) {
            let input1 = document.getElementById("ma");
            // let input2 = document.getElementById("edit_traloi");
            // let traloicu = document.getElementById("traloi_cu");
            let ma = document.getElementById("ma" + $key);
            let traloi = document.getElementById("traloi" + $key);
            // let htmlm =  {{ $ds[$key]->traloi }};
            // traloicu.innerHTML  = htmlm;
            input1.value = ma.value;
        }
    </script>
@endsection
