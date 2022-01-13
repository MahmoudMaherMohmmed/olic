@extends('template')
@section('page_title')
@lang('messages.services.create_additional_service')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.services.create_additional_service') </h3>
                </div>
                <div class="box-content">
                    @if($additional_service)
                    {!! Form::model($additional_service,["url"=>"additional_service/$additional_service->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('additional_service.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"additional_service","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('additional_service.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
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
        $('#additional_service').addClass('active');
    </script>
@stop
