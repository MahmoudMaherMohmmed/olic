<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.cars.client')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
      <select class="form-control chosen-rtl" name="client_id" required>
        @foreach($clients as $client)
            <option value="{{$client->id}}" {{$client_car && $client_car->client_id==$client->id ? 'selected' : '' }}>{{$client->name}}</option>
        @endforeach
      </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.cars.car_brand')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
      <select class="form-control chosen-rtl" name="model_id" required>
        @foreach($models as $model)
          @if($model->brand!=null)
            <option value="{{$model->id}}" {{$client_car && $client_car->model_id==$model->id ? 'selected' : '' }}>
              {{$model->brand->getTranslation('name', Session::get('applocale')) ." - ". $model->getTranslation('name', Session::get('applocale'))}}
            </option>
          @endif
        @endforeach
      </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.cars.car_cylinders')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
      <select class="form-control chosen-rtl" name="cylinder_id" required>
        @foreach($cylinders as $cylinder)
            <option value="{{$cylinder->id}}" {{$client_car && $client_car->cylinder_id==$cylinder->id ? 'selected' : '' }}>{{$cylinder->getTranslation('name', Session::get('applocale'))}}</option>
        @endforeach
      </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.cars.manufacture_year')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
        <input type="text" class="form-control" name="manufacture_year" value="@if ($client_car) {!! $client_car->manufacture_year !!} @endif" />
    </div>
</div> 

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.status.status')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
      <select class="form-control chosen-rtl" name="status" required>
        <option value="1" {{$client_car && $client_car->status==1 ? 'selected' : '' }}>@lang('messages.status.under_review')</option>
        <option value="2" {{$client_car && $client_car->status==2 ? 'selected' : '' }}>@lang('messages.status.approved')</option>
        <option value="0" {{$client_car && $client_car->status==0 ? 'selected' : '' }}>@lang('messages.status.rejected')</option>
      </select>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
        {!! Form::submit($buttonAction,['class'=>'btn btn-primary']) !!}
    </div>
</div>
