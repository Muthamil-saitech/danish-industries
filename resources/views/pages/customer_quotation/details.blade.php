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
    <link rel="stylesheet" href="{{ getBaseURL() }}frequent_changing/css/pdf_common.css">
    <section class="main-content-wrapper">
        @include('utilities.messages')
        <section class="content-header">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="top-left-header">@lang('index.quotation_info')</h2>
                </div>
                <div class="col-md-6">
                    <a href="javascript:void();" target="_blank" class="btn bg-second-btn print_invoice"
                        data-id="{{ $obj->id }}"><iconify-icon icon="solar:printer-broken"></iconify-icon>
                        @lang('index.print')</a>
                    <a href="{{ route('download-customer-quotation', encrypt_decrypt($obj->id, 'encrypt')) }}" target="_blank"
                        class="btn bg-second-btn print_btn"><iconify-icon icon="solar:cloud-download-broken"></iconify-icon>
                        @lang('index.download')</a>
                    <a class="btn bg-second-btn" href="{{ route('quotation.index') }}"><iconify-icon
                            icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
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
                                        <p class="pb-7 rgb-71">@lang('index.website') : {{ getCompanyInfo()->website }}
                                        </p>
                                    </td>
                                    <td class="w-50 text-right">
                                        <img src="{!! getBaseURL() .
                                            (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png') !!}" alt="site-logo">
                                    </td>
                                </tr>
                            </table>
                            <div class="text-center pt-10 pb-10">
                                <h2 class="color-000000 pt-20 pb-20">@lang('index.quotation_deatails')</h2>
                            </div>
                            <table>
                                <tr>
                                    <td class="w-50">
                                        <h4 class="pb-7">@lang('index.customer_info'):</h4>
                                        <p class="pb-7">{{ $obj->customer->name }}</p>
                                        <p class="pb-7 rgb-71">{{ $obj->customer->phone }}</p>
                                        <p class="pb-7 rgb-71">{{ $obj->customer->address }}</p>
                                    </td>
                                    <td class="w-50 text-right">
                                        <h4 class="pb-7">@lang('index.quotation_info'):</h4>
                                        <p class="pb-7">
                                            <span class="f-w-600">@lang('index.quotation_no'):</span>
                                            {{ $obj->quotation_no }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class="f-w-600">@lang('index.quote_date'):</span>
                                            {{ getDateFormat($obj->quote_date) }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <table class="w-100 mt-20">
                                <thead class="b-r-3 bg-color-000000">
                                    <tr>
                                        <th class="w-5 text-start">@lang('index.sn')</th>
                                        <th class="w-30 text-start">@lang('index.part_name')(@lang('index.part_no'))</th>
                                        <th class="w-15 text-center">@lang('index.unit_price')</th>
                                        <th class="w-15 text-center">@lang('index.quantity')</th>
                                        <th class="w-20 text-right pr-5">@lang('index.total')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @if (isset($quotation_details) && $quotation_details)
                                        @foreach ($quotation_details as $key => $value)
                                            <?php
                                            $i++;
                                            $productInfo = getFinishedProductInfo($value->product_id);
                                            ?>
                                            <tr class="rowCount" data-id="{{ $productInfo->id }}">
                                                <td class="width_1_p">{{ $i }}</td>
                                                <td class="text-start">{{ $productInfo->name }}({{ $productInfo->code }})</td>
                                                <td class="text-center">{{ $setting->currency }}{{ $value->unit_price }}</td>
                                                <td class="text-center">{{ $value->quantity }}</td>
                                                <td class="text-end">{{ $setting->currency }}{{ $value->total }}</td>
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
                                        <table>
                                            <tr>
                                                <td class="w-50">
                                                    <p class="f-w-600">@lang('index.subtotal')</p>
                                                </td>
                                                <td class="w-50 text-right pr-0">
                                                    <p>{{ $setting->currency }}{{ safe_integer($obj->subtotal) }} </p>
                                                </td>
                                            </tr>
                                        </table>
                                        <table>
                                            <tr>
                                                <td class="w-50">
                                                    <p class="f-w-600">@lang('index.other')</p>
                                                </td>
                                                <td class="w-50 text-right pr-0">
                                                    <p>{{ $setting->currency }}{{ safe_integer($obj->other) }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                        <table>
                                            <tr>
                                                <td class="w-50">
                                                    <p class="f-w-600">Without Material</p>
                                                </td>
                                                <td class="w-50 text-right pr-0">
                                                    <p>{{ $setting->currency }}{{ safe_integer($obj->discount) }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="mt-10 mb-10">
                                            <tr>
                                                <td class="w-50 border-top-dotted-gray border-bottom-dotted-gray">
                                                    <p class="f-w-600">@lang('index.grand_total') :</p>
                                                </td>
                                                <td class="w-50 text-right pr-0">
                                                    <p>{{ $setting->currency }}{{ safe_integer($obj->grand_total) }} </p>
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
    <?php
    $baseURL = getBaseURL();
    ?>
    <script src="{!! $baseURL . 'frequent_changing/js/customer_quotation.js' !!}"></script>
@endsection
