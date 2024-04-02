@extends('layout.user')

@section('title')
    {{ $title }}
@endsection

@section('cot_trai')
    @include('user.cot_trai')
@endsection
@section('cot_phai')
    @include('user.cot_phai')
@endsection

@section('content')
<br>

    <div class="row ">
        {!! $text !!}

        @foreach ($ds_gionglua as $item)
            <div class="row d-flex ">
                <div class="card border-0  zoom ">
                    <div class="row g-0 ">
                      <div class="col-md-4 mt-2">
                        <img src="/hinhanh/hinhanh_gionglua/{{ $item->ten_hinhanh }}" class="img-fluid " alt="...">
                      </div>
                      <div class="col-md-8">
                        <div class="card-body">
                          <h5 class="card-title fw-bold">{{ $item->ten }}</h5>
                          <div class="card-text overflow-hidden" style="height: 100px">{!! $item->thongtinkhac !!}</div>
                          
                          <p class="card-text"><small>Viết lúc {{ date("H:i d-m-Y", $item->ngaytao) }}</small></p>
                          @foreach ($item->chongchiutot as $item2)
                          <span class="badge text-bg-success">{{ $item2->ten_chongchiutot }}</span>
                          @endforeach
                          @foreach ($item->debinhiem as $item1)
                          <span class="badge text-bg-warning">{{ $item1->ten_debinhiem}}</span>
                          @endforeach
 
                          <a href="{{route('gionglua',['ma'=> $item->ma])}}" class="stretched-link"></a>
              
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
        @endforeach
    </div>
    <br>
    <div id="phantrang">{{ $ds_gionglua->appends(request()->all())->links() }}</div>
@endsection



@section('css')
    <style type="text/css">

    </style>
@endsection

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
       function check_item($id) {
            let item = document.getElementById("saubenh" + $id);
            let input1 = document.getElementById("chongchiutot");
            let itemt = document.getElementById("saubenht" + $id);
            if (item.className == "btn btn-list btn-light border-secondary") {
                item.className = "btn btn-list btn-secondary border-secondary";
                input1.value += item.value + ",";
                itemt.style.display = "none";
                itemt.classList.add("nocheck");
            } else {
                item.className = "btn btn-list btn-light border-secondary";
                input1.value = input1.value.replace(item.value + ",", "");
                itemt.style.display = "inline-block";
                itemt.classList.remove("nocheck");

            }

        }

        let input = document.getElementById("search_chongchiutot");

        function search_chongchiutot() {
            let num = {{ count($ds_cac_saubenh) }};
            for (let i = 0; i <= num; i++) {

                let item = document.getElementById("saubenh" + i);

                if (item.value.toLowerCase().includes(input.value.toLowerCase())) {
                    if (!item.classList.contains("nocheck")) {
                        item.style.display = "inline";
                    }
                } else {
                    item.style.display = "none";
                }


            }

        }
        input.addEventListener('input', search_chongchiutot);



        //////

        function check_item2($id) {
            let item = document.getElementById("saubenht" + $id);
            let input1 = document.getElementById("debinhiem");
            let itemt = document.getElementById("saubenh" + $id);
            if (item.className == "btn btn-list btn-light border-secondary") {
                item.className = "btn btn-list btn-secondary border-secondary";
                input1.value += item.value + ",";
                itemt.style.display = "none";
                itemt.classList.add("nocheck");

            } else {
                item.className = "btn btn-list btn-light border-secondary";
                input1.value = input1.value.replace(item.value + ",", "");
                itemt.style.display = "inline-block";
                itemt.classList.remove("nocheck");

            }

        }

        let input2 = document.getElementById("search_debinhiem");

        function search_debinhiem() {
            let num = {{ count($ds_cac_saubenh) }};
            for (let i = 0; i <= num; i++) {

                let item = document.getElementById("saubenht" + i);

                if (item.value.toLowerCase().includes(input2.value.toLowerCase())) {
                    if (!item.classList.contains("nocheck")) {
                        item.style.display = "inline";
                    }
                } else {
                    item.style.display = "none";
                }


            }

        }
        input2.addEventListener('input', search_debinhiem);
    </script>
@endsection
