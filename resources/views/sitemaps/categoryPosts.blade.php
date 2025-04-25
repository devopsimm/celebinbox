<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
    @foreach($posts as $post)
        @if($post->is_published == 1)
    <url>
        <loc>{{ route('slugPage',$post->PostSlug) }}</loc>
        <news:news>
            <news:publication>
                <news:name>CelebInbox</news:name>
                <news:language>en</news:language>
            </news:publication>
            <news:publication_date>{{ \Carbon\Carbon::parse($post->posted_at)->format('Y-m-d\TH:i:s+05:00') }}</news:publication_date>
            <news:title>
                <![CDATA[ {{ $post->title }} ]]>
            </news:title>
        </news:news>
    </url>
        @endif
    @endforeach
</urlset>

