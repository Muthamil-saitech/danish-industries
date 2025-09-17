@extends('layouts.app')
@section('script_top')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <?php
    $setting = getSettingsInfo();
    $tax_setting = getTaxInfo();
    $baseURL = getBaseURL();
    ?>
@endsection
@push('styles')
    <link rel="stylesheet" href="{!! $baseURL . 'assets/bower_components/gantt/css/style.css' !!}">
    <link rel="stylesheet" href="{{ getBaseURL() }}frequent_changing/css/pdf_common.css">
@endpush
@section('content')
    <!-- Optional theme -->
    <input type="hidden" id="edit_mode" value="{{ isset($obj) && $obj ? $obj->id : null }}">
    <section class="main-content-wrapper">
        @include('utilities.messages')
        <section class="content-header">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="top-left-header">{{ isset($title) && $title ? $title : '' }}</h2>
                </div>
                <div class="col-md-6 text-end">
                    <a class="btn bg-second-btn" href="{{ route('material_stocks.index') }}"><iconify-icon icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="col-md-12">
                <div class="card" id="dash_0">
                    <div class="card-body p30">
                        <div class="m-auto b-r-5">
                            <h6 class="text-muted mb-2"><strong>@lang('index.opening_stock')</strong></h6>
                            <div class="row">
                                <div class="col-md-12">
                                    @if(isset($material_stock) && $material_stock && isset($material) && $material)
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead class="b-r-3 bg-color-000000">
                                                <tr>
                                                    <th class="w-50 text-start">@lang('index.raw_material_name')<br>(@lang('index.code'))</th>
                                                    <th class="w-20 text-start">Heat No</th>
                                                    <th class="w-30 text-start">@lang('index.challan_no')<br>(DC Date)</th>
                                                    <th class="w-30 text-start">@lang('index.doc_no')</th>
                                                    <th class="w-20 text-start">@lang('index.stock_type')</th>
                                                    <th class="w-20 text-start">@lang('index.po_no')</th>
                                                    <th class="w-20 text-start">@lang('index.stock')</th>
                                                    <th class="w-20 text-start">@lang('index.alter_level')</th>
                                                    <th class="w-20 text-start">@lang('index.floating_stock')</th>
                                                    <th class="w-20 text-start">@lang('index.mat_price')</th>
                                                    <th class="w-30 text-start">@lang('index.hsn_no')</th>
                                                    <th class="w-30 text-start">@lang('index.created_on')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="rowCount">
                                                    <td class="text-start">{{ $material->name }}<br>({{ $material->code }})</td>
                                                    @if($material_stock->dc_no!='')
                                                        <td class="text-start" title="{{ $material_stock->heat_no }}">{{ substr_text($material_stock->heat_no,30) }}</td>
                                                        <td class="text-start">{{ $material_stock->dc_no }}<br>({{ date('d-m-Y',strtotime($material_stock->dc_date)) }})</td>
                                                        <td class="text-start">{{ $material_stock->mat_doc_no }}</td>
                                                    @else
                                                        <td class="text-start"> - </td>
                                                        <td class="text-start"> - </td>
                                                        <td class="text-start"> - </td>
                                                    @endif
                                                    <td class="text-start">{!! $material_stock->stock_type == 'customer'
                                                    ? $material_stock->stock_type . '<br><small>(' . getCustomerNameById($material_stock->customer_id) . ')</small>'
                                                    : $material_stock->stock_type. '<br><small>(' . getSupplierNameCode($material_stock->supplier_id) . ')</small>' !!}</td>
                                                    <td class="text-start">{{$material_stock->line_item_no!='' ? $material_stock->reference_no.'/'.$material_stock->line_item_no : $material_stock->reference_no }}</td>
                                                    <td class="text-start">{{ $material_stock->current_stock }} {{ getRMUnitById($material_stock->unit_id) }}</td>
                                                    <td class="text-start">{{ $material_stock->close_qty }} {{ getRMUnitById($material_stock->unit_id) }}</td>
                                                    <td class="text-start">{{ $material_stock->float_stock }} {{ getRMUnitById($material_stock->unit_id) }}</td>
                                                    <td class="text-start">{{ $material_stock->material_price!='0' ? '₹'.$material_stock->material_price : '' }}</td>
                                                    <td class="text-start">{{ $material_stock->hsn_no }}</td>
                                                    <td class="text-start padding-0">{{ getDateFormat($material_stock->created_at) }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <h6 class="text-muted mb-2 mt-2"><strong>{{ $title }}</strong></h6>
                            <table class="w-100 mt-10">
                                <thead class="b-r-3 bg-color-000000">
                                    <tr>
                                        <th class="w-5 text-start">@lang('index.sn')</th>
                                        {{-- <th class="w-15 text-start">@lang('index.adj_type')</th> --}}
                                        <th class="w-15 text-start">Heat No</th>
                                        <th class="w-15 text-start">@lang('index.challan_no')<br>(DC Date)</th>
                                        <th class="w-15 text-start">@lang('index.doc_no')</th>
                                        <th class="w-15 text-start">@lang('index.stock_type')</th>
                                        <th class="w-15 text-start">@lang('index.po_no')</th>
                                        <th class="w-15 text-start">@lang('index.quantity')</th>
                                        <th class="w-15 text-start">@lang('index.mat_price')</th>
                                        <th class="w-30 text-start">@lang('index.hsn_no')</th>
                                        <th class="w-30 text-start">@lang('index.created_on')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($stock_adjustments) && count($stock_adjustments) > 0)
                                        <?php
                                        $i = 1;
                                        ?>
                                        @foreach ($stock_adjustments as $key => $value)
                                            <tr class="rowCount">
                                                <td class="width_1_p">
                                                    <p class="set_sn">{{ $i++ }}</p>
                                                </td>
                                                {{-- <td class="text-start">{{ $value->type }}</td> --}}
                                                @if($value->dc_no!='')
                                                    <td class="text-start" title="{{ $value->heat_no }}">{{ substr_text($value->heat_no,30) }}</td>
                                                    <td class="text-start">{{ $value->dc_no }}<br>({{ date('d-m-Y',strtotime($value->dc_date)) }})</td>
                                                    <td class="text-start">{{ $value->mat_doc_no }}</td>
                                                @else
                                                    <td class="text-start"> - </td>
                                                    <td class="text-start"> - </td>
                                                    <td class="text-start"> - </td>
                                                @endif
                                                <td class="text-start">{!! $value->stock_type == 'customer' ? $value->stock_type . '<br><small>(' . getCustomerNameById ($material_stock->customer_id) . ')</small>' : $value->stock_type. '<br><small>(' . getSupplierNameCode($material_stock->supplier_id) . ')</small>' !!}</td>
                                                <td class="text-start">{{ $value->line_item_no!='' ? $value->reference_no.'/'.$value->line_item_no : $value->reference_no }}</td>
                                                <td class="text-start">{{ $value->quantity }} {{ isset($material_stock) ?  getRMUnitById($material_stock->unit_id) : "" }}</td>
                                                <td class="text-start">{{ $value->material_price!='0' ? '₹'.$value->material_price : '' }}</td>
                                                <td class="text-start">{{ $value->hsn_no }}</td>
                                                <td class="text-start padding-0">{{ getDateFormat($value->created_at) }}   <i class="fa fa-circle-question" title="{{ notificationDateFormat($value->created_at) }}"></i>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td colspan="9" class="text-center">No data found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
@section('script')
    <script type="text/javascript" src="{!! $baseURL . 'assets/bower_components/gantt/js/jquery.fn.gantt.js' !!}"></script>
    <script type="text/javascript" src="{!! $baseURL . 'assets/bower_components/gantt/js/jquery.cookie.min.js' !!}"></script>
@endsection