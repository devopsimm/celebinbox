<div class="section_right">
    <div class="sideBarFixed_">
        @if(isset($sideBarRelatedPosts) && count($sideBarRelatedPosts) > 0)
            <div id="mostreadAppend" class="royal" style="margin-bottom: 30px;">
                <div class="listing">
                    <ul class="listingMain">
                        @foreach($sideBarRelatedPosts as $post)
                            <li>
                                @include('layouts.partials.web.postThumbnailSmall', ['post' => $post])
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

    </div>
</div>
