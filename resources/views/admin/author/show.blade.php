
<x-app-layout>

    <x-slot name="header">
        {{ $author->name ?? 'Show Author' }}
    </x-slot>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Author</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('authors.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $author->name }}
                        </div>
                        <div class="form-group">
                            <strong>Slug:</strong>
                            {{ $author->slug }}
                        </div>
                        <div class="form-group">
                            <strong>Type:</strong>
                            {{ config('settings.authorType.'.$author->type) }}
                        </div>
                        <div class="form-group">
                            <strong>Twitter:</strong>
                            {{ $author->twitter }}
                        </div>
                        <div class="form-group">
                            <strong>Facebook:</strong>
                            {{ $author->facebook }}
                        </div>
                        <div class="form-group">
                            <strong>Profile Picture:</strong>
                            {!! ($author->profile_picture != null)?' <img width="100" src="'.Helper::getFileUrl($author->profile_picture,$author).'" /> ':'' !!}
                        </div>
                        <div class="form-group">
                            <strong>Email:</strong>
                            {{ $author->email }}
                        </div>
                        <div class="form-group">
                            <strong>Phone:</strong>
                            {{ $author->phone }}
                        </div>
                        <div class="form-group">
                            <strong>Details:</strong>
                            {{ $author->details }}
                        </div>
                        <div class="form-group">
                            <strong>Is Publish:</strong>
                            {{ config('settings.publishingStatus.'.$author->is_publish) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
