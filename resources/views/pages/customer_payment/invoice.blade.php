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
<link rel="stylesheet" href="{{ getBaseURL() . 'frequent_changing/css/pdf_common.css' }}">
<link rel="stylesheet" href="{{ getBaseURL() . 'assets/dist/css/lightbox.min.css' }}">
<section class="main-content-wrapper">
    @include('utilities.messages')
    <section class="content-header">
        <div class="row">
            <div class="col-md-6">
                <h2 class="top-left-header">@lang('index.customer_payment_invoice')</h2>
            </div>
            <div class="col-md-6">
                {{-- <a href="javascript:void();" target="_blank" class="btn bg-second-btn print_invoice"
                            data-id="{{ $obj->id }}"><iconify-icon icon="solar:printer-broken"></iconify-icon>
                @lang('index.print')</a> --}}
                <a class="btn bg-second-btn" href="{{ route('customer-payment.index') }}"><iconify-icon
                        icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="col-md-12">
            <div class="card" id="dash_0">
                <div class="card-body p30">
                    <div class="m-auto b-r-5">
                        {{-- <table>
                                <tr>
                                    <td class="w-50">
                                        <h3 class="pb-7">{{ getCompanyInfo()->company_name }}</h3>
                        <p class="pb-7 rgb-71">{{ safe(getCompanyInfo()->address) }}</p>
                        <p class="pb-7 rgb-71">@lang('index.email') : {{ safe(getCompanyInfo()->email) }}</p>
                        <p class="pb-7 rgb-71">@lang('index.phone') : {{ safe(getCompanyInfo()->phone) }}</p>
                        <p class="pb-7 rgb-71">@lang('index.website') : {{ safe(getCompanyInfo()->web_site) }}
                        </p>
                        </td>
                        <td class="w-50 text-right">
                            <img src="{!! getBaseURL() .
                                            (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png') !!}" alt="site-logo">
                        </td>
                        </tr>
                        </table> --}}
                        {{-- <div class="text-center pt-10 pb-10">
                                <h2 class="color-000000 pt-20 pb-20">@lang('index.customer_payment_invoice')</h2>
                            </div> --}}
                        <table>
                            <tr>
                                <td class="w-50">
                                    <img src="{!! getBaseURL() . (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png') !!}" alt="Logo Image" class="img-fluid mb-2">
                                    <h4 class="pb-7">@lang('index.customer_info'):</h4>
                                    <p class="pb-7 arabic">{{ $obj->customer->name }}</p>
                                    <p class="pb-7 rgb-71 arabic">{{ $obj->customer->address }}</p>
                                    <p class="pb-7 rgb-71 arabic">{{ $obj->customer->phone }}</p>
                                </td>
                                <td class="w-50 text-right">
                                    <h4 class="pb-7">@lang('index.order_info'):</h4>
                                    <p class="pb-7">
                                        <span class="">@lang('index.po_no'):</span>
                                        {{ $obj->reference_no }}
                                    </p>
                                    <p class="pb-7 rgb-71">
                                        <span class="">@lang('index.order_date'):</span>
                                        {{ getDateFormat($customer_inv->invoice_date) }}
                                    </p>
                                    <p class="pb-7 rgb-71">
                                        <span class="">@lang('index.total_amount'):</span>
                                        {{ getAmtCustom($customer_inv->amount) }}
                                    </p>
                                </td>
                            </tr>
                        </table>
                        <table class="w-100 mt-20">
                            <thead class="b-r-3 bg-color-000000">
                                <tr>
                                    <th class="w-5 text-start">@lang('index.sn')</th>
                                    <th class="w-15 text-start">@lang('index.payment_date')</th>
                                    {{-- <th class="w-20 text-start">@lang('index.customer_name')<br>(@lang('index.code'))</th> --}}
                                    <th class="w-15 text-start">@lang('index.paid_amount')</th>
                                    {{-- <th class="w-15 text-start">@lang('index.balance_amount')</th> --}}
                                    <th class="w-15 text-start">@lang('index.payment_type')</th>
                                    <th class="w-15 text-start">@lang('index.payment_img')</th>
                                    <th class="w-15 text-start">@lang('index.note')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                ?>
                                @if(isset($customer_due_entries) && $customer_due_entries->isNotEmpty())
                                @foreach($customer_due_entries as $customer_due)
                                <tr class="rowCount" data-id="{{ $customer_due->id }}">
                                    <td class="width_1_p">
                                        <p class="set_sn">{{ $i++ }}</p>
                                    </td>
                                    <td class="text-start">
                                        {{ getDateFormat($customer_due->created_at) }}
                                    </td>
                                    {{-- <td class="text-start arabic">{{ $customer_due->customerName->name }}<br><small>({{ getCustomerCodeById($customer_due->customerName->id) }})</small></td> --}}
                                    <td class="text-start">{{ getAmtCustom($customer_due->pay_amount) }}
                                    </td>
                                    {{-- <td class="text-start">{{ getAmtCustom($customer_due->balance_amount) }}
                                    </td> --}}
                                    <td class="text-start">{{ $customer_due->payment_type }}
                                    </td>
                                    <td class="text-start">
                                        @if($customer_due->payment_proof)
                                        {{-- <a class="text-decoration-none"
                                                        href="{{ $baseURL }}uploads/customer_due/{{ $customer_due->payment_proof }}"
                                        target="_blank">
                                        <img src="{{ $baseURL }}uploads/customer_due/{{ $customer_due->payment_proof }}"
                                            alt="File Preview" class="img-thumbnail mx-2"
                                            width="100px">
                                        </a> --}}
                                        <a class="text-decoration-none"
                                            href="{{ $baseURL }}uploads/customer_due/{{ $customer_due->payment_proof }}"
                                            data-lightbox="payment-proof"
                                            data-title="Payment Proof">
                                            <img src="{{ $baseURL }}uploads/customer_due/{{ $customer_due->payment_proof }}"
                                                alt="File Preview" class="img-thumbnail mx-2"
                                                width="50px">
                                        </a>
                                        @endif
                                    </td>
                                    <td class="text-start" title="{{ $customer_due->note }}">{{ substr_text($customer_due->note,20) }}
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr class="rowCount">
                                    <td colspan="7" class="text-center">No Data Found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        {{-- <table>
                                <tr>
                                    <td valign="top" class="w-50">
                                        
                                    </td>
                                    <td class="w-50">
                                        <table>
                                            <tr>
                                                <td class="w-50">
                                                    <p class="f-w-600">Total Amount</p>
                                                </td>
                                                <td class="w-50 text-right pr-0">
                                                    <p>{{ getAmtCustom($customer_inv->amount) }}</p>
                        </td>
                        </tr>
                        </table>
                        <table>
                            <tr>
                                <td class="w-50">
                                    <p class="f-w-600">Paid Amount</p>
                                </td>
                                <td class="w-50 text-right pr-0">
                                    <p>{{ getAmtCustom($customer_inv->paid_amount) }}</p>
                                </td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td class="w-50">
                                    <p class="f-w-600">Balance Amount</p>
                                </td>
                                <td class="w-50 text-right pr-0">
                                    <p>{{ getAmtCustom($customer_inv->due_amount) }}</p>
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
                        </table> --}}
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
<script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/addRMPurchase.js' !!}"></script>
<script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/supplier.js' !!}"></script>
<script src="{!! $baseURL . 'frequent_changing/js/customer_payment.js' !!}"></script>
<script src="{!! $baseURL . 'assets/dist/js/lightbox.min.js' !!}"></script>
@endsection