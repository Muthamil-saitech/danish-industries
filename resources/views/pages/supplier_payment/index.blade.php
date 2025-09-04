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
                <h5 class="mb-0">Total Supplier Payments: {{ isset($obj) ? count($obj) : '0' }} </h5>
            </div>
        </div>
    </section>
    <div class="box-wrapper">
        <div class="table-box">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped">
                    <thead>
                        <tr>
                        <tr>
                            <th class="width_1_p">@lang('index.sn')</th>
                            <th class="width_1_p">@lang('index.purchase_no')</th>
                            <th class="width_10_p">@lang('index.purchase_date')</th>
                            <th class="width_10_p">@lang('index.supplier_name')<br>(Code)</th>
                            <th class="width_10_p">@lang('index.total_amount')</th>
                            <th class="width_10_p">@lang('index.paid_amount')</th>
                            <th class="width_10_p">@lang('index.due_amount')</th>
                            {{-- <th class="width_10_p">@lang('index.status')</th> --}}
                            <th class="width_10_p">@lang('index.due_days')</th>
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
                        @foreach ($obj as $value)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $value->reference_no }}</td>
                            <td>{{ getDateFormat($value->date) }}</td>
                            <td>{{ getSupplierName($value->supplier) }}</td>
                            <td>{{ getAmtCustom($value->subtotal) }}</td>
                            <td>{{ getAmtCustom($value->paid) }}</td>
                            <td>{{ getAmtCustom($value->due) }}</td>
                            @php
                            $currentDate = \Carbon\Carbon::now();
                            $purchaseDate = \Carbon\Carbon::parse($value->date);
                            $due_days = $purchaseDate->diffInDays($currentDate);
                            @endphp
                            <td>{{ $due_days }} {{ $due_days <= 1 ? 'day' : 'days' }}</td>
                            @php
                            $payments = $value->supplierPayments;
                            $totalPaid = $payments->sum('pay_amount');
                            $totalDue = $payments->sum('pay_amount') - $payments->sum('bal_amount');
                            $isEmpty = $payments->isEmpty();
                            // dd($payments);
                            $paymentPurchaseIds = $payments->pluck('purchase_id')->toArray();
                            $paymentStatus = $payments->pluck('payment_status')->toArray();
                            @endphp
                            <td>
                                @if($value->due!=0 && !in_array($value->id,$paymentPurchaseIds))
                                <select name="status" class="form-control select2 sup-pay-status" data-id="{{ $value->id }}" style="width: 100px;">
                                    <option value="Hold" {{ $totalPaid == 0 ? 'selected' : '' }}>Hold</option>
                                    <option value="Initiated" {{ !$isEmpty ? 'selected' : '' }}>Initiated</option>
                                </select>
                                <div class="sup-pay-status-msg"></div>
                                @elseif($value->paid==0 && in_array($value->id,$paymentPurchaseIds))
                                <h5><span class="badge bg-warning">Initiated</span></h5>
                                @elseif($value->due==0)
                                <h5><span class="badge bg-success">Paid</span></h5>
                                @else
                                <h5><span class="badge bg-info">Partially Paid</span></h5>
                                @endif
                            </td>
                            {{-- <td>
                                        <select name="status" class="form-control select2 sup_pay-status" data-id="{{ $value->id }}" {{ optional($value->supplierPayments)->payment_status === "Paid" ? "disabled" : "" }} style="width: 200px;">
                            <option value="Hold" {{ $value->paid == 0.00 ? 'selected' : '' }}>Hold</option>
                            <option value="Initiated" {{ optional($value->supplierPayments)->payment_status == "Initiated" ? 'selected' : '' }}>Initiated</option>
                            </select>
                            <div class="sup-pay-status-msg"></div>
                            </td>
                            <td>
                                @if(optional($value->supplierPayments)->payment_status == "Initiated")
                            </td> --}}
                            <td class="text-end">
                                @if(!$isEmpty && $totalDue!=0)
                                <a class="button-success" id="supplierDueModal" data-bs-toggle="modal" data-purchase_id="{{ $value->id }}" data-tot_amount="{{ $value->subtotal }}" data-paid_amount="{{ $value->paid }}" data-due_amount="{{ $value->due }}" data-bs-target="#supplierDue" data-bs-toggle="tooltip" data-bs-placement="top" title="Due Entry"><i class="fa fa-money-bill"></i></a>
                                @endif
                                <a href="{{ route('supplier-payment-view', encrypt_decrypt($value->id, 'encrypt')) }}" class="button-info" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.view_details')"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="modal fade" id="supplierDue" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Supplier Payment Entry</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <form id="supplier_pay_form" action="{{ route('supplier-pay-entry') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 mb-2">
                                <div class="form-group">
                                    <label class="control-label">@lang('index.total_amount')</label>
                                    <input type="hidden" class="form-control" name="purchase_id" id="purchase_id">
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
                                    <p class="text-danger" id="paidamt_err"></p>
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
                                    <p class="text-danger" id="paytype_err"></p>
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
                        <button type="button" class="btn bg-blue-btn supplier_pay_submit"><iconify-icon icon="solar:check-circle-broken"></iconify-icon> @lang('index.submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="filterModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('index.supplier_due_payment')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::model('', [
                    'id' => 'add_form',
                    'method' => 'GET',
                    'enctype' => 'multipart/form-data',
                    'route' => ['supplier-payment.index'],
                    ]) !!}
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                {!! Form::text('startDate', (isset($startDate)&&$startDate!='') ? date('d-m-Y',strtotime($startDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"Start Date", 'id' => 'spay_start_date']) !!}
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                {!! Form::text('endDate', (isset($endDate)&&$endDate!='') ? date('d-m-Y',strtotime($endDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"End Date", 'id' => 'spay_complete_date']) !!}
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
                            <a href="{{ route('supplier-payment.index') }}" style="text-decoration: none;color:white;"><button type="button" value="reset" class="btn bg-second-btn w-100">Reset</button></a>
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
    function parseDMYtoDate(dmy) {
        const [day, month, year] = dmy.split('-');
        return new Date(`${year}-${month}-${day}`);
    }
    $('#spay_start_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
    }).on('changeDate', function(e) {
        const startDate = e.date;
        $('#spay_complete_date').datepicker('setStartDate', startDate);
        const completeDateVal = $('#spay_complete_date').val();
        if (completeDateVal) {
            const completeDate = parseDMYtoDate(completeDateVal);
            if (completeDate < startDate) {
                $('#spay_complete_date').datepicker('update', startDate);
            }
        }
    });
    $('#spay_complete_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
    }).on('changeDate', function(e) {
        const completeDate = e.date;
        const startDateVal = $('#spay_start_date').val();
        if (startDateVal) {
            const startDate = parseDMYtoDate(startDateVal);
            if (completeDate < startDate) {
                $('#spay_complete_date').datepicker('update', startDate);
            }
        }
    });
    $("#supplier_id").select2({
        dropdownParent: $("#filterModal"),
    });
    $(document).on("change", ".sup-pay-status", function(e) {
        let $this = $(this);
        let status = $this.val();
        let purchase_id = $this.data("id");
        let $statusMsg = $this.closest('td').find('.sup-pay-status-msg');
        $.ajax({
            type: "POST",
            url: $("#hidden_base_url").val() + "updateSupplierPayStatus",
            data: {
                purchase_id: purchase_id,
                status: status
            },
            dataType: "json",
            success: function(data) {
                $this.prop("disabled", true);
                $statusMsg.html('<span class="text-success">' + data.message + '</span>')
                    .delay(2000)
                    .fadeOut(function() {
                        location.reload();

                    });
            },
            error: function() {
                $statusMsg.html('<span class="text-danger">Something went wrong.</span>')
                    .delay(2000)
                    .fadeOut();
            }
        });
    });
    $(document).on("click", "#supplierDueModal", function(e) {
        e.preventDefault();
        var purchase_id = $(this).data('purchase_id');
        $('#purchase_id').val(purchase_id);
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
    $('.supplier_pay_submit').on('click', function(e) {
        e.preventDefault();
        $('#paidamt_err, #paytype_err').text('');
        let payAmount = $('#pay_amount').val().trim();
        let balAmount = $('#balance_amount').val().trim();
        let isValid = true;
        if (!payAmount) {
            $('#paidamt_err').text('Amount to Pay is Required.');
            isValid = false;
        } else if (parseFloat(payAmount) > parseFloat(balAmount)) {
            $('#paidamt_err').text('Amount to Pay cannot exceed Balance Amount.');
            isValid = false;
        }
        if (!$('input[name="payment_type"]:checked').val()) {
            $('#paytype_err').text('Payment type is Required.');
            isValid = false;
        }
        if (!isValid) {
            return;
        }
        $("#supplier_pay_form").submit();
    });
</script>
@endsection