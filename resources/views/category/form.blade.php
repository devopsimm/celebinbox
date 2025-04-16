<div class="row">
    <div class="col-md-6">
        <div class="box box-info padding-1">
            <div class="box-body">
                <input type="hidden" value="2" name="type" />
                <div class="form-group">
                    {{ Form::label('Parent Categories') }}
                    <select name="parent_id" required class="form-control">
                        <option {{ ($category->parent_id == null)?'Selected':'' }} >None</option>
                        @foreach($parentCategories as $parentCategory)
                            <option value="{{ $parentCategory->id }}" {{ ($parentCategory->id == $category->parent_id)?'selected':'' }}>{{ $parentCategory->name }}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('type', '<div class="invalid-feedback">:message</p>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('name') }}
                    {{ Form::text('name', $category->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
                    {!! $errors->first('name', '<div class="invalid-feedback">:message</p>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('description') }}
                    <textarea class="form-control {{ ($errors->has('description') ? ' is-invalid' : '') }}" name="description" placeholder="Category Description">{{ $category->description }}</textarea>
                    {!! $errors->first('description', '<div class="invalid-feedback">:message</p>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('image') }}
                    <input type="file" {{ (($category->image == null))?'':'' }} name="photo" class="form-control-file">
                    {!! $errors->first('image', '<div class="invalid-feedback">:message</p>') !!}
                    @if($category->image != null)
                        <br>
                        <img src="{{ Helper::getFileUrl($category->image,$category,'category') }}" width="150" alt="">
                    @endif
                </div>
                <div class="form-group">
                    {{ Form::label('is_featured') }}
                    <input type="checkbox" {{ ($category->is_featured == 1)?'checked':'' }} name="is_featured" class="{{ ($errors->has('description') ? ' is-invalid' : '') }}">
                    {!! $errors->first('description', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-info padding-1">
            <div class="box-body">
                <h6>SEO</h6>

                <div class="form-group">
                    {{ Form::label('title') }}
                    {{ Form::text('seo[title]', $seoTags['title'], ['required'=>'true','class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : ''), 'placeholder' => 'Title']) }}
                    {!! $errors->first('title', '<div class="invalid-feedback">:message</p>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('description') }}
                    <textarea name="seo[description]" class="form-control {{ ($errors->has('description') ? ' is-invalid' : '') }} " placeholder="Description">{{ $seoTags['description'] }}</textarea>
                    {!! $errors->first('description', '<div class="invalid-feedback">:message</p>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('keywords') }}
                    {{ Form::text('seo[keywords]', $seoTags['keywords'], ['required'=>'true','class' => 'form-control' . ($errors->has('keywords') ? ' is-invalid' : ''), 'placeholder' => 'Keywords']) }}
                    {!! $errors->first('keywords', '<div class="invalid-feedback">:message</p>') !!}
                </div>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box-footer mt20">
            <button type="submit" class="btn btn-primary pull-right">Submit</button>
        </div>
    </div>
</div>
