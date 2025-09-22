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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $partner_io->po_no }}</title>
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
            <h2 class="color-000000 pt-20 pb-20">@lang('index.partner_io_details')</h2>
        </div>
        <table>
            <tr>
                <td class="w-50">
                    <h4 class="pb-7">@lang('index.partner_info'):</h4>
                    <p class="pb-7 rgb-71">
                        <span class="">@lang('index.partner_code'):</span>
                        {{ $partner_io->partner->partner_id }}
                    </p>
                    <p class="pb-7 rgb-71">
                        <span class="">@lang('index.partner_name'):</span>
                        {{ $partner_io->partner->name }}
                    </p>
                    <p class="pb-7 rgb-71">
                        <span class="">@lang('index.phone_number'):</span>
                       {{ $partner_io->partner->phone }}
                    </p>
                    <p class="pb-7 rgb-71">
                        <span class="">@lang('index.email'):</span>
                        {{ $partner_io->partner->email }}
                    </p>
                </td>
                <td class="w-30" style="float: inline-end">
                    <h4 class="pb-7">@lang('index.order_info'):</h4>
                    <p class="pb-7 rgb-71">
                        <span class="">@lang('index.gst_no'):</span>
                        {{ $partner_io->partner->gst_no }}
                    </p> 
                    <p class="pb-7 rgb-71">
                        <span class="">@lang('index.ecc_no'):</span>
                        {{ $partner_io->partner->ecc_no }}
                    </p>
                    <p class="pb-7 rgb-71">
                        <span class="">@lang('index.inward_date'):</span>
                        {{ !empty($partner_io->inward_date) ? date('d-m-Y', strtotime($partner_io->inward_date)) : '' }}
                    </p> 
                    <p class="pb-7 rgb-71">
                        <span class="">@lang('index.inward_notes'):</span>
                        {{ $partner_io->notes}}
                    </p>
                    <p class="pb-7 rgb-71">
                        <span class="">@lang('index.delivery_address'):</span>
                        {{ $partner_io->d_address }}
                    </p>
                </td>
            </tr>
        </table>
        <table class="w-100 mt-20 order_details" style="border: 1px solid #000;">
            <thead class="b-r-3">
                <tr>
                    <th class="w-5 text-start" style="border:1px solid #000;">@lang('index.sn')</th>
                    <th class="w-5 text-start" style="border:1px solid #000;">@lang('index.po_no')</th>
                    <th class="w-15 text-start" style="border:1px solid #000;">@lang('index.date')</th>
                    <th class="w-20 text-start" style="border:1px solid #000;">@lang('index.type')</th>
                    <th class="w-30 text-start" style="border:1px solid #000;">@lang('index.category')</th>
                    <th class="w-5 text-center" style="border:1px solid #000;">@lang('index.instrument_name') (Code)</th>
                    <th class="w-5 text-center" style="border:1px solid #000;">@lang('index.quantity')</th>
                    <th class="w-15 text-center" style="border:1px solid #000;">@lang('index.remarks')</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @if(isset($partner_io_detail) && $partner_io_detail->count())
                    @php 
                        $ins_category = \App\InstrumentCategory::where('id',$partner_io_detail->ins_category)->first();
                        $instrument = \App\Instrument::where('id',$partner_io_detail->ins_name)->first();
                    @endphp
                    <tr class="rowCount" data-id="{{ $partner_io_detail->id }}">
                        <td class="width_1_p" style="border:1px solid #000;">
                            <p class="set_sn">{{ $i++ }}</p>
                        </td>
                        <td class="text-start" style="border:1px solid #000;">{{ $partner_io->reference_no .'/'. $partner_io_detail->line_item_no }}
                        </td>
                        <td class="text-start" style="border:1px solid #000;">{{ date('d-m-Y', strtotime($partner_io->io_date)) }}</td>
                        @if($partner_io_detail->type == '1')
                        <td class="text-start" style="border:1px solid #000;">Gauges/Checking Instruments</td>
                        @else
                        <td class="text-start" style="border:1px solid #000;">Measuring Instruments</td>
                        @endif
                        <td class="text-start" style="border:1px solid #000;">{{ $ins_category->category ?? 'N/A' }}</td>
                        <td class="text-start" style="border:1px solid #000;">{{ $instrument->instrument_name }}</td>
                        <td class="text-start" style="border:1px solid #000;">{{ $partner_io_detail->qty ?? 'N/A' }}</td>
                        <td class="text-start" style="border:1px solid #000;">{{ $partner_io_detail->remarks ?? 'N/A' }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
         <table class="file_extension">
            <tr>
                <td valign="top" class="w-50">
                    <div class="pt-20">
                        <h4 class="d-block pb-20">File</h4>
                        <div class="">
                        @if (isset($partner_io->file) && $partner_io->file)
                            @php
                                 $files = json_decode($partner_io->file, true);
                            @endphp

                            @if(is_array($files))
                                @foreach ($files as $file)
                                    @php
                                        $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                    @endphp

                                    @if ($fileExtension === 'pdf')
                                        <a class="text-decoration-none"
                                            href="{{ $baseURL }}uploads/partner_io/{{ $file }}"
                                            target="_blank">
                                            <img src="{{ $baseURL }}assets/images/pdf.png"
                                                alt="PDF Preview" class="img-thumbnail mx-2"
                                                width="25px">
                                        </a>
                                    @elseif (in_array($fileExtension, ['doc', 'docx']))
                                        <a class="text-decoration-none"
                                            href="{{ $baseURL }}uploads/partner_io/{{ $file }}"
                                            target="_blank">
                                            <img src="{{ $baseURL }}assets/images/word.png"
                                                alt="Word Preview" class="img-thumbnail mx-2"
                                                width="25px">
                                        </a>
                                    @else
                                        <a class="text-decoration-none"
                                            href="{{ $baseURL }}uploads/partner_io/{{ $file }}"
                                            target="_blank">
                                            <img src="{{ $baseURL }}uploads/partner_io/{{ $file }}"
                                                alt="File Preview" class="img-thumbnail mx-2"
                                                width="50px">
                                        </a>
                                    @endif
                                @endforeach
                            @endif
                        @endif
                    </div>

                    </div>
                </td>
            </tr>
        </table>
    </div>
    <script src="{{ $baseURL . ('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ $baseURL . ('frequent_changing/js/onload_print.js') }}"></script>
</body>

</html>