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
                <h5 class="mb-0">Total Materials: {{ $total_materials }} </h5>
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
                            <th class="width_10_p">@lang('index.material_code')</th>
                            <th class="width_20_p">@lang('index.raw_material_name')</th>
                            <th class="width_20_p">@lang('index.mat_type')</th>
                            <th class="width_20_p">@lang('index.material_category')</th>
                            {{-- <th class="width_20_p">@lang('index.ins_type')</th> --}}
                            <th class="width_10_p">@lang('index.diameter')</th>
                            {{-- <th class="width_10_p">@lang('index.heat_no')</th> --}}
                            <th class="width_10_p">Old Material No</th>
                            <th class="width_10_p">@lang('index.remarks')</th>
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
                            <td>{{ $value->code }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ getMatTypeName($value->mat_type_id) }}</td>
                            <td>{{ getCategoryById($value->category) }}</td>
                            {{-- <td>@if($value->insert_type == "1")
                                        Consumable
                                    @elseif($value->insert_type == "2")
                                        Non Consumable
                                    @else
                                        N/A
                                    @endif</td> --}}
                            <td>{{ $value->diameter!=0 ? $value->diameter : 'N/A'  }}</td>
                            {{-- <td>{{ safe($value->heat_no) }}</td> --}}
                            <td><span title="{{ $value->old_mat_no }}">{{ $value->old_mat_no != '' ? substr_text($value->old_mat_no,20) : 'N/A' }}</span></td>
                            <td><span title="{{ $value->remarks }}">{{ $value->remarks != '' ? substr_text($value->remarks,20) : 'N/A' }}</span></td>
                            <td class="text-start">
                                @if (routePermission('rm.edit'))
                                <a href="{{ url('rawmaterials') }}/{{ encrypt_decrypt($value->id, 'encrypt') }}/edit"
                                    class="button-success" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="@lang('index.edit')"><i class="fa fa-edit tiny-icon"></i></a>
                                @endif
                                @if (routePermission('rm.delete') && !$value->used_in_product)
                                <a href="#" class="delete button-danger"
                                    data-form_class="alertDelete{{ $value->id }}" type="submit"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.delete')">
                                    <form action="{{ route('rawmaterials.destroy', $value->id) }}"
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