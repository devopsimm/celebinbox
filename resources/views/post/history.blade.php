<x-app-layout>

    <x-slot name="header">
        Show Posts
    </x-slot>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Post</span>
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
                        <div class="form-group viewDescription">
                            <strong>Description:</strong>
                            {!! $meta->value !!}
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
        .viewDescription {
            width: 50%;
        }

        .viewDescription img {
            width: 100%;
        }
    </style>
</x-app-layout>
