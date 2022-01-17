@extends('template')
@section('page_title')
@lang('messages.oils.create_oil')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.oils.create_oil') </h3>
                </div>
                <div class="box-content">
                    @if($oil)
                    {!! Form::model($oil,["url"=>"oil/$oil->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('oil.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"oil","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('oil.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
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
        $('#oils').addClass('active');
    </script>
@stop
