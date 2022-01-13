@extends('template')
@section('page_title')
@lang('messages.cars.create_car_brand')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.cars.create_car_brand') </h3>
                </div>
                <div class="box-content">
                    @if($car_brand)
                    {!! Form::model($car_brand,["url"=>"car_brand/$car_brand->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('car_brand.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"car_brand","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('car_brand.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </div>

@stop
@section('script')
    <script>
        $('#service').addClass('active');
        $('#main_service').addClass('active');
    </script>
@stop
