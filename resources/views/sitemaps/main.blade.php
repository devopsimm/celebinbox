<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

    <url>
        <loc>https://www.celebinbox.com</loc>
    </url>
    @foreach($categories as $category)
        @if($category->id != 14)
            <url>
                <loc>{{ route('slugPage',$category->slug) }}</loc>
            </url>
            @if(count($category->childCategories))
                @foreach($category->childCategories as $child)
                    <url>
                        <loc>{{ route('subCategoryPage',['mainCat'=>$category->slug,'subCat'=>$child->slug]) }}</loc>
                    </url>
                @endforeach
            @endif
        @endif
    @endforeach

    <url>
        <loc>{{ route('faq') }}</loc>
    </url>
    <url>
        <loc>{{ route('aboutUs') }}</loc>
    </url>
    <url>
        <loc>{{ route('policy') }}</loc>
    </url>
    <url>
        <loc>{{ route('contactUs') }}</loc>
    </url>



</urlset>
