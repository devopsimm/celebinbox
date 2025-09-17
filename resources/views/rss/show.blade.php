@extends('layouts.web')

@push('metas')
    <title>RSS | CelebInbox</title>

@endpush



@section('content')
<div class="container">
    <div class="fbt-vc-inner hor">
        <div class="title-wrapper border-8">
            <h1><span class="colorbg">CelebInbox RSS</span></h1>
        </div>
        <ul class="rssShow">
            @foreach($categories as $category)
                <li><a href="{{ route('generateRss',['category'=>$category->id]) }}">{{ $category->name }}</a></li>
                @if(count($category->childCategories))
                    @foreach($category->childCategories as $child)
                        <li class="child"><a href="{{ route('generateRss',['category'=>$category->id,'subcategory'=>$child->id]) }}">{{ $child->name }}</a></li>
                    @endforeach
                @endif
            @endforeach
        </ul>
    </div>
</div>

@endsection


@push('scripts')
    <style>
        ul.rssShow li {
            padding: 10px;
            border: 1px solid #dbdbdb;
            margin-bottom: 10px;
        }

        ul.rssShow li.child {
            margin-left: 30px;
        }

        ul.rssShow li a {
            color: #000;
        }
    </style>
@endpush

