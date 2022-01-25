@extends('template')
@section('page_title')
@lang('messages.suppliers.suppliers')
@stop
@section('content')
@include('errors')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i>@lang('messages.suppliers.create_supplier')</h3>
            </div>
            <div class="box-content">
                <form class="form-horizontal" action="{{url('supplier')}}" method="post" enctype="multipart/form-data">
                    @include('supplier.form')
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script>
    $('#supplier').addClass('active');
    $('#supplier-index').addClass('active');
</script>
@stop
