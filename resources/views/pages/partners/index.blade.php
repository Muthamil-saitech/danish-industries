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
                <h5 class="mb-0">Total Partners: {{ isset($obj) && $obj ? count($obj) : '-' }} </h5>
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
                            {{-- <th class="width_10_p">@lang('index.contact_person')</th> --}}
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
                         @if ($obj && !empty($obj))
                        <?php
                        $i = 1;
                        ?>
                        @endif
                        @foreach ($obj as $value)
                            <tr>
                                <td class="c_center">{{ $i++ }}</td>
                                <td>{{ $value->partner_id }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ safe($value->phone)  }}</td>
                                <td>{{ safe($value->email)  }}</td>
                                <td title="{{ $value->address }}">{{ substr_text(safe($value->address),30)  }}</td>
                                <td>{{ safe($value->gst_no)  }}</td>
                                <td>{{ safe($value->ecc_no)  }}</td>
                                <td title="{{ $value->area }}">{{ substr_text(safe($value->area),30)  }}</td>
                                <td>{{ getUserName($value->added_by) }}</td>
                                <td>{{ getDateFormat($value->created_at) }}</td>
                                <td class="text-start">
                                    <a href="{{ route('partners.show', encrypt_decrypt($value->id, 'encrypt')) }}"
                                        class="button-info" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.view_details')"><i class="fa fa-eye"></i>
                                    </a>
                                    @if (routePermission('partner.edit')) 
                                    <a href="{{ url('partners') }}/{{ encrypt_decrypt($value->id, 'encrypt') }}/edit"
                                        class="button-success" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="@lang('index.edit')"><i class="fa fa-edit tiny-icon"></i></a>
                                    @endif 
                                    @if (routePermission('partner.delete') && !$value->used_in_partner_po) 
                                    <a href="#" class="delete button-danger"
                                        data-form_class="alertDelete{{ $value->id }}" type="submit"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.delete')">
                                        <form action="{{ route('partners.destroy', $value->id) }}"
                                            class="alertDelete{{ $value->id }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <i class="fa fa-trash tiny-icon"></i>
                                        </form>
                                    </a>
                                    @endif 
                                </td>
                            </tr>
                        @endforeach
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