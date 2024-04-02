@extends('layout.admin')

@section('title')
    {{ $title }}
@endsection


@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            {{-- @if (session('message'))
                <h6 class="alert alert-warning">{{ session('message') }}</h6>
            @endif --}}

            <form action="" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <input type="file" name="file" required class="form-control"  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"/>
                </div>
                <button type="submit" class="btn btn-success">Thêm</button>
            </form>
        </div>
    </div>
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
       ClassicEditor
            .create(document.querySelector('#traloi'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
