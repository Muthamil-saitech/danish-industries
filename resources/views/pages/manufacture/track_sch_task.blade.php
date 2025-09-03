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
            </div>
        </section>
        <section class="content">
            <div class="col-md-12">
                <div class="card" id="dash_0">
                    <div class="card-body p30">
                        <div class="m-auto b-r-5">
                            <h5>Production Scheduling</h5>
                            <div class="row mt-4">
                                @if (isset($productionScheduling) && $productionScheduling)
                                    <?php $k = 1; ?>
                                    @foreach ($productionScheduling as $key => $value)
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100 border shadow">
                                                <div class="card-body">
                                                    <h6 class="card-title text-muted">Stage {{ $k++ }} - {{ getProductionStages($value->production_stage_id) }}</h6>
                                                    <p class="mb-1"><strong>@lang('index.task'):</strong> {{ $value->task }}</p>
                                                    <p class="mb-1"><strong>@lang('index.assign_to'):</strong> {{ getEmpCode($value->user_id) }}</p>
                                                    <p class="mb-1"><strong>@lang('index.latest_update_on'):</strong> {{ notificationDateFormat($value->created_at) }}</p>
                                                    <p class="mb-1"><strong>@lang('index.total_hours'):</strong> {{ $value->task_hours }} hrs</p>
                                                    <p class="mb-1"><strong>@lang('index.task_status'):</strong><span class="text-muted">@if($value->task_status == "1") Pending @elseif($value->task_status == "2") In Progress @else Completed @endif</span></p>
                                                    <p class="mb-1"><strong>@lang('index.start_date'):</strong> {{ getDateFormat($value->start_date) }}</p>
                                                    <p class="mb-0"><strong>@lang('index.complete_date'):</strong> {{ getDateFormat($value->end_date) }}</p>
                                                    <p class="mb-1"><strong>@lang('index.note'):</strong> {{ $value->task_note }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12">
                                        <p class="text-muted">@lang('No data available.')</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
@section('script')
    <script type="text/javascript" src="{!! $baseURL . 'assets/bower_components/gantt/js/jquery.fn.gantt.js' !!}"></script>
    <script type="text/javascript" src="{!! $baseURL . 'assets/bower_components/gantt/js/jquery.cookie.min.js' !!}"></script>
    <script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/addManufactures.js' !!}"></script>
    <script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/genchat.js' !!}"></script>
    <script src="{!! $baseURL . 'frequent_changing/js/manufacture.js' !!}"></script>
@endsection