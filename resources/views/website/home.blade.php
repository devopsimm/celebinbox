@extends('layouts.web')

@push('meta')
    <title>The Celeb Inbox: Entertainment - Latest Celebrity News, Gossip & Photos - The Celeb Inbox</title>
    <meta name='TITLE' content="The Celeb Inbox: Entertainment - Latest Celebrity News, Gossip & Photos - The Celeb Inbox">
    <meta name="description" content="Get the Latest Entertainment, Celebrity News and Updates on Your Favorite Stars, Taylor Swift, Meghan Markle, Prince harry, King Charles">
    <meta name="keywords" content="Meghan Markle, Prince Harry, Kate Middleton, Prince William, Drake, Taylor Swift, Zendaya, Bad Bunny, Ariana Grande, Billie Eilish, Lady Gaga, Tom Holland, Selena Gomez, Travis Scott, Kim Kardashian, Kanye West">

@endpush
@push('css')

    <link rel="stylesheet" type="text/css" href="{{ url('website/home.css') }}" />
@endpush

@section('content')
    @if(count($bannerPosts) == 5)

    <div class="home_featured_story">
        <div class="container">
            <ul>
                <li>
                    <div class="h_featured_pic pic_all largeTop">
                        <a href="{{ route('slugPage',$bannerPosts[0]->id.'-'.$bannerPosts[0]->slug) }}"
                           title="{{ $bannerPosts[0]->title }}"
                           class="open-section">
                            <img class="lazyload"
                                 alt="{{ $bannerPosts[0]->title }}"
                                 title="{{ $bannerPosts[0]->title }}"
                                 src="{{ config('settings.placeholderImgFull') }}"
                                 data-src="{{ Helper::getFeaturedImg(['post'=>$bannerPosts[0]],'700X390') }}"
                                 width="700" height="390">
                        </a>
                        <div class="term-badges floated">
                            <span class="term_badge">
                                <a class="{{ $bannerPosts[0]->MainCategory->color }}" href="{{ route('categoryPage',$bannerPosts[0]->MainCategory->slug) }}"
                                   title="{{ ucfirst($bannerPosts[0]->MainCategory->name) }}">{{ ucfirst($bannerPosts[0]->MainCategory->name) }}</a>
                            </span>
                        </div>
                    </div>
                    <div class="h_featured_title">
                        <a href="{{ route('slugPage',$bannerPosts[0]->id.'-'.$bannerPosts[0]->slug) }}"
                           title="{{ $bannerPosts[0]?->title ?? 'None' }}"
                           class="open-section">
                            <h1>{{ $bannerPosts[0]?->title ?? 'None' }}</h1>
                        </a>
                    </div>
                </li>
            </ul>
            <ul>
                <li>
                    <div class="h_featured_pic pic_all">
                        <a href="{{ route('slugPage',$bannerPosts[1]->id.'-'.$bannerPosts[1]->slug) }}"
                           title="{{ $bannerPosts[1]->title }}" class="open-section">
                            <img class="lazyload" alt="{{ $bannerPosts[1]->title }}"
                                 title="{{ $bannerPosts[1]->title }}"
                                 src="{{ config('settings.placeholderImgFull') }}"
                                 data-src="{{ Helper::getFeaturedImg(['post'=>$bannerPosts[1]],'370X222') }}"
                                 width="370" height="222">
                        </a>
                        <div class="term-badges floated">
                            <span class="term_badge">
                                <a class="{{ $bannerPosts[1]->MainCategory->color }}" href="{{ route('categoryPage',$bannerPosts[1]->MainCategory->slug) }}"
                                   title="{{ ucfirst($bannerPosts[1]->MainCategory->name) }}">{{ ucfirst($bannerPosts[1]->MainCategory->name) }}</a>
                            </span>
                        </div>
                    </div>
                    <div class="h_featured_title">
                        <a href="{{ route('slugPage',$bannerPosts[1]->id.'-'.$bannerPosts[1]->slug) }}"
                           title="{{ $bannerPosts[1]->title }}" class="open-section">
                            <h2>{{ $bannerPosts[1]->title }}</h2>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="h_featured_pic pic_all">
                        <a href="{{ route('slugPage',$bannerPosts[2]->id.'-'.$bannerPosts[2]->slug) }}"
                           title="{{ $bannerPosts[2]->title }}" class="open-section">
                            <img class="lazyload" alt="{{ $bannerPosts[2]->title }}"
                                 title="{{ $bannerPosts[2]->title }}"
                                 src="{{ config('settings.placeholderImgFull') }}"
                                 data-src="{{ Helper::getFeaturedImg(['post'=>$bannerPosts[2]],'370X222') }}"
                                 width="370" height="222">
                        </a>
                        <div class="term-badges floated">
                            <span class="term_badge">
                                <a class="{{ $bannerPosts[2]->MainCategory->color }}" href="{{ route('categoryPage',$bannerPosts[2]->MainCategory->slug) }}"
                                   title="{{ ucfirst($bannerPosts[2]->MainCategory->name) }}">{{ ucfirst($bannerPosts[2]->MainCategory->name) }}</a>
                            </span>
                        </div>
                    </div>
                    <div class="h_featured_title">
                        <a href="{{ route('slugPage',$bannerPosts[2]->id.'-'.$bannerPosts[2]->slug) }}"
                           title="{{ $bannerPosts[2]->title }}" class="open-section">
                            <h2>{{ $bannerPosts[2]->title }}</h2>
                        </a>
                    </div>
                </li>
            </ul>
            <ul>
                <li>
                    <div class="h_featured_pic pic_all">
                        <a href="{{ route('slugPage',$bannerPosts[3]->id.'-'.$bannerPosts[3]->slug) }}"
                           title="{{ $bannerPosts[1]->title }}" class="open-section">
                            <img class="lazyload" alt="{{ $bannerPosts[3]->title }}"
                                 title="{{ $bannerPosts[3]->title }}"
                                 src="{{ config('settings.placeholderImgFull') }}"
                                 data-src="{{ Helper::getFeaturedImg(['post'=>$bannerPosts[3]],'370X222') }}"
                                 width="370" height="222">
                        </a>
                        <div class="term-badges floated">
                            <span class="term_badge">
                                <a class="{{ $bannerPosts[3]->MainCategory->color }}" href="{{ route('categoryPage',$bannerPosts[3]->MainCategory->slug) }}"
                                   title="{{ ucfirst($bannerPosts[3]->MainCategory->name) }}">{{ ucfirst($bannerPosts[3]->MainCategory->name) }}</a>
                            </span>
                        </div>
                    </div>
                    <div class="h_featured_title">
                        <a href="{{ route('slugPage',$bannerPosts[3]->id.'-'.$bannerPosts[3]->slug) }}"
                           title="{{ $bannerPosts[3]->title }}" class="open-section">
                            <h2>{{ $bannerPosts[3]->title }}</h2>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="h_featured_pic pic_all">
                        <a href="{{ route('slugPage',$bannerPosts[4]->id.'-'.$bannerPosts[4]->slug) }}"
                           title="{{ $bannerPosts[1]->title }}" class="open-section">
                            <img class="lazyload" alt="{{ $bannerPosts[4]->title }}"
                                 title="{{ $bannerPosts[4]->title }}"
                                 src="{{ config('settings.placeholderImgFull') }}"
                                 data-src="{{ Helper::getFeaturedImg(['post'=>$bannerPosts[4]],'370X222') }}"
                                 width="370" height="222">
                        </a>
                        <div class="term-badges floated">
                            <span class="term_badge">
                                <a class="{{ $bannerPosts[4]->MainCategory->color }}" href="{{ route('categoryPage',$bannerPosts[4]->MainCategory->slug) }}"
                                   title="{{ ucfirst($bannerPosts[4]->MainCategory->name) }}">{{ ucfirst($bannerPosts[4]->MainCategory->name) }}</a>
                            </span>
                        </div>
                    </div>
                    <div class="h_featured_title">
                        <a href="{{ route('slugPage',$bannerPosts[4]->id.'-'.$bannerPosts[4]->slug) }}"
                           title="{{ $bannerPosts[4]->title }}" class="open-section">
                            <h2>{{ $bannerPosts[4]->title }}</h2>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    @endif
    <div class="news_section">
        <div class="container">
            <div class="section_wrapper">
                <div class="section_left">
                    @if(isset($homeCats['entertainment']))
                    <div class="commonHeading">
                        <p class="mt-0"><a title="Celebrity"
                                           href="{{ route('categoryPage','entertainment') }}">Entertainment</a></p>
                        <span></span>
                    </div>
                    <ul class="newsRows">
                        @foreach($homeCats['entertainment'] as $post)
                        <li>
                           @include('layouts.partials.web.postThumbnail',['post'=>$post])
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                    {{ Helper::displayRightSideBar() }}

            </div>
        </div>
    </div>
    <div class="lastSec">
        <div class="container">
            <div class="lastSec_wrapper">

                @include('layouts.partials.web.postVerticalSection',['color'=>'pink','cat'=>'World','slug'=>'world','posts'=>$homeCats['world']])
                @include('layouts.partials.web.postVerticalSection',['color'=>'purple','cat'=>'Sports','slug'=>'sports','posts'=>$homeCats['sports']])
                @include('layouts.partials.web.postVerticalSection',['color'=>'blue','cat'=>'Health','slug'=>'health','posts'=>$homeCats['health']])

            </div>
        </div>
    </div>
{{--    <div class="videoSec">--}}
{{--        <div class="container">--}}

{{--            @include('layouts.partials.web.bigPostSection',['color'=>'green','cat'=>'Videos','slug'=>'videos','posts'=>$homeCats['videos']])--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
