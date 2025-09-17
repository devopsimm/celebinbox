@extends('layouts.web')
@push('meta')
    <title>{{ $post->title }}</title>
    <meta name='TITLE' content="{{ $post->title }}">
    <meta name="description" content="{{ $post->excerpt }}">
    <meta name="keywords"
          content="Meghan Markle, Prince Harry, Kate Middleton, Prince William, Drake, Taylor Swift, Zendaya, Bad Bunny, Ariana Grande, Billie Eilish, Lady Gaga, Tom Holland, Selena Gomez, Travis Scott, Kim Kardashian, Kanye West">
    <link rel="canonical" href="{{ route('slugPage',$post->id.'-'.$post->slug) }}" />
@endpush
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ url('website/detail.css') }}"/>
@endpush

@push('metas')
    <meta property="og:title"
          content="{{ (isset($metas['meta_title']) && $metas['meta_title']->value != '')?$metas['meta_title']->value:$post->title }}"/>
    <meta property="og:image" content="{{ Helper::getFileUrl($post->featured_image,$post,'post') }}"/>
    <meta property="og:description" content="{{ (isset($metaDescription))? $metaDescription : $post->excerpt }}"/>
    <meta property="og:url" content="{{ route('slugPage',$post->slug.'-'.$post->id) }}">
    <meta property="og:type" content="article"/>
    <meta property="og:site_name" content="CelebInbox">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@Celebinbox">
    <meta name="twitter:creator" content="@Web Desk"/>
    <meta name="twitter:title"
          content="{{ (isset($metas['meta_title']) && $metas['meta_title']->value != '')?$metas['meta_title']->value:$post->title }}">
    <meta name="twitter:description" content="{{ (isset($metaDescription))? $metaDescription : $post->excerpt }}">
    <meta name="twitter:image" content="{{ Helper::getFileUrl($post->featured_image,$post,'post') }}">


    @php $updatedAt = \Carbon\Carbon::parse($post->updated_at)->setTimezone(config('app.timezone'))->format('Y-m-d H:i:sP'); @endphp

    <script type="application/ld+json">
        {
            "@context": "https://schema.org/",
            "@type": "NewsArticle",
            "mainEntityofPage": "{{ url()->current() }}",
            "headline": "{{ $post->title }}",
             "datePublished": "{{ \Carbon\Carbon::parse($post->posted_at)->format('Y-m-d\TH:i:sP') }}",
             "dateModified": "{{ \Carbon\Carbon::parse($updatedAt)->format('Y-m-d\TH:i:sP') }}",
             "description": "{{ (isset($metaDescription))? $metaDescription : $post->excerpt }}",
             "image": {
                "@type": "ImageObject",
                "url": "{{ Helper::getFileUrl($post->featured_image,$post,'post') }}",
                "width": 1200,
                "height": 630
              },
              @if(isset($post->authors[0]))
            "author": {
                              "@type":"Person",
                              "name":"{{ $post->authors[0]->name }}",
                  "url":""
              },

        @endif

        "publisher": {
          "@type": "Organization",
          "name": "CelebInbox",
          "logo": {
            "@type": "ImageObject",
            "url": "{{ url('website/img/favicon-112x112.png') }}",
                "width": 112,
                "height": 112
              }
            }
        }



    </script>
    {{--    <script type="application/ld+json">--}}
    {{--    {--}}
    {{--      "@context": "https://schema.org",--}}
    {{--      "@type": "WebSite",--}}
    {{--      "url": "https://www.calebinbox.com/",--}}
    {{--      "potentialAction": {--}}
    {{--        "@type": "SearchAction",--}}
    {{--        "target": "https://www.calebinbox.com/search?q={search_term_string}",--}}
    {{--        "query-input": "required name=search_term_string"--}}
    {{--      }--}}
    {{--    }--}}
    {{--    </script>--}}
    {{--    <script type="application/ld+json">--}}
    {{--        {--}}
    {{--            "@context":"https://schema.org",--}}
    {{--            "@type":"Organization",--}}
    {{--            "name":"CelebInbox",--}}
    {{--            "url":"https://www.celebinbox.com/",--}}
    {{--            "logo":"https://www.gadinsider.com/website/logo.png",--}}
    {{--            "sameAs":--}}
    {{--            [--}}
    {{--            "https://www.facebook.com/Gadinsider/",--}}
    {{--            "https://x.com/Gadinsidernews",--}}
    {{--            "https://www.youtube.com/@GadInsider"--}}
    {{--            ]--}}
    {{--        }--}}
    {{--    </script>--}}
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', 'G-RMFTG9NG1N', {
            'language': 'English',
            'page_type': 'Detail Page',
            'detail_page_type': '{{ ($post->show_video_icon == 1) ? "Video Detail" : "Article Detail" }}',
            'sub_category': '{{ ucfirst($post->MainCategory->name) }}',
            'publish_date': '{{ \Carbon\Carbon::parse($post->posted_at)->format('d-M-Y') }}',
            'publish_time': '{{ \Carbon\Carbon::parse($post->posted_at)->format('H:i:s') }}',
            'update_date': '{{ \Carbon\Carbon::parse($updatedAt)->format('d-M-Y') }}',
            'article_word_count': {{ str_word_count(strip_tags($description)) }},
            'desk_sub': "{{ $post->user->name }}",
            'author_name': "{{ $post->user->name }}" {{-- "{{ (count($post->authors))?$post->authors[0]->name:'NA' }}" --}},
            'page_category': "{{ ucfirst($post->MainCategory->name) }}",
            'article_age': '{{ \Carbon\Carbon::parse($post->posted_at)->diffForHumans() }}',
            'author_id': {{ data_get($post, 'authors.0.id', 'NA') }}, //12344
            'story_id': {{ $post->id }}, //7823
            'video_embed': '{{ ($post->show_video_icon == 1) ? "Yes" : "No" }}',
            'ad_present': 'No',
            'Contributors': "",
        });
    </script>
@endpush



@section('content')
    <div class="detail_page">
        <div class="container">
            {{--            <div style="margin: 0px auto 10px; clear: both; text-align: center; float: left; width: 100%;">--}}
            {{--                <div style="width: 330px;display: inline-block;border: 2px solid #7c7c7c; padding: 10px 20px; text-align: left; margin: 0 auto; border-radius: 10px;">--}}
            {{--                    <div style="margin-bottom: 10px;font-size: 18px; font-weight: bold; text-align: left;">Trending</div>--}}
            {{--                    <ul class="listingMain" style=" margin-left: 10px;">--}}

            {{--                        @foreach($sideBarRelatedPosts as $post)--}}
            {{--                            <li style="list-style: disc;">--}}
            {{--                                <div class="contentList" style="width: 100%;">--}}
            {{--                                    <a href="{{ route('slugPage',$post->id.'-'.$post->slug) }}"--}}
            {{--                                       class="open-section" style="height: auto;text-decoration:underline;">{{ $post->title }}</a>--}}
            {{--                                </div>--}}
            {{--                            </li>--}}
            {{--                        @endforeach--}}
            {{--                    </ul>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            <div class="hdStyle">
                <h3 class="title_category"><a
                        href="{{ route('categoryPage',$post->MainCategory->slug) }}">{{ $post?->MainCategory?->name ?? '-' }}</a>
                </h3>
                <h1 id="postTit">{{ $post->title }}</h1>
                <h2 class="description">{{ $post->excerpt }}</h2>
                <div class="aut_share">
                    <div class="authorDetail">
                        <div class="authorName">
                            <span>By&nbsp;</span><span style="margin-right: 12px;">{{ 'Web Desk' }}</span>
                            <span class="time">{{ Carbon\Carbon::parse($post->posted_at)->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="aut_share">
                    <div class="share">
                        <ul>
                            <li>
                                <a href="https://www.facebook.com/sharer.php?u={{ route('slugPage',$post->id.'-'.$post->slug) }}"
                                   title="Facebook"><img
                                        src="{{ url('website/facebook-detail.svg') }}"
                                        alt="facebook" width="30" height="30"></a>
                            </li>
                            <li>
                                <a href="https://twitter.com/share?text={{ $post->title }}&url={{ route('slugPage',$post->id.'-'.$post->slug) }}"
                                   title="Twitter"><img
                                        src="{{ url('website/twitter-detail.svg') }}"
                                        alt="twitter" width="30" height="30"></a>
                            </li>
                            <li>
                                <a href="https://api.whatsapp.com/send?text={{ $post->title }}-{{ route('slugPage',$post->id.'-'.$post->slug) }}"
                                   title="Whatsapp"><img
                                        src="{{ url('website/whatsapp-detail.svg') }}"
                                        alt="whatsapp" width="30" height="30"></a>
                            </li>
{{--                            <li>--}}
{{--                                <a href="https://api.whatsapp.com/send?text={{ $post->title }}-{{ route('slugPage',$post->id.'-'.$post->slug) }}"--}}
{{--                                   title="Whatsapp"><img--}}
{{--                                        src="{{ url('website/pinterest-detail.svg') }}"--}}
{{--                                        alt="whatsapp" width="30" height="30"></a>--}}
{{--                            </li>--}}



                            <li>
                                <a href="mailto:?subject='{{ $post->title }}'&body={{ $post->excerpt }}"
                                   title="Whatsapp"><img
                                        src="{{ url('website/email-detail.svg') }}"
                                        alt="whatsapp" width="30" height="30"></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="section_wrapper">
                <div class="section_left">
                    <div class="celebBreadCrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('categoryPage',$post->MainCategory->slug) }}">{{ $post?->MainCategory?->name ?? '-' }}</a>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="detail_wrapper">
                        {!! $description !!}

                    </div>

                </div>

            </div>
            @if(count($relatedPosts))
                <div class="moreFrom">
                    <div class="commonHeading">
                        <p class="mt-0"><a class="red"
                                           href="{{ route('categoryPage',$post->MainCategory->slug) }}">{{ $post?->MainCategory?->name ?? '-' }}</a>
                        </p>
                        <span></span>
                    </div>
                    <ul style="margin-top: 0 !important;">
                        @foreach($relatedPosts as $post)
                            <li>
                                <div class="imgList">
                                    <a href="{{ route('slugPage',$post->id.'-'.$post->slug) }}"
                                       title="{{ $post->title }}" class="open-section">
                                        <img class="lazyload" alt="{{ $post->title }}"
                                             title="{{ $post->title }} "
                                             src="{{ config('settings.placeholderImg100') }}"
                                             data-src="{{ Helper::getFeaturedImg(['post'=>$post],'370X222') }}"
                                             width="370" height="222">
                                    </a>
                                </div>
                                <div class="contentList">
                                    <a href="{{ route('slugPage',$post->id.'-'.$post->slug) }}"
                                       title="{{ $post->title }}" class="open-section">
                                        {{ $post->title }} </a>
                                </div>

                            </li>
                        @endforeach

                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('figcaption').prop('contenteditable', 'false');
        if($('.tiktok-embed').length > 0){
            var scriptElement=document.createElement('script');
            scriptElement.type = 'text/javascript';
            scriptElement.setAttribute = 'async';
            scriptElement.src = 'https://www.tiktok.com/embed.js';
            document.body.appendChild(scriptElement);
        }

    </script>
    <style type="text/css">span {
            font-size: inherit !important;
        }</style>
@endpush
