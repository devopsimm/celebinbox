<x-app-layout>

    <x-slot name="header">
        Users
    </x-slot>


    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Category') }}
                            </span>

                             <div class="float-right">
                                 @can('categories.create')
                                <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
										<th>Parent</th>
										<th>Image</th>
										<th>Is Featured</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ ++$i }}</td>

											<td>{{ $category->name }}</td>
											<td>{{ $category->slug }}</td>
											<td>{{ ($category->parentCategories == null)?'None':$category->parentCategories->name }}</td>
											<td>{!! ($category->image != null)?'<img width="100" src="'.Helper::getFileUrl($category->image,$category,'category').'" />':'' !!}</td>
                                            <td>{{ ($category->is_featured == 1)?'Yes':'No' }}</td>
                                            <td>
                                                @can('categories.view')
                                                <a class="btn btn-sm btn-primary " href="{{ route('categories.show',$category->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                @endcan

                                                @can('categories.edit')
                                                <a class="btn btn-sm btn-success" href="{{ route('categories.edit',$category->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                @endcan

                                                @can('categories.delete')
                                                <form action="{{ route('categories.destroy',$category->id) }}" method="POST">
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
                {!! $categories->links() !!}
            </div>
        </div>
    </div>
</x-app-layout>
