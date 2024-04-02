{{-- <div class="col-md-2 cot_trai">
    <div class="bg-white p-3 sticky-top">
        @if ($ds_tintuc_moi != null)
            <h4>Tin tức mới</h4>
            @foreach ($ds_tintuc_moi as $key => $item)
                <div class="card mb-3 zoom border border-4" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="/hinhanh/hinhanh_tintuc/{{ $item->ten_hinhanh }}"
                                class="img-fluid rounded-start" alt="..." style="height: 100%">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body overflow-hidden" style="height: 150px">
                                <p class="fw-lighter fs-6">{{ date("d-m-Y H:i", $item->ngaytao) }}</p>

                                <h5 class="card-title fw-bolder">{{ $item->ten }}</h5>
                                <p class="card-text">{!! $item->noidung !!}</p>
                                <a href="{{ route('tintuc', ['ma' => $item->ma]) }}"
                                    class="stretched-link"></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div> --}}

<div class="col-md-3 cot_trai ">
    <div class=" p-3 sticky-top bg-white  ">
            <div class="">
                <div class=" p-2">
                  <h4 class="fw-bold">Loại tin tức</h4>
                    @if($ds_loai_tintuc !=null)
                    @foreach ($ds_loai_tintuc as $key => $item)

                    {{-- <a href="#" class=" link-underline-opacity-0 link-primary d-block p-2 ">{{ $item->ten }}</a>  --}}
                    <a href="{{route('ds_tintuc',['key_ds_loai_tintuc'=>$item->ten.','])}}" class=" link-underline-opacity-0 link-secondary d-block p-2 fw-bold">{{ $item->ten }}</a> 

                    @endforeach
                    @endif           
                </div>
              </div>
    </div>
</div>
<br>

