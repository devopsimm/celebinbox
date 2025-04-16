<x-app-layout>

    <x-slot name="header">
        Create Posts
    </x-slot>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <x-alertBox />

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Create Post</span>
                    </div>
                    <div class="card-body">
                        <form id="postForm" method="POST" action="{{ route('feed-posts.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('post.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
