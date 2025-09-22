@extends('layouts.app')

@section('script_top')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <?php
    $baseURL = getBaseURL();
    $setting = getSettingsInfo();
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
            <!-- general form elements -->
            <div class="table-box">
                <!-- form start -->
                {!! Form::model(isset($obj) && $obj ? $obj : '', [
                    'id' => 'customer_quote_form',
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'enctype' => 'multipart/form-data',
                    'route' => ['quotation.update', isset($obj->id) && $obj->id ? $obj->id : ''],
                ]) !!}

                @csrf
                <div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.quotation_no') <span class="required_star">*</span></label>
                                {!! Form::text('quotation_no', isset($obj->quotation_no) && $obj->quotation_no ? $obj->quotation_no : $ref_no, [
                                    'class' => 'check_required form-control',
                                    'id' => 'quotation_no',
                                    'onfocus' => 'select()',
                                    'readonly' => '',
                                    'placeholder' => 'Quotation No',
                                ]) !!}
                                <div class="text-danger d-none"></div>
                                @if ($errors->has('quotation_no'))
                                    <div class="error_alert text-danger">
                                        {{ $errors->first('quotation_no') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.customers') (@lang('index.code'))<span class="required_star">*</span></label>
                                <div class="d-flex align-items-center">
                                    <div class="w-100">
                                        <select class="form-control select2" id="customer_id" name="customer_id">
                                            <option value="">@lang('index.select_customer')</option>
                                            @foreach ($customers as $value)
                                                <option
                                                    {{ isset($obj->customer_id) && $obj->customer_id == $value->id ? 'selected' : '' }}
                                                    value="{{ $value->id }}">{{ $value->name }} ({{ $value->customer_id }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="text-danger d-none"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.quote_date') <span class="required_star">*</span></label>
                                {!! Form::text('quote_date', isset($obj->quote_date) && $obj->quote_date ? date('d-m-Y',strtotime($obj->quote_date)) : old('quote_date'), [
                                    'id' => 'quote_date',
                                    'class' => 'form-control',
                                    'placeholder' => 'Quotation Date',
                                ]) !!}
                                <div class="text-danger d-none"></div>
                                @if ($errors->has('quote_date'))
                                    <div class="error_alert text-danger">
                                        {{ $errors->first('quote_date') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.part_name') (@lang('index.part_no'))<span class="required_star">*</span></label>
                                <select class="form-control select2 select2-hidden-accessible" name="product_id"
                                    id="product_id">
                                    <option value="">@lang('index.select')</option>
                                    @foreach ($finishProducts as $fp)
                                        <option value="{{ $fp->id . '|' . $fp->name . ' (' . $fp->code . ')|' . $fp->name . '|' . $fp->sale_price . '|' . getPurchaseSaleUnitById($fp->unit) . '|' . $setting->currency . '|' . $fp->stock_method }}">{{ $fp->name . '(' . $fp->code . ')' }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger d-none"></div>
                                @if ($errors->has('selected_product_id'))
                                    <div class="error_alert text-danger">
                                        {{ $errors->first('selected_product_id') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive" id="purchase_cart">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="w-5 text-start">@lang('index.sn')</th>
                                            <th class="w-30">@lang('index.part_name')(@lang('index.part_no'))</th>
                                            <th class="w-15">@lang('index.sale_price')</th>
                                            <th class="w-15">@lang('index.quantity')</th>
                                            <th class="w-15">@lang('index.total') </th>
                                            <th class="w-5 ir_txt_center">@lang('index.actions')</th>
                                        </tr>
                                    </thead>
                                    <tbody class="add_tr">
                                        @if (isset($quotation_details) && $quotation_details)
                                            @foreach ($quotation_details as $key => $value)
                                                <?php
                                                $productInfo = getFinishedProductInfo($value->product_id);
                                                ?>
                                                <tr class="rowCount" data-id="{{ $value->product_id }}">
                                                    <td class="width_1_p ir_txt_center">
                                                        <p class="set_sn"></p>
                                                    </td>
                                                    <td><input type="hidden" value="{{ $value->product_id }}"
                                                            name="selected_product_id[]">
                                                        <span>{{ $productInfo->name }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <input type="number" name="unit_price[]"
                                                                onfocus="this.select();"
                                                                class="check_required form-control integerchk input_aligning unit_price_c cal_row"
                                                                placeholder="Unit Price" value="{{ $value->unit_price }}"
                                                                id="unit_price_1">
                                                            <span class="input-group-text"> {{ $setting->currency }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <input type="number" data-countid="1" id="qty_1"
                                                                name="quantity[]" onfocus="this.select();"
                                                                class="check_required form-control integerchk input_aligning qty_c cal_row"
                                                                value="{{ $value->quantity }}"
                                                                placeholder="Quantity">
                                                            <span class="input-group-text">KG</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <input type="number" id="total_1" name="total[]"
                                                                class="form-control input_aligning total_c"
                                                                value="{{ $value->total }}" placeholder="Total"
                                                                readonly="">
                                                            <span class="input-group-text"> {{ $setting->currency }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="ir_txt_center"><a
                                                            class="btn btn-xs del_row dlt_button"><iconify-icon
                                                                icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('index.note')</label>
                                {!! Form::textarea('note', isset($obj) ? $obj->note : '', [
                                    'class' => 'form-control',
                                    'id' => 'note',
                                    'placeholder' => 'Note',
                                    'rows' => '3',
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-3">
                            <div class="row">
                                <label>@lang('index.subtotal')</label>
                                <div class="input-group">
                                    {!! Form::text('subtotal', isset($obj->subtotal) && $obj->subtotal ? $obj->subtotal : null, [
                                        'class' => 'form-control',
                                        'readonly' => '',
                                        'id' => 'subtotal',
                                        'placeholder' => 'Sub Total',
                                    ]) !!}
                                    <span class="input-group-text">{{ $setting->currency }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <label>@lang('index.other')</label>
                                <div class="input-group">
                                    {!! Form::text('other', isset($obj->other) && $obj->other ? $obj->other : null, [
                                        'class' => 'form-control integerchk cal_row',
                                        'id' => 'other',
                                        'placeholder' => 'Other',
                                    ]) !!}
                                    <span class="input-group-text">{{ $setting->currency }}</span>
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                <label>@lang('index.discount')</label>
                                {!! Form::text('discount', isset($obj->discount) && $obj->discount ? $obj->discount : null, [
                                    'class' => 'form-control discount cal_row',
                                    'data-special_ignore' => 'ignore',
                                    'id' => 'discount',
                                    'placeholder' => 'Discount',
                                ]) !!}
                            </div> --}}
                            <div class="row">
                                <label>@lang('index.g_total') <span class="required_star">*</span></label>
                                <div class="input-group">
                                    {!! Form::text('grand_total', isset($obj->grand_total) && $obj->grand_total ? $obj->grand_total : null, [
                                        'class' => 'form-control',
                                        'readonly' => '',
                                        'id' => 'grand_total',
                                        'placeholder' => 'G.Total',
                                    ]) !!}
                                    <span class="input-group-text">{{ $setting->currency }}</span>
                                </div>
                            </div>
                        </div>
                        <input class="form-control supplier_credit_limit" type="hidden">
                    </div>
                    <!-- /.box-body -->
                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-12 mb-2 d-flex gap-3 flex-column flex-md-row">
                            <input type="hidden" name="button_click_type" id="button_click_type">
                            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><iconify-icon
                                    icon="solar:check-circle-broken"></iconify-icon>@lang('index.submit')</button>
                            <a class="btn bg-second-btn" href="{{ route('quotation.index') }}"><iconify-icon
                                    icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
    <div class="modal fade" id="cartPreviewModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">
                        @lang('index.select_finish_product')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">@lang('index.part_name') (@lang('index.part_no')) <span
                                    class="required_star">*</span></label>
                            <div class="col-sm-12">
                                <p id="item_name_modal" readonly=""></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">@lang('index.sale_price') <span
                                            class="required_star">*</span></label>
                                    <div class="col-sm-12">
                                        <input type="text" autocomplete="off"
                                            class="form-control integerchk1 unit_price_modal" onfocus="select();"
                                            name="unit_price_modal" id="" placeholder="@lang('index.sale_price')" value="">
                                        <input type="hidden" name="item_id_modal" id="item_id_modal" value="">
                                        <input type="hidden" name="item_currency_modal" id="item_currency_modal"
                                            value="">
                                        <input type="hidden" name="item_unit_modal" id="item_unit_modal" value="">
                                        <input type="hidden" name="item_st_method" id="item_st_method" value="">
                                        <input type="hidden" name="item_params" id="item_params" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="custom_label">@lang('index.quantity') <span class="required_star">*</span></label>
                                <div class="input-group">
                                    <input type="number" autocomplete="off" min="1" class="form-control integerchk1"
                                        onfocus="select();" name="qty_modal" id="qty_modal" placeholder="Quantity"
                                        value="1">
                                    <span class="input-group-text modal_unit_name"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer ir_d_block">
                    <button type="button" class="btn bg-blue-btn" id="addToCart"><iconify-icon
                            icon="solar:check-circle-broken"></iconify-icon>@lang('index.add_to_cart')</button>
                </div>
                <input type="hidden" id="quotation_page" value="1" />
            </div>
        </div>
    </div>
@endsection
@section('script')
    <?php
    $baseURL = getBaseURL();
    ?>
    <script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/customer_quotation.js' !!}"></script>
    <script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/addCustomerSales.js' !!}"></script>
@endsection
