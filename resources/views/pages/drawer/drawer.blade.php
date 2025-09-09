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
        <div class="row">
            <div class="col-md-6">
                <h2 class="top-left-header">{{ isset($title) && $title ? $title : '' }}</h2>
                <input type="hidden" class="datatable_name" data-title="{{ isset($title) && $title ? $title : '' }}"
                    data-id_name="datatable">
            </div>
            <div class="col-md-6 text-end">
                <h5 class="mb-0">Total Drawings: {{ $total_drawers }} </h5>
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
                            <th class="ir_w_1"> @lang('index.sn')</th>
                            <th class="ir_w_16">@lang('index.drawer_no')</th>
                            <th class="ir_w_16">@lang('index.revision_no')</th>
                            <th class="ir_w_16">@lang('index.revision_date')</th>
                            <th class="ir_w_25">@lang('index.drawer_loc')</th>
                            {{-- <th class="ir_w_25">@lang('index.program_code')</th> --}}
                            <th class="ir_w_25">@lang('index.draw_img')</th>
                            {{-- <th class="ir_w_25">Tools/Gauges List</th> --}}
                            <th class="ir_w_1 ir_txt_center">@lang('index.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($obj && !empty($obj))
                        @endif
                        @foreach ($obj as $value)
                        <tr>
                            <td class="ir_txt_center">{{ $loop->iteration }}</td>
                            <td>{{ $value->drawer_no }}</td>
                            <td>{{ $value->revision_no }}</td>
                            <td>{{ getDateFormat($value->revision_date) }}</td>
                            <td>{{ $value->drawer_loc }}</td>
                            {{-- <td><span title="{{ $value->program_code }}">{{ substr_text($value->program_code,20) }}</span></td> --}}
                            <td class="ir_txt_center">@if($value->drawer_img!='')<img src="{{ $baseURL }}uploads/drawer/{{ $value->drawer_img }}" alt="Drawer Image" class="img-thumbnail mx-2" width="100px"></a>@endif</td>
                            {{-- <td><span title="{{ $value->notes }}">{{ substr_text($value->notes,20) }}</span></td> --}}
                            <td class="text-start">
                                @if (routePermission('drawers.edit'))
                                <a href="{{ url('drawers') }}/{{ encrypt_decrypt($value->id, 'encrypt') }}/edit" class="button-success"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="@lang('index.edit')"><i class="fa fa-edit tiny-icon"></i></a>
                                @endif
                                @if (routePermission('drawers.delete') && !$value->used_in_manufacture)
                                <a href="#" class="delete button-danger"
                                    data-form_class="alertDelete{{ $value->id }}" type="submit"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.delete')">
                                    <form action="{{ route('drawers.destroy', $value->id) }}"
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