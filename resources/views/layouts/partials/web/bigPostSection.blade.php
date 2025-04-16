<div class="commonHeading">
    <p class="mt-0"><a title="{{ $cat }}" class="{{ $color }}"
                       href="{{ route('categoryPage',$slug) }}">{{ $cat }}</a></p>
    <span></span>
</div>
<div class="video_Sec_wrapper">
    @foreach($posts as $post)
        @include('layouts.partials.web.postThumbnailBig',['post'=>$post])
    @endforeach
    
</div>
