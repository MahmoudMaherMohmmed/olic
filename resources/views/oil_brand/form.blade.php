@extends('template')
@section('page_title')
@lang('messages.oils.create_oil_brand')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.oils.create_oil_brand') </h3>
                </div>
                <div class="box-content">
                    @if($oil_brand)
                    {!! Form::model($oil_brand,["url"=>"oil_brand/$oil_brand->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('oil_brand.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"oil_brand","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('oil_brand.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
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
        $('#oil_brand').addClass('active');
    </script>
@stop
