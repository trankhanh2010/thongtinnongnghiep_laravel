@extends('layout.admin')


@section('title')
    {{ $title }}
@endsection

{{-- @section('content')
    <div class="row">
        <div class="col">Tổng số bài viết tin tức:</div>
        <div class="col">Tổng số bài viết giống lúa:</div>
        <div class="col">Tổng số bài viết sâu bệnh:</div>
    </div>
    <hr>
    <div class="row p-1">
        <div class="col-4">
            <div class="row">Các bài viết tin tức nổi bật:</div>
            <br>
            @foreach ($ds_tintuc as $item)
                <div class="row">{{ $item->ten }}</div>
            @endforeach
        </div>
        <div class="col-4">
            <div class="row">Các bài viết giống lúa nổi bật:</div>
            <br>
            @foreach ($ds_gionglua as $item)
                <div class="row">{{ $item->ten }}</div>
            @endforeach
        </div>
        <div class="col-4">
            <div class="row">Các bài viết sâu bệnh nổi bật:</div>
            <br>
            @foreach ($ds_saubenh as $item)
                <div class="row">{{ $item->ten }}</div>
            @endforeach
        </div>
    </div>
@endsection --}}

@section('content')
    <div class="row">
        <div class="col-md-4">
            <p class="fw-lighter">Tin tức</p>
            <div>
                <canvas id="myChart1"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <p class="fw-lighter">Giống lúa</p>
            <div>
                <canvas id="myChart2"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <p class="fw-lighter">Sâu bệnh</p>
            <div>
                <canvas id="myChart3"></canvas>
            </div>
        </div>
    </div>
    
@endsection

@section('css')
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx1 = document.getElementById('myChart1');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: [ 'Bài viết 1', 'Bài viết 2', 'Bài viết 3', 'Bài viết 4', 'Bài viết 5'
                ],
                datasets: [{
                    label: '# Lượt xem',
                    data: [ {{  $ds_tintuc_10[0]->tong }},{{  $ds_tintuc_10[1]->tong }},{{  $ds_tintuc_10[2]->tong }},{{  $ds_tintuc_10[3]->tong }},{{  $ds_tintuc_10[4]->tong }}],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        const ctx2 = document.getElementById('myChart2');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: [ 'Bài viết 1', 'Bài viết 2', 'Bài viết 3', 'Bài viết 4', 'Bài viết 5'
                ],
                datasets: [{
                    label: '# Lượt xem',
                    data: [ {{  $ds_gionglua_10[0]->tong }},{{  $ds_gionglua_10[1]->tong }},{{  $ds_gionglua_10[2]->tong }},{{  $ds_gionglua_10[3]->tong }},{{  $ds_gionglua_10[4]->tong }}],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        const ctx3 = document.getElementById('myChart3');
        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: [ 'Bài viết 1', 'Bài viết 2', 'Bài viết 3', 'Bài viết 4', 'Bài viết 5'
                ],
                datasets: [{
                    label: '# Lượt xem',
                    data: [ {{  $ds_saubenh_10[0]->tong }},{{  $ds_saubenh_10[1]->tong }},{{  $ds_saubenh_10[2]->tong }},{{  $ds_saubenh_10[3]->tong }},{{  $ds_saubenh_10[4]->tong }}],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
