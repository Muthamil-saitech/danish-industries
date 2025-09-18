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
                    @if (routePermission('partner_io.print-customer-io'))
                    <a href="javascript:void();"  class="btn bg-second-btn print_invoice"
                        data-id="{{ isset($customer_io) ? $customer_io->id : '' }}"><iconify-icon icon="solar:printer-broken"></iconify-icon>
                        @lang('index.print')</a>
                    @endif
                    @if(routePermission('customer_io.download-customer-io'))
                    <a href="{{ route('customer-io-download', encrypt_decrypt($customer_io->id, 'encrypt')) }}"
                        target="_blank" class="btn bg-second-btn print_btn"><iconify-icon
                            icon="solar:cloud-download-broken"></iconify-icon>
                        @lang('index.download')</a>
                    @endif
                    @if (routePermission('customer_io.index'))
                    <a class="btn bg-second-btn" href="{{ route('customer_io.index') }}"><iconify-icon
                            icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
                    @endif
                </div>
            </div>
        </section>

        <section class="content">
            <div class="col-md-12">
                <div class="card" id="dash_0">
                    <div class="card-body p30">
                        <div class="m-auto b-r-5">
                            <div class="text-center pt-10 pb-10">
                                <h3 class="color-000000 pt-20 pb-20">@lang('index.customer_io_details')</h3>
                            </div>
                            <table>
                                <tr>
                                    <td class="w-50">
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.customer_code'):</strong></span>
                                            {{ $customer_io->customer->customer_id }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.customer_name'):</strong></span>
                                            {{ $customer_io->customer->name }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.phone_number'):</strong></span>
                                            {{ $customer_io->customer->phone }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.email'):</strong></span>
                                            {{ $customer_io->customer->email ? $customer_io->customer->email : 'N/A' }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.delivery_address'):</strong></span>
                                            {{ $customer_io->d_address }}
                                        </p> 
                                    </td>
                                    <td class="w-50" style="float: inline-end">
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.gst_no'):</strong></span>
                                            {{ $customer_io->customer->gst_no }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.ecc_no'):</strong></span>
                                            {{ $customer_io->customer->ecc_no }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.status'):</strong></span>
                                            @if($customer_io->status == 'Inward')
                                            <span class="badge bg-secondary">Inward</span>
                                            @else
                                            <span class="badge bg-success">Outward</span>
                                            @endif
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span><strong>@lang('index.inward_date'):</strong></span>
                                            {{ !empty($customer_io->inward_date) ? date('d-m-Y', strtotime($customer_io->inward_date)) : '' }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.inward_notes'):</strong></span>
                                            {{ $customer_io->notes}}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            @if(isset($customer_io->file) && $customer_io->file != '')
                                <div class="pt-10 pb-10">
                                    <div class="text-left">
                                        <h3 class="pt-20 pb-20">Documents</h3>
                                        <div class="d-flex flex-wrap gap-3">
                                            @php
                                                $files = json_decode($customer_io->file, true);
                                            @endphp

                                            @if(is_array($files))
                                                @foreach($files as $file)
                                                    @php
                                                        $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                    @endphp

                                                    @if(in_array($fileExtension, ['pdf']))
                                                        <a class="text-decoration-none" href="{{ url('uploads/customer_io/' . $file) }}" target="_blank">
                                                            <img src="{{ url('assets/images/pdf.png') }}" alt="PDF Preview" class="img-thumbnail mx-2" width="100">
                                                        </a>
                                                    @elseif(in_array($fileExtension, ['doc', 'docx']))
                                                        <a class="text-decoration-none" href="{{ url('uploads/customer_io/' . $file) }}" target="_blank">
                                                            <img src="{{ url('assets/images/word.png') }}" alt="Word Preview" class="img-thumbnail mx-2" width="100">
                                                        </a>
                                                    @else
                                                        <a class="text-decoration-none" href="{{ url('uploads/customer_io/' . $file) }}" target="_blank">
                                                            <img src="{{ url('uploads/customer_io/' . $file) }}" alt="File Preview" class="img-thumbnail mx-2" width="100">
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
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
                                        <th>@lang('index.remarks')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1; ?>
                                @if(isset($customer_io_details) && $customer_io_details->count())
                                @foreach($customer_io_details as $detail)
                                @php 
                                    $ins_category = \App\InstrumentCategory::where('id',$detail->ins_category)->first();
                                    $instrument = \App\Instrument::where('id',$detail->ins_name)->first();
                                @endphp
                                        <tr class="rowCount" data-id="{{ $detail->id }}">
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $customer_io->po_no .'/'. $customer_io->line_item_no }}</td>
                                            <td>{{ date('d-m-Y', strtotime($customer_io->date)) }}</td>
                                            @if($detail->type == '1')
                                                <td>Gauges/Checking Instruments</td>
                                            @else
                                                <td>Measuring Instruments</td>
                                            @endif
                                            <td>{{ $ins_category->category ?? 'N/A' }}</td>
                                            <td>{{ $instrument->instrument_name }}</td>
                                            <td>{{ $detail->qty ?? 'N/A' }}</td>
                                            <td>{{ $detail->remarks ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
@section('script')
<script src="{!! $baseURL . 'assets/datatable_custom/jquery-3.3.1.js' !!}"></script>
<script>
$(document).ready(function () {
    $(document).on("click", ".print_invoice", function () {
        console.log("test");
        viewChallan($(this).attr("data-id"));
    });
    function viewChallan(id) {
        let base_url = $("#hidden_base_url").val();
        open(
            base_url + "customer-io-print/" + id,
            "Print Customer IO",
            "width=1600,height=550"
        );
        newWindow.focus();
        newWindow.onload = function () {
            newWindow.document.body.insertAdjacentHTML("afterbegin");
        };
    }
});
</script>
@endsection
