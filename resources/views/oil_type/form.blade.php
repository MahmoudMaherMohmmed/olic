@extends('template')
@section('page_title')
@lang('messages.oils.create_oil_type')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.oils.create_oil_type') </h3>
                </div>
                <div class="box-content">
                    @if($oil_type)
                    {!! Form::model($oil_type,["url"=>"oil_type/$oil_type->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('oil_type.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"oil_type","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('oil_type.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </div>

@stop
@section('script')
    <script>
        $('#oil').addClass('active');
        $('#oil_type').addClass('active');
    </script>
@stop
