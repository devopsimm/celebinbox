@extends('layouts.web')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ url('website/category.css') }}" />
@endpush

@section('content')
    @if(count($posts) >= 5)
    <div class="innerFeat">
        <div class="container">
            <div class="topMain">
                <div class="featBig">
                    <article class="innerListing">
                        <div class="itemContent">
                            <a class="bgImg"
                               href="{{ route('slugPage',$posts[0]->id.'-'.$posts[0]->slug) }}"
                               title="{{ $posts[0]->title }}"
                               style="background-image: url('{{ Helper::getFeaturedImg(['post'=>$posts[0]]) }}');"></a>
                               <div class="innerBadge">
                                            <span>
                                                <a class="{{ optional($posts[0]->MainCategory)->color ?? 'blue' }}" href="{{ route('categoryPage',$posts[0]->MainCategory->slug) }}" title="{{ ucfirst($posts[0]->MainCategory->name) }}">{{ ucfirst($posts[0]->MainCategory->name) }}</a>
                                            </span>
                                        </div>
                            <div class="content-container">
                                <h2 class="title">
                                    <a href="{{ route('slugPage',$posts[0]->id.'-'.$posts[0]->slug) }}"
                                       title="{{ $posts[0]->title }}" class="post-url post-title">
                                        {{ $posts[0]->title }}
                                    </a>
                                </h2>
                                <h3 style="font-size:14px;margin: 5px 0;color: #d1d1d1;">{{ $posts[0]->excerpt }} </h3>

                            </div>
                        </div>
                    </article>
                </div>
                <div class="featSml">
                    <div class="smlRow1 clearfix">
                        @foreach(array_slice($posts, 1, 2) as $post)
                            @include('layouts.partials.web.smallBgThumForLatestPage',['post'=>$post ])
                        @endforeach
                    </div>
                    <div class="smlRow1 clearfix">
                        @foreach(array_slice($posts, 3, 2) as $post)
                            @include('layouts.partials.web.smallBgThumForLatestPage',['post'=>$post])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="news_section">
        <div class="container">
            <div class="section_wrapper">
                <div class="section_left">

                    <ul class="newsRows" id="load-more">
                        @foreach(array_slice($posts, 5, 15) as $post)
                           <li>
                               @include('layouts.partials.web.postThumbnail',['post'=>$post,'badge'=>optional($post->MainCategory)->color ?? 'blue'])
                           </li>
                        @endforeach

                    </ul>

                </div>
                {{ Helper::displayRightSideBar() }}
            </div>
            <div class="category_detail_section">

            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush
