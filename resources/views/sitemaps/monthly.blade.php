<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
   @foreach($posts as $post)
        @if($post->is_published == 1)
        <url>
        <loc>
            <![CDATA[ {{ route('slugPage',$post->PostSlug) }} ]]>
        </loc>
    </url>
        @endif
    @endforeach
</urlset>
