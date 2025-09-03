<?php
$setting = getSettingsInfo();
$tax_setting = getTaxInfo();
$baseURL = getBaseURL();
$whiteLabelInfo = App\WhiteLabelSettings::first();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $manufacture->reference_no }}</title>
    <link rel="stylesheet" href="{{ getBaseURL() }}frequent_changing/css/pdf_common.css">
</head>

<body>
    <section class="content">
        <div class="row" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
            <div style="max-width: 1200px; margin: 30px auto; ">
                <div style="text-align: center; border-bottom: 1px solid #000; padding: 10px;">
                    <img src="{!! getBaseURL() .
                        (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png') !!}" alt="Logo Image" class="img-fluid mb-2">
                    <h3 style="font-weight: 700; text-decoration: underline; font-size: 20px; padding-bottom: 15px;">INSPECTION REPORT</h3>
                    <form style="display: flex; justify-content: center; gap: 30px; align-items: center;">
                        <div style="display: flex; align-items: center;">
                            <input type="checkbox" style="transform: scale(1.8); margin-right: 20px; border-radius: 0px;" disabled {{ $di_inspect_dimensions->count() > 0 && !is_object($inspection_approval) ? 'checked' : '' }}>
                            <label style="font-size: 20px;"> In-Process</label>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <input type="checkbox" style="transform: scale(1.8); margin-right: 20px;" disabled {{ is_object($inspection_approval) && $inspection_approval->status == '2' ? 'checked' : '' }}>
                            <label style="font-size: 20px;"> Final</label>
                        </div>
                    </form>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: start; padding: 10px;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-weight: 600; font-size: 16px; display: flex; justify-content: space-between; width: 100px;">CUSTOMER <span>:</span> </span>
                            <p style="margin: 5px; font-weight: 600;">{{ getCustomerNameById($manufacture->customer_id) }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-weight: 600; font-size: 16px; display: flex; justify-content: space-between; width: 100px;">PART NAME <span>:</span> </span>
                            <p style="margin: 5px; font-weight: 600;">{{ isset($finishProduct) ? $finishProduct->name : '' }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-weight: 600; font-size: 16px; display: flex; justify-content: space-between; width: 100px;">PART No. <span>:</span> </span>
                            <p style="margin: 5px; font-weight: 600;">{{ isset($finishProduct) ? $finishProduct->code : '' }}</p>
                        </div>
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">DRG No. <span>:</span> </span>
                            <p style="margin: 5px;">{{ $manufacture->drawer_no }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">REV <span>:</span> </span>
                            <p style="margin: 5px;"> {{ $manufacture->rev }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">OPERATION <span>:</span> </span>
                            <p style="margin: 5px;"> {{ $manufacture->operation }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">PoNo <span>:</span> </span>
                            <p style="margin: 5px;">{{ getPoNo($manufacture->customer_order_id) }}</p>
                        </div>
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 150px;">MATERIAL <span>:</span> </span>
                            <p style="margin: 5px;">{{ materialName($manufacture->rawMaterials[0]->rmaterials_id).'-'.($material->code) }} {{ $material->diameter!='' ? 'DIA '.$material->diameter : '' }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 150px;">Total Quantity <span>:</span> </span>
                            <p style="margin: 5px;">{{ $manufacture->product_quantity }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 150px;">Sample Quantity <span>:</span> </span>
                            <p style="margin: 5px;">{{ $manufacture->product_quantity }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 150px;">Heat No. <span>:</span> </span>
                            <p style="margin: 5px;">{{ getheatNo($manufacture->rawMaterials[0]->rmaterials_id) }}</p>
                        </div>
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">Report No. <span>:</span> </span>
                            <p style="margin: 5px;">{{ 'IR' . str_pad($manufacture->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">Date <span>:</span> </span>
                            <p style="margin: 5px;"> {{ date('d/m/Y') }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">DC No. <span>:</span> </span>
                            <p style="margin: 5px;"> {{ $material_stock->dc_no }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">PPCRCNo. <span>:</span> </span>
                            <p style="margin: 5px;">{{ $manufacture->reference_no }}</p>
                        </div>
                    </div>
                </div>
                <div style="border:1px solid #000; border-top: none;">
                    <table style="width:100%; border-collapse:collapse; font-size:16px;">
                        <tr style="text-align:center;">
                            <th style='border: 1px solid #000; border-left: none;'>Sl.No</th>
                            <th style='border: 1px solid #000; padding: 10px;'>PARAMETER</th>
                            <th style='border: 1px solid #000; padding: 10px;'>DRAWING <br> SPEC.</th>
                            <th style='border: 1px solid #000; padding: 10px;'>INSP. <br>METHOD</th>
                            <th style='border: 1px solid #000; border-right: none;' colspan="14">OBSERVED DIMENSIONS SL.No.</th>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 5px; border-left: none; "></td>
                            <td style="border: 1px solid #000; padding: 5px;">&nbsp;</td>
                            <td style="border: 1px solid #000; padding: 5px;">&nbsp;</td>
                            <td style="border: 1px solid #000; padding: 5px;">&nbsp;</td>
                            @if(isset($inspection) && count($inspection) > 0 && isset($inspection[0]->details) && count($inspection[0]->details) > 0)
                            @php
                            $dimensionCount = isset($di_inspect_dimensions)
                            ? $di_inspect_dimensions->unique('set_no')->count()
                            : 0;
                            @endphp
                            @for ($i = 0; $i < 13; $i++)
                                <td style="border: 1px solid #000; padding: 5px;">
                                @if ($i < $dimensionCount)
                                    DBF {{ str_pad($i + 1, 3, '0', STR_PAD_LEFT) }}
                                    @else

                                    @endif
                                    </td>
                                    @endfor
                                    @else
                                    @for ($i = 0; $i < 13; $i++)
                                        <td style="border: 1px solid #000; padding: 5px;">
                                        </td>
                                        @endfor
                                        @endif
                                        <td style="border: 1px solid #000; padding: 5px; border-right: none;"></td>
                        </tr>
                        @if(isset($inspection) && count($inspection) > 0 && isset($inspection[0]->details) && count($inspection[0]->details) > 0)
                        <tr>
                            <th></th>
                            <th colspan="16" style="text-align: start; padding: 10px 7px;">Dimension Inspection</th>
                        </tr>
                        @foreach($inspection[0]->details as $key => $value)
                        @if($value->di_param!='')
                        <tr>
                            <td style="width: 80px; border: 1px solid #000; padding: 10px 7px;  border-left: none;">{{ $loop->iteration }}</td>
                            <td style="width: 80px; border: 1px solid #000; padding: 10px 7px;">{{ $value->di_param }}</td>
                            <td style="width: 80px; border: 1px solid #000; padding: 10px 7px;">{{ $value->di_spec }}</td>
                            <td style="text-align: center; width: 80px; border: 1px solid #000; padding: 10px 7px;">{{ $value->di_method!='' ? $value->di_method : '-' }}</td>
                            @php
                            $matchedDimensions = $di_inspect_dimensions
                            ->where('inspect_param_id', $value->id)
                            ->values();
                            @endphp
                            @for ($i = 0; $i < 13; $i++)
                                <td style="width: 80px; border: 1px solid #000;">
                                {{ $matchedDimensions[$i]->di_observed_dimension ?? '' }}
                                </td>
                                @endfor
                                <td style="width: 80px; border: 1px solid #000; padding: 10px 7px; border-right: none;"></td>
                        </tr>
                        @endif
                        @endforeach
                        @endif
                        @if(isset($inspection) && count($inspection) > 0 && isset($inspection[0]->details) && count($inspection[0]->details) > 0)
                        <tr>
                            <th></th>
                            <th colspan="16" style="text-align: start; padding: 10px 7px;">Appearance Inspection</th>
                        </tr>
                        @foreach($inspection[0]->details as $key => $value)
                        @if($value->ap_param!='')
                        <tr>
                            <td style="border: 1px solid; padding: 10px 7px; width: 80px; border-left: none ;">{{ $loop->iteration }}</td>
                            <td style="border: 1px solid; padding: 10px 7px; width: 80px;">{{ $value->ap_param }}</td>
                            <td style="border: 1px solid; padding: 10px 7px; width: 80px;">{{ $value->ap_spec }}</td>
                            <td style="text-align: center; border: 1px solid; padding: 10px 7px; width: 80px;">{{ $value->ap_method!='' ? $value->ap_method : '-' }}</td>
                            @php
                            $matchedApDimensions = $ap_inspect_dimensions
                            ->where('inspect_param_id', $value->id)
                            ->values();
                            @endphp
                            @for ($i = 0; $i < 13; $i++)
                                <td style="width: 80px; border: 1px solid #000;">
                                {{ $matchedApDimensions[$i]->ap_observed_dimension ?? '' }}
                                </td>
                                @endfor
                                <td style="border: 1px solid; padding: 10px 7px; width: 80px;border-right: none ;"></td>
                        </tr>
                        @endif
                        @endforeach
                        @endif
                    </table>
                    <div style="display: flex; justify-content: space-around;">
                        <div style="padding-top: 5px;">
                            <p>INSPECTED BY</p>
                            <h5>{{ !empty($inspection_approval) && is_object($inspection_approval) ? getEmpCode($inspection_approval->inspected_by) : '' }}</h5><br>
                        </div>
                        <div style="padding-top: 5px;">
                            <p>CHECKED BY</p>
                            <h5>{{ !empty($inspection_approval) && is_object($inspection_approval) ? getEmpCode($inspection_approval->checked_by) : '' }}</h5><br>
                        </div>
                    </div>
                </div>
                <p style="padding-top: 5px; padding-bottom: 100px; font-size: 13px;"><b>Remarks</b>&nbsp;&nbsp;{{ !empty($inspection_approval) && is_object($inspection_approval) ? $inspection_approval->remarks : '' }}</p>
            </div>
        </div>
    </section>
    <script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('frequent_changing/js/onload_print.js') }}"></script>
</body>

</html>