<?= '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL ?>
<rss xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/" version="2.0">
    <channel>
        <title>
            Gadinsider -
            <![CDATA[ {{ $category->name }} ]]>
        </title>
        <atom:link href="{{ url()->current() }}" rel="self" type="application/rss+xml"/>
        <link>
        <![CDATA[ {{ url('') }} ]]>
        </link>
        <description>
            <![CDATA[ {{ $description }} ]]>
        </description>
        <lastBuildDate><![CDATA[ {{ Carbon\Carbon::now()->format('D, d M Y G:i:s') }} +0500 ]]></lastBuildDate>
        <language><![CDATA[ en-US ]]></language>
        @foreach ($posts as $post)
           @if($post)
           <item>
                <title><![CDATA[ {{ str_replace(['"',"'"],'',$post->title) }} ]]></title>
                <link><![CDATA[ {{ route('slugPage',$post->slug.'-'.$post->id) }} ]]></link>
                <pubDate><![CDATA[ {{ Carbon\Carbon::now()->format('D, d M Y G:i:s') }} +0500 ]]></pubDate>
                <guid><![CDATA[{{ route('slugPage',$post->slug.'-'.$post->id) }} ]]></guid>
                <description>
                    <![CDATA[ <img src="{{ Helper::getOrgFileUrl($post->featured_image,$post) }}"/> ]]>
                    <![CDATA[ {{ Helper::ellipsis(Helper::removeHtmlTags($post->description),250) }} ]]>
                </description>


            </item>
           @endif
        @endforeach
    </channel>
</rss>


