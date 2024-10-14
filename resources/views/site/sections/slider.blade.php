
<div class="slider-area-2">
    <div class="slider-active owl-dot-style owl-carousel">
        @foreach ($data_slide->where('type', 'carrousel') as $item)
            @foreach ($item->getMedia('carrousel') as $media)
                <div class="single-slider pt-210 pb-220 bg-img" style="background-image:url('{{ $media->getUrl() }}');">
                    <div class="container">
                        <div class="slider-content slider-animated-2 text-center">
                            <h1 class="animated">{{ $item->title }}</h1>
                            <h3 class="animated">{{ $item->subtitle }}</h3>
                            @if ($item->btn_url && $item->btn_name)
                                <div class="slider-btn mt-90">
                                    <a class="animated" href="{{ $item->btn_url }}">{{ $item->btn_name }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
</div>

