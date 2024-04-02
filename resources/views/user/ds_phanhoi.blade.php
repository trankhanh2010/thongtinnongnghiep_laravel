@extends('layout.user')

@section('title')
    {{ $title }}
@endsection

@section('cot_trai')
<div class="col-md-3  d-inline">
</div>@endsection
@section('cot_phai')
<div class="col-md-3  d-inline">
</div>@endsection

@section('content')
<div class="w-100 p-3 bg-white">
    <div class="navbar-brand ">
        <p class="h4 text-uppercase text-center" style="color: #007bff">{{ $title }}</p>
    </div>
</div>
<br>

<div>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Tên</th>
                <th>Trả lời</th>
                <th>Gửi lúc</th>

            </tr>
        </thead>
        <tbody>
            @if ($ds_phanhoi != null)
                @foreach ($ds_phanhoi as $key => $item)
                    <tr style="">
                        <td>{{ $item->ten }}</td>
                        <td class="" style="@if($item->traloi != null) background: #9cf4ad @endif">{!! $item->traloi !!} @if($item->traloi == null) Chưa có phản hồi @endif</td>
                        <td>{{ date('H:i d-m-Y', $item->ngay_phanhoi) }}</td>

                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th>Tên</th>
                <th>Trả lời</th>
                <th>Gửi lúc</th>

            </tr>
        </tfoot>
    </table>
</div>
@endsection



@section('css')
    <style type="text/css">

    </style>
@endsection

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
          new DataTable('#example');
    </script>
@endsection
