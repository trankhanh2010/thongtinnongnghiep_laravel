@if ($posts != null)
    @foreach ($posts as $key => $item)
        <div class="row mt-2">
            <div class="col-2 d-inline">
                <div class=" ">
                    <img src="/hinhanh/avatar/avatar.jpg" class="img-fluid " alt="..." >
                  </div>
                  
            </div>
            <div class="col-10">
                <div class="card card-white post">
                    <div class="post-heading">
                        <div class="float-left meta ms-4 mt-2">
                            <div class="title h5">
                                <p class="fw-bold">{{ $item->name }}</p>
                            </div>
                        </div>
                        <div class="post-description ms-3 " >
                           @if($item->trangthai)  <p >{{ $item->noidung }}</p>@else <p class="fst-italic" >Bình luận này đã bị quản trị viên ẩn đi!</p> @endif
                            <p class="card-text fs-6 fw-lighter"><small>Lúc
                                    {{ date('H:i d-m-Y', $item->ngay_binhluan) }}</small></p>
                        </div>
                        @if (Auth::check())
                            @if (Auth::user()->id == $item->ma_user)
                                <div class="ms-3 mb-1">
                                    <form class="xoa-binh-luan" data_id={{ $item->ma }}>
                                        <button type="submit" class="btn btn-danger">Xóa</button>

                                    </form>
                                </div>
                            @endif
                        @endif
                    </div>

                </div>
            </div>

        </div>
    @endforeach
@endif
