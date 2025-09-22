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
                @if (routePermission('sale.print-invoice'))
                <a href="javascript:void();" target="_blank" class="btn bg-second-btn print_invoice"
                    data-id="{{ $obj->id }}"><iconify-icon icon="solar:printer-broken"></iconify-icon>
                    @lang('index.print')</a>
                @endif
                @if (routePermission('sale.download-invoice'))
                <a href="{{ route('sales.download_invoice', encrypt_decrypt($obj->id, 'encrypt')) }}"
                    target="_blank" class="btn bg-second-btn print_btn"><iconify-icon
                        icon="solar:cloud-download-broken"></iconify-icon>
                    @lang('index.download')</a>
                @endif
                @if (routePermission('sale.index'))
                <a class="btn bg-second-btn" href="{{ route('sales.index') }}"><iconify-icon
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
                                    <p class="pb-7 rgb-71">{{ safe(getCompanyInfo()->address) }}</p>
                                    <p class="pb-7 rgb-71">@lang('index.email') : {{ safe(getCompanyInfo()->email) }}</p>
                                    <p class="pb-7 rgb-71">@lang('index.phone') : {{ safe(getCompanyInfo()->phone) }}</p>
                                    <p class="pb-7 rgb-71">@lang('index.website') : <a href="{{ getCompanyInfo()->website }}" target="_blank">{{ safe(getCompanyInfo()->website) }}</a>
                                    </p>
                                </td>
                                <td class="w-50 text-right">
                                    <img src="{!! getBaseURL() .
                                            (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png') !!}" alt="site-logo">
                                </td>
                            </tr>
                        </table>
                        <div class="text-center pt-10 pb-10">
                            <h2 class="color-000000 pt-20 pb-20">@lang('index.sales_invoice')</h2>
                        </div>
                        <table>
                            <tr>
                                <td class="w-50">
                                    <h4 class="pb-7">@lang('index.customer_info'):</h4>
                                    <p class="pb-7">{{ $obj->customer->name }}</p>
                                    <p class="pb-7 rgb-71">{{ $obj->customer->address }}</p>
                                    @if($obj->customer->pan_no!='') <p class="pb-7 rgb-71"><b>PAN: </b>{{ $obj->customer->pan_no }}</p> @endif
                                </td>
                                <td class="w-50 text-right">
                                    <h4 class="pb-7">@lang('index.sale_info'):</h4>
                                    <p class="pb-7">
                                        <span class="">@lang('index.invoice_no'):</span>
                                        {{ $obj->reference_no }}
                                    </p>
                                    <p class="pb-7 rgb-71">
                                        <span class="">@lang('index.invoice_date'):</span>
                                        {{ getDateFormat($obj->sale_date) }}
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <table class="w-100 mt-20">
                            <thead class="b-r-3 bg-color-000000">
                                <tr>
                                    <th class="w-5 text-center">@lang('index.sn')</th>
                                    <th class="w-20 text-start">@lang('index.part_no')</th>
                                    <th class="w-20 text-start">@lang('index.description')</th>
                                    <th class="w-5 text-start">HSN</th>
                                    <th class="w-30 text-start">DC.No & Date</th>
                                    <th class="w-20 text-start">Your DC.No</th>
                                    <th class="w-5 text-start">SRN</th>
                                    <th class="w-5 text-start">@lang('index.po_no')</th>
                                    <th class="w-15 text-start">@lang('index.quantity')</th>
                                    <th class="w-15 text-start">@lang('index.unit_price')</th>
                                    <th class="w-30 text-right pr-5">@lang('index.total_amount')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($sale_details) && $sale_details) <?php $sum = 0; ?>
                                @foreach ($sale_details as $key => $value)
                                <?php
                                $orderInfo = getOrderDetail($value->order_id,$value->product_id);
                                $order = getOrderInfo($value->order_id);
                                $productInfo = getFinishedProductInfo($value->product_id);
                                $unit_id = optional($obj->quotation->quotationDetails
                                    ->where('product_id', $value->product_id)
                                    ->first())->unit_id;
                                $quote_price = optional($obj->quotation->quotationDetails
                                    ->where('product_id', $value->product_id)
                                    ->first())->price;
                                ?>
                                <tr class="rowCount" data-id="{{ $value->product_id }}">
                                    <td class="width_1_p">
                                        <p class="set_sn">{{ $key + 1 }}</p>
                                    </td>
                                    <td class="text-start">
                                        {{ $productInfo->code }}
                                    </td>
                                    <td class="text-start">
                                        {{ $productInfo->name }}
                                    </td>
                                    <td class="text-start">
                                        {{ $productInfo->hsn_sac_no!='' ? $productInfo->hsn_sac_no : ' - ' }}
                                    </td>
                                    <td class="text-start">
                                        {{ isset($challanInfo) ? $challanInfo->challan_no.'/'.date('d-m-Y',strtotime($challanInfo->challan_date)) : ' ' }}
                                    </td>
                                    <td class="text-start">
                                        {{ getYourDCNo($value->manufacture_id) }}
                                    </td>
                                    <td class="text-start">
                                        {{ $value->srn==0 ? 'NIL' : $value->srn }}
                                    </td>
                                    <td class="text-start">
                                        {{ getPoNo($value->order_id).'/'.getLineItemNo($value->order_id) }}
                                    </td>
                                    <td class="text-start">{{ $value->product_quantity }}
                                        {{-- {{ getRMUnitById($unit_id) }} --}}
                                    </td>
                                    <td class="text-start">
                                        {{ getCurrency(number_format(getOrderPrice($quote_price,$orderInfo->sale_price,$orderInfo->tax_type),2, '.', ''))  }}
                                        {{-- {{ getCurrency(number_format($orderInfo->sale_price, 2, '.', '')) }} --}}
                                    </td>   
                                    <?php  $sale_rate = getOrderPrice($quote_price,$orderInfo->sale_price,$orderInfo->tax_type);  /*$sale_rate = $orderInfo->sale_price;*/ 
                                    ?>
                                    <td class="text-right pr-10">
                                        {{ getCurrency(getSalePrice($sale_rate,$value->product_quantity)) }}
                                    </td>
                                    <?php $sale_r = getSalePrice($sale_rate,$value->product_quantity); $sum = $sum + $sale_r ?>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        <table>
                            <tr>
                                <td valign="top" class="w-50">
                                    <div class="pt-20">
                                        <h4 class="d-block pb-10">@lang('index.note')</h4>
                                        <div class="">
                                            <p class="h-180 color-black">
                                                {{ $obj->note }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="w-50">
                                    <table class="mt-10 mb-10">
                                        <tr>
                                            <td class="w-50 pr-0 border-bottom-dotted-gray">
                                                <p class="">@lang('index.subtotal') :</p>
                                            </td>
                                            <td class="w-50 pr-0 text-right">
                                                <p>{{ getAmtCustom($sum) }} </p>
                                            </td>
                                        </tr>
                                    </table> 
                                    @php
                                        $otherState = ($order->inter_state == 'N');
                                        $tax_row = getTaxItems($order->tax_type == 1 ? 'Labor' : 'Sales');
                                        if ($otherState) {
                                            // CGST + SGST
                                            $taxAmount = ($sum * ($tax_row->tax_value / 2) / 100) * 2;
                                        } else {
                                            // IGST
                                            $taxAmount = ($sum * $tax_row->tax_value) / 100;
                                        }

                                        $grandTotal = $sum + $taxAmount;
                                    @endphp                                   
                                    <table class="mt-10 mb-10">
                                        <tr>
                                            <td class="w-50 pr-0 border-bottom-dotted-gray">
                                                @if($otherState)
                                                    <p>CGST : {{ $tax_row->tax_value / 2 . '%' }}</p>
                                                    <p>SGST : {{ $tax_row->tax_value / 2 . '%' }}</p>
                                                @else
                                                    <p>IGST : {{ $tax_row->tax_value . '%' }}</p>
                                                @endif
                                            </td>
                                            <td class="w-50 pr-0 text-right">
                                                @if($otherState)
                                                    <p>{{ getAmtCustom(($sum * ($tax_row->tax_value / 2)) / 100) }}</p>
                                                    <p>{{ getAmtCustom(($sum * ($tax_row->tax_value / 2)) / 100) }}</p>
                                                @else
                                                    <p>{{ getAmtCustom(($sum * $tax_row->tax_value) / 100) }}</p>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="mt-10 mb-10">
                                        <tr>
                                            <td class="w-50 pr-0 border-bottom-dotted-gray">
                                                <p class="">@lang('index.grand_total') :</p>
                                            </td>
                                            <td class="w-50 pr-0 text-right">
                                                <p>{{ getAmtCustom($grandTotal) }} </p>
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
<script src="{!! $baseURL . 'frequent_changing/js/sales.js' !!}"></script>
@endsection