<div class="box box-info padding-1">
    <div class="box-body">

       <div class="row">
           <div class="col-md-6">
               <div class="form-group">
                   {{ Form::label('name') }}
                   {{ Form::text('name', $user->name, ['required'=>'true','class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
                   {!! $errors->first('name', '<div class="invalid-feedback">:message</p>') !!}
               </div>
               <div class="form-group">
                   {{ Form::label('email') }}
                   <input type="email" name="email" value="{{ $user->email }}" {{ ($user->email == null)?'required':'disabled' }} placeholder="Email"  class="form-control {{ ($errors->has('email') ? ' is-invalid' : '') }}" />
                   {!! $errors->first('email', '<div class="invalid-feedback">:message</p>') !!}
               </div>
               <div class="form-group">
                   {{ Form::label('password') }}
                   <input type="password" name="password" {{ ($user->password == null)?'required':'' }} placeholder="*******"  class="form-control {{ ($errors->has('password') ? ' is-invalid' : '') }}" />
                   {!! $errors->first('password', '<div class="invalid-feedback">:message</p>') !!}
               </div>
               <div class="form-group">
                   {{ Form::label('confirm password') }}
                   <input type="password" name="password_confirmation" {{ ($user->password == null)?'required':'' }} placeholder="*******"
                          class="form-control {{ ($errors->has('password_confirmation') ? ' is-invalid' : '') }}" />
                   {!! $errors->first('password_confirmation', '<div class="invalid-feedback">:message</p>') !!}
               </div>

               <div class="form-group">
                   {{ Form::label('Role') }}
                   <select name="role" class="form-control" required id="">
                       <option selected disabled>Select User Role</option>
                       @foreach($roles as $role)
                           <option {{ (count($user->roles))?(($user->roles[0]->id == $role->id)?"selected":''):"" }} value="{{ $role->id }}">{{ $role->name }}</option>
                       @endforeach
                   </select>
                   {!! $errors->first('confirm_password', '<div class="invalid-feedback">:message</p>') !!}
               </div>
           </div>
       </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
