@extends('layouts.app')
@section('script_top')
<?php
    $setting = getSettingsInfo();
    $tax_setting = getTaxInfo();
    $baseURL = getBaseURL();
?>
@endsection
@section('content')
    <section class="main-content-wrapper">
        <section class="content-header">
            <h3 class="top-left-header">
                {{ isset($title) && $title ? $title : '' }}
            </h3>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <!-- form start -->
                {!! Form::model(isset($obj) && $obj ? $obj : '', [
                    'id' => 'material_stock_form',
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'route' => ['material_stocks.update', isset($obj->id) && $obj->id ? $obj->id : ''],
                ]) !!}
                @csrf
                <div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.raw_material_name') (Code) <span class="required_star">*</span></label>
                                @if(isset($materials) && $materials)
                                    <select tabindex="4" class="form-control @error('mat_id') is-invalid @enderror select2 select2-hidden-accessible" name="mat_id" id="mat_id">
                                        <option value="">@lang('index.select')</option>
                                        @foreach($materials as $rm)
                                            <option value="{{ $rm->id.'|'.$rm->name.'|'.$rm->code }}" {{ isset($obj) && $rm->id === $obj->mat_id ? 'selected' : '' }}>{{ $rm->name }} ({{ $rm->code }})</option>
                                        @endforeach
                                    </select>
                                @else 
                                    <select tabindex="4" class="form-control @error('mat_id') is-invalid @enderror select2 select2-hidden-accessible" name="mat_id" id="mat_id">
                                        <option value="">@lang('index.select')</option>
                                    </select>
                                @endif
                                <div class="text-danger d-none"></div>
                                @error('mat_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.material_category') <span class="required_star">*</span></label>
                                <input type="hidden" name="mat_cat_id" class="form-control" id="mat_cat_id" placeholder="@lang('index.material_category') " value="{{ isset($obj) && $obj->mat_cat_id!='' ? $obj->mat_cat_id : old('mat_cat_id') }}" readonly>
                                <input type="text" name="mat_cat" class="form-control" id="mat_cat" placeholder="@lang('index.material_category')" value="{{ isset($obj) ? getCategoryById($obj->mat_cat_id) : old('mat_cat') }}" readonly>
                                {{-- <select class="form-control @error('mat_cat_id') is-invalid @enderror select2" name="mat_cat_id" id="mat_cat_id">
                                    <option value="">@lang('index.select')</option>
                                    @foreach ($mat_categories as $value)
                                        <option
                                            {{ (isset($obj->mat_cat_id) && $obj->mat_cat_id == $value->id) || old('mat_cat_id') == $value->id ? 'selected' : '' }}
                                            value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select> --}}
                                <div class="text-danger d-none"></div>
                                @error('mat_cat_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4 {{ isset($obj) && $obj->old_mat_no!='' ? "" : "d-none" }}" id="old_mat_no_div">
                            <div class="form-group">
                                <label>Old Material No </label>
                                <input type="text" name="old_mat_no" class="form-control" id="old_mat_no" placeholder="Old Material No" value="{{ isset($obj) && $obj->old_mat_no!='' ? $obj->old_mat_no : old('old_mat_no') }}" readonly>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.challan_no') <span class="required_star">*</span></label>
                                <input type="text" name="dc_no" class="form-control" id="dc_no" placeholder="@lang('index.challan_no')" value="{{ isset($obj) && $obj->dc_no!='' ? $obj->dc_no : old('dc_no') }}">
                                <div class="text-danger d-none"></div>
                                @error('dc_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>Heat No <span class="required_star">*</span></label>
                                <input type="text" name="heat_no" class="form-control" id="heat_no" placeholder="Heat No" value="{{ isset($obj) && $obj->heat_no!='' ? $obj->heat_no : old('heat_no') }}">
                                <div class="text-danger d-none"></div>
                                @error('heat_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>DC Date <span class="required_star">*</span></label>
                                {!! Form::text('date', isset($obj->dc_date) && $obj->dc_date ? date('d-m-Y',strtotime($obj->dc_date)) : (old('dc_date') ?: date('d-m-Y')), [
                                    'class' => 'form-control',
                                    'placeholder' => 'DC Date',
                                    'id' => 'dc_date',
                                ]) !!}
                                <div class="text-danger d-none"></div>
                                @if ($errors->has('dc_date'))
                                    <div class="error_alert text-danger">
                                        {{ $errors->first('dc_date') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.doc_no')</label>
                                <input type="text" class="form-control @error('mat_doc_no') is-invalid @enderror" name="mat_doc_no" id="mat_doc_no" value="{{ isset($obj->mat_doc_no) && $obj->mat_doc_no ? $obj->mat_doc_no : old('mat_doc_no') }}" placeholder="@lang('index.doc_no')">
                                <div class="text-danger d-none"></div>
                                @error('mat_doc_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="col-sm-12 mb-2 col-md-4 {{ isset($obj) && $obj->mat_cat_id=="1" ? "" : "d-none" }}" id="insert_mat_type_div">
                            <div class="form-group">
                                <label>@lang('index.mat_type') <span class="required_star">*</span></label>
                                <input type="hidden" class="form-control" name="mat_type" id="inp_mat_type" placeholder="@lang('index.mat_type')" value="{{ isset($obj) ? $obj->mat_type : old('mat_type') }}">
                                <input type="text" class="form-control" id="inp_name_mat_type" placeholder="@lang('index.mat_type')" value="{{ isset($obj) && $obj->mat_type == 1 ? 'Material' : (isset($obj) && $obj->mat_type == 2 ? 'Raw Material' : (isset($obj) && $obj->mat_type == 3 ? 'Insert' : '')) }}" readonly>
                            </div>
                        </div> --}}
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.mat_type') <span class="required_star">*</span></label>
                                <select class="form-control @error('mat_type') is-invalid @enderror select2" name="mat_type" id="mat_type">
                                    <option value="">@lang('index.select')</option>
                                    <option {{ (isset($obj->mat_type) && $obj->mat_type == 1) || old('mat_type') == 1 ? 'selected' : '' }} value="1">Material</option>
                                    <option {{ (isset($obj->mat_type) && $obj->mat_type == 2) || old('mat_type') == 2 ? 'selected' : '' }} value="2">Raw Material</option>
                                </select>
                                <div class="text-danger d-none"></div>
                                @error('mat_type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="col-sm-12 mb-2 col-md-4" id="ins_type_div" style="{{ isset($obj->mat_type) && $obj->mat_type == 3 ? '' : 'display:none;' }}" >
                            <div class="form-group">
                                <label>@lang('index.ins_type') <span class="required_star">*</span></label>
                                <select class="form-control @error('ins_type') is-invalid @enderror select2" name="ins_type" id="ins_type" {{ isset($obj->mat_type) && $obj->mat_type == 3 ? "disabled" : ""}}>
                                    <option value="">@lang('index.select')</option>
                                    <option {{ (isset($obj->ins_type) && $obj->ins_type == 1) || old('ins_type') == 1 ? 'selected' : '' }} value="1">Consumable</option>
                                    <option {{ (isset($obj->ins_type) && $obj->ins_type == 2) || old('ins_type') == 2 ? 'selected' : '' }} value="2">Non Consumable</option>
                                </select>
                                <input type="hidden" class="form-control" name="ins_type" id="inp_ins_type" placeholder="@lang('index.ins_type')" value="{{ isset($obj) && $obj->mat_type == 3 ? $obj->ins_type : old('ins_type') }}">
                                <div class="text-danger d-none"></div>
                                @error('ins_type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="col-sm-12 mb-2 col-md-4 {{ (isset($obj) && $obj->mat_type == 1) || old('mat_type') == 1 ? '' : 'd-none' }}" id="cust_div">
                            <div class="form-group">
                                <label>@lang('index.customer') </label>
                                <select class="form-control @error('mat_cat_id') is-invalid @enderror select2" name="customer_id" id="customer_id">
                                    <option value="">@lang('index.select')</option>
                                    @foreach ($customers as $value)
                                        <option
                                            {{ (isset($obj->customer_id) && $obj->customer_id == $value->id) || old('customer_id') == $value->id ? 'selected' : '' }}
                                            value="{{ $value->id }}">{{ $value->name.'('.$value->customer_id.')' }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger d-none"></div>
                                @error('customer_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.unit') <span class="required_star">*</span></label>
                                <select class="form-control @error('unit_id') is-invalid @enderror select2" name="unit_id" id="unit_id">
                                    <option value="">@lang('index.select')</option>
                                    @foreach ($units as $value)
                                        <option
                                            {{ (isset($obj->unit_id) && $obj->unit_id == $value->id) || old('unit_id') == $value->id ? 'selected' : '' }}
                                            value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger d-none"></div>
                                @error('unit_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.stock_type') <span class="required_star">*</span></label>
                                <select class="form-control @error('stock_type') is-invalid @enderror select2" name="stock_type" id="stock_type">
                                    <option value="">@lang('index.select')</option>
                                    <option value="purchase" {{ (isset($obj->stock_type) && $obj->stock_type == 'purchase') || old('stock_type') == 'purchase' ? 'selected' : '' }}>@lang('index.purchase_order')</option>
                                    <option value="customer" {{ (isset($obj->stock_type) && $obj->stock_type == 'customer') || old('stock_type') == 'customer' ? 'selected' : '' }}>@lang('index.customer_order_no')</option>
                                </select>
                                <div class="text-danger d-none"></div>
                                @error('stock_type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4 {{ !isset($obj) || (isset($obj) && $obj->stock_type == 'customer') ? 'd-none' : '' }}" id="select_ref_no">
                            <div class="form-group">
                                <label>@lang('index.po_no') <span class="required_star">*</span></label>
                                <select class="form-control @error('reference_no_purchase') is-invalid @enderror select2"
                                    name="reference_no_purchase" id="reference_no">
                                    <option value="">@lang('index.select')</option>
                                    @if(isset($obj) && isset($purchases))
                                        @foreach($purchases as $po)
                                            <option value="{{ $po->purchase->reference_no }}"
                                                {{ (isset($obj->reference_no) && $obj->reference_no == $po->purchase->reference_no) || old('reference_no') == $po->purchase->reference_no ? 'selected' : '' }}>
                                                {{ $po->purchase->reference_no }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="text-danger d-none"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4 {{ !isset($obj) || (isset($obj) && $obj->stock_type == 'customer') ? '' : 'd-none' }}" id="inp_ref_no_div">
                            <div class="form-group">
                                <label>@lang('index.po_no') <span class="required_star">*</span></label>
                                <input type="text" class="form-control @error('reference_no_customer') is-invalid @enderror" name="reference_no_customer" id="inp_ref_no" value="{{ isset($obj->reference_no) ? $obj->reference_no : old('reference_no') }}" placeholder="@lang('index.po_no')" readonly>
                                <div class="text-danger d-none"></div>
                            </div>
                        </div>
                        <input type="hidden" name="reference_no" id="reference_no_hidden">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.stock') <span class="required_star">*</span></label>
                                <input type="number" class="form-control @error('current_stock') is-invalid @enderror" name="current_stock" id="current_stock" value="{{ isset($obj->current_stock) ? $obj->current_stock : old('current_stock') }}" placeholder="@lang('index.stock')" min="0" {{ isset($obj) ? 'readonly' : '' }}>
                                <div class="text-danger d-none"></div>
                                @error('current_stock')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.alter_level') </label>
                                <input type="number" class="form-control @error('close_qty') is-invalid @enderror" name="close_qty" id="close_qty" value="{{ isset($obj->close_qty) && $obj->close_qty ? $obj->close_qty : old('close_qty') }}" placeholder="@lang('index.alter_level')" min="0">
                                <div class="text-danger d-none"></div>
                                @error('close_qty')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.dc_inw_price') </label>
                                <input type="text" class="form-control @error('dc_inward_price') is-invalid @enderror" name="dc_inward_price" id="dc_inward_price" value="{{ isset($obj->dc_inward_price) && $obj->dc_inward_price ? $obj->dc_inward_price : old('dc_inward_price') }}" placeholder="@lang('index.dc_inw_price')">
                                <div class="text-danger d-none"></div>
                                @error('dc_inward_price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.mat_price') </label>
                                <input type="text" class="form-control @error('material_price') is-invalid @enderror" name="material_price" id="material_price" value="{{ isset($obj->material_price) && $obj->material_price ? $obj->material_price : old('material_price') }}" placeholder="@lang('index.mat_price')">
                                <div class="text-danger d-none"></div>
                                @error('material_price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.hsn_no') </label>
                                <input type="text" class="form-control @error('hsn_no') is-invalid @enderror" name="hsn_no" id="hsn_no" value="{{ isset($obj->hsn_no) && $obj->hsn_no ? $obj->hsn_no : old('hsn_no') }}" placeholder="@lang('index.hsn_no')" >
                                <div class="text-danger d-none"></div>
                                @error('hsn_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
                            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><iconify-icon
                                    icon="solar:check-circle-broken"></iconify-icon>@lang('index.submit')</button>
                            <a class="btn bg-second-btn" href="{{ route('material_stocks.index') }}"><iconify-icon
                                    icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection
@section('script_bottom')
@endsection
@section('script')
    <script type="text/javascript" src="{!!  $baseURL . 'assets/bower_components/jquery-ui/jquery-ui.min.js'  !!}"></script>
    <script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/stock.js?v=1.2' !!}"></script>
@endsection
