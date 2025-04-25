<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

@foreach($posts as $post)
        @if($post->is_published == 1)
            <url>
                <loc><![CDATA[{{ route('slugPage',$post->PostSlug) }}]]></loc>
                 <news:news>
                     <news:publication>
                         <news:name>CelebInbox</news:name><news:language>en</news:language>
                     </news:publication>
                     <news:publication_date><![CDATA[{{ \Carbon\Carbon::parse($post->posted_at)->format('Y-m-d\TH:i:s+05:00') }}]]></news:publication_date>
                     <news:title><![CDATA[{{ $post->title }}]]></news:title>
                     <news:keywords><![CDATA[{{ $post->MainCategory->name }}]]></news:keywords>
                 </news:news>
                 <image:image>
                    <image:loc><![CDATA[{{ Helper::getOrgFileUrl($post->featured_image,$post) }}]]></image:loc>
                    <image:caption><![CDATA[{{ $post->title }}]]></image:caption>
                    <image:title><![CDATA[{{ $post->title }}]]></image:title>
                 </image:image>
            </url>
        @endif
    @endforeach
</urlset>

