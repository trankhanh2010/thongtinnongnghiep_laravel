@extends('layout.admin')

@section('title')
    {{ $title }}
@endsection


@section('content')

    <div>
        <form id ="add" class="add" action="" method="POST" enctype="multipart/form-data">
            <br>
            <div>
                <label class="form-label h4">Tên tin tức</label>
                <textarea  class="form-control" rows="1" id="comment" name="ten" placeholder="Nhập tên tin tức">{{ old('ten') ?? $detail->ten }}</textarea>
                @error('ten')
                    <span style="color:red">{{ $message }}</span>
                @enderror
            </div>
            <br>

            <div>
                @if ($ds_co_loai_tintuc != null)
                    <div>
                        <div>
                            <input type="text" name="ds_xoa_co_loai_tintuc" id="ds_xoa_co_loai_tintuc" class="d-none">
                        </div>
                        <div class="row">
                            <div class="col">
                                <p class="h4">Tin tức thuộc các thể loại: </p>
                            </div>
                            <div class="col  justify-content-center"><button id="btn_hoantac_debinhiem" disabled
                                    type="button" class="btn btn-primary" onclick="hoantac_debinhiem()">Hoàn
                                    tác</button></div>
                        </div>
                        <br>
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Tên </th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ds_loai_tintuc as $key => $item)
                                    <tr id="debinhiem{{ $key }}"
                                        class="@if ($item->show != 1) d-none @else debinhiem @endif">
                                        <td>{{ $item->ten }}</td>
                                        <td id="tt"><a class="btn btn-warning"
                                                onclick="xoadebinhiem({{ $key }},{{ $item->ma }})">Xóa</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <p class="form-label h4">Thêm mới:</p>
                <input type="text" id="search_debinhiem" class="form-control" placeholder="Nhập tên loại tin tức">
                <br>
                <textarea name="debinhiem" id="debinhiem" class="form-control" readonly rows="2"></textarea>
                <br>
                <div class="overflow-show">
                    @foreach ($ds_loai_tintuc as $key => $item)
                        <button value="{{ $item->ten }}" type="button"
                            class="btn btn-list btn-light border-secondary @if ($item->show != 0) d-none @endif"
                            id="saubenht{{ $key }}" onclick="check_item2({{ $key }})">
                            {{ $item->ten }}
                        </button>
                    @endforeach
                </div>
                <br>
            </div>


            <div>
                <label class="form-label h4">Nội dung</label>
                <textarea class="form-control" rows="10" id="noidung" name="noidung" placeholder="Nhập nội dung tin tức">{{ old('noidung') ?? $detail->noidung }}</textarea>
                @error('noidung')
                    <span style="color:red">{{ $message }}</span>
                @enderror
            </div>

            <br>
            @if ($ds_hinhanh != null)
                <div>
                    <input type="text" name="ds_xoahinhanh" id="ds_xoahinhanh" class="d-none">
                </div>
                <div>
                    <div class="row">
                        <div class="col">
                            <p class="h4">Danh sách hình ảnh </p>
                        </div>
                        <div class="col d-flex justify-content-center"><button id="btn_hoantac_hinhanh" disabled
                                type="button" class="btn btn-primary" onclick="hoantac_hinhanh()">Hoàn tác</button></div>
                    </div>
                    <br>
                    <div class="overflow-show" style="max-height: 500px">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Hình ảnh</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ds_hinhanh as $key => $item)
                                    <tr id="hinhanh{{ $key }}">
                                        <td><img src="/hinhanh/hinhanh_tintuc/{{ $item->ten }}"
                                                class="img-thumbnail w-50 p-1"></td>
                                        <td id="tt"><a class="btn btn-warning"
                                                onclick="xoahinhanh({{ $key }},{{ $item->ma }})">Xóa</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
            @endif

            <div>
                <label class="form-label h4">Thêm hình ảnh</label>
                <input id="files" type="file" multiple="multiple" name="hinhanh[]"
                    accept="image/jpeg, image/png, image/jpg">
                <output id="result">

                    <script>
                        document.querySelector("#files").addEventListener("change", (e) => { //CHANGE EVENT FOR UPLOADING PHOTOS
                            if (window.File && window.FileReader && window.FileList && window
                                .Blob) { //CHECK IF FILE API IS SUPPORTED
                                const files = e.target.files; //FILE LIST OBJECT CONTAINING UPLOADED FILES
                                const output = document.querySelector("#result");
                                output.innerHTML = "";
                                for (let i = 0; i < files.length; i++) { // LOOP THROUGH THE FILE LIST OBJECT
                                    if (!files[i].type.match("image"))
                                        continue; // ONLY PHOTOS (SKIP CURRENT ITERATION IF NOT A PHOTO)
                                    const picReader = new FileReader(); // RETRIEVE DATA URI 
                                    picReader.addEventListener("load", function(event) { // LOAD EVENT FOR DISPLAYING PHOTOS
                                        const picFile = event.target;
                                        const div = document.createElement("div");
                                        div.className = "d-inline";
                                        div.innerHTML =
                                            `<img class="img-thumbnail w-50 p-1" src="${picFile.result}" title="${picFile.name}"/>`;
                                        output.appendChild(div);
                                    });
                                    picReader.readAsDataURL(files[i]); //READ THE IMAGE
                                }
                            } else {
                                alert("Your browser does not support File API");
                            }
                        });
                    </script>
            </div>
            <br>
            <div>
                @if ($ds_co_lienquan_gionglua != null)
                    <div>
                        <div>
                            <input type="text" name="ds_xoa_co_lienquan_gionglua" id="ds_xoa_co_lienquan_gionglua"
                                class="d-none">
                        </div>
                        <div class="row">
                            <div class="col">
                                <p class="h4">Các loại giống lúa có liên quan đến tin tức: </p>
                            </div>
                            <div class="col  justify-content-center"><button id="btn_hoantac_co_lienquan_gionglua" disabled
                                    type="button" class="btn btn-primary" onclick="hoantac_chongchiutot()">Hoàn
                                    tác</button></div>
                        </div>
                        <br>
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ds_gionglua as $key => $item)
                                    <tr id="chongchiutot{{ $key }}"
                                        class="@if ($item->show != 1) d-none @else chongchiutot @endif">
                                        <td>{{ $item->ten }}</td>
                                        <td id="tt"><a class="btn btn-warning"
                                                onclick="xoachongchiutot({{ $key }},{{ $item->ma }})">Xóa</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <br>
                <p class="form-label h4">Thêm mới:</p>
                <input type="text" id="search_chongchiutot" class="form-control" placeholder="Nhập tên giống lúa">
                <br>
                <textarea name="chongchiutot" id="chongchiutot" class="form-control" readonly rows="2"></textarea>
                <br>
                {{-- <div id="chonchongchiutot"> --}}
                <div class="overflow-show">
                    @foreach ($ds_gionglua as $key => $item)
                        <button value="{{ $item->ten }}" type="button"
                            class="btn btn-list btn-light border-secondary  @if ($item->show != 0) d-none @endif"
                            id="saubenh{{ $key }}" onclick="check_item({{ $key }})">
                            {{ $item->ten }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </div>
            <br>
            @csrf
        </form>
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
        //
        let ds_xoahinhanh = document.getElementById("ds_xoahinhanh");
        let btn_hoantac_hinhanh = document.getElementById("btn_hoantac_hinhanh");

        function xoahinhanh($key, $ma_hinhanh) {
            ds_xoahinhanh.value += $ma_hinhanh + ",";
            let item = document.getElementById('hinhanh' + $key);
            item.style.display = "none";
            btn_hoantac_hinhanh.disabled = false;

        }

        function hoantac_hinhanh() {
            btn_hoantac_hinhanh.disabled = true;
            clear_input_ds_xoahinhanh();
            let num = {{ count($ds_hinhanh) }};
            for (let i = 0; i <= num; i++) {

                let item = document.getElementById("hinhanh" + i);
                item.style.display = "table-row";
            }

        }

        function clear_input_ds_xoahinhanh() {
            ds_xoahinhanh.value = '';
        }
        /////

        function check_item($id) {
            let item = document.getElementById("saubenh" + $id);
            let input1 = document.getElementById("chongchiutot");
            let itemt = document.getElementById("saubenht" + $id);

            if (item.classList.contains("btn-light")) {
                item.classList.add("btn-secondary");
                item.classList.remove("btn-light");
                input1.value += item.value + ",";
                itemt.classList.add("d-none");
                itemt.classList.add("nocheck");
            } else {
                item.classList.add("btn-light");
                item.classList.remove("btn-secondary");
                input1.value = input1.value.replace(item.value + ",", "");
                itemt.classList.remove("d-none");
                itemt.classList.remove("nocheck");
            }

        }

        let input = document.getElementById("search_chongchiutot");

        function search_chongchiutot() {
            let num = {{ count($ds_gionglua) }};
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

        let ds_xoachongchiutot = document.getElementById("ds_xoa_co_lienquan_gionglua");
        let btn_hoantac_chongchiutot = document.getElementById("btn_hoantac_co_lienquan_gionglua");

        function xoachongchiutot($key, $ma) {
            ds_xoachongchiutot.value += $ma + ",";
            let item = document.getElementById('chongchiutot' + $key);
            item.style.display = "none";
            let item1 = document.getElementById('saubenh' + $key);
            item1.classList.remove("d-none");
            btn_hoantac_chongchiutot.disabled = false;
        }

        function hoantac_chongchiutot() {
            btn_hoantac_chongchiutot.disabled = true;
            clear_input_ds_xoachongchiutot();
            let num = {{ count($ds_gionglua) }};
            for (let i = 0; i <= num; i++) {
                let item = document.getElementById("chongchiutot" + i);
                if (item.classList.contains("chongchiutot")) {
                    item.style.display = "table-row";

                    let item1 = document.getElementById("saubenh" + i);
                    item1.classList.add("d-none");
                    item1.classList.remove("btn-light");
                    item1.classList.remove("btn-secondary");
                    item1.classList.remove("nocheck");
                    item1.classList.add("btn-light");
                    let input1 = document.getElementById("chongchiutot");
                    input1.value = input1.value.replace(item1.value + ",", "");

                }
            }
        }

        function clear_input_ds_xoachongchiutot() {
            ds_xoachongchiutot.value = '';
        }


        ////


        function check_item2($id) {
            let item = document.getElementById("saubenht" + $id);
            let input1 = document.getElementById("debinhiem");
            let itemt = document.getElementById("saubenh" + $id);

            if (item.classList.contains("btn-light")) {
                item.classList.add("btn-secondary");
                item.classList.remove("btn-light");
                input1.value += item.value + ",";
                itemt.classList.add("d-none");
                itemt.classList.add("nocheck");
            } else {
                item.classList.add("btn-light");
                item.classList.remove("btn-secondary");
                input1.value = input1.value.replace(item.value + ",", "");
                itemt.classList.remove("d-none");
                itemt.classList.remove("nocheck");
            }

        }

        let input2 = document.getElementById("search_debinhiem");

        function search_debinhiem() {
            let num = {{ count($ds_loai_tintuc) }};
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

        let ds_xoadebinhiem = document.getElementById("ds_xoa_co_loai_tintuc");
        let btn_hoantac_debinhiem = document.getElementById("btn_hoantac_debinhiem");

        function xoadebinhiem($key, $ma) {
            ds_xoadebinhiem.value += $ma + ",";
            let item = document.getElementById('debinhiem' + $key);
            item.style.display = "none";
            let item1 = document.getElementById('saubenht' + $key);
            item1.classList.remove("d-none");
            let item2 = document.getElementById('saubenh' + $key);
            item2.classList.remove("d-none");
            btn_hoantac_debinhiem.disabled = false;
        }

        function hoantac_debinhiem() {
            btn_hoantac_debinhiem.disabled = true;
            clear_input_ds_xoadebinhiem();
            let num = {{ count($ds_loai_tintuc) }};
            for (let i = 0; i <= num; i++) {
                let item = document.getElementById("debinhiem" + i);
                if (item.classList.contains("debinhiem")) {
                    item.style.display = "table-row";

                    let item1 = document.getElementById("saubenh" + i);
                    item1.classList.add("d-none");
                    item1.classList.remove("btn-light");
                    item1.classList.remove("btn-secondary");
                    item1.classList.remove("nocheck");
                    item1.classList.add("btn-light");
                    let input1 = document.getElementById("chongchiutot");
                    input1.value = input1.value.replace(item1.value + ",", "");

                    let item2 = document.getElementById("saubenht" + i);
                    item2.classList.add("d-none");
                    item2.classList.remove("btn-light");
                    item2.classList.remove("btn-secondary");
                    item2.classList.remove("nocheck");
                    item2.classList.add("btn-light");
                    let input2 = document.getElementById("debinhiem");
                    input2.value = input2.value.replace(item2.value + ",", "");
                }
            }
        }

        function clear_input_ds_xoadebinhiem() {
            ds_xoadebinhiem.value = '';
        }


        ///

        ClassicEditor
            .create(document.querySelector('#noidung'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
