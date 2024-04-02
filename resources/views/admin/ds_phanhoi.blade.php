@extends('layout.admin')

@section('title')
    {{ $title }}
@endsection


@section('content')

    <div>
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Tên người phản hồi</th>
                    <th>Email người phản hồi</th>
                    <th>Phản hồi</th>
                    <th>Trả lời</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @if ($ds != null)
                    @foreach ($ds as $key => $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->ten }}</td>
                            <td>{!! $item->traloi !!}</td>
                            <td class="text-white">
                                <input type="text"  id="ma{{ $key }}" value="{{ $item->ma }}" class="d-none">
                                <a type="button" class="btn @if($item->traloi == '') btn-success @else btn-warning @endif mt-1" data-bs-toggle="modal"
                                    data-bs-target="#edit_phanhoi" onclick="check_item({{ $key }})">@if($item->traloi == '')Trả lời @else Cập nhật @endif</a>
                                {{-- <a type="button" class="btn btn-warning mt-1" href="{{route('admin.edit_phanhoi',['ma'=> $item->ma])}}">Sửa</a>  --}}
                                <a type="button" class="btn btn-danger mt-1"
                                    href="{{ route('admin.delete_phanhoi', ['ma' => $item->ma]) }}"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa ?')">Xóa</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th>Tên người phản hồi</th>
                    <th>Email người phản hồi</th>
                    <th>Phản hồi</th>
                    <th>Trả lời</th>
                    <th>Thao tác</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <form action="{{ route('admin.edit_phanhoi') }}" method="POST" id="form">
        <div class="modal fade modal-lg " id="edit_phanhoi" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Trả lời phản hồi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="overflow-show">
                            <div>
                                <input type="text" name="ma" id="ma" value="" class="d-none">
                                <label class="form-label h4">Câu trả lời</label>
                                <textarea class="form-control" rows="10" id="traloi" name="traloi" placeholder="Nhập câu trả lời">{{ old('traloi') }}</textarea>
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

        function check_item($key) {
            let input1 = document.getElementById("ma");
            let ma = document.getElementById("ma"+$key);
            
            input1.value = ma.value;
        }
    </script>
@endsection
