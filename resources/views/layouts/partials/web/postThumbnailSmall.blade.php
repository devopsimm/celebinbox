<div class="imgList">
    <a href="{{ route('slugPage',$post->id.'-'.$post->slug) }}"
       title="{{ $post->title }}" class="open-section">
        <img class="lazyload" alt="{{ $post->title }}"
             title="{{ $post->title }} "
             src="{{ config('settings.placeholderImg100') }}"
             data-src="{{ Helper::getFeaturedImg(['post'=>$post],'100X60') }}"
             width="100" height="60">
    </a>
</div>
<div class="contentList">
    <a href="{{ route('slugPage',$post->id.'-'.$post->slug) }}"
       title="{{ $post->title }}" class="open-section">
        {{ $post->title }} </a>
</div>
