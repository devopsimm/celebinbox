 <x-app-layout>

        <x-slot name="header">
            Content Position
        </x-slot>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Content Position') }}
                            </span>

                             <div class="float-right">
                                 @can('content_positions.create')
                                <a href="{{ route('content-positions.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
										<th>Key</th>
										<th>Slots</th>
										<th>Status</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contentPositions as $contentPosition)
                                        <tr>
                                            <td>{{ ++$i }}</td>

											<td>{{ $contentPosition->key }}</td>
											<td>{{ $contentPosition->slots }}</td>
                                            <td>{{ config('settings.publishingStatus.'.$contentPosition->status) }}</td>

                                            <td>
                                                @can('content_positions.view')
                                                <a class="btn btn-sm btn-primary " href="{{ route('content-positions.show',$contentPosition->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                @endcan
                                                @can('content_positions.edit')
                                                <a class="btn btn-sm btn-success" href="{{ route('content-positions.edit',$contentPosition->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                @endcan
                                                @can('content_positions.delete')
                                                <form action="{{ route('content-positions.destroy',$contentPosition->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                                </form>
                                                @endcan
                                                @can('content_positions.ManagePostProducts')
                                                    @if($contentPosition->content_type == '1')
{{--                                                    <a class="btn btn-sm btn-warning" href="{{ route('contentPosts',$contentPosition->id) }}"><i class="fa fa-fw fa-eye"></i> Posts</a>--}}
                                                    @else
{{--                                                    <a class="btn btn-sm btn-warning" href="{{ route('contentProducts',$contentPosition->id) }}"><i class="fa fa-fw fa-eye"></i> Products</a>--}}
                                                    @endif
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $contentPositions->links() !!}
            </div>
        </div>
    </div>
 </x-app-layout>
