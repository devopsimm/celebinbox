<x-app-layout>

    <x-slot name="header">
        Create Posts
    </x-slot>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Post</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('feed-posts.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <strong>Title:</strong>
                            {{ $post->title }}
                        </div>
                        <div class="form-group">
                            <strong>Excerpt:</strong>
                            {{ $post->excerpt }}
                        </div>
                        <div class="form-group">
                            <strong>Description:</strong>
                            {!! $post->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        .specs-photo-main {
            width: 160px;
            height: 213px;
            background-repeat: no-repeat;
        }
    </style>
</x-app-layout>
