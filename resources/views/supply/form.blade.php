@extends('template')
@section('page_title')
@lang('messages.supplies.create_supply')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.supplies.create_supply') </h3>
                </div>
                <div class="box-content">
                    @if($supply)
                    {!! Form::model($supply,["url"=>"supply/$supply->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('supply.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"supply","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('supply.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </div>

@stop
@section('script')
    <script>
        $('#supplier').addClass('active');
        $('#supplier-supplies').addClass('active');
    </script>
@stop
