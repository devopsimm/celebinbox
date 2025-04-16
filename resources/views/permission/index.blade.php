<x-app-layout>

    <x-slot name="header">
        Permission
    </x-slot>


    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Permission') }}
                            </span>
                            @can('permissions.manage')
                             <div class="float-right">
                                <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                            @endcan
                        </div>
                    </div>
                    <x-alertBox />
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
										<th>Name</th>
                                        @foreach($roles as $role)
                                            <th>{{ $role->name }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
											<td>{{ $permission->name }}</td>
                                            @foreach($roles as $role)
                                                <td><input class="managePermissionRole"
                                                           {{ (in_array($permission->id,$role->permissions()->pluck('id')->toArray()))?'checked':'' }}
                                                           type="checkbox"
                                                           data-permission="{{ $permission->id }}"
                                                           data-role="{{ $role->id }}"></td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $permissions->links() !!}
            </div>
        </div>
    </div>
    <input type="hidden" id="url" value="{{ route('assignRolePermission') }}">



@push('scripts')
    <script>
        const url = $("#url").val();
        $(".managePermissionRole").click(function (){
           let ele = $(this);
           let permissionId = ele.attr('data-permission');
           let roleId = ele.attr('data-role');
           let createNew = ele.is(":checked");
            $.ajax({
                url: url,
                method: 'POST',
                data: {permissionId:permissionId,roleId:roleId,createNew:createNew},
                success: function (res) {

                }
            });

        });
    </script>
@endpush
</x-app-layout>
