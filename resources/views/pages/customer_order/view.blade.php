@extends('layouts.app')
@section('script_top')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <?php
    $setting = getSettingsInfo();
    $tax_setting = getTaxInfo();
    $baseURL = getBaseURL();
    ?>
    <link rel="stylesheet" href="{{ getBaseURL() }}frequent_changing/css/pdf_common.css">
@endsection

@section('content')
    <!-- Optional theme -->

    <section class="main-content-wrapper bg-main">
        <section class="content-header">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="top-left-header">{{ isset($title) && $title ? $title : '' }}</h2>
                </div>
                <div class="col-md-6">
                    @if (routePermission('order.print-invoice'))
                        <a href="javascript:void();" target="_blank" class="btn bg-second-btn print_invoice"
                            data-id="{{ $obj->id }}"><iconify-icon icon="solar:printer-broken"></iconify-icon>
                            @lang('index.print')</a>
                    @endif
                    @if (routePermission('order.download-invoice'))
                        <a href="{{ route('customer-order-download', encrypt_decrypt($obj->id, 'encrypt')) }}"
                            target="_blank" class="btn bg-second-btn print_btn"><iconify-icon
                                icon="solar:cloud-download-broken"></iconify-icon>
                            @lang('index.download')</a>
                    @endif
                    @if (routePermission('order.index'))
                        <a class="btn bg-second-btn" href="{{ route('customer-orders.index') }}"><iconify-icon
                                icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
                    @endif
                </div>
            </div>
        </section>

        <section class="content">
            <div class="col-md-12">
                <div class="card" id="dash_0">
                    <div class="card-body p30">
                        <div class="m-auto b-r-5">
                            <table>
                                <tr>
                                    <td class="w-50">
                                        <h3 class="pb-7">{{ getCompanyInfo()->company_name }}</h3>
                                        <p class="pb-7 rgb-71">{{ getCompanyInfo()->address }}</p>
                                        <p class="pb-7 rgb-71">@lang('index.email') : {{ getCompanyInfo()->email }}</p>
                                        <p class="pb-7 rgb-71">@lang('index.phone') : {{ getCompanyInfo()->phone }}</p>
                                        <p class="pb-7 rgb-71">@lang('index.website') : <a href="{{ getCompanyInfo()->website }}" target="_blank">{{ getCompanyInfo()->website }}</a>
                                        </p>
                                    </td>
                                    <td class="w-50 text-right">
                                        <img src="{!! getBaseURL() .
                                            (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png') !!}" alt="site-logo">
                                    </td>
                                </tr>
                            </table>
                            <div class="text-center pt-10 pb-10">
                                <h2 class="color-000000 pt-20 pb-20">@lang('index.order_details')</h2>
                            </div>
                            <table>
                                <tr>
                                    <td class="w-50">
                                        <h4 class="pb-7">@lang('index.customer_info'):</h4>
                                        <p class="pb-7">{{ $obj->customer->name }}</p>
                                        <p class="pb-7 rgb-71">{{ $obj->customer->phone }}</p>
                                        <p class="pb-7 rgb-71">{{ $obj->customer->email }}</p>
                                        <p class="pb-7 rgb-71">{{ $obj->customer->address }}</p>
                                    </td>
                                    <td class="w-50 text-right">
                                        <h4 class="pb-7">@lang('index.order_info'):</h4>
                                        <p class="pb-7">
                                            <span class="">@lang('index.po_no'):</span>
                                            {{ $obj->reference_no }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class="">@lang('index.order_type'):</span>
                                            {{ $obj->order_type=='Quotation' ? 'Labor' : 'Sales' }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class="">@lang('index.delivery_address'):</span>
                                            {{ $obj->delivery_address }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <table class="w-100 mt-20">
                                <thead class="b-r-3 bg-color-000000">
                                    <tr>
                                        <th class="w-5 text-start">@lang('index.sn')</th>
                                        @if($obj->order_type=='Work Order')
                                        <th class="w-20 text-start">@lang('index.delivery_date')</th>
                                        @else
                                        <th class="w-20 text-start">@lang('index.quote_date')</th>
                                        @endif
                                        <th class="w-25 text-start">Part Name<br>(Part No)</th>
                                        <th class="w-25 text-start">@lang('index.raw_material_name')<br>(@lang('index.code'))</th>
                                        {{-- <th class="w-25 text-start">Heat No</th> --}}
                                        <th class="w-15 text-center">@lang('index.raw_quantity')</th>
                                        <th class="w-15 text-center">@lang('index.prod_quantity')</th>
                                        <th class="w-15 text-center">@lang('index.unit_price')</th>
                                        {{-- <th class="w-15 text-center">@lang('index.discount')</th> --}}
                                        {{-- <th class="w-15 text-center">@lang('index.subtotal')</th> --}}
                                        <th class="w-15 text-center">@lang('index.tax')</th>
                                        <th class="w-15 text-center">@lang('index.total')</th>
                                        {{-- <th class="w-10 text-right pr-5">@lang('index.total')</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($orderDetails) && $orderDetails)
                                        @php($i = 1)
                                        @foreach ($orderDetails as $key => $value)
                                            <?php
                                            $productRawInfo = getProductRawMaterialByProductId($value->product_id);
                                            $productInfo = getFinishedProductInfo($value->product_id);
                                            ?>
                                            <tr class="rowCount" data-id="{{ $value->product_id }}">
                                                <td class="width_1_p">
                                                    <p class="set_sn">{{ $i++ }}</p>
                                                </td>
                                                <td class="text-start">{{ $value->delivery_date != null ? getDateFormat($value->delivery_date): getDateFormat($obj->created_at) }}
                                                </td>
                                                <td class="text-start">{{ $productInfo->name }}<br>({{ $productInfo->code }})
                                                </td>
                                                <td class="text-start">{{ getRMName($value->raw_material_id) }}</td>
                                                {{-- <td class="text-start">{{ getheatNo($value->raw_material_id) }}</td> --}}
                                                <td class="text-center">{{ $value->raw_qty }}</td>
                                                <td class="text-center">{{ $value->quantity }}</td>
                                                <td class="text-center">{{ getAmtCustom($value->sale_price) }}</td>
                                                <?php
                                                    $sub_tot_before_dis = $value->sale_price;
                                                    $dis_val = $value->discount_percent != '0' ? $sub_tot_before_dis * ($value->discount_percent / 100) : '0';
                                                    $sub_tot_af_dis = $dis_val!='0' ? $sub_tot_before_dis - $dis_val : $sub_tot_before_dis;
                                                ?>
                                                {{-- <td class="text-center">{{ '-'.getAmtCustom($dis_val) }}
                                                </td> --}}
                                                {{-- <td class="text-center">{{ getAmtCustom($sub_tot_af_dis) }}</td> --}}
                                                <?php
                                                    if($value->igst=='') {
                                                        $gst_per = $value->cgst + $value->sgst;
                                                    } else {
                                                        $gst_per = $value->igst;
                                                    }
                                                    $gst_value = $sub_tot_af_dis * ($gst_per/100);
                                                    $total = $sub_tot_af_dis + $gst_value
                                                ?>
                                                <td class="text-center">{{ getAmtCustom($gst_value) }}
                                                </td>                                                
                                                <td class="text-center">{{ getAmtCustom($total) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <h4 class="mt-20">@lang('index.invoice_quotations')</h4>
                            <table class="w-100 mt-10">
                                <thead class="b-r-3 bg-color-000000">
                                    <tr>
                                        <th class="w-5 text-start">@lang('index.sn')</th>
                                        <th class="w-15 text-start">@lang('index.type')</th>
                                        <th class="w-15 text-center">@lang('index.date')</th>
                                        <th class="w-15 text-center">@lang('index.amount')</th>
                                        <th class="w-15 text-center">@lang('index.paid')</th>
                                        <th class="w-15 text-center">@lang('index.due')</th>
                                        {{-- <th class="w-15 text-right">@lang('index.order_due')</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($orderInvoice) && $orderInvoice)
                                        <?php
                                        $i = 1;
                                        ?>
                                        {{-- @foreach ($orderInvoice as $key => $value) --}}
                                            <tr class="rowCount">
                                                <td class="width_1_p">
                                                    <p class="set_sn">1</p>
                                                </td>
                                                <td class="text-start">{{ $orderInvoice->invoice_type }}</td>
                                                <td class="text-center">{{ getDateFormat($orderInvoice->invoice_date) }}</td>
                                                <td class="text-center">{{ getAmtCustom($orderInvoice->amount) }}
                                                </td>
                                                <td class="text-center">{{ getAmtCustom($orderInvoice->paid_amount) }}
                                                </td>
                                                <td class="text-center">{{ getAmtCustom($orderInvoice->due_amount) }}
                                                </td>
                                                {{-- <td class="text-right pr-10">{{ getAmtCustom($value->order_due_amount) }}
                                                </td> --}}
                                            </tr>
                                        {{-- @endforeach --}}
                                    @endif
                                </tbody>
                            </table>
                            <table>
                                <tr>
                                    <td class="w-30 ">
                                    </td>
                                    <td class="w-50">
                                        <table class="mt-10 mb-10">
                                            <tr>
                                                <td class="w-50">
                                                    <p class="">@lang('index.total_cost') :</p>
                                                </td>
                                                <td class="w-50 text-right pr-0">
                                                    <p>{{ getAmtCustom($obj->total_amount) }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <table class="mt-50">
                                <tr>
                                    <td class="w-50">
                                    </td>
                                    <td class="w-50 text-right">
                                        <p class="rgb-71 d-inline border-top-e4e5ea pt-10">@lang('index.authorized_signature')</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </section>
@endsection
@section('script')
    <script src="{!! $baseURL . 'frequent_changing/js/order.js' !!}"></script>
@endsection
