@extends('layout.admin')

@section('title')
    {{ $title }}
@endsection


@section('content')
    <form action="" method="POST">
        @csrf
        <h4 class="text-center text-upcase">Thống kê theo lượt hỏi</h4>
        <hr>
        <div class="row">
            <div class="col">
                <div class="input-group mb-3">
                    <span class="input-group-text">Top</span>
                    <input type="number" class="form-control" name=num value="" required>
                </div>
            </div>
            <div class="col">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">Thời gian</label>
                    <select class="form-select"  name=thoigian id="select" onchange="logic()">
                        <option value="tu">Từ</option>
                        {{-- <option value="trong">Trong</option> --}}
                        <option value="tatca" selected>Tất cả</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="input-group mb-3">
                    <span class="input-group-text">Từ</span>
                    <input type="date" class="form-control" name=tu disabled id="tu" required>
                </div>
            </div>
            <div class="col">
                <div class="input-group mb-3">
                    <span class="input-group-text">Đến</span>
                    <input type="date" class="form-control" name=den disabled id="den" required>
                </div>
            </div>
            {{-- <div class="col">
                <div class="input-group mb-3">
                    <span class="input-group-text">Trong</span>
                    <select class="form-select" id="inputGroupSelect01" name=trong>
                        @for( $i=1; $i<=12; $i++)
                        <option value="{{ $i.'/'.date("Y") }}" @if($i==1) selected @endif>{{ $i.'/'.date("Y") }}</option>
                        @endfor
                    </select>
                </div>
            </div> --}}
        </div>
        <div class="row">
            <div class="col-md-1">
                <button type="submit" class="btn btn-success">Liệt kê</button>
            </div>
        </div>
    </form>
    <hr>
    <div>
        <h4 class="text-center text-upcase text-primary">{{ $text ?? null }}</h4>
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Lượt hỏi</th>
                </tr>
            </thead>
            <tbody>
                @if ($ds != null)
                    @foreach ($ds as $key => $item)
                        <tr>
                            <td>{{ $item->ten }}</td>
                            <td>{{ $item->tong }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th>Tên</th>
                    <th>Lượt hỏi</th>
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
      
        function logic() {
            let select = document.getElementById('select');
            let tu = document.getElementById("tu");
            let den = document.getElementById("den");
            var value = select.options[select.selectedIndex].value;
            if(value == 'tu'){
                tu.removeAttribute('disabled')
                den.removeAttribute('disabled')
            };
            if(value == 'tatca'){
                tu.setAttribute('disabled','')
                den.setAttribute('disabled','')
            }
        }

    </script>
@endsection
