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
                <input type="hidden" class="datatable_name material_table" data-filter="yes"
                    data-title="{{ isset($title) && $title ? $title : '' }}">
            </div>
            <div class="col-md-6 text-end">
                <h5 class="mb-0">Total Material Stocks: {{ $total_material_stocks }} </h5>
            </div>
            {{-- <div class="col-md-6">
                    <p><b>Total Material:</b> <span class="text-danger text-bold">{{ isset($tot_mat) ? $tot_mat: 0 }} </span> | </p>
            <p><b>Total Raw Material:</b> <span class="text-danger text-bold">{{ isset($tot_raw_mat) ? $tot_raw_mat: 0 }} </span> | </p>
            <p><b>Total Insert:</b> <span class="text-danger text-bold">{{ isset($tot_ins) ? $tot_ins: 0 }}</span></p>
        </div> --}}
        </div>
        {{-- <div class="row">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                    <p><b>Consumable:</b> <span class="text-primary text-bold">{{ isset($tot_consumable) ? $tot_consumable: 0 }}</span> | </p>
        <p><b>Non Consumable:</b> <span class="text-primary text-bold">{{ isset($tot_non_cons) ? $tot_non_cons: 0 }}</span></p>
        </div>
        </div> --}}
    </section>
    <div class="box-wrapper">
        <ul class="nav nav-tabs" id="materialTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="danish-tab" data-bs-toggle="tab" data-bs-target="#danish" type="button" role="tab">Danish</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="customers-tab" data-bs-toggle="tab" data-bs-target="#customers" type="button" role="tab">Customers</button>
            </li>
        </ul>
        <div class="tab-content mt-3" id="materialTabContent">
            <div class="tab-pane fade show active" id="danish" role="tabpanel" aria-labelledby="danish-tab">
                <div class="table-responsive">
                    <table class="table table-striped material_table">
                        <thead>
                            <tr>
                                <th class="width_1_p">@lang('index.sn')</th>
                                {{-- <th class="width_10_p">@lang('index.material_category')</th> --}}
                                <th class="width_10_p">@lang('index.material_name')(@lang('index.code'))</th>
                                <th class="width_10_p">@lang('index.mat_type')</th>
                                {{-- <th class="width_10_p">@lang('index.ins_type')</th> --}}
                                <th class="width_10_p">@lang('index.customer')<br>(@lang('index.code'))</th>
                                <th class="width_10_p">@lang('index.stock')</th>
                                <th class="width_10_p">@lang('index.alter_level')</th>
                                <th class="width_10_p">@lang('index.floating_stock')</th>
                                <th class="width_10_p">@lang('index.added_by')</th>
                                <th class="width_1_p">@lang('index.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach($obj as $value)
                            @if(getStockCustomerNameById($value->customer_id) == 'Danish')
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td title="{{ getRMName($value->mat_id) }}">{{ substr_text(getRMName($value->mat_id),30) }}</td>
                                <td>
                                    @if($value->mat_type == 1)
                                    Material
                                    @elseif($value->mat_type == 2)
                                    Raw Material
                                    @else
                                    N/A
                                    @endif
                                </td>
                                {{-- <td>
                                                @if($value->ins_type == 1)
                                                    Consumable
                                                @elseif($value->ins_type == 2)
                                                    Non Consumable
                                                @else
                                                    N/A
                                                @endif
                                            </td> --}}
                                @if(!$value->customer_id)
                                <td title="{{ getStockCustomerNameById($value->customer_id) }}">{{ substr_text(getStockCustomerNameById($value->customer_id),30) }}</td>
                                @else
                                <td title="{{ getStockCustomerNameById($value->customer_id) }}">{{ substr_text(getStockCustomerNameById($value->customer_id),30) }}<br><small>({{ getCustomerCodeById($value->customer_id) }})</small></td>
                                @endif
                                <td>{{ $value->current_stock }} {{ getRMUnitById($value->unit_id) }}
                                    <div id="qty_msg"></div>
                                </td>
                                <td>{{ $value->close_qty }} {{ getRMUnitById($value->unit_id) }}</td>
                                <td>{{ $value->float_stock }} {{ getRMUnitById($value->unit_id) }}</td>
                                <td>{{ getUserName($value->added_by) }}</td>
                                <td>
                                    <a class="button-info" id="stockAdjBtn" data-bs-toggle="modal" data-id="{{ $value->id }}" data-mat_id="{{ $value->mat_id }}" data-customer_id="{{ $value->customer_id }}" data-material="{{ getRMName($value->mat_id) }}" data-bs-target="#stockAdjModal" title="Stock Adjustment"><i class="fa fa-pencil"></i></a>
                                    <a href="{{ url('material_stocks') }}/{{ encrypt_decrypt($value->id, 'encrypt') }}/stock_adjustments" class="button-info" data-bs-toggle="tooltip" data-bs-placement="top" title="View Stock Adjustments"><i class="fa fa-list"></i></a>
                                    @if (routePermission('material_stocks.edit') && !$value->used_in_manufacture)
                                    <a href="{{ url('material_stocks') }}/{{ encrypt_decrypt($value->id, 'encrypt') }}/edit"
                                        class="button-success" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="@lang('index.edit')"><i class="fa fa-edit"></i></a>
                                    @endif
                                    @if (routePermission('material_stocks.delete') && !$value->used_in_manufacture)
                                    <a href="#" class="delete button-danger"
                                        data-form_class="alertDelete{{ $value->id }}" type="submit"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="@lang('index.delete')">
                                        <form action="{{ route('material_stocks.destroy', $value->id) }}"
                                            class="alertDelete{{ $value->id }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <i class="c_padding_13 fa fa-trash tiny-icon"></i>
                                        </form>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="customers" role="tabpanel" aria-labelledby="customers-tab">
                <div class="table-responsive">
                    <table class="table table-striped material_table">
                        <thead>
                            <tr>
                                <th class="width_1_p">@lang('index.sn')</th>
                                <th class="width_10_p">@lang('index.material_name')(@lang('index.code'))</th>
                                <th class="width_10_p">@lang('index.mat_type')</th>
                                {{-- <th class="width_10_p">@lang('index.ins_type')</th> --}}
                                <th class="width_10_p">@lang('index.customer')<br>(@lang('index.code'))</th>
                                <th class="width_10_p">@lang('index.stock')</th>
                                <th class="width_10_p">@lang('index.alter_level')</th>
                                <th class="width_10_p">@lang('index.floating_stock')</th>
                                <th class="width_10_p">@lang('index.added_by')</th>
                                <th class="width_1_p">@lang('index.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach($obj as $value)
                            @if(getStockCustomerNameById($value->customer_id) != 'Danish')
                            <tr>
                                <td class="c_center">{{ $i++ }}</td>
                                <td title="{{ getRMName($value->mat_id) }}">{{ substr_text(getRMName($value->mat_id),30) }}</td>
                                <td>
                                    @if($value->mat_type == 1)
                                    Material
                                    @elseif($value->mat_type == 2)
                                    Raw Material
                                    @else
                                    N/A
                                    @endif
                                </td>
                                {{-- <td>
                                                @if($value->ins_type == 1)
                                                    Consumable
                                                @elseif($value->ins_type == 2)
                                                    Non Consumable
                                                @else
                                                    N/A
                                                @endif
                                            </td> --}}
                                @if(!$value->customer_id)
                                <td title="{{ getStockCustomerNameById($value->customer_id) }}">{{ substr_text(getStockCustomerNameById($value->customer_id),30) }}</td>
                                @else
                                <td title="{{ getStockCustomerNameById($value->customer_id) }}">{{ substr_text(getStockCustomerNameById($value->customer_id),30) }}<br><small>({{ getCustomerCodeById($value->customer_id) }})</small></td>
                                @endif
                                <td>{{ $value->current_stock }} {{ getRMUnitById($value->unit_id) }}
                                    <div id="qty_msg"></div>
                                </td>
                                <td>{{ $value->close_qty }} {{ getRMUnitById($value->unit_id) }}</td>
                                <td>{{ $value->float_stock }} {{ getRMUnitById($value->unit_id) }}</td>
                                <td>{{ getUserName($value->added_by) }}</td>
                                <td>
                                    <a class="button-info" id="stockAdjBtn" data-bs-toggle="modal" data-id="{{ $value->id }}" data-mat_id="{{ $value->mat_id }}" data-customer_id="{{ $value->customer_id }}" data-material="{{ getRMName($value->mat_id) }}" data-bs-target="#stockAdjModal" title="Stock Adjustment"><i class="fa fa-pencil"></i></a>
                                    <a href="{{ url('material_stocks') }}/{{ encrypt_decrypt($value->id, 'encrypt') }}/stock_adjustments" class="button-info" data-bs-toggle="tooltip" data-bs-placement="top" title="View Stock Adjustments"><i class="fa fa-list"></i></a>
                                    @if (routePermission('material_stocks.edit') && !$value->used_in_manufacture)
                                    <a href="{{ url('material_stocks') }}/{{ encrypt_decrypt($value->id, 'encrypt') }}/edit"
                                        class="button-success" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="@lang('index.edit')"><i class="fa fa-edit"></i></a>
                                    @endif
                                    @if (routePermission('material_stocks.delete') && !$value->used_in_manufacture)
                                    <a href="#" class="delete button-danger"
                                        data-form_class="alertDelete{{ $value->id }}" type="submit"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="@lang('index.delete')">
                                        <form action="{{ route('material_stocks.destroy', $value->id) }}"
                                            class="alertDelete{{ $value->id }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <i class="c_padding_13 fa fa-trash tiny-icon"></i>
                                        </form>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="filterModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('index.rm_stocks')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::model(isset($mat_type) && $mat_type ? $mat_type : '', [
                    'id' => 'add_form',
                    'method' => 'GET',
                    'enctype' => 'multipart/form-data',
                    'route' => ['material_stocks.index'],
                    ]) !!}
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.mat_type') </label>
                                <select name="mat_type" id="mat_type" class="form-control select2">
                                    <option value="">@lang('index.select')</option>
                                    <option value="1" {{ isset($mat_type) && $mat_type == "1" ? 'selected' : '' }}>Material</option>
                                    <option value="2" {{ isset($mat_type) && $mat_type == "2" ? 'selected' : '' }}>Raw Material</option>
                                    {{-- <option value="3" {{ isset($mat_type) && $mat_type == "3" ? 'selected' : '' }}>Insert</option> --}}
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-md-12 mb-2 d-none" id="ins_type_div">
                                <div class="form-group">
                                    <label>@lang('index.ins_type') </label>
                                    <select name="ins_type" id="ins_type" class="form-control select2">
                                        <option value="">@lang('index.select')</option>
                                        <option value="1" {{ isset($ins_type) && $ins_type == "1" ? 'selected' : '' }}>Consumable</option>
                        <option value="2" {{ isset($ins_type) && $ins_type == "2" ? 'selected' : '' }}>Non Consumable</option>
                        </select>
                    </div>
                </div> --}}
                <div class="col-md-12 mb-2">
                    <div class="form-group">
                        <label>@lang('index.material') </label>
                        <select name="mat_id" id="mat_id" class="form-control select2">
                            <option value="">@lang('index.select')</option>
                            @if(isset($mat_id))
                            @foreach ($materials as $key => $value)
                            <option value="{{ $value->id }}"
                                {{ isset($mat_id) && $mat_id == $value->id ? 'selected' : '' }}>
                                {{ $value->name }} - {{ $value->code }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <button type="submit" name="submit" value="submit"
                        class="btn w-100 bg-blue-btn">@lang('index.submit')</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    </div>
    </div>
    <div class="modal fade" id="stockAdjModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.stock_adjustment')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 mb-2" id="selected_material">

                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="control-label">@lang('index.stock_type')<span class="ir_color_red">*</span></label>
                                    <select class="form-control @error('title') is-invalid @enderror select2"
                                        name="stock_type" id="stock_type">
                                        <option value="">@lang('index.select')</option>
                                        <option value="purchase">@lang('index.purchase_order')</option>
                                        <option value="customer">@lang('index.customer_order_no')</option>
                                    </select>
                                    <p class="text-danger stock_type_err"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2 d-none" id="select_ref_no">
                                <div class="form-group">
                                    <label class="control-label">@lang('index.po_no')<span class="ir_color_red">*</span></label>
                                    <select class="form-control @error('reference_no_purchase') is-invalid @enderror select2"
                                        name="reference_no_purchase" id="reference_no">
                                        <option value="">@lang('index.select')</option>
                                    </select>
                                    <p class="text-danger reference_no_err"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-6 d-none" id="inp_ref_no_div">
                                <div class="form-group">
                                    <label>@lang('index.reference_no') <span class="required_star">*</span></label>
                                    <input type="text" class="form-control @error('reference_no_customer') is-invalid @enderror" name="reference_no_customer" id="inp_ref_no" placeholder="@lang('index.po_no')" readonly>
                                    <p class="text-danger reference_no_err"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="control-label">@lang('index.adj_type')<span class="ir_color_red">*</span></label>
                                    <input type="hidden" name="mat_stock_id" id="mat_stock_id">
                                    <input type="hidden" name="mat_id" id="stk_mat_id">
                                    <input type="hidden" name="customer_id" id="customer_id">
                                    <input type="hidden" name="reference_no" id="reference_no_hidden">
                                    <select class="form-control @error('title') is-invalid @enderror select2"
                                        name="adj_type" id="adj_type">
                                        <option value="">@lang('index.select')</option>
                                        <option value="addition">@lang('index.addition')</option>
                                        <option value="subtraction">@lang('index.subtraction')</option>
                                    </select>
                                    <p class="text-danger material_id_err"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="control-label">@lang('index.quantity')<span class="ir_color_red"> *</span></label>
                                    <div>
                                        <input type="number" class="form-control" name="quantity" id="stock_qty" placeholder="Quantity" value="" min="1">
                                    </div>
                                    <p class="text-danger quantity_error"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label>@lang('index.challan_no') <span class="required_star">*</span></label>
                                    <input type="text" name="dc_no" class="form-control" id="dc_no" placeholder="@lang('index.challan_no')">
                                    <p class="text-danger dc_no_err"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label>Heat No <span class="required_star">*</span></label>
                                    <input type="text" name="heat_no" class="form-control" id="heat_no" placeholder="Heat No">
                                    <p class="text-danger heat_no_err"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label>DC Date <span class="required_star">*</span></label>
                                    {!! Form::text('date', date('d-m-Y'), [
                                    'class' => 'form-control',
                                    'placeholder' => 'DC Date',
                                    'id' => 'dc_date',
                                    ]) !!}
                                    <p class="text-danger dc_date_err"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label>@lang('index.doc_no')</label>
                                    <input type="text" class="form-control @error('mat_doc_no') is-invalid @enderror" name="mat_doc_no" id="mat_doc_no" placeholder="@lang('index.doc_no')">
                                    <p class="text-danger mat_doc_no_err"></p>
                                </div>
                            </div>
                            {{-- <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label>@lang('index.dc_inw_price') </label>
                                    <input type="text" class="form-control @error('dc_inward_price') is-invalid @enderror" name="dc_inward_price" id="dc_inward_price" value="{{ isset($obj->dc_inward_price) && $obj->dc_inward_price ? $obj->dc_inward_price : old('dc_inward_price') }}" placeholder="@lang('index.dc_inw_price')">
                                </div>
                            </div> --}}
                            <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label>@lang('index.mat_price') </label>
                                    <input type="text" class="form-control @error('material_price') is-invalid @enderror" name="material_price" id="material_price" value="{{ isset($obj->material_price) && $obj->material_price ? $obj->material_price : old('material_price') }}" placeholder="@lang('index.mat_price')">
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label>@lang('index.hsn_no') </label>
                                    <input type="text" class="form-control @error('hsn_no') is-invalid @enderror" name="hsn_no" id="hsn_no" value="{{ isset($obj->hsn_no) && $obj->hsn_no ? $obj->hsn_no : old('hsn_no') }}" placeholder="@lang('index.hsn_no')">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn bg-blue-btn stock_adjust_btn"><iconify-icon icon="solar:check-circle-broken"></iconify-icon>
                        @lang('index.submit')</button>
                </div>
            </div>
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
<script>
    $('#adj_type').select2({
        dropdownParent: $('#stockAdjModal')
    });
    $('#stock_type').select2({
        dropdownParent: $('#stockAdjModal')
    });
    $('#reference_no').select2({
        dropdownParent: $('#stockAdjModal')
    });
    $('#mat_id').select2({
        dropdownParent: $('#filterModal')
    });
    $('#mat_type').select2({
        dropdownParent: $('#filterModal')
    });
    $('#ins_type').select2({
        dropdownParent: $('#filterModal')
    });
    /* Filter */
    $(document).on("change", "#mat_type", function() {
        let mat_type = $(this).find(":selected").val();
        let hidden_base_url = $("#hidden_base_url").val();
        // if(mat_type=="3") {
        //     $("#ins_type_div").removeClass('d-none');
        //     $("#ins_type").trigger("change");
        // } else {
        //     $("#ins_type_div").addClass('d-none');
        //     $("#ins_type").val('');
        // }
        $.ajax({
            type: "POST",
            url: hidden_base_url + "getMaterialByMatType",
            data: {
                mat_type: mat_type
            },
            dataType: "json",
            success: function(data) {
                let materials = data;
                let select = $("#mat_id");
                select.empty();
                select.append('<option value="">Please Select</option>');
                materials.forEach(function(item) {
                    if (item) {
                        let id = item.id;
                        let name = item.name;
                        let code = item.code ?? '';
                        select.append('<option value="' + id + '|' + name + '|' + code + '">' + name + '</option>');
                    }
                });
                // $(".select2").select2();
            },
            error: function() {
                console.error("Failed to fetch product details.");
            },
        });
    });
    /* $(document).on("change", "#ins_type", function () {
        let mat_type = $("#mat_type").val();
        let ins_type = $(this).find(":selected").val();
        let hidden_base_url = $("#hidden_base_url").val();
        $.ajax({
            type: "POST",
            url: hidden_base_url + "getMaterialByMatInsType",
            data: { mat_type: mat_type, ins_type: ins_type },
            dataType: "json",
            success: function (data) {
                let materials = data;
                let select = $("#mat_id");
                select.empty();
                select.append('<option value="">Please Select</option>');
                materials.forEach(function (item) {
                    if (item) {
                        let id = item.id;
                        let name = item.name;
                        let code = item.code ?? '';
                        select.append('<option value="' + id + '|' + name + '|' + code + '">' + name + '</option>');
                    }
                });
                // $(".select2").select2();
            },
            error: function () {
                console.error("Failed to fetch product details.");
            },
        });
    }); */
    $(document).on("click", "#stockAdjBtn", function(e) {
        e.preventDefault();
        var mat_stock_id = $(this).data('id');
        $('#mat_stock_id').val(mat_stock_id);
        var mat_id = $(this).data('mat_id');
        $('#stk_mat_id').val(mat_id);
        var customer_id = $(this).data('customer_id');
        $('#customer_id').val(customer_id);
        var material = $(this).data('material');
        $('#selected_material').html('<p>' + material + '</p>');
        $('#stock_type').val("").trigger('change.select2');
        $('#reference_no').val("").trigger('change.select2');
        $("#select_ref_no").addClass("d-none");
        $("#inp_ref_no_div").addClass("d-none");
        $('#inp_ref_no').val("");
        $('#stock_qty').val("");
        $('#adj_type').val("").trigger('change.select2');
        $(".quantity_error").html("");
        $(".stock_type_err").html("");
        $(".reference_no_err").html("");
        $(".material_id_err").html("");
    });
    $(document).on("change", "#stock_type", function(e) {
        let hidden_base_url = $("#hidden_base_url").val();
        let stock_type = $("#stock_type").val();
        var mat_id = $("#stk_mat_id").val();
        var customer_id = $("#customer_id").val();
        $.ajax({
            type: "POST",
            url: hidden_base_url + "getStockReference",
            data: {
                stock_type: stock_type,
                mat_id: mat_id,
                customer_id: customer_id
            },
            dataType: "html",
            success: function(data) {
                if (typeof data === "string") {
                    data = JSON.parse(data);
                }
                if (data.type === "purchase") {
                    $("#reference_no").html(data.html);
                    $("#select_ref_no").removeClass("d-none");
                    $("#inp_ref_no_div").addClass("d-none");
                    $("#inp_ref_no").val("");
                    $("#stock_qty").val("");
                } else {
                    $("#select_ref_no").addClass("d-none");
                    $("#inp_ref_no_div").removeClass("d-none");
                    $("#inp_ref_no").val(data.html);
                    $("#stock_qty").val(data.qty);
                    $("#stock_qty").attr("max", data.qty);
                }
            },
            error: function() {
                console.log("error");
            },
        });
    });
    $(document).on("change", "#reference_no", function(e) {
        let selected = $(this).val();
        let split = selected.split('|');
        $("#stock_qty").val(split[1]);
        $("#stock_qty").attr("max", split[1]);
    });
    $("#stock_qty").on("input", function() {
        let enteredQty = parseFloat($(this).val());
        let maxQty = parseFloat($(this).attr("max"));
        if (enteredQty > maxQty) {
            $(this).val(maxQty);
            $(".quantity_error").text("Quantity cannot exceed ordered quantity.");
        } else {
            $(".quantity_error").text("");
        }
    });
    $(document).on("click", ".stock_adjust_btn", function(e) {
        e.preventDefault();
        let status = true;
        let hidden_base_url = $("#hidden_base_url").val();
        let mat_stock_id = $("#mat_stock_id").val();
        let mat_id = $("#stk_mat_id").val();
        let adj_type = $("#adj_type").val();
        let stock_type = $("#stock_type").val();
        let dc_no = $("#dc_no").val();
        let heat_no = $("#heat_no").val();
        let dc_date = $("#dc_date").val();
        let mat_doc_no = $("#mat_doc_no").val();
        // let dc_inward_price = $("#dc_inward_price").val();
        let material_price = $("#material_price").val();
        let hsn_no = $("#hsn_no").val();
        let reference_no = "";
        if (stock_type === "purchase") {
            reference_no = $("#reference_no").val().split('|')[0];
        } else if (stock_type === "customer") {
            reference_no = $("#inp_ref_no").val();
        }
        $("#reference_no_hidden").val(reference_no);
        let stock_qty = $("#stock_qty").val();
        if (adj_type == "") {
            $(".material_id_err").text("The Adjustment Type field is required.");
            status = false;
        } else {
            $(".material_id_err").text("");
        }
        if (stock_qty == "") {
            $(".quantity_error").text("The Quantity field is required.");
            status = false;
        } else {
            $(".quantity_error").text("");
        }
        if (stock_type == "") {
            $(".stock_type_err").text("The Stock Type field is required.");
            status = false;
        } else {
            $(".stock_type_err").text("");
        }
        if (dc_no == "") {
            $(".dc_no_err").text("The Customer DC No field is required.");
            status = false;
        } else {
            $(".dc_no_err").text("");
        }
        if (heat_no == "") {
            $(".heat_no_err").text("The Heat No field is required.");
            status = false;
        } else {
            $(".heat_no_err").text("");
        }
        if (dc_date == "") {
            $(".dc_date_err").text("The DC Date field is required.");
            status = false;
        } else {
            $(".dc_date_err").text("");
        }
        // if(mat_doc_no == "") {
        //     $(".mat_doc_no_err").text("The Material Doc No field is required.");
        //     status = false;
        // } else {
        //     $(".mat_doc_no_err").text("");
        // }
        if (reference_no === "") {
            if (stock_type === "purchase") {
                $(".reference_no_err").text("The PO Number field is required.");
            } else {
                $(".reference_no_err").text("The PO Number field is required.");
            }
            status = false;
        } else {
            $(".reference_no_err").text("");
        }
        if (status == false) {
            return false;
        }
        $.ajax({
            type: "POST",
            url: hidden_base_url + "materialStockAdjust",
            data: {
                mat_stock_id: mat_stock_id,
                adj_type: adj_type,
                stock_qty: stock_qty,
                mat_id: mat_id,
                stock_type: stock_type,
                reference_no: reference_no,
                dc_no: dc_no,
                heat_no: heat_no,
                dc_date: dc_date,
                mat_doc_no: mat_doc_no,
                // dc_inward_price: dc_inward_price,
                material_price: material_price,
                hsn_no: hsn_no
            },
            dataType: "json",
            success: function(data) {
                const modalEl = document.getElementById('stockAdjModal');
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) {
                    modalInstance.hide();
                }
                let hidden_alert = data.status ? "Success" : "Error";
                let hidden_cancel = $("#hidden_cancel").val();
                let hidden_ok = $("#hidden_ok").val();
                swal({
                    title: hidden_alert + "!",
                    text: data.message,
                    cancelButtonText: hidden_cancel,
                    confirmButtonText: hidden_ok,
                    confirmButtonColor: "#3c8dbc",
                }, function() {
                    location.reload();
                });
            },
            error: function() {},
        });
    });
</script>
@endsection