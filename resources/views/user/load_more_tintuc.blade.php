{{-- 
@foreach ($posts as $post)
    <div class="col" >
        
      <div class="card zoom border border-4" style="height: 405px">
        <img src="/hinhanh/hinhanh_tintuc/{{ $post->ten_hinhanh }}" class="card-img-top" alt="..." style="width: 100%; height:200px">
        <div class="card-body overflow-hidden" style="height: 160px">
          <p class="fw-lighter fs-6">{{ date("d-m-Y H:i", $post->ngaytao) }}</p>

          <h5 class="card-title fw-bolder">{{ $post->ten }}</h5>

          <p class="card-text">{!! $post->noidung !!}</p>
          <a href="{{route('tintuc',['ma'=> $post->ma])}}" class="stretched-link"></a>
        </div>
      </div>
    </div>

@endforeach --}}


@foreach ($posts as $item)
<div class="row d-flex ">
  <div class="card border-0  zoom ">
      <div class="row g-0 ">
        <div class="col-md-4 mt-2">
          <img src="/hinhanh/hinhanh_tintuc/{{ $item->ten_hinhanh }}" class="img-fluid " alt="...">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title fw-bold">{{ $item->ten }}</h5>
            <div class="card-text overflow-hidden" style="height: 100px">{!! $item->noidung !!}</div>
            
            <p class="card-text"><small>Viết lúc {{ date("H:i d-m-Y", $item->ngaytao) }}</small></p>
            @foreach ($item->loai_tintuc as $item2)
            <span class="badge text-bg-warning">{{ $item2->ten_tintuc }}</span>
            @endforeach
            @foreach ($item->gionglua_lienquan as $item2)
            <span class="badge text-bg-success">{{ $item2->ten_gionglua_lienquan }}</span>
            @endforeach
            <a href="{{route('tintuc',['ma'=> $item->ma])}}" class="stretched-link"></a>

          </div>
        </div>
      </div>
    </div>
</div>
@endforeach


