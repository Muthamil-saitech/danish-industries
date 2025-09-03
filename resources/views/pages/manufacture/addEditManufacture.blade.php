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
    <link rel="stylesheet" href="{{ $baseURL . 'assets/bower_components/jquery-ui/jquery-ui.css' }}">
@endpush

@section('content')
    <input type="hidden" id="edit_mode" value="{{ isset($obj) && $obj ? $obj->id : null }}">
    <section class="main-content-wrapper">
        @include('utilities.messages')
        <section class="content-header">
            <h3 class="top-left-header">
                {{ isset($title) && $title ? $title : '' }}
            </h3>
        </section>

        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- form start -->
                {!! Form::model(isset($obj) && $obj ? $obj : '', [
                    'id' => 'manufacture_form',
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'enctype' => 'multipart/form-data',
                    'route' => ['productions.update', isset($obj->id) && $obj->id ? $obj->id : ''],
                ]) !!}
                @csrf
                {!! Form::hidden('stage_counter', null, ['class' => 'stage_counter', 'id' => 'stage_counter']) !!}
                {!! Form::hidden('stage_name', null, ['class' => 'stage_name', 'id' => 'stage_name']) !!}
                <div>
                    <div class="row">
                        {{-- <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.ppcrc_no') <span class="required_star">*</span></label>
                                <input type="text" name="reference_no" id="code"
                                    class="check_required form-control @error('reference_no') is-invalid @enderror"
                                    placeholder="@lang('index.ppcrc_no')"
                                    value="{{ isset($obj->reference_no) ? $obj->reference_no : old('reference_no') }}"
                                    onfocus="select()">
                                <div class="text-danger d-none"></div>
                                @error('reference_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.customer_name')(@lang('index.code'))<span class="required_star">*</span></label>
                                <input type="hidden" name="selected_customer_id" id="selected_customer_id" value="{{ isset($selected_customer_id) ? $selected_customer_id : old('selected_customer_id')}}" >
                                <select class="form-control customer_id_c1 select2" name="customer_id" id="customer_id" {{ isset($selected_customer_id) ? 'disabled' : '' }}>
                                    <option value="">@lang('index.select')</option>
                                    @foreach ($customers as $value)
                                        <option value="{{ $value->id }}"
                                            {{ old('customer_id', $selected_customer_id ?? ($obj->customer_id ?? '')) == $value->id ? 'selected' : '' }}>
                                            {{ $value->name }} ({{ $value->customer_id }})
                                        </option>
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
                                <label>@lang('index.po_no')<span class="required_star">*</span></label>
                                <input type="hidden" name="selected_customer_order_id" value="{{ isset($selected_customer_order_id) ? $selected_customer_order_id : old('selected_customer_order_id') }}" >
                                <select class="form-control customer_order_id_c1 select2" name="customer_order_id" id="customer_order_id" {{ isset($selected_customer_order_id) ? 'disabled' : '' }}>
                                    <option value="">@lang('index.select')</option>
                                    @foreach ($customerOrderList as $value)
                                        <option value="{{ $value->id }}"
                                            {{ old('customer_order_id', $selected_customer_order_id ?? ($obj->customer_order_id ?? '')) == $value->id ? 'selected' : '' }}>
                                            {{ $value->reference_no }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="text-danger d-none"></div>
                                @error('customer_order_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12 col-md-6 mb-2 col-lg-4">
                            <div class="form-group">
                                <label>@lang('index.start_date') <span class="required_star">*</span></label>
                                <input type="text" name="start_date_m" id="start_date"
                                    class="form-control @error('start_date') is-invalid @enderror" readonly
                                    placeholder="Start Date"
                                    value="{{ isset($obj->start_date) ? date('d-m-Y',strtotime($obj->start_date)) : old('start_date_m') }}">
                                <div class="text-danger d-none"></div>
                                @error('start_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2 col-lg-4">
                            <div class="form-group">
                                <label>@lang('index.delivery_date') </label>
                                <input type="text" name="complete_date_m" id="complete_date"
                                    class="form-control @error('complete_date') is-invalid @enderror"
                                    placeholder="@lang('index.delivery_date')"
                                    value="{{ isset($obj->complete_date) ? date('d-m-Y',strtotime($obj->complete_date)) : old('complete_date_m') }}">
                                <div class="text-danger d-none"></div>
                                @error('complete_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div id="customer_order_area" class="row"></div>
                        <div class="clearfix"></div>
                        <?php $st_method = ''; ?>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.part_name')(@lang('index.code'))<span class="required_star">*</span></label>
                                @if (isset($obj->product_id) && $obj->product_id !== '')
                                    <input type="hidden" name="product_id" id="fproduct_id" value="{{ isset($obj) ? $obj->product_id : old('product_id') }}">
                                    <input type="text"
                                        class="form-control @error('product_id') is-invalid @enderror check_required"
                                        id="fproduct_id" value="{{ getProductNameById($obj->product_id) }}" readonly>
                                    <?php
                                    if (isset($obj->product_id) && $obj->product_id) {
                                        $st_method = $obj->product->stock_method;
                                    }
                                    ?>
                                @else
                                    <input type="hidden" name="product_id" value="{{ $selected_product_id ?? '' }}">
                                    <select
                                        class="form-control @error('product_id') is-invalid @enderror select2 fproduct_id check_required" name="product_id" id="fproduct_id" {{ isset($selected_product_id) ? 'disabled' : '' }}>
                                        <option value="">@lang('index.select')</option>
                                        @if (isset($manufactures) && $manufactures)
                                            @foreach ($manufactures as $value)
                                                <option
                                                    {{ isset($selected_product_id) && $selected_product_id == $value->id ? 'selected' : '' }}
                                                    value="{{ $value->id . '|' . $value->stock_method }}">
                                                    {{ $value->name }} ({{ $value->code }})</option>
                                                <?php
                                                if (isset($selected_product_id) && $selected_product_id == $value->id) {
                                                    $st_method = $selected_st_method;
                                                }
                                                ?>
                                            @endforeach
                                        @endif
                                    </select>
                                @endif
                                <div class="text-danger d-none"></div>
                                @error('product_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-2">
                            <div class="form-group">
                                <label>@lang('index.prod_quantity') <span class="required_star">*</span></label>
                                <input type="number" name="product_quantity" id="product_quantity"
                                    class="check_required form-control @error('product_quantity') is-invalid @enderror product_quantity"
                                    placeholder="@lang('index.prod_quantity')"
                                    value="{{ isset($obj->product_quantity) ? $obj->product_quantity : old('product_quantity') }}" readonly>
                                <div class="text-danger d-none"></div>
                                @error('product_quantity')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.mat_type') <span class="required_star">*</span></label>
                                @if (isset($obj->stk_mat_type) && $obj->stk_mat_type !== '')
                                    <input type="hidden" name="stk_mat_type" id="stk_mat_type" value="{{ $obj->stk_mat_type }}">
                                    <input type="text"
                                        class="form-control @error('stk_mat_type') is-invalid @enderror check_required"
                                        id="stk_mat_type" value="{{ getMaterialType($obj->stk_mat_type) }}" readonly>
                                @else
                                    <select class="form-control @error('stk_mat_type') is-invalid @enderror select2" name="stk_mat_type" id="stk_mat_type">
                                        <option value="">@lang('index.select')</option>
                                        <option value="1" {{ (isset($obj->stk_mat_type) && $obj->stk_mat_type == 1) || old('stk_mat_type') == 1 ? 'selected' : '' }}>Material</option>
                                        <option value="2" {{ (isset($obj->stk_mat_type) && $obj->stk_mat_type == 2) || old('stk_mat_type') == 2 ? 'selected' : '' }}>Raw Material</option>
                                    </select>
                                @endif
                                <div class="text-danger d-none"></div>
                                @error('stk_mat_type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> 
                        {{-- <div
                            class="col-sm-12 mb-2 col-md-2 none_method fefo_method @if (in_array($st_method, ['none', 'fifo', 'fefo'])) d-none @endif">
                            <div class="form-group">
                                <label>@lang('index.batch_no')</label>
                                <input type="text" name="batch_no" id="batch_no"
                                    class="form-control @error('batch_no') is-invalid @enderror" placeholder="Batch No"
                                    value="{{ isset($obj->batch_no) ? $obj->batch_no : old('batch_no') }}">
                                <div class="text-danger d-none"></div>
                                @error('batch_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div
                            class="col-sm-12 mb-2 col-md-2 none_method batch_method @if (in_array($st_method, ['none', 'batchcontrol', 'fifo'])) d-none @endif">
                            <div class="form-group">
                                <label>@lang('index.expiry_days') <span class="required_star">*</span></label>
                                <input type="text" name="expiry_days" id="expiry_days"
                                    class="form-control @error('expiry_days') is-invalid @enderror"
                                    placeholder="Expiry Days"
                                    value="{{ isset($obj->expiry_days) ? $obj->expiry_days : old('expiry_days') }}">
                                <div class="text-danger d-none"></div>
                                @error('expiry_days')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}
                        {{-- <input type="hidden" name="st_method" id="st_method"> --}}
                        <div class="col-sm-12 mb-2 col-md-2">
                            <div class="form-group">
                                <button id="pr_go"
                                    class="btn bg-blue-btn w-100 goBtn govalid {{ isset($obj) ? 'disabled' : '' }}"><span
                                        class="me-2">@lang('index.go')</span> <iconify-icon
                                        icon="solar:arrow-right-broken"></iconify-icon></button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row {{ isset($obj) ? '' : 'hidden_sec' }}">
                        <div class="col-md-12">
                            <h4 class="mb-0">@lang('index.raw_material_consumption_cost') (BoM)</h4>
                            <div class="table-responsive" id="fprm">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="w-5 text-start">@lang('index.sn')</th>
                                            <th class="w-30">@lang('index.material_name')(@lang('index.code'))</th>
                                            <th class="w-30">@lang('index.stock')</th>
                                            {{-- <th class="w-20"> @lang('index.rate_per_unit') <span class="required_star">*</span> <i
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    title="@lang('index.rm_stock_price_calculate')"
                                                    class="fa fa-question-circle base_color c_pointer"></i>
                                            </th> --}}
                                            <th class="w-20"> @lang('index.consumption') <span class="required_star">*</span>
                                            </th>
                                            {{-- <th class="w-20">@lang('index.total_cost')</th> --}}
                                            {{-- <th class="w-5 text-end">@lang('index.actions')</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody class="add_trm">
                                        @if (isset($m_rmaterials) && $m_rmaterials)
                                            @foreach ($m_rmaterials as $key => $value)
                                                <tr class="rowCount" data-id="{{ $value->rmaterials_id }}">
                                                    <td class="width_1_p text-start">
                                                        <p class="set_sn"></p>
                                                    </td>
                                                    <td><input type="hidden" value="{{ $value->stock_id }}"
                                                            name="stock_id[]">
                                                        <input type="hidden" value="{{ $value->rmaterials_id }}"
                                                            name="rm_id[]" class="rm_id">
                                                        <span>{{ getRMName($value->rmaterials_id) }}</span>
                                                    </td>
                                                    <td>
                                                        <input type="hidden"
                                                            id="mat_stock" name="stock[]"       
                                                            class="check_required form-control"
                                                            value="{{ $value->stock }}"
                                                            placeholder="Stock">
                                                        <p id="show_stock">{{ $value->stock }} <span
                                                            >{{ getStockUnitById($value->stock_id) }}</span></p>
                                                    </td>
                                                    {{-- <td>
                                                        <div class="input-group">
                                                            <input type="number" tabindex="5" name="unit_price[]"
                                                                onfocus="this.select();"
                                                                class="check_required form-control @error('title') is-invalid @enderror integerchk unit_price_c cal_row"
                                                                placeholder="Unit Price" value="{{ $value->unit_price }}"
                                                                id="unit_price_1">
                                                            <span class="input-group-text">
                                                                {{ $setting->currency }}</span>
                                                        </div>
                                                    </td> --}}
                                                    <td>
                                                        <div class="input-group">
                                                            <input type="number" data-countid="1" tabindex="51"
                                                                id="qty_1" name="quantity_amount[]"
                                                                onfocus="this.select();"
                                                                class="check_required form-control @error('title') is-invalid @enderror integerchk  qty_c cal_row"
                                                                value="{{ $value->consumption }}"
                                                                placeholder="Consumption" readonly>
                                                            <span
                                                                class="input-group-text">{{ getStockUnitById($value->stock_id) }}</span>
                                                        </div>
                                                    </td>
                                                    {{-- <td>
                                                        <div class="input-group">
                                                            <input type="number" id="total_1" name="total[]"
                                                                class="form-control @error('title') is-invalid @enderror total_c"
                                                                value="{{ $value->consumption_unit }}"
                                                                placeholder="Total" readonly="">
                                                            <span class="input-group-text">
                                                                {{ $setting->currency }}</span>
                                                        </div>
                                                    </td> --}}
                                                    {{-- <td class="text-end"><a
                                                            class="btn btn-xs del_row dlt_button"><iconify-icon
                                                                icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a>
                                                    </td> --}}
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                {{-- <button id="fprmaterial" class="btn bg-blue-btn w-20 mt-2"
                                    type="button">@lang('index.add_more')</button> --}}
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row {{ isset($obj) ? '' : 'hidden_sec' }}">
                        <div class="table-responsive">
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="w-5"></td>
                                        <td class="w-30"></td>
                                        <td class="w-20">
                                        </td>
                                        <td class="w-20"></td>
                                        <td class="w-20">
                                            <label class="custom_label">@lang('index.total_raw_material_cost')</label>
                                            <div class="input-group">
                                                <input type="text" name="mrmcost_total" id="rmcost_total"
                                                    class="form-control @error('mrmcost_total') is-invalid @enderror"
                                                    readonly placeholder="{{ __('index.total_raw_material_cost') }}"
                                                    value="{{ isset($obj->mrmcost_total) ? $obj->mrmcost_total : old('mrmcost_total') }}">
                                                <span class="input-group-text">{{ $setting->currency }}</span>
                                            </div>
                                        </td>
                                        <td class="w-5 ir_txt_center"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> --}}
                    {{-- <div class="row {{ isset($obj) ? '' : 'hidden_sec' }}">
                        <div class="clearfix"></div>
                        <h4 class="mb-0">@lang('index.non_inventory_cost')</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="purchase_cart">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="w-5 text-start">@lang('index.sn')</th>
                                                <th class="w-30">@lang('index.non_inventory_items')</th>
                                                <th class="w-20"></th>
                                                <th class="w-20"> @lang('index.non_inventory_item_cost') <span
                                                        class="required_star">*</span> </th>
                                                <th class="w-20"> @lang('index.account') <span
                                                        class="required_star">*</span></th>
                                                <th class="w-5 text-end">@lang('index.actions')</th>
                                            </tr>
                                        </thead>
                                        <tbody class="add_tnoni">
                                            @if (isset($m_nonitems) && $m_nonitems)
                                                @foreach ($m_nonitems as $key => $value)
                                                    <tr class="rowCount1" data-id="{{ $value->noninvemtory_id }}">
                                                        <td class="width_1_p text-start">
                                                            <p class="set_sn1"></p>
                                                        </td>
                                                        <td><input type="hidden" value="{{ $value->noninvemtory_id }}"
                                                                name="noniitem_id[]">
                                                            <span>{{ getNonInventroyItem($value->noninvemtory_id) }}</span>
                                                        </td>
                                                        <td></td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="number" id="total_1" name="total_1[]"
                                                                    class="cal_row  form-control @error('title') is-invalid @enderror aligning total_c1"
                                                                    onfocus="select();" value="{{ $value->nin_cost }}"
                                                                    placeholder="Total">
                                                                <span class="input-group-text">
                                                                    {{ $setting->currency }}</span>
                                                            </div>
                                                        </td>
                                                        <td width="20%">
                                                            <select
                                                                class="form-control @error('title') is-invalid @enderror"
                                                                name="account_id[]" id="account_id{{ $value->id }}">
                                                                <option value="">@lang('index.select')</option>
                                                                @foreach ($accounts as $account)
                                                                    <option
                                                                        {{ isset($value->account_id) && $value->account_id == $account->id ? 'selected' : '' }}
                                                                        id="account_id" class="account_id"
                                                                        value="{{ $account->id }}">{{ $account->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="text-end"><a
                                                                class="btn btn-xs del_row dlt_button"><iconify-icon
                                                                    icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    <button id="fpnonitem" class="btn bg-blue-btn w-20 mt-2"
                                        type="button">@lang('index.add_more')</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="w-5"></td>
                                            <td class="w-30"></td>
                                            <td class="w-20"></td>
                                            <td class="w-20"><label class="custom_label">@lang('index.total_non_inventory_cost')</label>
                                                <div class="input-group">
                                                    <input type="text" name="mnoninitem_total" id="noninitem_total"
                                                        class="form-control @error('mnoninitem_total') is-invalid @enderror"
                                                        readonly placeholder="{{ __('index.total_non_inventory_cost') }}"
                                                        value="{{ isset($obj->mnoninitem_total) ? $obj->mnoninitem_total : old('mnoninitem_total') }}">
                                                    <span class="input-group-text">{{ $setting->currency }}</span>
                                                </div>
                                            </td>
                                            <td class="w-20"></td>
                                            <td class="w-5 text-end"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <hr>
                    <div class="row mb-2">
                        <div class="col-md-3">
                            <label class="custom_label">@lang('index.total_cost')</label>
                            <div class="input-group">
                                <input type="text" name="mtotal_cost" id="total_cost"
                                    class="form-control @error('mtotal_cost') is-invalid @enderror total_cos margin_cal"
                                    readonly placeholder="Total Non Inventory Cost"
                                    value="{{ isset($obj->mtotal_cost) ? $obj->mtotal_cost : old('mtotal_cost') }}">
                                <span class="input-group-text">{{ $setting->currency }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="custom_label">@lang('index.profit_margin') (%)</label>
                            <div class="input-group">
                                <input type="text" name="mprofit_margin" id="profit_margin"
                                    class="form-control @error('mprofit_margin') is-invalid @enderror profit_margin margin_cal integerchk"
                                    placeholder="Profit Margin"
                                    value="{{ isset($obj->mprofit_margin) ? $obj->mprofit_margin : old('mprofit_margin') }}" readonly>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('index.tax_type') </label>
                                <input type="text" name="tax_type" id="mtax_type" class="form-control" value="{{ isset($obj) && $obj ? $obj->tax_type : old('tax_type') }}" placeholder="Tax Type" readonly >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tax Value </label>
                                <input type="text" name="tax_value" id="mtax_value" class="form-control" value="{{ isset($obj) && $obj ? $obj->tax_value : old('tax_value') }}" placeholder="tax Value" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="custom_label">@lang('index.sale_price') </label>
                            <div class="input-group">
                                <input type="text" name="msale_price" id="sale_price"
                                    class="form-control @error('msale_price') is-invalid @enderror margin_cal sale_price"
                                    readonly placeholder="Sale Price"
                                    value="{{ isset($obj->msale_price) ? $obj->msale_price : old('msale_price') }}">
                                <span class="input-group-text">{{ $setting->currency }}</span>
                            </div>
                        </div>
                    </div> --}}
                    <hr>
                    <div class="row {{ isset($obj) ? '' : 'hidden_sec' }}">
                        <div class="clearfix"></div>
                        <h4 class="mb-0">@lang('index.manufacture_stages')</h4>
                        <p class="text-danger stage_check_error d-none"></p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="purchase_cart">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="width_1_p">@lang('index.sn')</th>
                                                <th class="width_20_p stage_header">@lang('index.check')</th>
                                                <th class="width_20_p stage_header text-left">
                                                    @lang('index.stage')</th>
                                                <th class="width_20_p stage_header">@lang('index.required_time')</th>
                                            </tr>
                                        </thead>
                                        <tbody class="add_tstage">
                                            @if (isset($finishProductStage) && $finishProductStage)
                                                <?php
                                                $total_month = 0;
                                                $total_day = 0;
                                                $total_hour = 0;
                                                $total_mimute = 0;
                                                $i = 1;
                                                ?>
                                                @foreach ($finishProductStage as $key => $value)
                                                    <?php
                                                    $checked = $disabled ='';
                                                    $tmp_key = $key + 1;
                                                    if ($obj->stage_counter == $tmp_key) {
                                                        $checked = 'checked=checked';
                                                    }
                                                    if ($tmp_key < $obj->stage_counter) {
                                                        $disabled = 'disabled';
                                                    }
                                                    $total_value = $value->stage_month * 2592000 + $value->stage_day * 86400 + $value->stage_hours * 3600 + $value->stage_minute * 60;
                                                    $months = floor($total_value / 2592000);
                                                    $hours = floor(($total_value % 86400) / 3600);
                                                    $days = floor(($total_value % 2592000) / 86400);
                                                    $minuts = floor(($total_value % 3600) / 60);
                                                    
                                                    $total_month += $months;
                                                    $total_hour += $hours;
                                                    $total_day += $days;
                                                    $total_mimute += $minuts;
                                                    
                                                    $total_stages = $total_month * 2592000 + $total_hour * 3600 + $total_day * 86400 + $total_mimute * 60;
                                                    $total_months = floor($total_stages / 2592000);
                                                    $total_hours = floor(($total_stages % 86400) / 3600);
                                                    $total_days = floor(($total_stages % 2592000) / 86400);
                                                    $total_minutes = floor(($total_stages % 3600) / 60);
                                                    
                                                    ?>
                                                    <tr class="rowCount2 align-baseline"
                                                        data-id="{{ $value->productionstage_id }}">
                                                        <td class="width_1_p ir_txt_center">
                                                            <p class="set_sn2"></p>
                                                        </td>
                                                        <td class="width_1_p">
                                                            <input
                                                                class="form-check-input set_class custom_checkbox"
                                                                data-stage_name="{{ getProductionStages($value->productionstage_id) }}"
                                                                type="radio"
                                                                id="checkboxNoLabel_{{ $i }}"
                                                                name="stage_check"
                                                                value="{{ $i }}"
                                                                {{ $checked }}
                                                                {{ $disabled }}
                                                            >

                                                            {{-- Hidden input to preserve value if disabled --}}
                                                            @if($disabled)
                                                                <input type="hidden" name="stage_check_hidden[]" value="{{ $i }}">
                                                            @endif
                                                        </td>
                                                        <td class="stage_name text-left"><input type="hidden"
                                                                value="{{ $value->productionstage_id }}"
                                                                name="producstage_id[]">
                                                            <span>{{ getProductionStages($value->productionstage_id) }}</span>
                                                        </td>
                                                        <td>
                                                            <div class="row">
                                                                {{-- <div class="col-xl-3 col-md-4">
                                                                    <div class="input-group">
                                                                        <input
                                                                            class="form-control @error('title') is-invalid @enderror stage_aligning"
                                                                            type="number" id="month_limit"
                                                                            name="stage_month[]"
                                                                            class="form-control @error('title') is-invalid @enderror"
                                                                            min="0" max="12"
                                                                            value="{{ $value->stage_month }}"
                                                                            placeholder="Month"><span
                                                                            class="input-group-text">@lang('index.months')</span>
                                                                    </div>
                                                                </div> --}}
                                                                {{-- <div class="col-xl-3 col-md-4">
                                                                    <div class="input-group">
                                                                        <input
                                                                            class="form-control @error('title') is-invalid @enderror stage_aligning"
                                                                            type="number" id="day_limit"
                                                                            name="stage_day[]" min="0"
                                                                            max="31"
                                                                            value="{{ $value->stage_day }}"
                                                                            placeholder="Days"><span
                                                                            class="input-group-text">@lang('index.days')</span>
                                                                    </div>
                                                                </div> --}}
                                                                <div class="col-xl-6 col-md-6">
                                                                    <div class="input-group">
                                                                        <input
                                                                            class="form-control @error('title') is-invalid @enderror stage_aligning"
                                                                            type="number" id="hours_limit"
                                                                            name="stage_hours[]" min="0"
                                                                            max="24"
                                                                            value="{{ $value->stage_hours }}"
                                                                            placeholder="Hours"><span
                                                                            class="input-group-text">@lang('index.hours')</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6 col-md-6">
                                                                    <div class="input-group">
                                                                        <input
                                                                            class="form-control @error('title') is-invalid @enderror stage_aligning"
                                                                            type="number" id="minute_limit"
                                                                            name="stage_minute[]" min="0"
                                                                            max="60"
                                                                            value="{{ $value->stage_minute }}"
                                                                            placeholder="Minutes"><span
                                                                            class="input-group-text">@lang('index.minutes')</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                    ?>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tr>
                                            <td class="width_1_p"></td>
                                            <td class="width_1_p"></td>
                                            <td class="width_1_p">@lang('index.total')</td>
                                            <td>
                                                <div class="row">
                                                    {{-- <div class="col-md-3">
                                                        <div class="input-group">
                                                            <input
                                                                class="form-control @error('title') is-invalid @enderror stage_aligning stage_color"
                                                                readonly type="text" id="t_month" name="t_month"
                                                                value="{{ isset($total_months) && $total_months ? $total_months : '' }}"
                                                                placeholder="Months">
                                                            <span class="input-group-text">@lang('index.months')</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="input-group">
                                                            <input
                                                                class="form-control @error('title') is-invalid @enderror stage_aligning stage_color"
                                                                readonly type="text" id="t_day" name="t_day"
                                                                value="{{ isset($total_days) && $total_days ? $total_days : '' }}"
                                                                placeholder="Days">
                                                            <span class="input-group-text">@lang('index.days')</span>
                                                        </div>
                                                    </div> --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input
                                                                class="form-control @error('title') is-invalid @enderror stage_aligning stage_color"
                                                                readonly type="text" id="t_hours" name="t_hours"
                                                                value="{{ isset($total_hours) && $total_hours ? $total_hours : '' }}"
                                                                placeholder="Hours">
                                                            <span class="input-group-text">@lang('index.hours')</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input
                                                                class="form-control @error('title') is-invalid @enderror stage_aligning stage_color"
                                                                readonly type="text" id="t_minute" name="t_minute"
                                                                value="{{ isset($total_minutes) && $total_minutes ? $total_minutes : '' }}"
                                                                placeholder="Minutes">
                                                            <span class="input-group-text">@lang('index.minutes')</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div><br>
                    <div class="row {{ isset($obj) ? '' : 'hidden_sec' }}">
                        <div class="clearfix"></div>
                        <h4 class="mb-0">@lang('index.manufacture_scheduling')</h4>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="table-responsive" id="purchase_cart">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="w-5"></th>
                                                <th class="w-5 text-start">@lang('index.sn')</th>
                                                <th class="w-20">@lang('index.stage')</th>
                                                <th class="w-25">
                                                    @lang('index.task')</th>
                                                <th class="w-25">@lang('index.assign_to')</th>
                                                <th class="w-5">@lang('index.total_hours')</th>
                                                <th class="w-25">@lang('index.task_status')</th>
                                                <th class="w-30">@lang('index.start_date')</th>
                                                <th class="w-25">@lang('index.complete_date')</th>
                                                <th class="w-5 text-center">@lang('index.actions')</th>
                                            </tr>
                                        </thead>
                                        <tbody class="add_production_scheduling sort_menu">
                                            @if (isset($productionScheduling) && $productionScheduling)
                                                @php($m = 0)
                                                @foreach ($productionScheduling as $key => $value)
                                                    <tr class="rowCount3" data-id="{{ $value->production_stage_id }}"
                                                        data-row="{{ ++$m }}">
                                                        <td><span class="handle me-2"><iconify-icon
                                                                    icon="radix-icons:move"></iconify-icon></span></td>
                                                        <td class="width_1_p text-start">
                                                            <p class="set_sn4">{{ $m }}</p>
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                class="form-control"
                                                                value="{{ isset($value->production_stage_id) ? getProductionStage($value->production_stage_id) : '' }}"
                                                                disabled>
                                                            <input type="hidden"
                                                                name="productionstage_id_scheduling[]"
                                                                value="{{ isset($value->production_stage_id) ? $value->production_stage_id . '|' . getProductionStage($value->production_stage_id) : '' }}">
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="text" id="manufacture_task" name="task[]"
                                                                    class="form-control @error('title') is-invalid @enderror changeableInput"
                                                                    value="{{ $value->task }}" placeholder="Task">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <select
                                                                class="form-control manufacture_stage_id changeableInput"
                                                                name="user_id_scheduling[]"
                                                                id="manufacture_user_id_{{ $m }}">
                                                                <option value="" disabled>@lang('index.select')</option>
                                                                @if (isset($employees) && $employees)
                                                                    @foreach ($employees as $emp)
                                                                        <option
                                                                            {{ isset($value->user_id) && $value->user_id == $emp->id ? 'selected' : '' }}
                                                                            value="{{ $emp->id }}">
                                                                            {{ $emp->name }}({{ $emp->emp_code }})</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="hidden" name="task_note[]"
                                                                    class="form-control @error('title') is-invalid @enderror changeableInput"
                                                                    value="{{ $value->task_note }}" placeholder="Task Note">
                                                                <input type="number" id="manufacture_task_hours" name="task_hours[]"
                                                                    class="form-control @error('title') is-invalid @enderror changeableInput"
                                                                    value="{{ $value->task_hours }}" placeholder="Task Hours">
                                                            </div>
                                                        </td>                                                        
                                                        <td>
                                                            <input type="hidden" name="task_status[]" class="edit_post_status" value="{{ $value->task_status }}">
                                                            <select class="form-control task_status changeableInput" id="task_status_{{ $m }}" {{ isset($value->task_status) && $value->task_status=="3" ? "disabled" : "" }}>
                                                                <option value="" disabled>@lang('index.select')</option>
                                                                <option {{ isset($value->task_status) && ($value->task_status == "1" || $value->task_status == "" ) ? 'selected' : '' }} value="1">Pending</option>
                                                                <option {{ isset($value->task_status) && $value->task_status == "2" ? 'selected' : '' }} value="2">In Progress</option>
                                                                <option {{ isset($value->task_status) && $value->task_status == "3" ? 'selected' : '' }} value="3">Completed</option>
                                                                {{-- <option
                                                                    {{ isset($value->task_status) && $value->task_status == "4" ? 'selected' : '' }}
                                                                    value="4"
                                                                    {{ isset($value->task_status) && $value->task_status != "3" ? 'disabled' : '' }}>
                                                                    Move To Next Task
                                                                </option> --}}
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="text" name="start_date[]"
                                                                    class="form-control @error('title') is-invalid @enderror changeableInput pstart_date"
                                                                    value="{{ date('d-m-Y',strtotime($value->start_date)) }}"
                                                                    placeholder="Start Date">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="text"
                                                                    name="complete_date[]"
                                                                    class="form-control @error('title') is-invalid @enderror changeableInput pcomplete_date"
                                                                    value="{{ date('d-m-Y',strtotime($value->end_date)) }}"
                                                                    placeholder="Complete Date">
                                                            </div>
                                                            <p class="text-danger end_date_error d-none"></p>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center justify-content-center" id="qc_msg">
                                                                @if(isset($value->task_status) && $value->task_status == "3")
                                                                <button id="qc_add" data-bs-toggle="modal" data-manufacture_id="{{ $value->manufacture_id }}"
                                                                data-production_stage_id="{{ $value->production_stage_id }}"
                                                                data-scheduling_id="{{ $value->id }}"
                                                                data-bs-target="#qcScheduling" class="btn bg-blue-btn w-20" title="QC Check"
                                                                type="button"><i class="fa fa-list-check"></i></button>&nbsp;
                                                                <button id="qc_view" data-bs-toggle="modal"
                                                                data-manufacture_id="{{ $value->manufacture_id }}"
                                                                data-production_stage_id="{{ $value->production_stage_id }}"
                                                                data-scheduling_id="{{ $value->id }}"
                                                                data-bs-target="#qcView" class="btn bg-blue-btn w-20" title="QC Assignment History"
                                                                type="button"><i class="fa fa-user"></i></button>
                                                                @endif
                                                                {{-- <a class="btn btn-xs del_row dlt_button">
                                                                    <iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon>
                                                                </a> --}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    <button id="scheduling_add" data-bs-toggle="modal"
                                        data-bs-target="#productScheduling" class="btn bg-blue-btn w-20 mt-2"
                                        type="button" {{ isset($obj) && isset($move_to_next) && $move_to_next =="N" ? "disabled" : "" }}>@lang('index.add_more')</button>
                                </div>
                            </div>
                            {{-- <div class="col-xl-12 p-0">
                                <div class="gantt"></div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <input type="hidden" name="previous_status"
                                value={{ isset($obj->manufacture_status) ? $obj->manufacture_status : null }}>
                            <input type="hidden" name="previous_quantity"
                                value="{{ isset($obj->product_quantity) ? $obj->product_quantity : null }}">
                            <div class="form-group">
                                <label>@lang('index.status') <span class="required_star">*</span></label>
                                <select
                                    class="form-control @error('manufacture_status') is-invalid @enderror select2 check_required"
                                    name="manufacture_status" id="m_status">
                                    <option value="">@lang('index.select')</option>
                                    @if(isset($obj) && ($obj->manufacture_status != 'inProgress') || isset($obj) && $obj->stage_counter == 0 || !isset($obj))
                                    <option id="status_draft"
                                        {{ (isset($obj->manufacture_status) && $obj->manufacture_status == 'draft') || old('manufacture_status') == 'draft' ? 'selected' : '' }}
                                        value="draft">@lang('index.draft')</option>
                                    @endif
                                    <option
                                        {{ (isset($obj->manufacture_status) && $obj->manufacture_status == 'inProgress') || old('manufacture_status') == 'inProgress' ? 'selected' : '' }}
                                        value="inProgress">@lang('index.in_progress')</option>
                                    @if(isset($obj) && ($obj->stage_counter == count($finishProductStage)))
                                        <option {{ (isset($obj->manufacture_status) && $obj->manufacture_status == 'done') || old('manufacture_status') == 'done' ? 'selected' : '' }} value="done">@lang('index.done')</option>
                                    @endif
                                </select>
                                <div class="text-danger d-none"></div>
                                @error('manufacture_status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>DC No </label>
                                <input type="text" name="dc_no" id="dc_no" class="form-control" maxlength="10" placeholder="DC No" value="{{ isset($obj) ? $obj->dc_no : '' }}" readonly>
                                <div class="text-danger d-none"></div>
                                @error('dc_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>Rev </label>
                                <input type="text" name="rev" class="form-control" placeholder="Rev" id="rev" value="{{ isset($obj) ? $obj->rev : '' }}" readonly>
                                <div class="text-danger d-none"></div>
                                @error('rev')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>Operation </label>
                                <input type="text" name="operation" class="form-control" id="operation" placeholder="Operation" value="{{ isset($obj) ? $obj->operation : '' }}" readonly> 
                                <div class="text-danger d-none"></div>
                                @error('operation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.drawer_no') </label>
                                <input type="text" name="drawer_no" class="form-control" id="drawer_no" placeholder="@lang('index.drawer_no')" value="{{ isset($obj) ? $obj->drawer_no : '' }}" readonly>
                                <div class="text-danger d-none"></div>
                                @error('drawer_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 mb-2">
                            <div class="form-group">
                                <label>@lang('index.note')</label>
                                <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror"
                                    placeholder="Note">{{ isset($obj->note) ? $obj->note : old('note') }}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 mb-2">
                            <div class="form-group custom_table">
                                <label>@lang('index.add_a_file') (@lang('index.max_size_5_mb'))</label>
                                <table width="100%">
                                    <tbody>
                                        <tr>
                                            <td width="100%">
                                                <input type="hidden" name="file_old"
                                                    value="{{ isset($obj->file) && $obj->file ? $obj->file : '' }}">
                                                <input type="file" name="file_button[]" id="file_button"
                                                    class="form-control @error('title') is-invalid @enderror file_checker_global image_preview"
                                                    accept="image/png,image/jpeg,image/jgp,image/gif,application/pdf,.doc,.docx"
                                                    multiple>
                                                <p class="text-danger errorFile"></p>
                                                <div class="image-preview-container">
                                                    @if (isset($obj->file) && $obj->file)
                                                        @php($files = explode(',', $obj->file))

                                                        @foreach ($files as $file)
                                                            @php($fileExtension = pathinfo($file, PATHINFO_EXTENSION))
                                                            @if ($fileExtension == 'pdf')
                                                                <a class="text-decoration-none"
                                                                    href="{{ $baseURL }}uploads/manufacture/{{ $file }}"
                                                                    target="_blank">
                                                                    <img src="{{ $baseURL }}assets/images/pdf.png"
                                                                        alt="PDF Preview" class="img-thumbnail mx-2"
                                                                        width="100px">
                                                                </a>
                                                            @elseif($fileExtension == 'doc' || $fileExtension == 'docx')
                                                                <a class="text-decoration-none"
                                                                    href="{{ $baseURL }}uploads/manufacture/{{ $file }}"
                                                                    target="_blank">
                                                                    <img src="{{ $baseURL }}assets/images/word.png"
                                                                        alt="Word Preview" class="img-thumbnail mx-2"
                                                                        width="100px">
                                                                </a>
                                                            @else
                                                                <a class="text-decoration-none"
                                                                    href="{{ $baseURL }}uploads/manufacture/{{ $file }}"
                                                                    target="_blank">
                                                                    <img src="{{ $baseURL }}uploads/manufacture/{{ $file }}"
                                                                        alt="File Preview" class="img-thumbnail mx-2"
                                                                        width="100px">
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
                            <button type="submit" name="submit" value="submit"
                                class="btn bg-blue-btn submit_btn"><iconify-icon
                                    icon="solar:check-circle-broken"></iconify-icon>@lang('index.submit')</button>
                            <button type="button" class="btn bg-blue-btn d-none" id="checkStockButton"
                                data-bs-toggle="modal" data-bs-target="#stockCheck"><iconify-icon
                                    icon="solar:info-circle-broken"></iconify-icon>@lang('index.check_stock')</button>
                            <a class="btn bg-second-btn" href="{{ route('productions.index') }}"><iconify-icon
                                    icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <select id="ram_hidden" class="display_none" name="rmaterials_id">
                <option value="">@lang('index.select')</option>
                @foreach ($rmaterials as $value)
                    <option id="rmaterials_ids" class="rmaterials_ids"
                        value="{{ $value->id . '|' . $value->unit . '|' . getPurchaseSaleUnitById($value->consumption_unit) . '|' . $setting->currency . '|' . $value->rate_per_consumption_unit . '|' . $value->rate_per_unit . '|' . getPurchaseUnitByRMID($value->id) }}">
                        {{ $value->name }}</option>
                @endforeach
            </select>
            <select id="noni_hidden" class="display_none" name="noninvemtory_id">
                <option value="">@lang('index.select')</option>
                @foreach ($nonitem as $value)
                    <option id="noninvemtory_ids" class="noninvemtory_ids"
                        value="{{ $value->id . '|' . $value->nin_cost . '|' . $setting->currency }}">
                        {{ $value->name }}</option>
                @endforeach
            </select>
            <select id="stages_hidden" class="display_none">
                <option value="">@lang('index.select')</option>
                @foreach ($p_stages as $value)
                    <option id="noninvemtory_ids" class="noninvemtory_ids"
                        value="{{ $value->productionstage_id.'|'.getProductionStage($value->productionstage_id) }}">
                        {{ getProductionStage($value->productionstage_id) }}</option>
                @endforeach
            </select>
            <select id="account_hidden" class="display_none" name="account_id">
                <option value="">@lang('index.select')</option>
                @foreach ($accounts as $value)
                    <option id="account_id" class="account_id" value="{{ $value->id }}">{{ $value->name }}
                    </option>
                @endforeach
            </select>
            <select class="form-control d-none" id="task_status_select">
                <option value="" disabled>@lang('index.select')</option>
                <option value="1">Pending</option>
                <option value="2">In Progress</option>
                <option value="3">Completed</option>
            </select>
    </section>
    {{-- Stock Check Modal --}}
    <div class="modal fade" id="stockCheck" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.current_stock')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <form action="{{ route('purchase-generate-customer-order') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="table-responsive" id="check_stock_modal_body">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-blue-btn delivaries_button"><iconify-icon
                                icon="solar:cart-plus-broken"></iconify-icon>
                            @lang('index.purchase')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="qcScheduling" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.qc')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <form id="qc_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 mb-2 col-md-4">
                                <div class="form-group">
                                    <label>@lang('index.assign_to') <span class="required_star">*</span></label>
                                    <select class="form-control @error('qc_user_id') is-invalid @enderror select2"
                                        name="qc_user_id" id="qc_user_id">
                                        <option value="">@lang('index.select')</option>
                                        @if (isset($qc_employees) && $qc_employees)
                                            @foreach ($qc_employees as $emp)
                                                <option value="{{ $emp->id }}">
                                                    {{ $emp->name }}({{ $emp->emp_code }})</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="text-danger qc_user_error"></p>
                                </div>
                            </div>
                            {{-- <div class="col-sm-12 mb-2 col-md-3">
                                <div class="form-group">
                                    <label>@lang('index.qc_status') <span class="required_star">*</span></label>
                                    <select class="form-control @error('qc_status') is-invalid @enderror select2"
                                        name="qc_status" id="qc_status">
                                        <option value="">@lang('index.select')</option>
                                        @if (isset($qc_statuses) && $qc_statuses)
                                            @foreach ($qc_statuses as $status)
                                                <option value="{{ $status->id }}">
                                                    {{ $status->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="text-danger qc_status_error"></p>
                                </div>
                            </div> --}}
                            <div class="col-sm-12 mb-2 col-md-4">
                                <div class="form-group">
                                    <label>@lang('index.start_date') <span class="required_star">*</span></label>
                                    <input type="text" name="start_date"
                                        class="form-control @error('title') is-invalid @enderror"
                                        id="qc_start_date" placeholder="Start Date">
                                    <p class="text-danger start_date_error"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-4">
                                <div class="form-group">
                                    <label>@lang('index.complete_date') <span class="required_star">*</span></label>
                                    <input type="text" name="complete_date"
                                        class="form-control @error('title') is-invalid @enderror"
                                        id="qc_complete_date" placeholder="Complete Date">
                                    <p class="text-danger end_date_error"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-12">
                                <div class="form-group">
                                    <label>@lang('index.note') </label>
                                    <textarea name="qc_note" id="qc_note" class="form-control @error('note') is-invalid @enderror" placeholder="Note" maxlength="100"></textarea>
                                    <input type="hidden" name="manufacture_id" id="manufacture_id">
                                    <input type="hidden" name="production_stage_id" id="production_stage_id">
                                    <input type="hidden" name="scheduling_id" id="scheduling_id">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-blue-btn qc_scheduling_btn"><iconify-icon
                                icon="solar:check-circle-broken"></iconify-icon>
                            @lang('index.add')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="productScheduling" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.add_product_scheduling')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <form id="product_scheduling_form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label>@lang('index.stage') <span class="required_star">*</span></label>
                                    <select class="form-control @error('title') is-invalid @enderror select2"
                                        name="productionstage_id" id="productionstage_id">
                                        <option value="">@lang('index.select')</option>
                                        @if (isset($p_stages) && $p_stages)
                                            @foreach ($p_stages as $value)
                                                <option value="{{ $value->productionstage_id.'|'.getProductionStage($value->productionstage_id) }}">
                                                    {{ getProductionStage($value->productionstage_id) }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="text-danger stage_error"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label>@lang('index.task') <span class="required_star">*</span></label>
                                    <input type="text" name="task"
                                        class="form-control @error('title') is-invalid @enderror" id="task"
                                        placeholder="Task">
                                    <p class="text-danger task_error"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label>@lang('index.assign_to') <span class="required_star">*</span></label>
                                    <select class="form-control @error('user_id') is-invalid @enderror select2"
                                        name="user_id" id="user_id">
                                        <option value="">@lang('index.select')</option>
                                        @if (isset($employees) && $employees)
                                            @foreach ($employees as $emp)
                                                <option value="{{ $emp->id }}">
                                                    {{ $emp->name }}({{ $emp->emp_code }})</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="text-danger user_error"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label>@lang('index.total_hours') <span class="required_star">*</span></label>
                                    <input type="number" name="task_hours"
                                        class="form-control @error('task_hours') is-invalid @enderror" id="task_hours"
                                        placeholder="Task Hours">
                                    <p class="text-danger task_hrs_error"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label>@lang('index.start_date') <span class="required_star">*</span></label>
                                    <input type="text" name="start_date"
                                        class="form-control @error('title') is-invalid @enderror"
                                        id="ps_start_date" placeholder="Start Date">
                                    <p class="text-danger start_date_error"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label>@lang('index.complete_date') <span class="required_star">*</span></label>
                                    <input type="text" name="complete_date"
                                        class="form-control @error('title') is-invalid @enderror"
                                        id="ps_complete_date" placeholder="Complete Date">
                                    <p class="text-danger end_date_error"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-12">
                                <div class="form-group">
                                    <label>@lang('index.note') </label>
                                    <textarea name="task_note" id="task_note" class="form-control @error('note') is-invalid @enderror" placeholder="Note" maxlength="100">{{ isset($obj->task_note) ? $obj->task_note : old('task_note') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-blue-btn product_scheduling_button"><iconify-icon
                                icon="solar:check-circle-broken"></iconify-icon>
                            @lang('index.add')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="qcView" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">QC Assignment History</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                {{-- <form action="{{ route('purchase-generate-customer-order') }}" method="post">
                    @csrf --}}
                    <div class="modal-body">
                        <div class="table-responsive" id="qc_log_modal_body">

                        </div>
                    </div>
                    <input type="hidden" name="qa_manufacture_id" id="qa_manufacture_id">
                    <input type="hidden" name="qa_production_stage_id" id="qa_production_stage_id">
                    <input type="hidden" name="qa_scheduling_id" id="qa_scheduling_id">
                    {{-- <div class="modal-footer">
                        <button type="submit" class="btn bg-blue-btn delivaries_button"><iconify-icon
                                icon="solar:cart-plus-broken"></iconify-icon>
                            @lang('index.purchase')</button>
                    </div> --}}
                {{-- </form> --}}
            </div>
        </div>
    </div>
@endsection
@push('top_script')
    <script type="text/javascript" src="{!! $baseURL . 'assets/bower_components/jquery-ui/jquery-ui.min.js' !!}"></script>
@endpush
@section('script')
    <script type="text/javascript" src="{!! $baseURL . 'assets/bower_components/gantt/js/jquery.fn.gantt.js' !!}"></script>
    <script type="text/javascript" src="{!! $baseURL . 'assets/bower_components/gantt/js/jquery.cookie.min.js' !!}"></script>
    <script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/genchat.js' !!}"></script>
    <script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/addManufactures.js?v=2.1' !!}"></script>
    <script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/imagePreview.js' !!}"></script>
@endsection
