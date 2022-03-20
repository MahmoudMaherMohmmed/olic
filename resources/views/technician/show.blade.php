@extends('template')
@section('page_title')
    @lang('messages.technicians.technician_details')
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">

                <div class="col-md-12">
                    <div class="box box-black">
                        <div class="box-title">
                            <h3><i class="fa fa-table"></i> @lang('messages.technicians.technician_details')</h3>
                        </div>
                        <div class="box-content">
                            <div class="table-responsive">
                                <table class="table table-striped dt-responsive" cellspacing="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td> @lang('messages.name') </td>
                                            <td> {{ $technician->name }} </td>
                                        </tr>
                                        <tr>
                                            <td> @lang('messages.users.email') </td>
                                            <td> {{ $technician->email }} </td>
                                        </tr>
                                        <tr>
                                            <td> @lang('messages.users.technician_phone') </td>
                                            <td> {{  $technician->phone }}  </td>
                                        </tr>
                                        <tr>
                                            <td> @lang('messages.users.technician_phone_2') </td>
                                            <td> {{ $technician->phone_2 }} </td>
                                        </tr>
                                        <tr>
                                            <td> @lang('messages.Image.Image') </td>
                                            <td> <img style="width: 50%;" src="{{url($technician->image)}}" alt="{{ $technician->name }}" /> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@stop

@section('script')
    <script>
        $('#technician').addClass('active');
	    $('#technician_index').addClass('active');
    </script>
@stop
