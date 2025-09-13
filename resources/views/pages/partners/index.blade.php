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
<section class="main-content-wrapper">
    @include('utilities.messages')
    <section class="content-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="top-left-header">{{ isset($title) && $title ? $title : '' }}</h2>
                <input type="hidden" class="datatable_name" data-title="{{ isset($title) && $title ? $title : '' }}"
                    data-id_name="datatable">
            </div>
            <div class="col-md-6 text-end">
                <h5 class="mb-0">Total Partners: 2 </h5>
            </div>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <!-- /.box-header -->
            <div class="table-responsive">
                <table id="datatable" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="width_1_p">@lang('index.sn')</th>
                            <th class="width_1_p">@lang('index.partner_code')</th>
                            <th class="width_13_p">@lang('index.partner_name')</th>
                            <th class="width_10_p">@lang('index.contact_person')</th>
                            <th class="width_10_p">@lang('index.phone')</th>
                            <th class="width_10_p">@lang('index.email')</th>
                            <th class="width_10_p">@lang('index.address')</th>
                            <th class="width_10_p">@lang('index.gst_no')</th>
                            <th class="width_10_p">@lang('index.ecc_no')</th>
                            <th class="width_10_p">@lang('index.landmark')</th>
                            <th class="width_10_p">@lang('index.added_by')</th>
                            <th class="width_10_p">@lang('index.created_on')</th>
                            <th class="width_3_p ir_txt_center">@lang('index.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="c_center">1</td>
                            <td>P001</td>
                            <td>Riyan</td>
                            <td>Elakkiya</td>
                            <td>7458961231</td>
                            <td>riyan@gmail.com</td>
                            <td title="">Jaihindpuram</td>
                            <td>N/A</td>
                            <td>N/A</td>
                            <td title="">Madurai</td>
                            <td>Admin</td>
                            <td>13-09-2025</td>
                            <td class="text-start">
                                <a href="{{ url('partners.show') }}"
                                    class="button-info" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.view_details')"><i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ url('partners.create') }}"
                                    class="button-success" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="@lang('index.edit')"><i class="fa fa-edit tiny-icon"></i></a>
                                <a href="#" class="delete button-danger"
                                    data-form_class="alertDelete1" type="submit"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.delete')">
                                    <form action=""
                                        class="alertDelete1" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <i class="fa fa-trash tiny-icon"></i>
                                    </form>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="c_center">2</td>
                            <td>PARTNER002</td>
                            <td>Vinothini</td>
                            <td>Elakkiya</td>
                            <td>7569841032</td>
                            <td>vinothini@gmail.com</td>
                            <td title="">Koodal Nagar</td>
                            <td>N/A</td>
                            <td>N/A</td>
                            <td title="">Madurai</td>
                            <td>Admin</td>
                            <td>13-09-2025</td>
                            <td class="text-start">
                                <a href="{{ url('partners/show') }}"
                                    class="button-info" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.view_details')"><i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ url('partners/create') }}"
                                    class="button-success" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="@lang('index.edit')"><i class="fa fa-edit tiny-icon"></i></a>
                                <a href="#" class="delete button-danger"
                                    data-form_class="alertDelete1" type="submit"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.delete')">
                                    <form action=""
                                        class="alertDelete1" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <i class="fa fa-trash tiny-icon"></i>
                                    </form>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</section>
@endsection
@section('script')
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
@endsection