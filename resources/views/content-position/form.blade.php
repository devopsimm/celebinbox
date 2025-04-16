<div class="row">
    <div class="col-md-6">
        <div class="box box-info padding-1">
            <div class="box-body">

                <div class="form-group">
                    {{ Form::label('key') }}
                    {{ Form::text('key', $contentPosition->key, ['required'=>'true','class' => 'form-control' . ($errors->has('key') ? ' is-invalid' : ''), 'placeholder' => 'Key']) }}
                    {!! $errors->first('key', '<div class="invalid-feedback">:message</p>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('slots') }}
                    {{ Form::text('slots', $contentPosition->slots, ['required'=>'true','class' => 'form-control' . ($errors->has('slots') ? ' is-invalid' : ''), 'placeholder' => 'Slots']) }}
                    {!! $errors->first('slots', '<div class="invalid-feedback">:message</p>') !!}
                </div>
                <input type="hidden" value="1" name="content_type">
                <div class="form-group">
                    {{ Form::label('is_published') }}
                    <select class="form-control" name="status">
                        <option {{ ($contentPosition->status == null) ?'selected':'' }} disabled>Select Publishing Status</option>
                        @foreach(config('settings.publishingStatus') as $key => $publishingStatus)
                            <option {{ ($contentPosition->status == $key)?'selected':'' }} value="{{ $key }}">{{ $publishingStatus }}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('is_published', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
            <div class="box-footer mt20">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
    <div class="col-md-6" >
        <div class="box box-info padding-1">
            <div class="box-body">

                @if(count($contentPosition->details))
                    <ul>
                        @php $i = 1 @endphp
                        @foreach($contentPosition->details as $details)
                            <li style="display: flex; margin-bottom: 15px">
                                <span style="margin-right: 10px"> <b>{{ $i }})</b></span>
                                <input disabled type="text" class="form-control"
                                       value="{{ ($contentPosition->content_type == 1) ? (($details->post != null)?$details->post->title:'None') : (($details->product != null)? $details->product->title: 'none') }}"
                                       style="margin-right: 10px">
                                <input style="width:  10%;" type="number" class="form-control" name="details[{{ $details->id }}]" value="{{ $details->sequence }}">

                            </li>
                            @php $i++; @endphp
                        @endforeach
                    </ul>
                @endif

            </div>

        </div>
    </div>
</div>

@push('scripts')

@endpush
