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
                <div class="col-md-6">
                        <a class="btn bg-second-btn" href="{{ route('customer_io.index') }}">
                            <iconify-icon icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
                </div>
            </div>
        </section>

        <section class="content">

            <div class="col-md-12">
                <div class="card" id="dash_0">
                    <div class="card-body p30">
                        <div class="m-auto b-r-5">
                            <div class="text-center pt-10 pb-10">
                                <h2 class="color-000000 pt-20 pb-20">@lang('index.customer_io_details')</h2>
                            </div>
                            <table>
                                <tr>
                                    <td class="w-50">
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.customer_code'):</strong></span>
                                            CUS001
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.customer_type'):</strong></span>
                                            Wholesale
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.customer_name'):</strong></span>
                                            Malini
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.phone'):</strong></span>
                                            7419632580
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.email'):</strong></span>
                                            malini@gmail.com
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.delivery_address'):</strong></span>
                                            41/A, Anna Nagar, Madurai
                                        </p>
                                    </td>
                                    <td class="w-50" style="float: inline-end">
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.gst_no'):</strong></span>33AAACT7409H1ZH
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.ecc_no'):</strong></span>
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.landmark'):</strong></span>
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.created_on'):</strong></span>
                                            13-09-2025
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.created_by'):</strong></span>
                                            Admin
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.note'):</strong></span>
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.status'):</strong></span>
                                            <span class="badge bg-secondary">Inward</span>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <div class="text-center pt-10 pb-10">
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>@lang('index.sn')</th>
                                        <th>@lang('index.po_no')</th>
                                        <th>@lang('index.date')</th>
                                        <th>@lang('index.type')</th>
                                        <th>@lang('index.category')</th>
                                        <th>@lang('index.instrument_name') (Code)</th>
                                        <th>@lang('index.quantity')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>6500150191/1</td>
                                        <td>13-09-2025</td>
                                        <td>Gauges/Checking Instruments	</td>
                                        <td>Plug Gauge</td>
                                        <td>Micrometer Screw Gauge(INS001)</td>
                                        <td>5</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>6500150191/1</td>
                                        <td>13-09-2025</td>
                                        <td>Measuring Instruments</td>
                                        <td>Vernier Caliper</td>
                                        <td>Digital Multimeter(INS002)</td>
                                        <td>5</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
