@extends('layout.admin')

@section('title')
    {{ $title }}
@endsection


@section('content')
    <br>

    @if (empty($detail0))
        @if (!empty($detail1))
            <div>
                <label class="form-label h4">Tên tin tức</label>
                <textarea class="form-control " readonly rows="1" id="comment" name="ten">{{ $detail1[0]->ten }}</textarea>
            </div>
            <br>
            <div>
                <label class="form-label h4">Nội dung</label>
                <div class="overflow-show">
                    {!! $detail1[0]->noidung !!}
                </div>
            </div>
            <br>

            @if ($ds_hinhanh1 != null)
                <br>
                <div>
                    <div class="row">
                        <div class="col">
                            <p class="h4">Danh sách hình ảnh </p>
                        </div>
                    </div>
                    <div class="overflow-show" style="max-height: 500px">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Hình ảnh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ds_hinhanh1 as $key => $item)
                                    <tr id="hinhanh{{ $key }}">
                                        <td><img src="/hinhanh/hinhanh_tintuc/{{ $item->ten }}"
                                                class="img-thumbnail w-25 p-1"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <label class="form-label h4">Loại tin tức: </label>
                        <textarea class="form-control" readonly rows="5" id="thongtinkhac" name="thongtinkhac"
                            placeholder="Nhập thông tin khác cho giống lúa">{{ $detail1[0]->loai_tintuc ?? '' }}</textarea>
                    </div>
                    <br>
                    <div>
                        <label class="form-label h4">Các giống lúa liên quan: </label>
                        <textarea class="form-control" readonly rows="5" id="thongtinkhac" name="thongtinkhac"
                            placeholder="Nhập thông tin khác cho giống lúa">{{ $detail1[0]->co_lienquan_gionglua ?? ''}}</textarea>
                    </div>
                </div>
                <br>
            @endif
        @endif
    @else
        <div class="row">
            <div class="col">
                @if (!empty($detail0))
                    <div>
                        <label class="form-label h4">Thông tin ngày
                            {{ date('d-m-Y H:i:s ', $detail0[0]->ngaycapnhat) }} </label>
                    </div>
                    <div>
                        <label class="form-label h4">Tên tin tức</label>
                        <textarea class="form-control " readonly rows="1" id="comment" name="ten">{{ $detail0[0]->ten }}</textarea>
                    </div>
                    <br>
                    <div>
                        <label class="form-label h4">Nội dung</label>
                        <div class="overflow-show" style="height: 400px">
                            {!! $detail0[0]->noidung !!}
                        </div>
                    </div>

                    <br>
                 
                @endif
                @if ($ds_hinhanh0 != null)
                    <div>
                        <input type="text" name="ds_xoahinhanh" id="ds_xoahinhanh" class="d-none">
                    </div>
                    <br>

                    <div>
                        <div class="row">
                            <div class="col">
                                <p class="h4">Danh sách hình ảnh </p>
                            </div>
                        </div>
                        <div class="overflow-show" style="max-height: 500px">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Hình ảnh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ds_hinhanh0 as $key => $item)
                                        <tr id="hinhanh{{ $key }}">
                                            <td><img src="/hinhanh/hinhanh_tintuc/{{ $item->ten }}"
                                                    class="img-thumbnail w-50 p-1"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        <label class="form-label h4">Loại tin tức: </label>
                        <textarea class="form-control" readonly rows="5" id="thongtinkhac" name="thongtinkhac"
                            placeholder="Nhập thông tin khác cho giống lúa">{{ $detail0[0]->loai_tintuc ?? '' }}</textarea>
                    </div>
                    <br>
                    <div>
                        <label class="form-label h4">Các giống lúa liên quan: </label>
                        <textarea class="form-control" readonly rows="5" id="thongtinkhac" name="thongtinkhac"
                            placeholder="Nhập thông tin khác cho giống lúa">{{ $detail0[0]->co_lienquan_gionglua ?? ''}}</textarea>
                    </div>
                    <br>
                @endif
            </div>
            <div class="col">
                @if (!empty($detail1))
                    <div>
                        <label class="form-label h4">Thông tin ngày
                            {{ date('d-m-Y H:i:s ', $detail1[0]->ngaycapnhat) }} </label>
                    </div>
                    <div>
                        <label class="form-label h4">Tên tin tức</label>
                        <textarea class="form-control " readonly rows="1" id="comment" name="ten">{{ $detail1[0]->ten }}</textarea>
                    </div>
                    <br>
                    <div>
                        <label class="form-label h4">Nội dung</label>
                        <div class="overflow-show" style="height: 400px">
                            {!! $detail1[0]->noidung !!}
                        </div>
                    </div>
                    <br>
                   
                @endif
                @if ($ds_hinhanh1 != null)
                    <div>
                        <input type="text" name="ds_xoahinhanh" id="ds_xoahinhanh" class="d-none">
                    </div>
                    <br>
                    <div>
                        <div class="row">
                            <div class="col">
                                <p class="h4">Danh sách hình ảnh </p>
                            </div>
                        </div>
                        <div class="overflow-show" style="max-height: 500px">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Hình ảnh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ds_hinhanh1 as $key => $item)
                                        <tr id="hinhanh{{ $key }}">
                                            <td><img src="/hinhanh/hinhanh_tintuc/{{ $item->ten }}"
                                                    class="img-thumbnail w-50 p-1"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <label class="form-label h4">Loại tin tức: </label>
                            <textarea class="form-control" readonly rows="5" id="thongtinkhac" name="thongtinkhac"
                                placeholder="Nhập thông tin khác cho giống lúa">{{ $detail1[0]->loai_tintuc ?? '' }}</textarea>
                        </div>
                        <br>
                        <div>
                            <label class="form-label h4">Các giống lúa liên quan: </label>
                            <textarea class="form-control" readonly rows="5" id="thongtinkhac" name="thongtinkhac"
                                placeholder="Nhập thông tin khác cho giống lúa">{{ $detail1[0]->co_lienquan_gionglua ?? ''}}</textarea>
                        </div>
                    </div>
                    <br>
                @endif
            </div>
        </div>
    @endif
@endsection

@section('css')
    <style type="text/css">
        .btn-list {
            margin-bottom: 5px;
        }
    </style>
@endsection

@section('js')
    <script></script>
@endsection
