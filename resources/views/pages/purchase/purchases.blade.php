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
                <input type="hidden" class="datatable_name" data-filter="yes" data-title="{{ isset($title) && $title ? $title : '' }}"
                    data-id_name="datatable">
            </div>
            <div class="col-md-6 text-end">
                <h5 class="mb-0">Total Supplier Purchases: {{ $total_supplier_purchase }} </h5>
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
                            <th class="width_1_p">@lang('index.sn')</th>
                            <th class="width_10_p">@lang('index.purchase_no')</th>
                            <th class="width_10_p">@lang('index.purchase_date')</th>
                            <th class="width_10_p">@lang('index.supplier_name')</th>
                            <th class="width_10_p">@lang('index.g_total')</th>
                            <th class="width_10_p">@lang('index.paid')</th>
                            <th class="width_10_p">@lang('index.due')</th>
                            <th class="width_10_p">@lang('index.status')</th>
                            <th class="width_10_p">@lang('index.added_by')</th>
                            <th class="width_3_p">@lang('index.actions')</th>
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
                            <td class="c_center">{{ $i++ }}</td>
                            <td>{{ $value->reference_no }}</td>
                            <td>{{ getDateFormat($value->date) }}</td>
                            <td>{{ getSupplierName($value->supplier) }}</td>
                            <td>{{ getCurrency($value->grand_total) }}</td>
                            <td>{{ getCurrency($value->paid) }}</td>
                            <td>{{ getCurrency($value->due) }}</td>
                            <td>
                                <select name="status" class="form-control select2 purchase-status" data-id="{{ $value->id }}" {{ in_array($value->status, ["Completed"]) ? 'disabled' : '' }} style="width: 200px;">
                                    <option value="Draft" {{ $value->status == "Draft" ? 'selected' : '' }}>Draft</option>
                                    <option value="Completed" {{ $value->status == "Completed" ? 'selected' : '' }}>Completed</option>
                                </select>
                                <div class="purchase-status-msg"></div>
                            </td>
                            <td>{{ getUserName($value->added_by) }}</td>
                            <td class="text-start">
                                <a href="{{ url('rawmaterialpurchases') }}/{{ encrypt_decrypt($value->id, 'encrypt') }}" class="button-info" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.view_details')"><i class="fa fa-eye tiny-icon"></i></a>
                                @if($value->status=="Draft")
                                <a href="{{ url('rawmaterialpurchases') }}/{{ encrypt_decrypt($value->id, 'encrypt') }}/edit"
                                    class="button-success" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="@lang('index.edit')"><i class="fa fa-edit"></i></a>
                                @endif
                                @if($value->status=="Draft")
                                <a href="#" class="delete button-danger"
                                    data-form_class="alertDelete{{ $value->id }}" type="submit"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.delete')">
                                    <form action="{{ route('rawmaterialpurchases.destroy', $value->id) }}"
                                        class="alertDelete{{ $value->id }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <i class="c_padding_13 fa fa-trash tiny-icon"></i>
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
    <div class="modal fade" id="filterModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('index.purchase')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::model('', [
                    'id' => 'add_form',
                    'method' => 'GET',
                    'enctype' => 'multipart/form-data',
                    'route' => ['rawmaterialpurchases.index'],
                    ]) !!}
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                {!! Form::text('startDate', (isset($startDate)&&$startDate!='') ? date('d-m-Y',strtotime($startDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"Start Date", 'id' => 'pur_start_date']) !!}
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                {!! Form::text('endDate', (isset($endDate)&&$endDate!='') ? date('d-m-Y',strtotime($endDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"End Date", 'id' => 'pur_complete_date']) !!}
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.suppliers') </label>
                                <select name="supplier_id" id="supplier_id" class="form-control select2">
                                    <option value="">@lang('index.select')</option>
                                    @if(isset($supplier_id))
                                    @foreach ($suppliers as $key => $value)
                                    <option value="{{ $value->id }}"
                                        {{ isset($supplier_id) && $supplier_id == $value->id ? 'selected' : '' }}>
                                        {{ $value->name }} ({{ $value->supplier_id }})
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <button type="submit" name="submit" value="submit" class="btn w-100 bg-blue-btn">@lang('index.submit')</button>
                        </div>
                        <div class="col-md-4 mt-3">
                            <a href="{{ route('rawmaterialpurchases.index') }}" style="text-decoration: none;color:white;"><button type="button" value="reset" class="btn bg-second-btn w-100">Reset</button></a>
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
<script src="{!! $baseURL . 'frequent_changing/js/purchase.js' !!}"></script>
<script>
    function parseDMYtoDate(dmy) {
        const [day, month, year] = dmy.split('-');
        return new Date(`${year}-${month}-${day}`);
    }
    $('#pur_start_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
    }).on('changeDate', function(e) {
        const startDate = e.date;
        $('#pur_complete_date').datepicker('setStartDate', startDate);
        const completeDateVal = $('#pur_complete_date').val();
        if (completeDateVal) {
            const completeDate = parseDMYtoDate(completeDateVal);
            if (completeDate < startDate) {
                $('#pur_complete_date').datepicker('update', startDate);
            }
        }
    });
    $('#pur_complete_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
    }).on('changeDate', function(e) {
        const completeDate = e.date;
        const startDateVal = $('#pur_start_date').val();
        if (startDateVal) {
            const startDate = parseDMYtoDate(startDateVal);
            if (completeDate < startDate) {
                $('#pur_complete_date').datepicker('update', startDate);
            }
        }
    });
    $("#supplier_id").select2({
        dropdownParent: $("#filterModal"),
    });
</script>
@endsection