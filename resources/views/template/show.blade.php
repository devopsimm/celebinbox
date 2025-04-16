@extends('../admin/layouts.app')

@section('template_title')
    {{ $template->name ?? 'Show Template' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Template</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('templates.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $template->name }}
                        </div>
                        <div class="form-group">
                            <strong>Page Key:</strong>
                            {{ $template->page_key }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
