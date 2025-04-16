@extends('../admin/layouts.app')

@section('template_title')
    Create Template
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                 @includeif('admin.layouts.partials.alertBox')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Create Template</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('templates.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('admin.template.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
