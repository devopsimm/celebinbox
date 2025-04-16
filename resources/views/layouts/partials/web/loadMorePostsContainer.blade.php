@foreach($posts as $post)
    <li>
        @include('layouts.partials.web.postThumbnail',['post'=>$post])
    </li>
@endforeach
