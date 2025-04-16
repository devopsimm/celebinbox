<div class="video_list">
    <div class="topImage">
        <a href="{{ route('slugPage',$post->id.'-'.$post->slug) }}"
           title="{{ $post->title }}"
           class="open-section">
            <img class="lazyload"
                 alt="{{ $post->title }}"
                 title="{{ $post->title }}"
                 src="{{ config('settings.placeholderImg467') }}"
                 data-src="{{ Helper::getFeaturedImg(['post'=>$post]) }}"
                 width="467" height="350">
            <div class="imgDtl">
                <div class="imgDtlInner">
                    <div>{{ $post->title }}</div>
                </div>
            </div>
        </a>
    </div>
</div>
