@extends('template')
@section('page_title')
@lang('messages.cars.create_client_car')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.cars.create_client_car') </h3>
                </div>
                <div class="box-content">
                    @if($client_car)
                    {!! Form::model($client_car,["url"=>"client_car/$client_car->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('client_car.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"client_car","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('client_car.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
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
        $('#client_car').addClass('active');
    </script>
@stop
