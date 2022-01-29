{{ csrf_field() }}
<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.name') *</label>
    <div class="col-sm-9 col-lg-10 controls">
        <input type="text" name="name" placeholder="@lang('messages.name')" class="form-control input-lg"
            required value="{{ $technician->name ?? old('name') }}">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.users.email') *</label>
    <div class="col-sm-9 col-lg-10 controls">
        <input type="email" name="email" placeholder="@lang('messages.users.email')" class="form-control input-lg"
            required value="{{ $technician->email ?? old('email') }}">
    </div>
</div>

@if(!isset($technician) || $technician==null)
    <div class="form-group">
        <label class="col-sm-3 col-lg-2 control-label">@lang('messages.users.password') *</label>
        <div class="col-sm-9 col-lg-10 controls">
            <input type="password" name="password" placeholder="@lang('messages.users.password')"
                class="form-control input-lg" {{ isset($user) ? '' : 'required' }}>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 col-lg-2 control-label">@lang('messages.users.confirm_password') *</label>
        <div class="col-sm-9 col-lg-10 controls">
            <input type="password" name="password_confirmation" placeholder="@lang('messages.users.confirm_password')"
                class="form-control input-lg" {{ isset($user) ? '' : 'required' }}>
        </div>
    </div>
@endif
<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.users.phone') *</label>
    <div class="col-sm-9 col-lg-10 controls">
        <input type="text" name="phone" placeholder="@lang('messages.users.phone')" class="form-control input-lg"
            value="{{ $technician->phone ?? old('phone') }}">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.users.phone') *</label>
    <div class="col-sm-9 col-lg-10 controls">
        <input type="text" name="phone_2" placeholder="@lang('messages.users.phone')" class="form-control input-lg"
            value="{{ $technician->phone_2 ?? old('phone_2') }}">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-md-2 control-label">@lang('messages.Image.Image')</label>
    <div class="col-sm-9 col-md-8 controls">
        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                @if($technician)
                    <img src="{{url($technician->image)}}" alt="" />
                @else
                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                @endif
            </div>
            <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
            <div>
                <span class="btn btn-file"><span class="fileupload-new">@lang('messages.select_image')</span>
                    <span class="fileupload-exists">Change</span>
                    {!! Form::file('image',["accept"=>"image/*" ,"class"=>"default"]) !!}
                </span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
            </div>
        </div>
        <span class="label label-important">NOTE!</span>
        <span>Only extensions supported png, jpg, and jpeg</span>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
        <input type="submit" class="btn btn-primary" value="@lang('messages.save')">
    </div>
</div>
