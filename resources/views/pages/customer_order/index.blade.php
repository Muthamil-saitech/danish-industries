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
                <h5 class="mb-0">Total Customer Orders: {{ $total_orders }}</h5>
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
                            <th class="width_10_p">@lang('index.po_date')</th>
                            <th class="width_10_p">@lang('index.po_no')</th>
                            <th class="width_10_p">@lang('index.order_type')</th>
                            <th class="width_10_p">@lang('index.customer')</th>
                            <th class="width_10_p">@lang('index.product_count')</th>
                            <th class="width_10_p">@lang('index.total_value')</th>
                            {{-- <th class="width_10_p">@lang('index.delivery_date')</th> --}}
                            <th class="width_10_p">@lang('index.status_for_quote')</th>
                            <th class="width_10_p">@lang('index.created_by')</th>
                            <th class="width_3_p">@lang('index.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($obj && !empty($obj))
                        <?php
                        $i = count($obj);
                        ?>
                        @endif
                        @foreach ($obj as $value)
                        <tr>
                            <td>{{ $value->po_date ?  getDateFormat($value->po_date) : '-' }}</td>
                            <td>{{ $value->reference_no }}</td>
                            <td>{{ $value->order_type == "Quotation" ? "Labor" : "Sales" }}</td>
                            <td>{{ $value->customer->name }}<br> ({{ $value->customer->customer_id }})</td>
                            <td>{{ $value->total_product }}</td>
                            <td>{{ getAmtCustom($value->total_amount) }}</td>
                            {{-- <td>{{ getDateFormat($value->delivery_date) }}</td> --}}
                            <td>
                                <select name="order_status" class="form-control select2 order-quote-status" data-order_id="{{ $value->id }}" {{ in_array($value->order_status, [1,2]) ? 'disabled' : '' }}>
                                    <option value="0" {{ $value->order_status == 0 ? 'selected' : '' }}>Pending</option>
                                    <option value="1" {{ $value->order_status == 1 ? 'selected' : '' }}>Confirmed</option>
                                    <option value="2" {{ $value->order_status == 2 ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <div class="status-msg"></div>
                            </td>
                            <td>{{ getUserName($value->created_by) }}</td>
                            <td>
                                @if (routePermission('order.view-details'))
                                <a href="{{ url('customer-orders') }}/{{ encrypt_decrypt($value->id, 'encrypt') }}" class="button-info"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="@lang('index.view_details')"><i class="fa fa-eye tiny-icon"></i></a>
                                @endif
                                @if (routePermission('order.edit') && $value->order_status == 0)
                                <a href="{{ url('customer-orders') }}/{{ encrypt_decrypt($value->id, 'encrypt') }}/edit"
                                    class="button-success" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="@lang('index.edit')"><i class="fa fa-edit tiny-icon"></i></a>
                                @endif
                                {{-- @if (routePermission('order.print-invoice'))
                                            <a href="javascript:void()" class="button-info print_invoice"
                                                data-id="{{ $value->id }}" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="@lang('index.print_invoice')"><i
                                    class="fa fa-print tiny-icon"></i></a>
                                @endif
                                @if (routePermission('order.download-invoice'))
                                <a href="{{ route('customer-order-download', encrypt_decrypt($value->id, 'encrypt')) }}"
                                    class="button-info" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="@lang('index.download_invoice')"><i class="fa fa-download tiny-icon"></i></a>
                                @endif --}}
                                @if (routePermission('order.delete') && $value->order_status == 0)
                                <a href="#" class="delete button-danger"
                                    data-form_class="alertDelete{{ $value->id }}" type="submit"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.delete')">
                                    <form action="{{ route('customer-orders.destroy', $value->id) }}"
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
    <div class="modal fade" id="filterModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('index.customer_order')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::model('', [
                    'id' => 'add_form',
                    'method' => 'GET',
                    'enctype' => 'multipart/form-data',
                    'route' => ['customer-orders.index'],
                    ]) !!}
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                {!! Form::text('startDate', (isset($startDate)&&$startDate!='') ? date('d-m-Y',strtotime($startDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"Start Date", 'id' => 'order_start_date']) !!}
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                {!! Form::text('endDate', (isset($endDate)&&$endDate!='') ? date('d-m-Y',strtotime($endDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"End Date", 'id' => 'order_complete_date']) !!}
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.customer') </label>
                                <select name="customer_id" id="fil_customer_id" class="form-control select2">
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
                            <a href="{{ route('customer-orders.index') }}" style="text-decoration: none;color:white;"><button type="button" value="reset" class="btn bg-second-btn w-100">Reset</button></a>
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