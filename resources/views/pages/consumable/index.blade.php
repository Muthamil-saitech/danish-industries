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
                <input type="hidden" class="datatable_name" data-title="{{ isset($title) && $title ? $title : '' }}"
                    data-id_name="datatable">
            </div>
            <div class="col-md-6 text-end">
                <h5 class="mb-0">Total Consumables: {{ $total_consumables }} </h5>
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
                            <th class="ir_w_1"> @lang('index.sn')</th>
                            <th class="ir_w_16">@lang('index.ppcrc_no')</th>
                            <th class="ir_w_16">@lang('index.part_no')</th>
                            <th class="ir_w_16">@lang('index.part_name') </th>
                            <th class="ir_w_16">@lang('index.po_no')</th>
                            <th class="ir_w_16">@lang('index.customer_name')<br>(@lang('index.code'))</th>
                            <th class="ir_w_16">@lang('index.start_date')</th>
                            <th class="ir_w_16">@lang('index.delivery_date')</th>
                            <th class="ir_w_1 ir_txt_center">@lang('index.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($manufactures && !empty($manufactures))
                        @foreach ($manufactures as $value)
                        @php $prodInfo = getFinishedProductInfo($value->product_id); @endphp
                        <tr>
                            <td class="ir_txt_center">{{ $loop->iteration }}</td>
                            <td>{{ $value->reference_no }}</td>
                            <td>{{ $prodInfo->code }}</td>
                            <td>{{ $prodInfo->name }}</td>
                            <td>{{ getPoNo($value->customer_order_id).'/'.getLineItemNo($value->customer_order_id) }}</td>
                            <td>{{ getCustomerNameById($value->customer_id).' ('.getCustomerCodeById($value->customer_id).')' }}</td>
                            <td>{{ getDateFormat($value->start_date) }}</td>
                            <td>{{ $value->complete_date!='' ? getDateFormat($value->complete_date) : ' - ' }}</td>
                            <td>
                                <a href="{{ url('consumable') }}/{{ encrypt_decrypt($value->id, 'encrypt') }}"
                                    class="button-info" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="@lang('index.view_details')">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ url('consumable') }}/{{ encrypt_decrypt($value->id, 'encrypt') }}/edit" class="button-success" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.edit')"><i class="fa fa-edit tiny-icon"></i></a>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
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
@endsection