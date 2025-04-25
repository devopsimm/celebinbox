<x-app-layout>

    <x-slot name="header">
        Authors
    </x-slot>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Author') }}
                            </span>

                             <div class="float-right">
                                 @can('manageAuthors')
                                <a href="{{ route('authors.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                                 @endcan
                              </div>
                        </div>
                    </div>
                    <x-alertBox />
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
										<th>Name</th>
										<th>Slug</th>
										<th>Type</th>
										<th>Profile Picture</th>
										<th>Email</th>
										<th>Phone</th>
										<th>Is Publish</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($authors as $author)
                                        <tr>
                                            <td>{{ ++$i }}</td>

											<td>{{ $author->name }}</td>
											<td>{{ $author->slug }}</td>
											<td>{{ config('settings.authorType.'.$author->type) }}</td>
											<td>{!! ($author->profile_picture != null)?'<img width="100" src="'.Helper::getFileUrl($author->profile_picture,$author).'" />':'' !!}</td>
											<td>{{ $author->email }}</td>
											<td>{{ $author->phone }}</td>
											<td>{{ config('settings.publishingStatus.'.$author->is_publish) }}</td>

                                            <td>
                                                 @can('manageAuthors')
                                                <a class="btn btn-sm btn-primary " href="{{ route('authors.show',$author->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                 @endcan
                                                 @can('manageAuthors')
                                                <a class="btn btn-sm btn-success" href="{{ route('authors.edit',$author->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                 @endcan
                                                 @can('manageAuthors')
                                                <form action="{{ route('authors.destroy',$author->id) }}" method="POST">
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
                {!! $authors->links() !!}
            </div>
        </div>
    </div>
</x-app-layout>
