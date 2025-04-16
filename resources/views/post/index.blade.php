<x-app-layout>

    <x-slot name="header">
        Posts
    </x-slot>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                <b>{{ __('Post') }}</b>
                                <hr>
                            </span>

                             <div class="float-right">
                                 @can('posts.create')
{{--                                <a href="{{ route('posts.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">--}}
{{--                                  {{ __('Create New') }}--}}
{{--                                </a>--}}
                                 @endcan
                                 @if(!isset($type))
{{--                                     <a href="{{ route('indexByType','3') }}" class="btn btn-warning btn-sm float-right mr-4"  data-placement="left">--}}
{{--                                         {{ __('Scheduled Posts') }}--}}
{{--                                     </a>--}}
                                 @else
{{--                                    <a href="{{ route('posts.index') }}" class="btn btn-warning btn-sm float-right mr-4"  data-placement="left">--}}
{{--                                        {{ __('Posts') }}--}}
{{--                                    </a>--}}
                                 @endif
                              </div>

                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <button id="filter" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm pull-left">Filter</button>
                            </div>
                          @role('Admin')
                            <div class="col-md-6">
                                <form action="" style="display: flex">
                                    <input type="text" class="form-control" name="search" />
                                    <input type="submit" value="Search" class="btn btn-primary btn-sm">
                                </form>
                            </div>
                            @endrole
                        </div>
                        @can('posts.edit')
                        <hr>
                        <div class="row" style="display: none">
                            <div class="col-md-2">
                                <select id="blukAction"  style="width: 100%" >
                                    <option disabled> Select Status</option>
                                    @foreach(config('settings.publishingStatus') as $key=>$val)
                                        <option  value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button id="bulkSubmit"  class="btn btn-primary btn-sm pull-left">Bulk Submit</button>
                            </div>
                        </div>
                        @endcan




                    </div>
                    <x-alertBox />

                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        @can('posts.edit')
{{--                                        <th><input type="checkbox" id="toggleAllCheckBox"></th>--}}
                                        @endcan
                                        <th>No</th>
										<th>Title</th>
										<th>Rephrase</th>
										<th>Category</th>
                                        <th>Created At</th>
                                        <th>Posted At</th>
										<th>Is Published</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $post)

                                        {{-- TODO: MAnage Status for initial posts--}}
                                        @if($post->slug != null && $post->title != null)
                                        <tr>
                                            @can('posts.edit')
{{--                                            <td><input type="checkbox" name="postId[{{ $post->id }}]" value="{{ $post->id }}"></td>--}}
                                            @endcan
                                            <td>{{ ++$i }}</td>
											<td>
                                                <a href="{{ route('feed-posts.edit',$post->id) }}" class="titleCol">
                                                    <img style="margin-right: 10px" src="{{ Helper::getFeaturedImg(['post'=>$post]) }}" width="50">
                                                    <p>{{ $post->title }}</p> <b>({{ $post->feed->name }})</b>
                                                </a>
                                            </td>
                                                <td>
                                                    {{ $post->is_rephrase == 0 ? '' : 'Rephrased' }}
                                                </td>
                                                <td>
                                                    {{ $post->MainCategory->name }}
                                                </td>
                                            <td>{{ \Carbon\Carbon::parse($post->created_at)->format('d-m-Y H:i:s') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($post->posted_at)->format('d-m-Y H:i:s') }}</td>
											<td>{{ config('settings.publishingStatus.'.$post->is_published) }}</td>

                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>

                            {!! $posts->withQueryString()->links() !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Filter Posts</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="date" value="{{ ($filters && isset($filters['startDate'])?$filters['startDate']:'' ) }}" class="form-control" name="filter[startDate]" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="date" value="{{ ($filters && isset($filters['endDate'])?$filters['endDate']:'' ) }}" class="form-control" name="filter[endDate]" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Feeds</label>
                                    <select style="width: 100%" multiple name="filter[feeds][]" >
                                        <option disabled> Select Categories</option>
                                        @foreach($feeds as $feed)
                                            <option {{ ($filters && isset($filters['feeds']) && in_array($feed->id,$filters['feeds']) ?'selected':'' ) }} value="{{ $feed->id }}">{{ $feed->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Categories</label>
                                    <select style="width: 100%" multiple name="filter[categories][]" >
                                        <option disabled> Select Categories</option>
                                        @foreach($categories as $category)
                                            <option {{ ($filters && isset($filters['categories']) && in_array($category->id,$filters['categories']) ?'selected':'' ) }} value="{{ $category->id }}">{{ $category->name }}</option>
                                            @if(count($category->childCategories))
                                                @foreach($category->childCategories as $child)
                                                    <option {{ ($filters && isset($filters['categories']) && in_array($child->id,$filters['categories']) ?'selected':'' ) }} value="{{ $child->id }}">-{{ $child->name }}</option>
                                                @endforeach
                                            @endif

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Publishing Status</label>
                                    <select  style="width: 100%" multiple name="filter[publish_status][]" >
                                        <option disabled> Select Status</option>
                                        @foreach(config('settings.publishingStatus') as $key=>$val)
                                            <option {{ ($filters && isset($filters['publish_status']) && in_array($key,$filters['publish_status']) ?'selected':'' ) }} value="{{ $key }}">{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>



@push('scripts')
    <script !src="">
        $("#toggleAllCheckBox").click(function (){
           var isChecked = $(this).prop('checked');
            $('input[type="checkbox"]').prop('checked', isChecked);
        });


      $("#bulkSubmit").click(function (){
          var checkboxes = $('input[type="checkbox"]:checked').not('#toggleAllCheckBox:checked');

          var checkboxValues = checkboxes.map(function() {
              return $(this).val();
          }).get();
          var action = $("#blukAction").val();

          $.blockUI({ css: {
                  border: 'none',
                  padding: '15px',
                  backgroundColor: '#000',
                  '-webkit-border-radius': '10px',
                  '-moz-border-radius': '10px',
                  opacity: .5,
                  color: '#fff'
              } });

          $.ajax({
              url: '{{ route("bulkPostSubmit") }}',
              method: 'POST',
              data: { checkboxes: checkboxValues,action:action },
              success: function(response) {
                  $.unblockUI();
                  location.reload();
              },
              error: function(xhr, status, error) {
                  // Handle error
                  console.error(error);
              }
          });
      });
    </script>
        <style>
            table.table.table-striped.table-hover td > a {
                display: flex;
                text-decoration: underline;
            }
            table.table.table-striped.table-hover td > a p {
                margin-right: 10px;
            }
        </style>
    @endpush

</x-app-layout>
