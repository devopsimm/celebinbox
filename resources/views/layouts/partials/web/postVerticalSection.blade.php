<div class="lastSec_list">
    <div class="commonHeading">
        <p class="mt-0"><a title="{{ $cat }}"
                           href="{{ route('categoryPage',$slug) }}">{{ $cat }}</a></p>
        <span></span>
    </div>
    @foreach($posts as $post)
        @if($loop->first)
    <div class="topImage">
        <a href="{{ route('slugPage',$post->id.'-'.$post->slug) }}"
           title="{{ $post->title }}"
           class="open-section">
            <img class="lazyload"
                 alt="{{ $post->title }}"
                 title="{{ $post->title }}"
                 src="{{ config('settings.placeholderImg370') }}"
                 data-src="{{ Helper::getFeaturedImg(['post'=>$post],'370X222') }}"
                 width="370" height="222">
            <div class="imgDtl">
                <div class="imgDtlInner">
                    <div>{{ $post->title }}</div>
                </div>
            </div>
        </a>
    </div>
    <div class="listing">
        <ul class="listingMain">
        @endif
         @if(!$loop->first)
                <li>
                    @include('layouts.partials.web.postThumbnailSmall',['post'=>$post])
                </li>
            @endif
        @if($loop->last)
        </ul>
    </div>
        @endif

    @endforeach
</div>
