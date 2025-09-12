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
                        <a class="btn bg-second-btn" href="{{ route('partner_io.index') }}"><iconify-icon
                                icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
                </div>
            </div>
        </section>

        <section class="content">

            <div class="col-md-12">
                <div class="card" id="dash_0">
                    <div class="card-body p30">
                        <div class="m-auto b-r-5">
                            <div class="text-center pt-10 pb-10">
                                <h3 class="color-000000 pt-20 pb-20">Partner Details</h3>
                            </div>
                            <table>
                                <tr>
                                    <td class="w-50">
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>Partner Code:</strong></span>
                                            P001
                                        </p> 
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>Partner Name:</strong></span>
                                            Malini
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.phone'):</strong></span>
                                            7894561230
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.email'):</strong></span>
                                            malini@gmail.com
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.address'):</strong></span>
                                            Anna nagar
                                        </p>
                                         <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.contact_person'):</strong></span>
                                            Prakash
                                        </p>
                                    </td>
                                    <td class="w-50 text-right">
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.gst_no'):</strong></span>
                                            33AAACT7409H1ZH
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.ecc_no'):</strong></span>
                                            
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.landmark'):</strong></span>
                                           
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.created_on'):</strong></span>
                                            12-09-2025
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.created_by'):</strong></span>
                                            Admin
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.note'):</strong></span>
                                            
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <div class="text-center pt-10 pb-10">
                                <h3 class="color-000000 pt-20 pb-20">Partner Order Details</h3>
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>@lang('index.sn')</th>
                                        <th>@lang('index.reference_no')</th>
                                        <th>@lang('index.type')</th>
                                        <th>@lang('index.category')</th>
                                        <th>@lang('index.instrument_name') (Code)</th>
                                        <th>@lang('index.quantity')</th>
                                        <th>@lang('index.remarks')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>P001/1</td>
                                        <td>Gauges/Checking Instruments	</td>
                                        <td>Plug Gauge</td>
                                        <td>Caliper (10001)</td>
                                        <td>5</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>P001/2</td>
                                        <td>Gauges/Checking Instruments	</td>
                                        <td>Vernier Caliper (10002)</td>
                                        <td>Bore Gauge</td>
                                        <td>5</td>
                                        <td>-</td>
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
