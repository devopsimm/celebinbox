<div class="box box-info padding-1">
    <div class="box-body">
<div class="row">

    <div class="col-md-6">

        <div class="form-group">
            {{ Form::label('name') }}
            {{ Form::text('name', $author->name, ['required'=>'true','class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Source type') }}
            <select name="type" required class="form-control">
                @foreach(config('settings.authorType') as $key=>$val)
                    <option value="{{ $key }}" {{ ($author->type == $key)?'selected':'' }}>{{ $val }}</option>
                @endforeach
            </select>
            {!! $errors->first('type', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('twitter') }}
            {{ Form::text('twitter', $author->twitter, ['class' => 'form-control' . ($errors->has('twitter') ? ' is-invalid' : ''), 'placeholder' => 'Twitter']) }}
            {!! $errors->first('twitter', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('facebook') }}
            {{ Form::text('facebook', $author->facebook, ['class' => 'form-control' . ($errors->has('facebook') ? ' is-invalid' : ''), 'placeholder' => 'Facebook']) }}
            {!! $errors->first('facebook', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('email') }}
            {{ Form::text('email', $author->email, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => 'Email']) }}
            {!! $errors->first('email', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('phone') }}
            {{ Form::text('phone', $author->phone, ['class' => 'form-control' . ($errors->has('phone') ? ' is-invalid' : ''), 'placeholder' => 'Phone']) }}
            {!! $errors->first('phone', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('designation') }}
            {{ Form::text('designation', $author->designation, ['class' => 'form-control' . ($errors->has('designation') ? ' is-invalid' : ''), 'placeholder' => 'Designation']) }}
            {!! $errors->first('designation', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('details') }}
            <textarea class="form-control" name="details" placeholder="Author's Description">{{ $author->details }}</textarea>
            {!! $errors->first('details', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('is_publish') }}
            <select name="is_publish" required class="form-control">
                @foreach(config('settings.publishingStatus') as $key=>$val)
                    <option value="{{ $key }}" {{ ($author->is_publish == $key)?'selected':'' }}>{{ $val }}</option>
                @endforeach
            </select>
            {!! $errors->first('is_publish', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('profile_picture') }}
            <input type="file" {{ (($author->profile_picture == null))?'required':'' }} name="photo" class="form-control-file">
            {!! $errors->first('profile_picture', '<div class="invalid-feedback">:message</p>') !!}
            @if($author->profile_picture != null)
                <img src="{{ Helper::getFileUrl($author->profile_picture,$author) }}" width="150" alt="">
            @endif
        </div>
    </div>

</div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
