@extends('layouts.app')

@section('script_top')
<meta name="csrf-token" content="{{ csrf_token() }}">
<?php
$setting = getSettingsInfo();
$tax_setting = getTaxInfo();
$baseURL = getBaseURL();
?>
@endsection

@section('content')
<section class="main-content-wrapper">
    <section class="content-header">
        <h3 class="top-left-header txt-uh-82">@lang('index.generate_salary_for') : {{$obj->month}} - {{$obj->year}} </h3>
        {{-- <input type="hidden" class="datatable_name" data-title="{{ isset($title) && $title ? $title : '' }}" data-id_name="pay-table"> --}}
    </section>
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            {{Form::model($obj,['route'=>['payroll.update',$obj->id],'method'=>'put'])}}
            @include('pages/payroll/_form')
            {!! Form::close() !!}
        </div>
    </div>
</section>
@endsection
@section('script')
<script src="{!! $baseURL.'frequent_changing/js/salary.js'!!}"></script>
<script src="{!! $baseURL . 'assets/datatable_custom/jquery-3.3.1.js' !!}"></script>
<script src="{!! $baseURL . 'assets/dataTable/jquery.dataTables.min.js' !!}"></script>
<script src="{!! $baseURL . 'assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js' !!}"></script>
<script src="{!! $baseURL . 'assets/dataTable/dataTables.bootstrap4.min.js' !!}"></script>
<script src="{!! $baseURL . 'assets/dataTable/dataTables.buttons.min.js' !!}"></script>
<script src="{!! $baseURL . 'assets/dataTable/buttons.html5.min.js' !!}"></script>
<script src="{!! $baseURL . 'assets/dataTable/buttons.print.min.js' !!}"></script>
<script src="{!! $baseURL . 'assets/dataTable/jszip.min.js' !!}"></script>
<script src="{!! $baseURL . 'assets/dataTable/pdfmake.min.js' !!}"></script>
<script src="{!! $baseURL . 'assets/dataTable/vfs_fonts.js' !!}"></script>
<script src="{!! $baseURL . 'frequent_changing/newDesign/js/forTable.js' !!}"></script>
<script src="{!! $baseURL . 'frequent_changing/js/custom_report.js' !!}"></script>
<link rel="stylesheet" href="{!! $baseURL.'assets/bower_components/buttonCSS/checkBotton2.css'!!}">
@endsection