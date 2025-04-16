@extends('../admin/layouts.app')

@section('template_title')
    Template
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Template') }}
                            </span>

                             <div class="float-right">
                                 @can('templates.view')
                                <a href="{{ route('templates.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                                 @endcan
                              </div>
                        </div>
                    </div>
                    @includeif('admin.layouts.partials.alertBox')
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
										<th>Name</th>
										<th>Page Key</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($templates as $template)
                                        <tr>
                                            <td>{{ ++$i }}</td>

											<td>{{ $template->name }}</td>
											<td>{{ $template->page_key }}</td>

                                            <td>
                                                @can('templates.view')
                                                <a class="btn btn-sm btn-primary " href="{{ route('templates.show',$template->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                @endcan
                                                @can('templates.edit')
                                                <a class="btn btn-sm btn-success" href="{{ route('templates.edit',$template->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                @endcan
                                                @can('templates.delete')
                                                <form action="{{ route('templates.destroy',$template->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                                </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $templates->links() !!}
            </div>
        </div>
    </div>
@endsection
