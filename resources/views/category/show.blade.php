<x-app-layout>

    <x-slot name="header">
        {{ $category->name ?? 'Show User' }}
    </x-slot>

    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Category</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('categories.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $category->name }}
                        </div>
                        <div class="form-group">
                            <strong>Slug:</strong>
                            {{ $category->slug }}
                        </div>
                        <div class="form-group">
                            <strong>Type:</strong>
                            {{ $category->type }}
                        </div>
                        <div class="form-group">
                            <strong>Description:</strong>
                            {{ $category->description }}
                        </div>
                        <div class="form-group">
                            <strong>Parent:</strong>
                            {{ ($category->parentCategories == null)?'None':$category->parentCategories->name }}
                        </div>
                        <div class="form-group">
                            <strong>Image:</strong>
                            {!! ($category->image != null)?'<img width="100" src="'.Helper::getFileUrl($category->image,$category,'category').'" />':'' !!}
                        </div>
                        <div class="form-group">
                            <strong>Is Featured:</strong>
                            {{ ($category->is_featured == 1)?'Yes':'No' }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
