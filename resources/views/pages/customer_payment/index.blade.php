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
                <input type="hidden" class="datatable_name" data-filter="yes" data-title="{{ isset($title) && $title ? $title : '' }}" data-id_name="datatable">
            </div>
            <div class="col-md-6 text-end">
                <h5 class="mb-0">Total Customer Receives: {{ isset($obj) ? count($obj) : '0' }} </h5>
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
                            <th class="width_1_p">@lang('index.sn')</th>
                            <th class="width_10_p">@lang('index.po_no')</th>
                            <th class="width_10_p">@lang('index.po_date')</th>
                            <th class="width_10_p">@lang('index.customer')<br>(Code)</th>
                            <th class="width_10_p">@lang('index.total_amount')</th>
                            <th class="width_10_p">@lang('index.paid_amount')</th>
                            <th class="width_10_p">@lang('index.due_amount')</th>
                            <th class="width_10_p">@lang('index.payment_status')</th>
                            <th class="width_3_p ir_txt_center">@lang('index.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($obj && !empty($obj))
                        <?php
                        $i = 1;
                        ?>
                        @endif
                        @foreach ($obj as $key => $value)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $value->reference_no }}</td>
                            <td>{{ $value->po_date ? getDateFormat($value->po_date) : '-' }}</td>
                            <td>{{ getCustomerNameById($value->customer_id) }}<br><small>{{ '('.getCustomerCodeById($value->customer_id).')' }}</small></td>
                            <td>{{ getAmtCustom($value->orderInvoice->amount) }}</td>
                            <td>{{ getAmtCustom($value->orderInvoice->paid_amount) }}</td>
                            <td>{{ getAmtCustom($value->orderInvoice->due_amount) }}</td>
                            <td>
                                <h6>@if($value->orderInvoice->due_amount==0.00) <span class="badge bg-success">Paid</span> @elseif($value->orderInvoice->paid_amount==0.00) <span class="badge bg-danger">Unpaid</span> @else <span class="badge bg-info">Partially Paid</span>@endif</h6>
                            </td>
                            <td class="text-end">
                                @if($value->orderInvoice->due_amount!=0.00)
                                <a class="button-success" id="customerDueModal" data-bs-toggle="modal" data-order_id="{{ $value->id }}" data-tot_amount="{{ $value->orderInvoice->amount }}" data-paid_amount="{{ $value->orderInvoice->paid_amount }}" data-due_amount="{{ $value->orderInvoice->due_amount }}" data-bs-target="#customerDue" data-bs-toggle="tooltip" data-bs-placement="top" title="Due Entry"><i class="fa fa-money-bill"></i></a>
                                @endif
                                <a href="{{ route('customer-payment-view', encrypt_decrypt($value->id, 'encrypt')) }}" class="button-info" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.view_details')"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="customerDue" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Customer Receive Entry</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <form id="customer_due_form" action="{{ route('customer-due-entry') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 mb-2">
                                <div class="form-group">
                                    <label class="control-label">@lang('index.total_amount')</label>
                                    <input type="hidden" class="form-control" name="order_id" id="order_id">
                                    <input type="text" class="form-control @error('total_amount') is-invalid @enderror" name="total_amount" id="total_amount" placeholder="@lang('index.total_amount')" readonly>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 mb-2">
                                <div class="form-group">
                                    <label class="control-label">@lang('index.balance_amount')</label>
                                    <input type="number" class="form-control @error('balance_amount') is-invalid @enderror" name="balance_amount" id="balance_amount" placeholder="@lang('index.balance_amount')" min="1" readonly>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 mb-2">
                                <div class="form-group">
                                    <label class="control-label">@lang('index.amt_to_pay') <span class="ir_color_red">*</span></label>
                                    <input type="number" class="form-control @error('pay_amount') is-invalid @enderror" name="pay_amount" id="pay_amount" placeholder="@lang('index.amt_to_pay')" min="1">
                                    <p class="text-danger" id="paid_amt_err"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <div class="form-group mt-1">
                                    <label class="control-label">@lang('index.payment_type') <span class="ir_color_red">*</span></label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="payment_type" id="payment_cash" value="Cash">
                                        <label class="form-check-label" for="payment_cash">Cash</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="payment_type" id="payment_upi" value="UPI">
                                        <label class="form-check-label" for="payment_upi">UPI</label>
                                    </div>
                                    <p class="text-danger" id="pay_type_err"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="control-label">@lang('index.payment_img') (@lang('index.max_size_1_mb'))</label>
                                    <input type="file" class="form-control" name="payment_img" id="payment_img" accept=".jpg,.jpeg,.png">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 mb-2">
                                <div class="form-group">
                                    <label class="control-label">@lang('index.note')</label>
                                    <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror" placeholder="Note" maxlength="100"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-blue-btn customer_due_submit"><iconify-icon icon="solar:check-circle-broken"></iconify-icon> @lang('index.submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="filterModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('index.customer_due_receives')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::model('', [
                    'id' => 'add_form',
                    'method' => 'GET',
                    'enctype' => 'multipart/form-data',
                    'route' => ['customer-payment.index'],
                    ]) !!}
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                {!! Form::text('startDate', (isset($startDate)&&$startDate!='') ? date('d-m-Y',strtotime($startDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"Start Date", 'id' => 'cr_start_date']) !!}
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                {!! Form::text('endDate', (isset($endDate)&&$endDate!='') ? date('d-m-Y',strtotime($endDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"End Date", 'id' => 'cr_complete_date']) !!}
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.customer') </label>
                                <select name="customer_id" id="customer_id" class="form-control select2">
                                    <option value="">@lang('index.select')</option>
                                    @if(isset($customer_id))
                                    @foreach ($customers as $key => $value)
                                    <option value="{{ $value->id }}"
                                        {{ isset($customer_id) && $customer_id == $value->id ? 'selected' : '' }}>
                                        {{ $value->name }} ({{ $value->customer_id }})
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <button type="submit" name="submit" value="submit"
                                class="btn w-100 bg-blue-btn">@lang('index.submit')</button>
                        </div>
                        <div class="col-md-4 mt-3">
                            <a href="{{ route('customer-payment.index') }}" style="text-decoration: none;color:white;"><button type="button" value="reset" class="btn bg-second-btn w-100">Reset</button></a>
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
<script>
    $(document).on("click", "#customerDueModal", function(e) {
        e.preventDefault();
        var order_id = $(this).data('order_id');
        $('#order_id').val(order_id);
        var tot_amount = $(this).data('tot_amount');
        $('#total_amount').val(tot_amount);
        var due_amount = $(this).data('due_amount');
        $('#balance_amount').val(due_amount);
    });
    $(document).on('change', "#payment_img", function() {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        const file = this.files[0];
        $('#payment_img_err').remove();
        if (file && !allowedTypes.includes(file.type)) {
            $(this).after('<small id="payment_img_err" class="text-danger">Only JPG, JPEG, or PNG files are allowed.</small>');
            $(this).val('');
        }
        if (file && file.size > 1048576) {
            $(this).after('<small id="payment_img_err" class="text-danger">Maximum allowed file size is 1MB.</small>');
            $(this).val('');
        }
    });
    $('.customer_due_submit').on('click', function(e) {
        e.preventDefault();
        $('#paid_amt_err, #pay_type_err').text('');
        let payAmount = $('#pay_amount').val().trim();
        let balAmount = $('#balance_amount').val().trim();
        let isValid = true;
        if (!payAmount) {
            $('#paid_amt_err').text('Amount to Pay is Required.');
            isValid = false;
        } else if (parseFloat(payAmount) > parseFloat(balAmount)) {
            $('#paid_amt_err').text('Amount to Pay cannot exceed Balance Amount.');
            isValid = false;
        }
        if (!$('input[name="payment_type"]:checked').val()) {
            $('#pay_type_err').text('Payment type is Required.');
            isValid = false;
        }
        if (!isValid) {
            return;
        }
        $("#customer_due_form").submit();
    });

    function parseDMYtoDate(dmy) {
        const [day, month, year] = dmy.split('-');
        return new Date(`${year}-${month}-${day}`);
    }
    $('#cr_start_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
    }).on('changeDate', function(e) {
        const startDate = e.date;
        $('#cr_complete_date').datepicker('setStartDate', startDate);
        const completeDateVal = $('#cr_complete_date').val();
        if (completeDateVal) {
            const completeDate = parseDMYtoDate(completeDateVal);
            if (completeDate < startDate) {
                $('#cr_complete_date').datepicker('update', startDate);
            }
        }
    });
    $('#cr_complete_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
    }).on('changeDate', function(e) {
        const completeDate = e.date;
        const startDateVal = $('#cr_start_date').val();
        if (startDateVal) {
            const startDate = parseDMYtoDate(startDateVal);
            if (completeDate < startDate) {
                $('#cr_complete_date').datepicker('update', startDate);
            }
        }
    });
    $("#customer_id").select2({
        dropdownParent: $("#filterModal"),
    });
</script>
@endsection