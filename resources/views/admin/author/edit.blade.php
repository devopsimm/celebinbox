<x-app-layout>

    <x-slot name="header">
        <div>
            <span>Update Author</span>

        </div>

    </x-slot>
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <x-alertBox />

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Author</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('authors.update', $author->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('admin.author.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
