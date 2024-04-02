@extends('layout.admin')

@section('title')
    {{ $title }}
@endsection


@section('content')
    <form id ="add" class="add" action="" method="POST" enctype="multipart/form-data">

        <div>
            <label class="form-label h4">Tên tin tức</label>
            <textarea class="form-control" rows="1" id="ten" name="ten" placeholder="Nhập tên tin tức">{{ old('ten') }}</textarea>
            @error('ten')
                <span style="color:red">{{ $message }}</span>
            @enderror
        </div>
        <br>
        @if ($ds != null)
            <div>
                <label class="form-label h4">Loại tin tức</label>
                <textarea name="ds_loai_tintuc" id="ds_loai_tintuc" class="form-control" readonly rows="2"></textarea>
                <br>
                <div class="overflow-show">
                    @foreach ($ds_loai_tintuc as $key => $item)
                        <button value="{{ $item->ten }}" type="button" class="btn btn-list btn-light border-secondary"
                            id="loai_tintuc{{ $key }}" onclick="check_item2({{ $key }})">
                            {{ $item->ten }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endif
        <br>
        <div>
            <label class="form-label h4">Nội dung</label>
            <textarea class="form-control" rows="10" id="noidung" name="noidung" placeholder="Nhập nội dung tin tức">{{ old('noidung') }}</textarea>
            @error('noidung')
                <span style="color:red">{{ $message }}</span>
            @enderror
        </div>
        <br>



        <div>
            <label class="form-label h4">Thêm hình ảnh</label>
            <input id="files" type="file" multiple="multiple" name="hinhanh[]"
                accept="image/jpeg, image/png, image/jpg">
            <output id="result" class="d-table-cell">

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
        @if ($ds != null)
            <div>
                <label class="form-label h4">Tin tức liên quan đến giống lúa</label>
                <input type="text" id="search_chongchiutot" class="form-control" placeholder="Nhập tên giống lúa">
                <br>
                <textarea name="ds_ma_gionglua" id="chongchiutot" class="form-control" readonly rows="2"></textarea>
                <br>
                <div class="overflow-show">
                    @foreach ($ds as $key => $item)
                        <button value="{{ $item->ten }}" type="button" class="btn btn-list btn-light border-secondary"
                            id="saubenh{{ $key }}" onclick="check_item({{ $key }})">
                            {{ $item->ten }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endif
        <br>
        <div>
            <button type="submit" class="btn btn-primary">Thêm mới</button>
        </div>
        <br>
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
        ClassicEditor
            .create(document.querySelector('#noidung'))
            .catch(error => {
                console.error(error);
            });

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
            let num = {{ count($ds) }};
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

        function check_item2($id) {
            let item = document.getElementById("loai_tintuc" + $id);
            let input1 = document.getElementById("ds_loai_tintuc");
            let itemt = document.getElementById("loai_tintuc2" + $id);
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
    </script>
@endsection
