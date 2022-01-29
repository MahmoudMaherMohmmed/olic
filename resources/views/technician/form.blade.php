@extends('template')
@section('page_title')
@lang('messages.technicians.create_technician')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.technicians.create_technician') </h3>
                </div>
                <div class="box-content">
                    @if($technician)
                    {!! Form::model($technician,["url"=>"technician/$technician->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('technician.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"technician","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('technician.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </div>

@stop
@section('script')
    <script>
        $('#technician').addClass('active');
        $('#technician_create').addClass('active');
    </script>
@stop
