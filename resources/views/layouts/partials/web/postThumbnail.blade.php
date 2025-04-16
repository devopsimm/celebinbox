<div class="imgBox">
    @if(isset($badge))

        <span><a class="{{ $badge }}" href="{{ route('categoryPage',$post->MainCategory->slug) }}"
                 title="{{ ucfirst($post->MainCategory->name) }}">
                {{ ucfirst($post->MainCategory->name) }}
            </a>
        </span>
    @endif

    <a href="{{ route('slugPage',$post->id.'-'.$post->slug) }}"
       title="{{ $post->title }} "
       class="open-section">
        <img class="lazyload"
             alt="{{ $post->title }}  "
             title="{{ $post->title }} "
             src="{{ config('settings.placeholderImgFull') }}"
             data-src="{{ Helper::getFeaturedImg(['post'=>$post],'370X222') }}"
             width="370" height="222">
    </a>
</div>

<div class="newsDetail">
    <a href="{{ route('slugPage',$post->id.'-'.$post->slug) }}"
       title="{{ $post->title }} "
       class="open-section">
        {{ $post->title }}  </a>
    <p>{{ $post->title }} </p>
</div>
