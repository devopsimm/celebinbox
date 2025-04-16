@extends('../admin/layouts.app')

@section('template_title')
    Update Template
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                 @includeif('admin.layouts.partials.alertBox')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Template</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('templates.update', $template->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('admin.template.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
