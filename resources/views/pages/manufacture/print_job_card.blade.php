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
    <title>{{ $obj->reference_no }}</title>
    <link rel="stylesheet" href="{{ getBaseURL() }}frequent_changing/css/pdf_common.css">
</head>

<body>
    @if(isset($latest_form) && $latest_form!='')
    @php
    $imagePath = base_path('uploads/job_card_form/'.$latest_form);
    $imageData = base64_encode(file_get_contents($imagePath));
    $mimeType = mime_content_type($imagePath);
    @endphp
    <div style="width: 98%; max-width: 1100px; margin: 30px auto;">
        <h3 style="text-align: center; font-weight: bold; font-size: 22px; margin-bottom: 5px;">{{ strtoupper($setting->name_company_name) }}</h3>
        <p style="text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 10px;">{{ isset($title) && $title ? strtoupper($title) : '' }}</p>
        <img src="data:{{ $mimeType }};base64,{{ $imageData }}" alt="job card form" style="display: block; margin: 0 auto; width: 100%;">
    </div>
    @else
    <div style="width: 98%; max-width: 1100px; margin: 30px auto; font-family: Arial, sans-serif;  padding: 18px;">
        <div class="text-center">
            <img src="{!! getBaseURL() .
                        (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png') !!}" alt="Logo Image" class="img-fluid mb-2">
        </div>
        <div style="text-align: center;">
            <!-- <h3 style="margin: 0; font-size: 22px;">{{ strtoupper($setting->name_company_name) }}</h3> -->
            <p style="font-size: 14px; margin-bottom: 10px">{{ strtoupper($setting->address) }}</p>
        </div>
        <h3 style="text-align: center; margin-bottom: 10px; font-size: 18px;">{{ isset($title) && $title ? strtoupper($title) : '' }}</h3>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <div><b>WORK CENTRE: </b></div>
            <div>
                <div style="margin-bottom: 10px;margin-right:100px;"><b>Sl. No: </b></div>
                <div style="margin-right:100px;"><b>Date: </b></div>
            </div>
        </div>
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <thead>
                <tr>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">OPR NAME</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">SHIFT</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">
                        PART NO.<br>
                        <span style="font-weight: bold; border-top: 1px solid #000;">PPRC.No</span>
                    </th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">ITEM NAME</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">OPRN STAGE</th>
                    <th colspan="3" style="border: 1px solid #000; padding: 4px;">SETTING TIME</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">CYCLE TIME IN MIN</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">IDEAL TIME IN MIN</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">ACHIEVED QTY</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">ACCEPTED QTY</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">REJECTED QTY</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">REWORK QTY</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">IN TIME MIN</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">OUT TIME MIN</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">OPERATOR SIGN</th>
                </tr>
                <tr>
                    <th style="border: 1px solid #000; padding: 4px;">START</th>
                    <th style="border: 1px solid #000; padding: 4px;">END</th>
                    <th style="border: 1px solid #000; padding: 4px;">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"><br><br></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; border-right: 1px solid #000; padding: 20px;"></td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; border-right: 1px solid #000; padding: 20px;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"><br></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"><br></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; border-right: 1px solid #000; padding: 20px;"></td>
                </tr>
                <tr>
                    <td colspan="5" style="border: 1px solid #000; text-align: right; padding: 5px;"></td>
                    <td colspan="2" style="border: 1px solid #000; text-align: right; padding: 5px;"><strong>TOTAL TIME</strong></td>
                    <td colspan="1" style="border: 1px solid #000; text-align: right; padding: 5px;"></td>
                    <td colspan="1" style="border: 1px solid #000; text-align: right; padding: 5px;"></td>
                    <td colspan="1" style="border: 1px solid #000; text-align: right; padding: 5px;"></td>
                    <td colspan="1" style="border: 1px solid #000; text-align: right; padding: 5px;"></td>
                    <td colspan="1" style="border: 1px solid #000; text-align: right; padding: 5px;"></td>
                    <td colspan="1" style="border: 1px solid #000; text-align: right; padding: 5px;"></td>
                    <td colspan="1" style="border: 1px solid #000; text-align: right; padding: 5px;"></td>
                    <td colspan="1" style="border: 1px solid #000; text-align: right; padding: 5px;"></td>
                    <td colspan="1" style="border: 1px solid #000; text-align: right; padding: 5px;"></td>
                    <td colspan="1" style="border: 1px solid #000; text-align: right; padding: 5px;"></td>
                </tr>
            </tbody>
        </table>
        <p class="text-right" style="padding-right:20px; padding-top:5px; font-size: 9px;"><b>PRODUCTION INCHARGE</b></p>
        <div style="display: flex; justify-content: space-between; margin-top: 20px;">
            <div style="width: 53%;">
                <p style="font-size: 16px; font-weight: bold;">OPERATION STAGE</p>
                <p style="font-size: 16px;">
                <div style="display: flex; gap: 20px;">
                    <span style="width: 150px;"> 01. Skin Turn </span><span> 08. Drilling / Tap </span>
                </div>
                <div style="display: flex; gap: 20px;">
                    <span style="width: 150px;"> 02. Finishing-1 </span><span> 09. Milling</span>
                </div>
                <div style="display: flex; gap: 20px">
                    <span style="width: 150px;"> 03. Finishing-2</span><span>10. Special Operation</span>
                </div>
                <div style="display: flex; gap: 20px">
                    <span style="width: 150px;"> 04. Roughing-1</span><span> 11. Cutting </span>
                </div>
                <div style="display: flex; gap: 20px">
                    <span style="width: 150px;"> 05. Roughing-2 </span><span> 12. Spot Facing </span>
                </div>
                <div style="display: flex; gap: 20px">
                    <span style="width: 150px;"> 06. Drilling</span><span> 13. Rework</span>
                </div>
                <div style="display: flex; gap: 20px">
                    <span style="width: 150px;"> 07. Reaming </span><span> 14. Grinding</span>
                </div>
                </p>
            </div>
            <div style="width: 47%;">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <tr>
                        <td style="border: 1px solid #000; padding: 3px;">Note:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td style="text-align:center; border: 1px solid #000; padding: 3px;">OPR SIGN</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #000; padding: 3px;">1</td>
                        <td style="border: 1px solid #000; padding: 3px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #000; padding: 3px;">2</td>
                        <td style="border: 1px solid #000; padding: 3px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #000; padding: 3px;">3</td>
                        <td style="border: 1px solid #000; padding: 3px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #000; padding: 3px;">4</td>
                        <td style="border: 1px solid #000; padding: 3px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #000; padding: 3px;">5</td>
                        <td style="border: 1px solid #000; padding: 3px;">&nbsp;</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @endif
    <script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('frequent_changing/js/onload_print.js') }}"></script>
</body>

</html>