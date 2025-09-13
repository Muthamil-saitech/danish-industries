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
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="top-left-header">{{ isset($title) && $title ? $title : '' }}</h2>
                <input type="hidden" class="datatable_name" data-filter="yes" data-title="{{ isset($title) && $title ? $title : '' }}" data-id_name="datatable">
            </div>
            <div class="col-md-6 text-end">
                <h5 class="mb-0">Total Partner IO: 2</h5>
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
                            <th>@lang('index.sn')</th>
                            <th>@lang('index.reference_no')</th>
                            <th>@lang('index.customer')</th>
                            <th>@lang('index.date')</th>
                            <th>@lang('index.type')</th>
                            <th>@lang('index.category')</th>
                            <th>@lang('index.instrument_name')(Code)</th>
                            <th>@lang('index.quantity')</th>
                            <th>@lang('index.status')</th>
                            <th>@lang('index.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>P001/1</td>
                            <td>Malini</td>
                            <td>12-09-2025</td>
                            <td>Gauges/Checking Instruments</td>
                            <td>Plug Gauge</td>
                            <td>Material(INS001)</td>
                            <td>5</td>
                            <td>
                                <span class="badge bg-secondary">Inward</span>
                            </td>
                            <td>
                                <a href="#" class="button-warning" data-bs-toggle="modal" data-bs-target="#calendarModal" title="@lang('index.view_calendar')"><i class="fa fa-calendar tiny-icon"></i></a>
                                <a href="{{ url('partner_io/view') }}"
                                    class="button-info" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="@lang('index.view_partner')"><i class="fa fa-eye tiny-icon"></i></a>
                                <a href="{{ url('partner_io/create') }}"
                                    class="button-success" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="@lang('index.edit')"><i class="fa fa-edit tiny-icon"></i></a>
                                <a href="#" class="delete button-danger"
                                    data-form_class="alertDelete1" type="submit"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.delete')">
                                    <form action=""
                                        class="alertDelete1" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <i class="fa fa-trash tiny-icon"></i>
                                    </form>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>P001/2</td>
                            <td>Malini</td>
                            <td>12-09-2025</td>
                            <td>Gauges/Checking Instruments</td>
                            <td>Vernier Caliper</td>
                            <td>Bore Gauge(INS002)</td>
                            <td>5</td>
                            <td>
                                <span class="badge bg-success">Outward</span>
                            </td>
                            <td>
                                 <a href="{{ url('partner_io/view') }}"
                                    class="button-info" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="@lang('index.view_partner')"><i class="fa fa-eye tiny-icon"></i></a>
                                <a href="{{ url('partner_io/create') }}"
                                    class="button-success" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="@lang('index.edit')"><i class="fa fa-edit tiny-icon"></i></a>
                                <a href="#" class="delete button-danger"
                                    data-form_class="alertDelete1" type="submit"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.delete')">
                                    <form action=""
                                        class="alertDelete1" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <i class="fa fa-trash tiny-icon"></i>
                                    </form>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>

    </div>
    <div class="modal fade" id="calendarModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('index.calendar')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::model('', [
                    'id' => 'add_form',
                    'method' => 'GET',
                    'enctype' => 'multipart/form-data',
                    ]) !!}
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label>@lang('index.date') <span class="required_star">*</span></label>
                                {!! Form::text('po_date', old('po_date', date('d-m-Y')), [
                                'class' => 'form-control',
                                'id' => 'date',
                                'placeholder' => 'Date',
                                ]) !!}
                                @if ($errors->has('date'))
                                <div class="error_alert text-danger">
                                    {{ $errors->first('date') }}
                                </div>
                                @endif
                                <div class="text-danger d-none"></div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label>@lang('index.notes') </label>
                                <textarea name="notes" class="form-control" placeholder="@lang('index.notes')"></textarea>
                                @if ($errors->has('notes'))
                                <div class="error_alert text-danger">
                                    {{ $errors->first('notes') }}
                                </div>
                                @endif
                                <div class="text-danger d-none"></div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <button type="submit" name="submit" value="submit"
                                class="btn w-100 bg-blue-btn">@lang('index.submit')</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
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
<script src="{!! $baseURL . 'frequent_changing/js/order.js' !!}"></script>
<script>
    $("#fil_customer_id").select2({
        dropdownParent: $("#filterModal"),
    });
</script>
@endsection