

<div class="row">
    <input id="post_edit_id" name="post_edit_id" data-name="post_edit_id" type="hidden" value="{{ ($id)? $id : '' }}">
    <input id="ParentCategoryId" type="hidden" value="{{ $post->category_id }}">
    <input type="hidden" id="description" name="description" />

    <div class="postCol1">
        <div class="box box-info padding-1">
            @if($post->is_rephrase == 1)
            <div class="box-header"> <h2 class="underline" style="font-size: 26px;">Rephrased</h2> </div>
            @endif
                <div class="box-body">
                <div class="form-group">
                    {{ Form::label('title') }}
                    {{ Form::text('title', $post->title, ['required'=>'true','class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : ''), 'placeholder' => 'Title']) }}
                    {!! $errors->first('title', '<div class="invalid-feedback">:message</p>') !!}
                </div>
                <div class="postBtns">
                    <button type="button" data-targetClass="appTitle" class="postBtn btn btn-sm btn-primary"> APP Title </button>
                    <button type="button" data-targetClass="slug" class="postBtn btn btn-sm btn-primary"> Slug </button>
                    <button type="button" data-targetClass="story_highlights" class="postBtn btn btn-sm btn-primary"> Story Highlights </button>
                    <button type="button" data-targetClass="canonicals" class="postBtn btn btn-sm btn-primary"> Canonicals </button>

                    <hr>
                </div>


                <div class="form-group appTitle displayNone">
                    {{ Form::label('app_title') }}
                    {{ Form::text('app_title', $post->app_title, ['class' => 'form-control' . ($errors->has('app_title') ? ' is-invalid' : ''), 'placeholder' => 'App Title']) }}
                    {!! $errors->first('app_title', '<div class="invalid-feedback">:message</p>') !!}
                </div>

                <div class="form-group slug displayNone">
                    {{ Form::label('slug') }}
                    {{ Form::text('slug', $post->slug, ['class' => 'form-control' . ($errors->has('slug') ? ' is-invalid' : ''), 'placeholder' => 'Slug']) }}
                    {!! $errors->first('slug', '<div class="invalid-feedback">:message</p>') !!}
                </div>

                <div class="form-group story_highlights displayNone">
                    {{ Form::label('story_highlights') }}
                    <textarea name="story_highlights" class="form-control {{ ($errors->has('story_highlights') ? ' is-invalid' : '') }}" placeholder="Story Highlights">{{ $post->story_highlights }}</textarea>
                    {!! $errors->first('story_highlights', '<div class="invalid-feedback">:message</p>') !!}
                </div>

                <div class="row canonicals displayNone">
                    <div class="col-md-6 form-group">
                        {{ Form::label('canonical_url') }}
                        {{ Form::text('canonical_url', $post->canonical_url, ['class' => 'form-control' . ($errors->has('canonical_url') ? ' is-invalid' : ''), 'placeholder' => 'Canonical Url']) }}
                        {!! $errors->first('canonical_url', '<div class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="col-md-6 form-group">
                        {{ Form::label('canonical_source') }}
                        {{ Form::text('canonical_source', $post->canonical_source, ['class' => 'form-control' . ($errors->has('canonical_source') ? ' is-invalid' : ''), 'placeholder' => 'Canonical Source']) }}
                        {!! $errors->first('canonical_source', '<div class="invalid-feedback">:message</p>') !!}
                    </div>
                </div>





                <div class="form-group">
                    {{ Form::label('excerpt') }}
                    <textarea name="excerpt" required class="form-control {{ ($errors->has('excerpt') ? ' is-invalid' : '') }}" placeholder="Excerpt Text">{{ $post->excerpt }}</textarea>
                    {!! $errors->first('excerpt', '<div class="invalid-feedback">:message</p>') !!}
                </div>

                <div class="form-group">
                    {{ Form::label('description') }}
                   <div class="editable" data-oldpostid="false" name="description" data-name="description" data-placeholder="Type some text">
                       <p class="">
                           {!! $description !!}

                       </p>
                   </div>
                    {!! $errors->first('description', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>

        </div>
    </div>
    <div class="postCol2">

        <div class="box box-info padding-1">
            <div class="box-body">

            <div class="form-group">
                {{ Form::label('template') }}
                <select name="template_id" class="form-control">
                    @foreach($templates as $template)
                        <option {{ ($template->id == $post->template_id)?'selected':'' }} value="{{ $template->id }}">{{ $template->name }}</option>
                    @endforeach
                </select>
                {!! $errors->first('template_id', '<div class="invalid-feedback">:message</p>') !!}
            </div>
            <div class="form-group">
                {{ Form::label('Main Category') }}
                <select id="parent_category" required name="parent_category" class="form-control">
                    <option {{ ($post->category_id == null)?'selected':'' }} disabled>Select Main Category</option>
                    @foreach($categories as $category)
                        <option {{ ($post->category_id == $category->id)?'selected':'' }} value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                {!! $errors->first('parent_category', '<div class="invalid-feedback">:message</p>') !!}
            </div>
            <div class="form-group">
                {{ Form::label('Categories') }}
                <select id="categories"  multiple name="categories[]" class="form-control">
                </select>
                {!! $errors->first('categories', '<div class="invalid-feedback">:message</p>') !!}
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('featured_image') }}

                        <input {{ ($featuredImg == null) ? 'required' : '' }} style="display: none" type="file" name="image" accept="image/*" id="image-upload">
                        <div id="image-container" >
                               <span class="imgContainerText" style="{{ ($post->featured_image != null)?'display:none':'' }}">
                                   <i class="fa fa-plus fa-2x"></i>
                                   <p>Click to upload thumbnail </p>
                               </span>
                            <img class="img-fluid" src="{{ $featuredImg }}" id="imagePreview" />
                        </div>
                        {!! $errors->first('featured_image', '<div class="invalid-feedback">:message</p>') !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('Tags') }}
                        <input type="text" name="tags" value="{{ ($selectedTags)?$selectedTags:'' }}" class="form-control" id="hero-demo">
                        {!! $errors->first('tags', '<div class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="form-group">
                        {{ Form::label('Content Position') }}

                        <select multiple name="content_positions[]" class="form-control">

                            @foreach($contentPositions as $contentPosition )
                                @foreach($contentPosition->details as $details)
                                    <option {{ in_array($details->id,$postPositions)? 'selected' : '' }}
                                            value="{{ $details->id }}">
                                            {{ $contentPosition->key.'-'.$details->sequence }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                        {!! $errors->first('content_position', '<div class="invalid-feedback">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="row">
                @if(config('settings.pushNotification'))
                    <div class="col-md-6">
                        <h5>Push Notification</h5>
                        <ul class="NoListStyle">
                            @foreach(config('settings.pushNotification') as $key=>$val)
                                <li>
                                    <label for="pn_{{ $key }}">
                                        <input id="pn_{{ $key }}" type="checkbox" value="{{ $key }}" name="pushNotifications[]">
                                        {{ $val }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(count(config('settings.socialSharing')))
                    <div class="col-md-6">
                        <h5>Social Sharing</h5>
                        <ul class="NoListStyle">
                            @foreach(config('settings.socialSharing') as $key=>$val)
                                <li>
                                    <label for="ss_{{ $key }}">
                                        <input id="ss_{{ $key }}" {{ in_array($key,$socialSharing)?'checked':'' }} type="checkbox" value="{{ $key }}" name="socialSharings[]">
                                        {{ $val }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h5>Others</h5>
                    </div>
                    <div class="col-md-6">
                        <ul class="NoListStyle">
                            <li>
                                <label for="show_video_icon">
                                    <input id="show_video_icon" {{ ($post->show_video_icon == '1')?'checked':'' }} type="checkbox" value="1" name="show_video_icon">
                                    Show video icon on story image
                                </label>
                            </li>
                            @foreach(array_slice(config('settings.postMetaCheckBoxes'), 0, count(config('settings.postMetaCheckBoxes')) / 2) as $key=>$val)
                                <li>
                                    <label for="pm_{{ $key }}">
                                        <input id="pm_{{ $key }}" {{ (isset($metas[$key]))?'checked':'' }} type="checkbox" value="1" name="meta[{{ $key }}]">
                                        {{ $val }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="NoListStyle">
                            @foreach(array_slice(config('settings.postMetaCheckBoxes'), count(config('settings.postMetaCheckBoxes')) / 2) as $key=>$val)
                                <li>
                                    <label for="pm_{{ $key }}">
                                        <input id="pm_{{ $key }}" {{ (isset($metas[$key]))?'checked':'' }} type="checkbox" value="1" name="meta[{{ $key }}]">
                                        {{ $val }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @if(count(config('settings.postMetaInputs')))
                <div class="row">
                        @foreach(config('settings.postMetaInputs') as $key=>$val)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{ $val }}</label>
                                    <input type="text" value="{{ (isset($metas[$key]))?$metas[$key]:'' }}" class="form-control" placeholder="{{ $val }}" name="metaInputs[{{ $key }}]">
                                </div>
                            </div>
                        @endforeach
                </div>
                @endif
                <div class="form-group">
                    {{ Form::label('Source Type') }}
                    <select id="sourceType" name="source_type" class="form-control">
                        @foreach(config('settings.postSourceType') as $key=>$val)
                            <option value="{{ $key }}" {{ ($key == $post->type)?'selected':'' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('source_type', '<div class="invalid-feedback">:message</p>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('authors') }}
                    <select multiple name="author_ids[]" id="authors" required class="form-control">

                    </select>
                    {!! $errors->first('author_id', '<div class="invalid-feedback">:message</p>') !!}
                </div>



            <div class="row relatedPostsRow">
               <div class="col-md-10">
                   <div class="form-group">
                       <label>Related Posts</label>
                       <input type="text" id="relatedPosts" class="form-control">
                   </div>
               </div>
               <div class="col-md-2">
                   <input type="button" id="searchRelatedPost" value="Search" class="btn btn-primary btn-sm" style="margin-top: 30px">
               </div>
               <div class="relatedPostsPopup">
                   <span class="PopUpClose">x</span>
                   <div class="holder"></div>
               </div>
               <div id="relatedPostsHolder">
                   @if(count($relatedPosts))
                       @foreach($relatedPosts as $key=>$relatedPost)
                           <div class="relatedPost">
                               <input type="hidden" name="relatedPostIds[]" value="{{ $key }}" />
                               <span class="removeRelatedPost" onclick="removeRelatedPost(this)">-</span>
                               <b>{{ $relatedPost }}</b>
                           </div>
                       @endforeach
                   @endif
               </div>
           </div>
            <div class="form-group">
                {{ Form::label('is_published') }}
                @php $status = config('settings.publishingStatus');
                $status[3] = 'Scheduled';
                @endphp
                <select class="form-control" name="is_published">
                    <option {{ ($post->is_published == null) ?'selected':'' }} disabled>Select Publishing Status</option>
                    @foreach($status as $key => $publishingStatus)
                        <option {{ ($post->is_published == $key)?'selected':'' }} value="{{ $key }}">{{ $publishingStatus }}</option>
                    @endforeach
                </select>
                {!! $errors->first('is_published', '<div class="invalid-feedback">:message</p>') !!}
            </div>


            </div>
        </div>
    </div>
    <div class="postCol3" style="display: none">
        <div class="box box-info padding-1">
            <div class="box-header"> <h2 class="underline" style="font-size: 26px;">Original</h2>
{{--            <i >close</i>--}}
            </div>
            <div class="box-body">
              <div class="topSection">
                  <div class="form-group titleBox">
                      <b>Title</b>
                      <p>{{ $post->org_title }}</p>
                  </div>
                  <div class="form-group excerptBox">
                      <b>Excerpt</b>
                      <p>{{  $post->org_excerpt }}</p>
                  </div>
              </div>
              <div class="postDescription">
                  {!! $descriptionOrg !!}
              </div>
            </div>
        </div>
    </div>

</div>
<div class="box-footer mt20">
    <div class="row">
        <div class="form-group col-md-2">

            <input type="text" value="{{ Helper::convertDateFormat($post->posted_at,'12') }}" id="datetimepicker1" name="posted_at" class="form-control">
{{--            <input type="text" value="{{ $post->posted_at }}" id="datetimepicker1" name="posted_at" class="form-control">--}}
        </div>
        <div class="col-md-2">

            <button type="button" id="savePost" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <ul>
            @if(count($post->activity))
                @foreach($post->activity as $activity)
                    <li><b>{{ $activity->user->name }}</b> {{ $activity->activity }} at: {{ $activity->created_at }}</li>
                @endforeach

            @endif
        </ul>
    </div>
</div>


@push('scripts')
    <style>
        .postCol3 .box-header i {
            position: absolute;
            font-style: normal;
            text-transform: capitalize;
            top: 0;
            right: 0;
            background: #444;
            color: #fff;
            padding: 10px 26px;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
        }
        .postDescription img {
            max-width: 100%;
        }

        .postDescription {
            margin-top: 55px;
        }
        .topSection {
            min-height: 220px;
        }
        .titleBox{
            display: flex;
            flex-direction: column;
            justify-content: center;}
        .postCol1 {
            /*width: 66%;*/
            width: 50%;
        }

        .postCol2 {
            width: 33%;
        }

        .postCol3 {
            width: 50%;
        }

        .medium-editor-toolbar-form-active {
            background: #d3d3d3;
            padding: 10px;
        }
        div#medium-editor-anchor-preview-1 {
            background: #000 !important;
            padding: 10px;
        }
    </style>
    <script !src="">
        const getTagsUrl = '/admin/get-tags';
    </script>
    <link rel="stylesheet" href="{{ url('admin-assets/libs/jQuery-tagEditor-master/jquery.tag-editor.css') }}">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
    <script src="{{ url('admin-assets/libs/jQuery-tagEditor-master/jquery.caret.min.js') }}"></script>
    <script src="{{ url('admin-assets/libs/jQuery-tagEditor-master/jquery.tag-editor.js') }}"></script>
    <link rel="stylesheet" href="{{ url('admin-assets/css/medium-editor.min.css') }}">
    <link rel="stylesheet" href="{{ url('admin-assets/css/medium-editor-insert-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ url('admin-assets/css/spectrum.min.css') }}">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/medium-editor-insert-plugin/2.5.0/css/medium-editor-insert-plugin-frontend.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/medium-editor-insert-plugin/2.5.0/css/medium-editor-insert-plugin.min.css" />
    <link rel="stylesheet" href="{{ url('admin-assets/css/medium-editor-master/medium-editor.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css">
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script src="{{ url('admin-assets/js/jquery.ui.widget.js') }}"></script>
    <script src="{{ url('admin-assets/js/jquery.iframe-transport.js') }}"></script>
    <script src="{{ url('admin-assets/js/jquery.fileupload.js') }}"></script>
    <script src="{{ url('admin-assets/js/medium-editor.js') }}"></script>
    <script src="{{ url('admin-assets/js/handlebars.runtime.min.js') }}"></script>
    <script src="{{ url('admin-assets/js/medium-editor-insert-plugin.js') }}"></script>
    <script src="{{ url('admin-assets/js/medium-editor-tables.min.js') }}"></script>
    <script src="{{ url('admin-assets/js/spectrum.min.js') }}"></script>
    <script src="{{ url('admin-assets/js/appv3.js') }}"></script>
    <script src="{{ url('admin-assets/js/extension.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script !src="">
        const getRelatedPosts = "{{ route('getRelatedPosts') }}";
        const getAuthorsBySourceType = "{{ route('getAuthorsBySourceType') }}";
        const getChildCategoriesRoute = "{{ route('getChildCategories') }}";
    </script>
    <script src="{{ url('admin-assets/js/post.js') }}"></script>
    <script sync src="https://www.instagram.com/embed.js"></script>

    {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker-standalone.css" integrity="sha512-wT6IDHpm/cyeR3ASxyJSkBHYt9oAvmL7iqbDNcAScLrFQ9yvmDYGPZm01skZ5+n23oKrJFoYgNrlSqLaoHQG9w==" crossorigin="anonymous" referrerpolicy="no-referrer" />--}}
    {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker-standalone.min.css" integrity="sha512-L0/PNISezIYAoqFXBGP9EJ4qLH8XF356+Lo92vzloQqk7HUpZ4FN1x1dUOnsUAUjHTSxXxeaD0HXfrANhtJOEA==" crossorigin="anonymous" referrerpolicy="no-referrer" />--}}
    {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" integrity="sha512-mQ8Fj7epKOfW0M7CwuuxdPtzpmtIB5rI4rl76MSd3mm5dCYBKjzPk7EU/2buhPMs0KmC6YOPR/MQlQwpkdNcpQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />--}}
    {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" integrity="sha512-WWc9iSr5tHo+AliwUnAQN1RfGK9AnpiOFbmboA0A0VJeooe69YR2rLgHw13KxF1bOSLmke+SNnLWxmZd8RTESQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />--}}
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js" integrity="sha512-Y+0b10RbVUTf3Mi0EgJue0FoheNzentTMMIE2OreNbqnUPNbQj8zmjK3fs5D2WhQeGWIem2G2UkKjAL/bJ/UXQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}
    {{--    --}}

        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css">
        <link rel="stylesheet" href="{{ url('admin-assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" type="text/css" media="all" />
        <script src="{{ url('admin-assets/libs/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script !src="">
            $('#datetimepicker1').datetimepicker({
                "showTodayButton": true,

                "allowInputToggle": true,
                "showClose": true,
                // "showClear": true,
                "format": "YYYY-MM-DD hh:mm:ss A",

            });

            $("#viewOrg").click(function (){
                $('.postCol2').hide();
                $('.postCol3').show();

                $("#viewOrg").hide();
                $("#closeBtn").show();
            });


            $("#closeBtn").click(function (){
                $('.postCol3').hide();
                $('.postCol2').show();

                $("#viewOrg").show();
                $("#closeBtn").hide();
            });

            $(".loaderLink").click(function (e){
              //  alert();
                $("#loader").css('display','flex');
                            });
        </script>

@endpush
