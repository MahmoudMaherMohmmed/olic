@extends('template')
@section('page_title')
    @lang('messages.oils.oils')
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">

                <div class="col-md-12">
                    <div class="box box-black">
                        <div class="box-title">
                            <h3><i class="fa fa-table"></i> @lang('messages.oils.oils')</h3>
                        </div>
                        <div class="box-content">
                            <div class="btn-toolbar pull-right">
                                <div class="btn-group">
                                    @if (get_action_icons('oil/create', 'get'))
                                        <a class="btn btn-circle show-tooltip" title=""
                                            href="{{ url('oil/create') }}" data-original-title="Add new record"><i
                                                class="fa fa-plus"></i></a>
                                    @endif
                                    <?php $table_name = 'oils';
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
                                            <th>@lang('messages.name')</th>
                                            <th>@lang('messages.oils.oil_type')</th>
                                            <th>@lang('messages.oils.oil_brand')</th>
                                            <th>@lang('messages.oils.price')</th>
                                            <th>@lang('messages.oils.quantity')</th>
                                            <th>@lang('messages.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($oils as $value)
                                            <tr>
                                                <td><input type="checkbox" name="selected_rows[]" value="{{ $value->id }}" class="roles select_all_template">
                                                </td>
                                                <td>{{ $value->id }}</td>
                                                <td>
                                                    @foreach ($languages as $language)
                                                        <li> <b>{{ $language->title }} :</b>
                                                            {{ $value->getTranslation('name', $language->short_code) }}</li>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    {{ $value->type!=null ? $value->type->getTranslation('name', Session::get('applocale')) : '---'}}  
                                                </td>
                                                <td>
                                                    {{ $value->brand!=null ? $value->brand->getTranslation('name', Session::get('applocale')) : '---'}}  
                                                </td>
                                                <td> {{ $value->price}} </td>
                                                <td> {{ $value->quantity}} </td>
                                                <td class="visible-md visible-xs visible-sm visible-lg">
                                                    <div class="btn-group">
                                                        @if (get_action_icons('oil/{id}/edit', 'get'))
                                                            <a class="btn btn-sm show-tooltip"
                                                                href='{{ url("oil/$value->id/edit") }}'
                                                                title="Edit"><i class="fa fa-edit"></i></a>
                                                        @endif
                                                        @if (get_action_icons('oil/{id}/delete', 'get'))
                                                            <form action="{{ route('oil.destroy', $value->id) }}"
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
        $('#oil').addClass('active');
        $('#oils').addClass('active');
    </script>
@stop
