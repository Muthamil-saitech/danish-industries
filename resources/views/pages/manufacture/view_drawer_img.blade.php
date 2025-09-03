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
        {{-- <section class="content-header">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="top-left-header">{{ isset($title) && $title ? $title : '' }}</h2>
                </div>
            </div>
        </section> --}}
        <section class="content">
            <h5 class="text-center mb-3">{{ isset($title) && $title ? $title : '' }}</h5>
            <div class="row">
                @if (isset($drawer) && $drawer->drawer_img)
                    <div class="col-md-12 text-center">
                        <img src="{{ $baseURL }}uploads/drawer/{{ $drawer->drawer_img }}" alt="Drawer Image" class="img-fluid" width="400px;"> 
                    </div>
                    {{-- <div class="col-md-6 text-left">
                        <p class="text-muted"><strong>Drawer No :</strong> {{ $drawer->drawer_no }}</p>
                    </div> --}}
                @else
                    <div class="col-12">
                        <p class="text-center text-danger">No Image Available!</p>
                    </div>
                @endif
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