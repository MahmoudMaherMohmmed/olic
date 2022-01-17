@extends('template')
@section('page_title')
@lang('messages.questions.create_question')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.questions.create_question') </h3>
                </div>
                <div class="box-content">
                    @if($question)
                    {!! Form::model($question,["url"=>"question/$question->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('question.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"question","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('question.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </div>

@stop
@section('script')
    <script>
        $('#questions').addClass('active');
        $('#question_create').addClass('active');
    </script>
@stop
