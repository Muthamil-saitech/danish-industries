<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $obj->reference_no }}</title>
</head>

<body>
    <section class="content" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
        <div style="width: 98%; max-width: 1200px; margin: 30px auto;">
            <div style="padding: 18px 0; border: 1px solid #000; background: #fff;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                    <div style="flex: 1; text-align: center;">
                        <h5 style="font-size: 18px; font-weight: 700; letter-spacing: 1px; margin: 0;">DELIVERY CHALLAN</h5>
                        <img src="{!! getBaseURL() .
                        (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png') !!}" alt="Logo Image" class="img-fluid my-2">
                        <!-- <h3 style="font-size: 25px; font-weight: 500; margin: 2px 0;">{{ strtoupper(getCompanyInfo()->company_name) }}</h3> -->
                        <p style="font-size: 15px;margin-top: 0px; margin-bottom: 1px;">An ISO 9001:2008 Certified Company</p>
                        <p style="font-size: 16px; margin: 0;">{{ safe(getCompanyInfo()->address) }}
                        </p>
                    </div>
                </div>
                <div
                    style="display: flex; align-items: start; justify-content: space-between; font-size: 16px; margin:0px 25px  2px 10px; flex-wrap: wrap">
                    <div style="display: flex; align-items: center;">
                        <p>GSTIN No.: </p><b style="margin-left: 10px">{{ safe(getCompanyInfo()->gst_no) }}</b>
                    </div>
                    <div>
                        <span style="display: flex; align-items: center;">
                            <p style="margin: 5px; display: flex; justify-content: space-between; width: 30%; white-space: nowrap">SSl. No
                                <span>:</span>
                            </p> <b style="margin-left: 10px">{{ safe(getCompanyInfo()->ssi_no) }}</b>
                        </span>
                        <span style="display: flex; align-items: center;">
                            <p style="margin: 5px;  display: flex; justify-content: space-between; width: 30%; white-space: nowrap">PAN No. <span>:</span> </p><b style="margin-left: 10px">{{ safe(getCompanyInfo()->pan_no) }}</b>
                        </span>
                    </div>
                    <div>
                        <span style="display: flex; align-items: center;">
                            <p style="margin: 5px;  display: flex; justify-content: space-between; width: 30%; white-space: nowrap">Phone No<span>:</span> </p><b style="margin-left: 10px">{{ safe(getCompanyInfo()->phone) }}</b>
                        </span>
                        <span style="display: flex; align-items: center;">
                            <p style="margin: 5px;  display: flex; justify-content: space-between; width: 30%; white-space: nowrap">E-Mail
                                <span>:</span>
                            </p><b style=" width: 50%;margin-left: 10px">{{ safe(getCompanyInfo()->email) }}</b>
                        </span>
                    </div>
                </div>
                <div style="display: flex; margin: 12px 0 0;">
                    <div
                        style="width: 50%; border-top: 1px solid #000; border-right: 1px solid #000; padding: 8px 10px; font-size: 16px;">
                        <b>To</b><br>
                        <div style="padding-left: 30px; display: flex;"> <span>Mr./Ms.</span> <b
                                style="padding-left: 10px; font-weight: 700;"> {{ $obj->customer->name }}<br>
                                {{ $obj->customer->address }}<br>
                                {{ $obj->customer->pan_no!='' ? 'PAN: '.$obj->customer->pan_no : '' }}</b>
                        </div>
                        <p>Party GSTIN No. : {{ $obj->customer->gst_no }}</p>
                    </div>
                    <div style="width: 50%; border-top: 1px solid #000; padding: 8px 10px; font-size: 16px;">
                        <div style="display: flex; margin-bottom: 4px;">
                            <span style="width: 40%;">DC No </span> <b>: {{ $obj->challan_no }}</b>
                        </div>
                        <div style="display: flex;margin-bottom: 4px;">
                            <span style="width: 40%;">DC Date</span> <b> : {{ getDateFormat($obj->challan_date) }}</b>
                        </div>
                        <div style="display: flex; margin-bottom: 4px;">
                            <span style="width: 40%;">Customer Code</span> <b> : {{ $obj->customer->customer_id }}</b>
                        </div>
                    </div>
                </div>

                <table style="width:100%; border-collapse:collapse; font-size:16px;">
                    <tr>
                        <th style="border:1px solid #000; padding:4px; border-left: none;">S.No</th>
                        <th style="border:1px solid #000; padding:4px;">Part No.</th>
                        <th style="border:1px solid #000; padding:4px;">Description</th>
                        <th style="border:1px solid #000; padding:4px;">Qty</th>
                        <th style="border:1px solid #000; padding:4px;">UOM</th>
                        {{-- <th style="border:1px solid #000; padding:4px;">Rate</th> --}}
                        <th style="border:1px solid #000; padding:4px;">PO No</th>
                        <th style="border:1px solid #000; padding:4px;">HSN/SAC</th>
                        <th style="border:1px solid #000; padding:4px;">DC Ref</th>
                        <th style="border:1px solid #000; padding:4px;">Challan Ref</th>
                        <th style="border:1px solid #000; padding:4px; border-right: none;">Remarks</th>
                    </tr>
                    <?php $i = 0;
                    $totalQty = 0; ?>
                    @if (isset($quotation_details) && $quotation_details)
                    @foreach ($quotation_details as $key => $value)
                    <?php
                    $i++;
                    $productInfo = getFinishedProductInfo($value->product_id);
                    $totalQty += $value->product_quantity;
                    $orderDetail = getOrderDetail($value->customer_order_id, $value->product_id);
                    ?>
                    <tr>
                        <td style="border:1px solid #000; padding:4px; text-align:center;  border-left: none;" rowspan="4">{{ $i }}</td>
                        <td style="padding:4px; text-align: center;">{{ $productInfo->code }}</td>
                        <td style="border:1px solid #000; padding:4px; border-bottom: none;">{{ $productInfo->name }} </td>
                        <td style="border:1px solid #000; padding:4px; border-bottom: none; text-align:center;">{{ $value->product_quantity }}</td>
                        <td style="border:1px solid #000; padding:4px; border-bottom: none; text-align:start;">{{ getRMUnitById($value->unit_id) }}</td>
                        {{-- <td style="border:1px solid #000; padding:4px; border-bottom: none; text-align:start;">{{ getOrderPrice($value->price,$orderDetail->sale_price,$orderDetail->tax_type) }}</td> --}}
                        <td style="border:1px solid #000; padding:4px; border-bottom: none; text-align:start;">{{ $value->po_no }}
                        </td>
                        <td style="border:1px solid #000; padding:4px; border-bottom: none; text-align:start;">{{ $productInfo->hsn_sac_no }}</td>
                        <td style="border:1px solid #000; padding:4px; border-bottom: none; text-align:start;">{{ $value->dc_ref }}
                        </td>
                        <td style="border:1px solid #000; padding:4px; border-bottom: none; text-align:start;">{{ $value->challan_ref }}</td>
                        <td style="padding:4px; border-bottom: none; text-align:start; border-right: none;">{{ $value->description }}</td>
                    </tr>
                    <tr>
                        <td style="border-left: 1px solid #000;"></td>
                        <td style="border-left: 1px solid #000;"></td>
                        <td style="border-left: 1px solid #000;"></td>
                        <td style="border-left: 1px solid #000;"></td>
                        {{-- <td style="border-left: 1px solid #000;"></td> --}}
                        <td style="border-left: 1px solid #000;">{{ $value->po_date!='' ? date('d-m-Y',strtotime($value->po_date)) : '' }}</td>
                        <td style="border-left: 1px solid #000;"></td>
                        <td style="border-left: 1px solid #000;">{{ $value->dc_ref_date!='' ? date('d-m-Y',strtotime($value->dc_ref_date)) : '' }}</td>
                        <td style="border-left: 1px solid #000;"></td>
                        <td style="border-left: 1px solid #000;"></td>
                    </tr>
                    <tr>
                        <td style="border-left: 1px solid #000; padding: 0 4px;"></td>
                        <td style="border-left: 1px solid #000; padding: 0 4px;"></td>
                        <td style="border-left: 1px solid #000;"></td>
                        <td style="border-left: 1px solid #000;"></td>
                        {{-- <td style="border-left: 1px solid #000;"></td> --}}
                        <td style="border-left: 1px solid #000;"></td>
                        <td style="border-left: 1px solid #000;"></td>
                        <td style="border-left: 1px solid #000;"></td>
                        <td style="border-left: 1px solid #000;"></td>
                        <td style="border-left: 1px solid #000;"></td>
                        <td></td>
                    </tr>
                    <tr style="border-bottom:1px solid #000;">
                        <td style="border-left: 1px solid #000;  padding: 5px 5px 7px;"></td>
                        <td style="border-left: 1px solid #000;  padding: 5px 5px 7px;"></td>
                        <td style="border-left: 1px solid #000; "></td>
                        <td style="border-left: 1px solid #000; "></td>
                        {{-- <td style="border-left: 1px solid #000; "></td> --}}
                        <td style="border-left: 1px solid #000; "></td>
                        <td style="border-left: 1px solid #000; "></td>
                        <td style="border-left: 1px solid #000; "></td>
                        <td style="border-left: 1px solid #000;"></td>
                        <td style="border-left: 1px solid #000;"></td>
                        <td></td>
                    </tr>
                    @endforeach
                    @endif
                    <tfoot>
                        <tr style="border: 1px solid #000;border-left:none;border-right:none;text-align:center;">
                            <td style="border-right: 1px solid #000; border-left:none;"> </td>
                            <td style="border-right: 1px solid #000;"></td>
                            <td style="border-right: 1px solid #000;padding-bottom:35px;"><b>Total Quantity</b></td>
                            <td style="border-right: 1px solid #000;padding-bottom:35px;"><b>{{ $totalQty }}</b></td>
                            {{-- <td style="border-right: 1px solid #000;"></td> --}}
                            <td style="border-right: 1px solid #000;"></td>
                            <td style="border-right: 1px solid #000;"></td>
                            <td style="border-right: 1px solid #000;"></td>
                            <td style="border-right: 1px solid #000;"></td>
                            <td style="border-right: 1px solid #000;"></td>
                            <td style="border-right: 1px solid #000;border-right:none;" >&nbsp;&nbsp;</td>
                        </tr>
                    </tfoot>
                </table>
                <div
                    style="display: flex; justify-content: space-between; align-items: start; margin: 30px 10px 0px; font-size: 16px;">
                    <div>
                        <p style="margin: 0;"> Received the above Goods in good conditions</p>
                        <p style="margin-top: 30px;"> Receiver's Signature with Seal</p>
                    </div>
                    <div style="text-align: right;">
                        For <b>{{ strtoupper(getCompanyInfo()->company_name) }}</b>

                    </div>
                </div>
            </div>
            <div style="text-align: end;">
                <span style="font-size: 12px;">DAN/STR/SF/01</span>
            </div>
        </div>
    </section>
</body>