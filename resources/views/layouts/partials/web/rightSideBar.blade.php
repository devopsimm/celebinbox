<div class="section_right">
    <div class="sideBarFixed_">
        @if(isset($mostReadPosts) && count($mostReadPosts) > 0)
        <div id="mostreadAppend" class="royal" style="margin-bottom: 30px;">
            <div class="commonHeading">
                <p class="mt-0"><a title="Royals" href="#_">Most Read</a></p>
                <span></span>
            </div>
            <div class="listing">
                <ul class="listingMain">
                    @foreach($mostReadPosts as $post)
                        <li>
                            @include('layouts.partials.web.postThumbnailSmall', ['post' => $post])
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
            @if(isset($sideCats) && count($sideCats) > 0)
                @foreach($sideCats as $key=>$sideCat)
                        @if(count($sideCat))
                        <div id="royalAppend" class="royal">
                            <div class="commonHeading">
                                <p class="mt-0"><a title="{{ $key }}"
                                                   href="{{ route('categoryPage',$key) }}">{{ $key }}</a></p>
                                <span></span>
                            </div>
                            <div class="listing">
                                <ul class="listingMain">
                                    @foreach($sideCat as $post)
                                        <li>
                                            @include('layouts.partials.web.postThumbnailSmall', ['post' => $post])
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                        @endif
                @endforeach
           @endif
    </div>
</div>
