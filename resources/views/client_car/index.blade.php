@extends('template')
@section('page_title')
    @lang('messages.cars.client_cars')
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">

                <div class="col-md-12">
                    <div class="box box-black">
                        <div class="box-title">
                            <h3><i class="fa fa-table"></i> @lang('messages.cars.client_cars')</h3>
                        </div>
                        <div class="box-content">
                            <div class="btn-toolbar pull-right">
                                <div class="btn-group">
                                    @if (get_action_icons('client_car/create', 'get'))
                                        <a class="btn btn-circle show-tooltip" title=""
                                            href="{{ url('client_car/create') }}" data-original-title="Add new record"><i
                                                class="fa fa-plus"></i></a>
                                    @endif
                                    <?php $table_name = 'client_cars';
                                    // pass table name to delete all function
                                    // if the current route exists in delete all table flags it will appear in view
                                    // else it'll not appear
                                    ?>
                                </div>
                            </div>
                            <br><br>
                            <div class="table-responsive">
                                <table id="example" class="table table-striped dt-responsive" cellspacing="0" width="100%">

                                    <thead>
                                        <tr>
                                            <th style="width:18px"><input type="checkbox" id="check_all" data-table="{{ $table_name }}"></th>
                                            <th>id</th>
                                            <th>@lang('messages.cars.client')</th>
                                            <th>@lang('messages.cars.car_brand')</th>
                                            <th>@lang('messages.cars.car_cylinders')</th>
                                            <th>@lang('messages.cars.manufacture_year')</th>
                                            <th>@lang('messages.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($client_cars as $value)
                                            <tr>
                                                <td><input type="checkbox" name="selected_rows[]" value="{{ $value->id }}" class="roles select_all_template">
                                                </td>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ $value->client->name }}</td>
                                                <td>
                                                    {{ $value->model!=null ? $value->model->brand->getTranslation('name', Session::get('applocale')) .'-'. $value->model->getTranslation('name', Session::get('applocale')) : '---'}}
                                                </td>
                                                <td>
                                                    {{ $value->cylinder!=null ? $value->cylinder->getTranslation('name', Session::get('applocale')) : '---'}} 
                                                </td>
                                                <td> {{ $value->manufacture_year }} </td>
                                                <td class="visible-md visible-xs visible-sm visible-lg">
                                                    <div class="btn-group">
                                                        @if (get_action_icons('client_car/{id}/edit', 'get'))
                                                            <a class="btn btn-sm show-tooltip"
                                                                href='{{ url("client_car/$value->id/edit") }}'
                                                                title="Edit"><i class="fa fa-edit"></i></a>
                                                        @endif
                                                        @if (get_action_icons('client_car/{id}/delete', 'get'))
                                                            <form action="{{ route('client_car.destroy', $value->id) }}"
                                                                method="POST" style="display: initial;">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                    style="height: 28px;"><i
                                                                        class="fa fa-trash"></i></button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
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
