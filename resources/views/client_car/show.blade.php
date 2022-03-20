@extends('template')
@section('page_title')
    @lang('messages.cars.client_car_details')
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">

                <div class="col-md-12">
                    <div class="box box-black">
                        <div class="box-title">
                            <h3><i class="fa fa-table"></i> @lang('messages.cars.client_car_details')</h3>
                        </div>
                        <div class="box-content">
                            <div class="table-responsive">
                                <table class="table table-striped dt-responsive" cellspacing="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td> @lang('messages.cars.client') </td>
                                            <td> {{ $client_car->client->first_name .' '. $client_car->client->last_name}} </td>
                                        </tr>
                                        <tr>
                                            <td> @lang('messages.cars.car_brand') </td>
                                            <td> {{ $client_car->model!=null ? $client_car->model->brand->getTranslation('name', Session::get('applocale')) .'-'. $client_car->model->getTranslation('name', Session::get('applocale')) : '---'}} </td>
                                        </tr>
                                        <tr>
                                            <td> @lang('messages.cars.car_cylinders') </td>
                                            <td> {{ $client_car->cylinder!=null ? $client_car->cylinder->getTranslation('name', Session::get('applocale')) : '---'}}  </td>
                                        </tr>
                                        <tr>
                                            <td> @lang('messages.cars.manufacture_year') </td>
                                            <td> {{ $client_car->manufacture_year }} </td>
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
        $('#car').addClass('active');
        $('#client_car').addClass('active');
    </script>
@stop
