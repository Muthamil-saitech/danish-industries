@extends('layouts.app')
@section('content')
    <?php
    $baseURL = getBaseURL();
    $setting = getSettingsInfo();
    $base_color = '#6ab04c';
    if (isset($setting->base_color) && $setting->base_color) {
        $base_color = $setting->base_color;
    }
    ?>
    <section class="main-content-wrapper">
        @include('utilities.messages')
        <section class="content-header">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="top-left-header">{{ isset($title) && $title ? $title : '' }}</h2>
                    <input type="hidden" class="datatable_name" data-title="{{ isset($title) && $title ? $title : '' }}"
                        data-id_name="datatable">
                </div>
                <div class="col-md-6 text-end">
                    <h5 class="mb-0">Total Instrument Categories: {{ isset($obj) ? count($obj) : '0' }} </h5>
                </div>
            </div>
        </section>


        <div class="box-wrapper">

            <div class="table-box">
                <!-- /.box-header -->
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped">
                        <thead>
                            <tr>
                            <tr>
                                <th class="w-5 text-start">@lang('index.sn')</th>
                                <th class="w-20">@lang('index.type')</th>
                                <th class="w-20">@lang('index.instrument_category')</th>
                                <th class="w-20">@lang('index.instrument_name')</th>
                                <th class="w-20">@lang('index.instrument_code')</th>
                                <th class="w-20">@lang('index.unit')</th>
                                <th class="w-20">@lang('index.owner')</th>
                                <th class="w-20">@lang('index.customer')</th>
                                <th class="w-20">@lang('index.range/size')</th>
                                <th class="w-20">@lang('index.accuracy')</th>
                                <th class="w-20">@lang('index.make')</th>
                                <th class="w-20">@lang('index.calibration_due')</th>
                                <th class="w-20">@lang('index.remarks')</th>
                                <th class="w-10 ir_txt_center">@lang('index.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($obj && !empty($obj))
                                <?php
                                $i = 1;
                                ?>
                            @endif
                            @foreach ($obj as $value)
                                <tr>
                                    <td class="text-start">{{ $i++ }}</td>
                                    <td>
                                        @if($value->type == 1)
                                        Gauges/Checking Instruments
                                        @elseif($value->type == 2)
                                        Measuring Instruments
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td>{{ getInstrumentCategoryById($value->category) }}</td>
                                    <td>{{ $value->instrument_name }}</td>
                                    <td>{{ $value->code }}</td>
                                    <td>{{ $value->unit }}</td>
                                    <td>{{ $value->owner_type==1 ? 'Own' : 'Customer' }}</td>
                                    <td>{{ getStockCustomerNameById($value->customer_id) }} <br>{{ $value->owner_type!=1 ? '('.getCustomerCodeById($value->customer_id).')' : '' }}</td>
                                    <td>{{ $value->range }}</td>
                                    <td>{{ $value->accuracy }}</td>
                                    <td>{{ $value->make }}</td>
                                    <td>{{ getDateFormat($value->calibration_due) }}</td>
                                    <td title="{{ $value->remarks }}">{{ substr_text(safe($value->remarks),20) }}</td>
                                    <td class="ir_txt_center">
                                        @if (routePermission('instruments.edit'))
                                            <a href="{{ url('instruments') }}/{{ encrypt_decrypt($value->id, 'encrypt') }}/edit"
                                                class="button-success" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="@lang('index.edit')"><i class="fa fa-edit tiny-icon"></i></a>
                                        @endif
                                        @if (routePermission('instruments.delete'))
                                            <a href="#" class="delete button-danger"
                                                data-form_class="alertDelete{{ $value->id }}" type="submit"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.delete')">
                                                <form action="{{ route('instruments.destroy', $value->id) }}"
                                                    class="alertDelete{{ $value->id }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <i class="fa fa-trash tiny-icon"></i>
                                                </form>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="{!! $baseURL . 'assets/datatable_custom/jquery-3.3.1.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/jquery.dataTables.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/dataTables.bootstrap4.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/dataTables.buttons.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/buttons.html5.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/buttons.print.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/jszip.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/pdfmake.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/vfs_fonts.js' !!}"></script>
    <script src="{!! $baseURL . 'frequent_changing/newDesign/js/forTable.js' !!}"></script>
    <script src="{!! $baseURL . 'frequent_changing/js/custom_report.js' !!}"></script>
@endsection
