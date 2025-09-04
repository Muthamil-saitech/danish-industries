<?php
$setting = getSettingsInfo();
$tax_setting = getTaxInfo();
$baseURL = getBaseURL();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    {{-- <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> --}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $obj->reference_no }}</title>
    <link rel="stylesheet" href="{{ getBaseURL() }}frequent_changing/css/pdf_common.css">
</head>
<body>
    <div class="m-auto b-r-5 p-30">
        <table>
            <tr>
                <td class="w-50">
                    <h3 class="pb-7">{{ getCompanyInfo()->company_name }}</h3>
                    <p class="pb-7 rgb-71">{{ getCompanyInfo()->address }}</p>
                    <p class="pb-7 rgb-71">@lang('index.email') : {{ getCompanyInfo()->email }}</p>
                    <p class="pb-7 rgb-71">@lang('index.phone') : {{ getCompanyInfo()->phone }}</p>
                    <p class="pb-7 rgb-71">@lang('index.website') : {{ getCompanyInfo()->website }}</p>
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
                    <th class="w-5 text-start">@lang('index.po_date')</th>
                    <th class="w-15 text-start">@lang('index.part_no')</th>
                    <th class="w-20 text-start">@lang('index.part_name')</th>
                    <th class="w-30 text-start">@lang('index.raw_material_name')<br>(@lang('index.code'))</th>
                    {{-- <th class="w-25 text-start">Heat No</th> --}}
                    <th class="w-5 text-center">@lang('index.raw_quantity')</th>
                    <th class="w-5 text-center">@lang('index.prod_quantity')</th>
                    <th class="w-15 text-center">@lang('index.unit_price')</th>
                    {{-- <th class="w-15 text-center">@lang('index.discount')</th> --}}
                    {{-- <th class="w-15 text-center">@lang('index.subtotal')</th> --}}
                    <th class="w-15 text-center">@lang('index.tax')</th>
                    <th class="w-15 text-center">@lang('index.total')</th>
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
                            <td class="text-start">{{ $value->po_date != null ? getDateFormat($value->po_date): getDateFormat($obj->created_at) }}
                            </td>
                            <td class="text-start">{{ $productInfo->code }}</td>
                            <td class="text-start">{{ $productInfo->name }}</td>
                            <td class="text-start">{{ getRMName($value->raw_material_id) }}</td>
                            {{-- <td class="text-start">{{ getheatNo($value->raw_material_id) }}</td> --}}
                            <td class="text-start">{{ $value->raw_qty }}</td>
                            <td class="text-start">{{ $value->quantity }}</td>
                            <td class="text-start" style="font-family: DejaVu Sans, sans-serif;">₹{{ number_format($value->sale_price,2) }}</td>
                            <?php
                                $sub_tot_before_dis = $value->sale_price;
                                $dis_val = $value->discount_percent != '0' ? $sub_tot_before_dis * ($value->discount_percent / 100) : '0';
                                $sub_tot_af_dis = $dis_val!='0' ? $sub_tot_before_dis - $dis_val : $sub_tot_before_dis;
                            ?>
                            {{-- <td class="text-start">₹{{ '-'.number_format($dis_val,2) }}
                            </td> --}}
                            {{-- <td class="text-start">₹{{ number_format($sub_tot_af_dis,2) }}</td> --}}
                            <?php
                                if($value->igst=='') {
                                    $gst_per = $value->cgst + $value->sgst;
                                } else {
                                    $gst_per = $value->igst;
                                }
                                $gst_value = $sub_tot_af_dis * ($gst_per/100);
                                $total = $sub_tot_af_dis + $gst_value
                            ?>
                            <td class="text-start" style="font-family: DejaVu Sans, sans-serif;">₹{{ number_format($gst_value,2) }}
                            </td>
                            <td class="text-start" style="font-family: DejaVu Sans, sans-serif;">₹{{ number_format($total,2) }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        {{-- <h4 class="mt-20">@lang('index.invoice_quotations')</h4>
        <table class="w-100 mt-10">
            <thead class="b-r-3 bg-color-000000">
                <tr>
                    <th class="w-5 text-start">@lang('index.sn')</th>
                    <th class="w-15 text-start">@lang('index.type')</th>
                    <th class="w-15">@lang('index.date')</th>
                    <th class="w-15">@lang('index.amount')</th>
                    <th class="w-15">@lang('index.paid')</th>
                    <th class="w-15">@lang('index.due')</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($orderInvoice) && $orderInvoice)
                    <?php
                    $i = 1;
                    ?>
                    @foreach ($orderInvoice as $key => $value)
                        <tr class="rowCount">
                            <td class="width_1_p">
                                <p class="set_sn">{{ $i++ }}</p>
                            </td>
                            <td class="text-start">{{ $value->invoice_type }}</td>
                            <td class="text-center">{{ getDateFormat($value->invoice_date) }}</td>
                            <td class="text-center" style="font-family: DejaVu Sans, sans-serif;">₹{{ number_format($value->amount, 2) }}
                            </td>
                            <td class="text-center" style="font-family: DejaVu Sans, sans-serif;">₹{{ number_format($value->paid_amount, 2) }}
                            </td>
                            <td class="text-center" style="font-family: DejaVu Sans, sans-serif;">₹{{ number_format($value->due_amount, 2) }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table> --}}
        {{-- @if (isset($orderDeliveries) && count($orderDeliveries) > 0)
            <h4 class="w-100 mt-20">@lang('index.deliveries')</h5>
                <table class="w-100 mt-10">
                    <thead class="b-r-3 bg-color-000000">
                        <tr>
                            <th class="w-5 text-start">@lang('index.sn')</th>
                            <th class="w-20 text-start">@lang('index.product')</th>
                            <th class="w-15">@lang('index.quantity')</th>
                            <th class="w-15">@lang('index.delivery_date')</th>
                            <th class="w-15">@lang('index.status')</th>
                            <th class="w-15 text-right">@lang('index.note')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i = 1)
                        @foreach ($orderDeliveries as $key => $value)
                            <?php
                            // $productInfo = getFinishedProductInfo($value->product_id);
                            
                            ?>
                            <tr class="rowCount">
                                <td class="width_1_p">
                                    <p class="set_sn">{{ $i++ }}</p>
                                </td>
                                <td class="text-start">{{ safe($productInfo->name) }}</td>
                                <td class="text-center">{{ safe($value->quantity) }}
                                    {{ getRMUnitById($productInfo->unit) }}</td>
                                <td class="text-center">{{ getDateFormat($value->delivery_date) }}</td>
                                <td class="text-center">{{ safe($value->delivery_status) }}
                                </td>
                                <td class="text-right">{{ safe($value->delivery_note) }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
        @endif --}}
        <table>
            <tr>
                <td valign="top" class="w-50">
                    <div class="pt-20">
                        <h4 class="d-block pb-20">File</h4>
                        <div class="">
                            @if (isset($obj->file) && $obj->file)
                                @php($file = $obj->file)
                                @php($fileExtension = pathinfo($file, PATHINFO_EXTENSION))
                                @if ($fileExtension == 'pdf')
                                <a class="text-decoration-none"
                                    href="{{ $baseURL }}uploads/order/{{ $file }}"
                                    target="_blank">
                                    <img src="{{ $baseURL }}assets/images/pdf.png"
                                        alt="PDF Preview" class="img-thumbnail mx-2"
                                        width="100px">
                                </a>
                                @elseif($fileExtension == 'doc' || $fileExtension == 'docx')
                                <a class="text-decoration-none"
                                    href="{{ $baseURL }}uploads/order/{{ $file }}"
                                    target="_blank">
                                    <img src="{{ $baseURL }}assets/images/word.png"
                                        alt="Word Preview" class="img-thumbnail mx-2"
                                        width="100px">
                                </a>
                                @else
                                <a class="text-decoration-none"
                                    href="{{ $baseURL }}uploads/order/{{ $file }}"
                                    target="_blank">
                                    <img src="{{ $baseURL }}uploads/order/{{ $file }}"
                                        alt="File Preview" class="img-thumbnail mx-2"
                                        width="100px">
                                </a>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="pt-20">
                        <p class="pb-7 rgb-71">
                            <span class="">@lang('index.quotation_note'):</span>
                            {{ $obj->quotation_note!='' ? $obj->quotation_note : '' }}
                        </p>
                        <p class="pb-7 rgb-71">
                            <span class="">@lang('index.internal_note'):</span>
                            {{ $obj->internal_note!='' ? $obj->internal_note : '' }}
                        </p>
                    </div>
                </td>
                <td class="w-50">
                    <table>
                        <tr>
                            <td class="w-50">
                                <p class="">@lang('index.total_cost')</p>
                            </td>
                            <td class="w-50 text-right pr-0">
                                <p style="font-family: DejaVu Sans, sans-serif;">₹{{ number_format($obj->total_amount,2) }}</p>
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
    <script src="{{ $baseURL . ('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ $baseURL . ('frequent_changing/js/onload_print.js') }}"></script>
</body>
</html>