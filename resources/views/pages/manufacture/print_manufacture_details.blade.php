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
    <div class="m-auto b-r-5 p-30">
        <table>
            <tr>
                <td class="w-50">
                    <h3 class="pb-7">{{ getCompanyInfo()->company_name }}</h3>
                    <p class="pb-7 rgb-71">{{ safe(getCompanyInfo()->address) }}</p>
                    <p class="pb-7 rgb-71">@lang('index.email') : {{ safe(getCompanyInfo()->email) }}</p>
                    <p class="pb-7 rgb-71">@lang('index.phone') : {{ safe(getCompanyInfo()->phone) }}</p>
                    <p class="pb-7 rgb-71">@lang('index.website') : {{ getCompanyInfo()->website }}</p>
                </td>
                <td class="w-50 text-right">
                    <img src="{!! getBaseURL() . (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png') !!}" alt="site-logo">
                </td>
            </tr>
        </table>
        <div class="text-center pt-10 pb-10">
            <h2 class="color-000000 pt-20 pb-20">@lang('index.manufacture_details')</h2>
        </div>
        <table>
            <tr>
                <td class="w-50">
                    <p class="pb-7">
                        <span class="">@lang('index.ppcrc_no'):</span>
                        {{ $obj->reference_no }}
                    </p>
                    <p class="pb-7 rgb-71">
                        <span class="">@lang('index.status'):</span>
                        @if ($obj->manufacture_status == 'draft')
                        Draft
                        @elseif($obj->manufacture_status == 'inProgress')
                        In Progress
                        @elseif($obj->manufacture_status == 'done')
                        Done
                        @endif
                    </p>
                    <p class="pb-7 rgb-71">
                        <span class="">@lang('index.start_date'):</span>
                        {{ getDateFormat($obj->start_date) }}
                    </p>
                </td>
                <td class="w-50 text-right">
                    @php $prodInfo = getFinishedProductInfo($obj->product_id); @endphp
                    <p class="pb-7">
                        <span class="">@lang('index.part_no'):</span>
                        {{ $prodInfo->code }}
                    </p>
                    <p class="pb-7">
                        <span class="">@lang('index.part_name'):</span>
                        {{ $prodInfo->name }}
                    </p>
                    <p class="pb-7 rgb-71">
                        <span class="">@lang('index.prod_quantity'):</span>
                        {{ $obj->product_quantity }}
                    </p>
                    <p class="pb-7 rgb-71">
                        <span class="">@lang('index.delivery_date'):</span>
                        {{ $obj->complete_date != null ? getDateFormat($obj->complete_date) : 'N/A' }}
                    </p>
                </td>
            </tr>
        </table>
        <h4>@lang('index.raw_material_consumption_cost') (RoM)</h4>
        <table class="w-100 mt-10 manufacture_table">
            <thead class="b-r-3">
                <tr>
                    <th class="w-5 text-left">@lang('index.sn')</th>
                    <th class="w-30 text-left">@lang('index.raw_material_name')(@lang('index.code'))</th>
                    <th class="w-15 text-left">Heat No</th>
                    <th class="w-15 text-left">@lang('index.stock')</th>
                    <th class="w-15 text-left">@lang('index.consumption')</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($m_rmaterials) && $m_rmaterials)
                <?php $i = 1; ?>
                @foreach ($m_rmaterials as $key => $value)
                <tr class="rowCount">
                    <td class="width_1_p">
                        <p class="set_sn">{{ $i++ }}</p>
                    </td>
                    <td class="text-start">{{ getRMName($value->rmaterials_id) }}</td>
                    <td class="text-start">{{ getheatNo($value->rmaterials_id) }}</td>
                    <td class="text-start">{{ $value->stock }} {{ getStockUnitById($value->stock_id) }}</td>
                    <td class="text-start">{{ $value->consumption }} {{ getStockUnitById($value->stock_id) }}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>

        <h4 class="mt-20">@lang('index.manufacture_stages')</h4>
        <table class="w-100 mt-10 production_table">
            <thead class="b-r-3">
                <tr>
                    <th class="w-5 text-left">@lang('index.sn')</th>
                    <th class="w-30 text-left">@lang('index.stage')</th>
                    <th class="w-15 text-center">@lang('index.required_time')</th>
                    <th class="w-15 text-center">Setup Time</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($m_stages) && $m_stages)
                <?php
                $k = 1;
                $total_mimute = 0;$total_req_min = 0;$total_set_min = 0;
                ?>
                @foreach ($m_stages as $key => $value)
                <?php
                $total_req_min += $value->stage_minute;
                $total_set_min += $value->stage_set_minute;
                $total_mimute += $value->stage_minute + $value->stage_set_minute;
                $checked = '';
                $tmp_key = $key + 1;
                if ($obj->stage_counter == $tmp_key) {
                    $checked = 'checked=checked';
                }
                
                ?>
                <tr class="rowCount">
                    <td class="width_1_p">
                        <p class="set_sn">{{ $k++ }}</p>
                    </td>
                    <td class="text-left">
                        {{ getProductionStages($value->productionstage_id) }}
                    </td>
                    <td class="text-center">{{ $value->stage_minute }}</td>
                    <td class="text-center">{{ $value->stage_set_minute }}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-right pr-10">@lang('index.total') :</td>
                    <td class="text-center">
                        {{ isset($total_mimute) && $total_mimute ? $total_mimute : '' }}
                    </td>
                </tr>
            </tfoot>
        </table>

        <table>
            <tr>
                <td valign="top" class="w-50">
                    <div class="pt-20">
                        <h4 class="d-block pb-10">@lang('index.files')</h4>
                        <div class="">
                            @if (isset($obj->file) && $obj->file)
                            @php($files = explode(',', $obj->file))
                            @foreach ($files as $file)
                            @php($fileExtension = pathinfo($file, PATHINFO_EXTENSION))
                            @if ($fileExtension == 'pdf')
                            <a class="text-decoration-none"
                                href="{{ $baseURL }}uploads/manufacture/{{ $file }}"
                                target="_blank">
                                <img src="{{ $baseURL }}assets/images/pdf.png"
                                    alt="PDF Preview" class="img-thumbnail mx-2"
                                    width="100px">
                            </a>
                            @elseif($fileExtension == 'doc' || $fileExtension == 'docx')
                            <a class="text-decoration-none"
                                href="{{ $baseURL }}uploads/manufacture/{{ $file }}"
                                target="_blank">
                                <img src="{{ $baseURL }}assets/images/word.png"
                                    alt="Word Preview" class="img-thumbnail mx-2"
                                    width="100px">
                            </a>
                            @else
                            <a class="text-decoration-none"
                                href="{{ $baseURL }}uploads/manufacture/{{ $file }}"
                                target="_blank">
                                <img src="{{ $baseURL }}uploads/manufacture/{{ $file }}"
                                    alt="File Preview" class="img-thumbnail mx-2"
                                    width="100px">
                            </a>
                            @endif
                            @endforeach
                            @endif
                        </div>
                    </div>
                </td>
                <td style="text-align:right;">
                    <div class="pt-20">
                        <h4 class="d-block pb-10">@lang('index.note')</h4>
                        <div class="">
                            <p class="h-180 color-black">
                                {{ $obj->note }}
                            </p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table class="mt-20">
            <tr>
                <td class="w-50">
                </td>
                <td class="w-50 text-right">
                    <p class="rgb-71 d-inline border-top-e4e5ea pt-10">@lang('index.authorized_signature')</p>
                </td>
            </tr>
        </table>
    </div>
    <script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('frequent_changing/js/onload_print.js') }}"></script>
</body>

</html>