@extends('template')
@section('page_title')
@lang('messages.cars.create_car_model')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.cars.create_car_model') </h3>
                </div>
                <div class="box-content">
                    @if($car_model)
                    {!! Form::model($car_model,["url"=>"car_model/$car_model->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('car_model.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"car_model","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('car_model.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </div>

@stop
@section('script')
    <script>
        $('#car').addClass('active');
        $('#car_model').addClass('active');
    </script>
@stop
