@extends('template')
@section('page_title')
    @lang('messages.reservations.reservations')
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">

                <div class="col-md-12">
                    <div class="box box-black">
                        <div class="box-title">
                            <h3><i class="fa fa-table"></i> @lang('messages.reservations.reservations')</h3>
                        </div>
                        <div class="box-content">
                            <div class="btn-toolbar pull-right">
                                <div class="btn-group">
                                    <!-- @if (get_action_icons('reservation/create', 'get'))
                                        <a class="btn btn-circle show-tooltip" title=""
                                            href="{{ url('reservation/create') }}" data-original-title="Add new record"><i
                                                class="fa fa-plus"></i></a>
                                    @endif -->
                                    <?php $table_name = 'reservations';
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
                                            <th>@lang('messages.reservations.client_name')</th>
                                            <th>@lang('messages.reservations.client_car')</th>
                                            <th>@lang('messages.reservations.technician_name')</th>
                                            <th>@lang('messages.reservations.date')</th>
                                            <th>@lang('messages.reservations.time')</th>
                                            <th>@lang('messages.reservations.total_price')</th>
                                            <th>@lang('messages.reservations.payment_type')</th>
                                            <th>@lang('messages.reservations.status')</th>
                                            <th>@lang('messages.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reservations as $value)
                                            <tr>
                                                <td><input type="checkbox" name="selected_rows[]" value="{{ $value->id }}" class="roles select_all_template">
                                                </td>
                                                <td>{{ $value->id }}</td>
                                                <td> {{ $value->client->first_name . ' ' . $value->client->first_name}} </td>
                                                <td> 
                                                    @php $car=$value->car @endphp
                                                    <a class="show-tooltip" href='{{ url("client_car/$car->id") }}' title="عرض">
                                                        {{ $value->car->model!=null ? $value->car->model->brand->getTranslation('name', Session::get('applocale')) .'-'. $value->car->model->getTranslation('name', Session::get('applocale')) : '---'}} 
                                                    </a>
                                                </td>
                                                <td> 
                                                    @php $technician=$value->technician @endphp
                                                    <a class="show-tooltip" href='{{ url("technician/$technician->id") }}' title="عرض">
                                                        {{ $technician->name }} 
                                                    </a>
                                                </td>
                                                <td> {{ $value->date }} </td>
                                                <td> {{ $value->from }} </td>
                                                <td> {{ $value->total_price }} </td>
                                                <td> {{ $value->payment_type==1 ? 'تحويل بنكى' : 'كاش' }} </td>
                                                <td>
                                                    @if($value->status==2)
                                                        تم الموافقه عليه
                                                    @elseif($value->status==1)
                                                        قيد المراجعه
                                                    @else
                                                        تم الالغاء
                                                    @endif
                                                </td>
                                                <td class="visible-md visible-xs visible-sm visible-lg">
                                                    <div class="btn-group">
                                                        @if (get_action_icons('reservation/{id}/edit', 'get'))
                                                            <a class="btn btn-sm show-tooltip"
                                                                href='{{ url("reservation/$value->id/edit") }}'
                                                                title="Edit"><i class="fa fa-edit"></i></a>
                                                        @endif
                                                        @if($value->payment_type==1)
                                                            <a class="btn btn-sm btn-success show-tooltip"
                                                                href='{{ url("reservation/$value->id") }}'
                                                                title="View"><i class="fa fa-eye"></i></a>
                                                        @endif
                                                        <!-- <form action="{{ route('reservation.destroy', $value->id) }}"
                                                            method="POST" style="display: initial;">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                style="height: 28px;"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </form> -->
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
        $('#reservation').addClass('active');
        $('#reservation_index').addClass('active');
    </script>
@stop
