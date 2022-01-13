@extends('template')
@section('page_title')
@lang('messages.cars.create_car_cylinder')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.cars.create_car_cylinder') </h3>
                </div>
                <div class="box-content">
                    @if($car_cylinder)
                    {!! Form::model($car_cylinder,["url"=>"car_cylinder/$car_cylinder->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('car_cylinder.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"car_cylinder","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('car_cylinder.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
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
        $('#car_cylinder').addClass('active');
    </script>
@stop
