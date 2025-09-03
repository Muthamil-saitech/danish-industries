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
                <h2 class="top-left-header">@lang('index.supplier_payment_invoice')</h2>
            </div>
            <div class="col-md-6">
                {{-- <a href="javascript:void();" target="_blank" class="btn bg-second-btn print_invoice"
                            data-id="{{ $obj->id }}"><iconify-icon icon="solar:printer-broken"></iconify-icon>
                @lang('index.print')</a> --}}
                <a class="btn bg-second-btn" href="{{ route('supplier-payment.index') }}"><iconify-icon
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
                                    <img src="{!! getBaseURL() . (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png') !!}" alt="Logo Image" class="img-fluid mb-2">
                                    <h4 class="pb-7">@lang('index.supplier_info'):</h4>
                                    <p class="pb-7">{{ $supplier->name }}</p>
                                    {{-- <p class="pb-7 rgb-71">{{ $supplier->contact_person }}</p> --}}
                                    <p class="pb-7 rgb-71">{{ $supplier->phone }}</p>
                                    <p class="pb-7 rgb-71">{{ $supplier->email }}</p>
                                    <p class="pb-7 rgb-71">{{ $supplier->address }}</p>
                                </td>
                                <td class="w-50 text-right">
                                    <h4 class="pb-7">@lang('index.purchase_info'):</h4>
                                    <p class="pb-7">
                                        <span class="">@lang('index.purchase_no'):</span>
                                        {{ $obj->reference_no }}
                                    </p>
                                    <p class="pb-7 rgb-71">
                                        <span class="">@lang('index.purchase_date'):</span>
                                        {{ getDateFormat($obj->date) }}
                                    </p>
                                </td>
                            </tr>
                        </table>
                        <table class="w-100 mt-20">
                            <thead class="b-r-3 bg-color-000000">
                                <tr>
                                    <th class="w-5 text-start">@lang('index.sn')</th>
                                    <th class="w-15 text-start">@lang('index.payment_date')</th>
                                    <th class="w-15">@lang('index.paid_amount')</th>
                                    <th class="w-15">@lang('index.payment_type')</th>
                                    <th class="w-15">@lang('index.payment_img')</th>
                                    <th class="w-15">@lang('index.note')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                ?>
                                @if(isset($supplier_pay_entries) && $supplier_pay_entries->isNotEmpty())
                                @foreach($supplier_pay_entries as $supplier_pay)
                                <tr class="rowCount" data-id="{{ $supplier_pay->id }}">
                                    <td class="width_1_p">
                                        <p class="set_sn">{{ $i++ }}</p>
                                    </td>
                                    <td class="text-start">{{ getDateFormat($supplier_pay->purchase_date) }}</td>
                                    <td class="text-start">{{ getAmtCustom($supplier_pay->pay_amount) }}
                                    </td>
                                    <td class="text-start">{{ $supplier_pay->pay_type }}
                                    </td>
                                    <td class="text-start">
                                        @if($supplier_pay->payment_proof)
                                        <a class="text-decoration-none"
                                            href="{{ $baseURL }}uploads/supplier_payments/{{ $supplier_pay->payment_proof }}"
                                            data-lightbox="payment-proof"
                                            data-title="Payment Proof">
                                            <img src="{{ $baseURL }}uploads/supplier_payments/{{ $supplier_pay->payment_proof }}"
                                                alt="File Preview" class="img-thumbnail mx-2"
                                                width="50px">
                                        </a>
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td class="text-start" title="{{ $supplier_pay->note }}">{{ $supplier_pay->note ? substr_text($supplier_pay->note,20) : 'N/A' }}
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr class="rowCount" data-id="{{ $obj->id }}">
                                    <td class="width_1_p">
                                        <p class="set_sn">{{ $i++ }}</p>
                                    </td>
                                    <td class="text-start">N/A</td>
                                    <td class="text-start">{{ getAmtCustom($obj->paid) }}
                                    </td>
                                    <td class="text-start">N/A</td>
                                    <td class="text-start">N/A</td>
                                    <td class="text-start">N/A</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        {{-- <table>
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
                                <p class="f-w-600">Amount Pay</p>
                            </td>
                            <td class="w-50 text-right pr-0">
                                <p>{{ getAmtCustom($obj->amount) }}</p>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td class="w-50">
                                <p class="f-w-600">Amount Due</p>
                            </td>
                            <td class="w-50 text-right pr-0">
                                <p>{{ getAmtCustom(getSupplierDue($obj->supplier)) }}</p>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td class="w-50">
                                <p class="f-w-600">Amount Enclosed</p>
                            </td>
                            <td class="w-50 text-right pr-0">
                                <p>{{ getAmtCustom(getSupplierDue($obj->supplier)) }}</p>
                            </td>
                        </tr>
                    </table>
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
<script src="{!! $baseURL . 'frequent_changing/js/supplier_payment.js' !!}"></script>
<script src="{!! $baseURL . 'assets/dist/js/lightbox.min.js' !!}"></script>
@endsection