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
                    @if (routePermission('supplier.index'))
                        <a class="btn bg-second-btn" href="{{ route('suppliers.index') }}"><iconify-icon
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
                                <h2 class="color-000000 pt-20 pb-20">@lang('index.supplier_details')</h2>
                            </div>
                            <table>
                                <tr>
                                    <td class="w-50">
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.supplier_id'):</strong></span>
                                            {{ $obj->supplier_id }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.supplier_name'):</strong></span>
                                            {{ $obj->name }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.phone'):</strong></span>
                                            {{ $obj->phone }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.email'):</strong></span>
                                            {{ $obj->email }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.address'):</strong></span>
                                            {{ $obj->address }}
                                        </p>
                                        {{-- <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.contact_person'):</strong></span>
                                            {{ $obj->contact_person }}
                                        </p> --}}
                                    </td>
                                    <td class="w-50" style="float: inline-end">
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.gst_no'):</strong></span>
                                            {{ $obj->gst_no }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.ecc_no'):</strong></span>
                                            {{ $obj->ecc_no }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.landmark'):</strong></span>
                                            {{ $obj->area }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.created_on'):</strong></span>
                                            {{ getDateFormat($obj->created_at) }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.created_by'):</strong></span>
                                            {{ getUserName($obj->added_by) }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class=""><strong>@lang('index.note'):</strong></span>
                                            {{ $obj->note }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <div class="text-center pt-10 pb-10">
                                <h3 class="color-000000 pt-20 pb-20">Supplier Contact Info</h3>
                            </div>
                            <table>
                                @if(isset($supplier_contact_details) && count($supplier_contact_details) > 0)
                                    <thead>
                                        <tr>
                                            <th>@lang('index.sn')</th>
                                            <th>Contact Person Name</th>
                                            <th>Department</th>
                                            <th>Designation</th>
                                            <th>Phone Number</th>
                                            <th>Email</th>
                                            <th>Created On</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($supplier_contact_details as $contact)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $contact->scp_name!='' ? $contact->scp_name : 'N/A' }}</td>
                                                <td>{{ $contact->scp_department!='' ? $contact->scp_department : 'N/A' }}</td>
                                                <td>{{ $contact->scp_designation!='' ? $contact->scp_designation : 'N/A' }}</td>
                                                <td>{{ $contact->scp_phone!='' ? $contact->scp_phone : 'N/A' }}</td>
                                                <td>{{ $contact->scp_email!='' ? $contact->scp_email : 'N/A' }}</td>
                                                <td>{{ $contact->created_at!='' ? getDateFormat($contact->created_at) : 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">No data found</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
