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
                    @if (routePermission('partner_io.print-partner-io'))
                    <a href="javascript:void();"  class="btn bg-second-btn print_invoice"
                        data-id="{{ isset($partner_io) ? $partner_io->id : '' }}"><iconify-icon icon="solar:printer-broken"></iconify-icon>
                        @lang('index.print')</a>
                    @endif
                    @if (routePermission('partner_io.download-partner-io'))
                    <a href="{{ route('partner-io-download', encrypt_decrypt($partner_io->id, 'encrypt')) }}"
                        target="_blank" class="btn bg-second-btn print_btn"><iconify-icon
                            icon="solar:cloud-download-broken"></iconify-icon>
                        @lang('index.download')</a>
                    @endif
                    @if (routePermission('partner_io.index'))
                    <a class="btn bg-second-btn" href="{{ route('partner_io.index') }}"><iconify-icon
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
                                <h3 class="color-000000 pt-20 pb-20">Partner I/O Details</h3>
                            </div>
                            <table>
                                <tr>
                                    <td class="w-50">
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>Partner Code:</strong></span>
                                            {{ $partner_io->partner->partner_id }}
                                        </p> 
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>Partner Name:</strong></span>
                                            {{ $partner_io->partner->name }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.phone_number'):</strong></span>
                                            {{ $partner_io->partner->phone }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.email'):</strong></span>
                                            {{ $partner_io->partner->email }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.delivery_address'):</strong></span>
                                            {{ $partner_io->d_address }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.inward_date'):</strong></span>
                                            {{ !empty($partner_io_detail->inward_date) ? date('d-m-Y', strtotime($partner_io_detail->inward_date)) : '' }}
                                        </p>
                                    </td>
                                    <td class="w-50" style="float: inline-end">
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.gst_no'):</strong></span>
                                            {{ $partner_io->partner->gst_no ?? 'N/A' }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.ecc_no'):</strong></span>
                                            {{ $partner_io->partner->ecc_no ?? 'N/A' }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.landmark'):</strong></span>
                                            {{ $partner_io->partner->area ?? 'N/A' }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.created_on'):</strong></span>
                                             {{ getDateFormat($partner_io->partner->created_at) }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.created_by'):</strong></span>
                                            {{ getUserName($partner_io->partner->added_by) }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.note'):</strong></span>
                                            {{ $partner_io->partner->note}}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.inward_notes'):</strong></span>
                                            {{ $partner_io_detail->notes}}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            @if(isset($partner_io->file) && $partner_io->file != '')
                                <div class="pt-10 pb-10">
                                    <div class="text-left">
                                        <h3 class="pt-20 pb-20">Documents</h3>
                                        <div class="d-flex flex-wrap gap-3">
                                                @php
                                                    $files = json_decode($partner_io->file, true);
                                                @endphp

                                                @foreach($files as $file)
                                                    @php
                                                        $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                                                    @endphp

                                                    @if(in_array($fileExtension, ['pdf']))
                                                        <a class="text-decoration-none" href="{{ url('uploads/partner_io/' . $file) }}" target="_blank">
                                                            <img src="{{ url('assets/images/pdf.png') }}" alt="PDF Preview" class="img-thumbnail mx-2" width="100">
                                                        </a>
                                                    @elseif(in_array($fileExtension, ['doc', 'docx']))
                                                        <a class="text-decoration-none" href="{{ url('uploads/partner_io/' . $file) }}" target="_blank">
                                                            <img src="{{ url('assets/images/word.png') }}" alt="Word Preview" class="img-thumbnail mx-2" width="100">
                                                        </a>
                                                    @else
                                                        <a class="text-decoration-none" href="{{ url('uploads/partner_io/' . $file) }}" target="_blank">
                                                            <img src="{{ url('uploads/partner_io/' . $file) }}" alt="File Preview" class="img-thumbnail mx-2" width="100">
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </div>
                                    </div>
                                </div>
                            @endif

                            <table>
                                <thead>
                                    <tr>
                                        <th>@lang('index.sn')</th>
                                        <th>@lang('index.reference_no')</th>
                                        <th>@lang('index.date')</th>
                                        <th>@lang('index.type')</th>
                                        <th>@lang('index.category')</th>
                                        <th>@lang('index.instrument_name') (Code)</th>
                                        <th>@lang('index.quantity')</th>
                                        <th>@lang('index.remarks')</th>
                                        <th>@lang('index.status')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @if(isset($partner_io_detail) && isset($partner_io))
                                    @php 
                                        $ins_category = \App\InstrumentCategory::where('id',$partner_io_detail->ins_category)->first();
                                        $instrument = \App\Instrument::where('id',$partner_io_detail->ins_name)->first();
                                    @endphp
                                        <tr class="rowCount" data-id="{{ $partner_io_detail->id }}">
                                            <td>{{ $i }}</td>
                                            <td>{{ $partner_io->reference_no .'/'. $partner_io_detail->line_item_no }}</td>
                                            <td>{{ date('d-m-Y', strtotime($partner_io->io_date)) }}</td>
                                            @if($partner_io_detail->type == '1')
                                                <td>Gauges/Checking Instruments</td>
                                            @else
                                                <td>Measuring Instruments</td>
                                            @endif
                                            <td>{{ $ins_category->category ?? 'N/A' }}</td>
                                            <td>{{ $instrument->instrument_name }}</td>
                                            <td>{{ $partner_io_detail->qty ?? 'N/A' }}</td>
                                            <td>{{ $partner_io_detail->remarks ?? 'N/A' }}</td>
                                            <td>
                                                @if($partner_io_detail->status == 'Inward')
                                                <span class="badge bg-secondary">Inward</span>
                                                @else
                                                <span class="badge bg-success">Outward</span>
                                                @endif
                                            </td>
                                        </tr>
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
            base_url + "partner-io-print/" + id,
            "Print Partner IO",
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