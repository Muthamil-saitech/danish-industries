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
        @include('utilities.messages')
        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- form start -->
                {!! Form::model(isset($obj) && $obj ? $obj : '', [
                    'id' => 'dc_form',
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'enctype' => 'multipart/form-data',
                    'route' => ['quotation.update', isset($obj->id) && $obj->id ? $obj->id : ''],
                ]) !!}

                @csrf
                <div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.challan_date') <span class="required_star">*</span></label>
                                {!! Form::text('challan_date', isset($obj->challan_date) && $obj->challan_date ? $obj->challan_date : (old('challan_date') ?: date('d-m-Y')), [
                                    'class' => 'form-control',
                                    'id' => 'challan_date',
                                    'placeholder' => 'DC Date',
                                ]) !!}
                                @if ($errors->has('challan_date'))
                                    <div class="error_alert text-danger">
                                        {{ $errors->first('challan_date') }}
                                    </div>
                                @endif
                                <div class="text-danger d-none"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.challan_no') <span class="required_star">*</span></label>
                                {!! Form::text('challan_no', isset($obj->challan_no) && $obj->challan_no ? $obj->challan_no : old('challan_no'), [
                                    'class' => 'check_required form-control',
                                    'id' => 'challan_no',
                                    'onfocus' => 'select()',
                                    'placeholder' => 'DC No',
                                ]) !!}
                                @if ($errors->has('challan_no'))
                                    <div class="error_alert text-danger">
                                        {{ $errors->first('challan_no') }}
                                    </div>
                                @endif
                                <div class="text-danger d-none"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.doc_no') <span class="required_star">*</span></label>
                                {!! Form::text('material_doc_no', isset($obj->material_doc_no) && $obj->material_doc_no ? $obj->material_doc_no : old('material_doc_no'), [
                                    'class' => 'check_required form-control',
                                    'id' => 'material_doc_no',
                                    'onfocus' => 'select()',
                                    'placeholder' => 'Material Doc No',
                                ]) !!}
                                @if ($errors->has('material_doc_no'))
                                    <div class="error_alert text-danger">
                                        {{ $errors->first('material_doc_no') }}
                                    </div>
                                @endif
                                <div class="text-danger d-none"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.customer') <span class="required_star">*</span></label>
                                <div class="d-flex align-items-center">
                                    <div class="w-100">
                                        <input type="hidden" value="{{ isset($obj) && $obj ? $obj->customer_id : '' }}" name="customer_id">
                                        <select class="form-control select2" id="dccustomer_id" name="customer_id" {{ isset($obj) && $obj ? 'disabled' : '' }}>
                                            <option value="">@lang('index.select_customer')</option>
                                            @foreach ($customers as $value)
                                                <option
                                                    {{ isset($obj->customer_id) && $obj->customer_id == $value->id ? 'selected' : '' }}
                                                    value="{{ $value->id }}">{{ $value->name }} ({{ $value->customer_id }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @if ($errors->has('dccustomer_id'))
                                    <div class="error_alert text-danger">
                                        {{ $errors->first('dccustomer_id') }}
                                    </div>
                                @endif
                                <div class="text-danger d-none customerErr"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.gst_no') </label>
                                {!! Form::text('customer_gst', isset($obj->customer_gst) && $obj->customer_gst ? $obj->customer_gst : old('customer_gst'), [
                                    'class' => 'form-control',
                                    'id' => 'customer_gst',
                                    'onfocus' => 'select()',
                                    'placeholder' => 'Customer GST',
                                    'readonly' => 'true'
                                ]) !!}
                                <div class="text-danger d-none"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.delivery_address') <span class="required_star">*</span></label>
                                {!! Form::textarea('customer_address', isset($obj) ? $obj->customer_address : old('customer_address'), [
                                    'class' => 'form-control',
                                    'id' => 'customer_address',
                                    'placeholder' => 'Customer Address',
                                    'rows' => '3',
                                ]) !!}
                                <div class="text-danger d-none"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>PPCRC Number (Part Name) <span class="required_star">*</span></label>
                                <select class="form-control select2 select2-hidden-accessible" name="product_id[]" id="dcproduct_id" multiple {{ isset($obj) && $obj ? 'disabled' : '' }}>
                                    <option value="">@lang('index.select')</option>
                                    {{-- @if($finishProducts)
                                        @foreach ($finishProducts as $fp)
                                            <option value="{{ $fp->id . '|' . $fp->name . ' (' . $fp->code . ')|' . $fp->name . '|' . $fp->sale_price . '|' . getPurchaseSaleUnitById($fp->unit) . '|' . $setting->currency . '|' . $fp->stock_method }}">{{ $fp->name . '(' . $fp->code . ')' }}</option>
                                        @endforeach
                                    @endif --}}
                                </select>
                                @if ($errors->has('dcproduct_id'))
                                    <div class="error_alert text-danger">
                                        {{ $errors->first('dcproduct_id') }}
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
                                            {{-- <th class="w-30">@lang('index.finished_product')(@lang('index.code'))</th> --}}
                                            <th class="w-50">@lang('index.part_no')</th>
                                            {{-- <th class="w-50">Rate</th> --}}
                                            <th class="w-50">@lang('index.description')</th>
                                            <th class="w-15">@lang('index.prod_quantity')</th>
                                            {{-- <th class="w-15">@lang('index.raw_quantity')</th> --}}
                                            {{-- <th class="w-15">@lang('index.unit_price')</th> --}}
                                            {{-- <th class="w-15">@lang('index.profit')</th> --}}
                                            {{-- <th class="w-15">@lang('index.subtotal')</th> --}}
                                            {{-- <th class="w-15">@lang('index.unit')</th> --}}
                                            {{-- <th class="w-15">@lang('index.po_no')</th> --}}
                                            <th class="w-15">@lang('index.hsn')</th>
                                            <th class="w-15">@lang('index.dc_ref')</th>
                                            <th class="w-15">@lang('index.dc_ref_date')</th>
                                            <th class="w-15">@lang('index.challan_ref')</th>
                                            <th class="w-30 ir_txt_center">@lang('index.remarks')</th>
                                            {{-- <th class="w-15">@lang('index.sale_price')(₹)</th> --}}
                                            {{-- <th class="w-15">@lang('index.discount')(₹)</th> --}}
                                            {{-- <th class="w-30">@lang('index.tax')(₹) </th> --}}
                                            {{-- <th class="w-30">CGST(%) </th> --}}
                                            {{-- <th class="w-30">CGST(₹) </th> --}}
                                            {{-- <th class="w-30">SGST(%) </th> --}}
                                            {{-- <th class="w-30">SGST(₹) </th> --}}
                                            {{-- <th class="w-30">IGST(%) </th> --}}
                                            {{-- <th class="w-30">IGST(₹) </th> --}}
                                            {{-- <th class="w-30">@lang('index.total')</th> --}}
                                            @if(!isset($obj))<th class="w-5 ir_txt_center">@lang('index.actions')</th>@endif
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
                                                    <td>
                                                        <span>{{ $productInfo->code }}</span>
                                                    </td>
                                                    {{-- <td>
                                                        <span><input type="text" name="price[]" class="form-control" placeholder="Rate" value="{{ $value->price }}" id="finalPrice"></span>
                                                        <div class="text-danger d-none"></div>
                                                    </td> --}}
                                                    <td>
                                                        <input type="hidden" value="{{ $productInfo->id.'|'. $value->customer_order_id }}" name="selected_product_id[]">
                                                        <span>{{ $productInfo->name }} ({{ $productInfo->code }})</span>
                                                    </td>
                                                    <td>
                                                        <span>{{ $value->product_quantity }} {{ getRMUnitById($value->unit_id) }}</span>
                                                    </td>
                                                    {{-- <td>
                                                        <span>{{ $value->raw_qty }}</span>
                                                    </td> --}}
                                                    {{-- <td>
                                                        <span>{{ getAmtCustom($value->unit_price) }}</span>
                                                    </td>
                                                    <td>
                                                        <span>{{ getAmtCustom($value->profit) }}</span>
                                                    </td>
                                                    <td>
                                                        <span>{{ getAmtCustom($value->subtotal + $value->profit) }}</span>
                                                    </td> --}}
                                                    {{-- <td>
                                                        <span>{{ getRMUnitById($value->unit_id) }}</span>
                                                    </td> --}}
                                                    {{-- <td>
                                                        <span>{{ $value->po_no }}<br>{{ getDateFormat($value->po_date) }}</span>
                                                    </td> --}}
                                                    <td>
                                                        <span>{{ $productInfo->hsn_sac_no }}</span>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="dc_ref[]" placeholder="DC Reference" rows="3" cols="50" maxlength="50">{{ $value->dc_ref }}</textarea>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="dc_ref_date[]" class="form-control dc-ref-date" value="{{ $value->dc_ref_date!='' ? date('d-m-Y',strtotime($value->dc_ref_date)) : date('d-m-Y') }}">
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="challan_ref[]" placeholder="Challan Reference" rows="3" cols="50" maxlength="50">{{ $value->challan_ref }}</textarea>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="description[]" placeholder="Description" rows="3" cols="50" maxlength="50">{{ $value->description ?? '' }}</textarea>
                                                    </td>
                                                    {{-- <td>
                                                        <span>{{ $value->sale_price }}</span>
                                                    </td>
                                                    <td>
                                                        <span>{{ $value->disc_value }}</span>
                                                    </td>
                                                    <?php
                                                    $tax_items = getTaxItems($value->tax_type);
                                                    ?>
                                                    <td>
                                                        <span>{{ $value->tax_value }}</span>
                                                    </td>
                                                    @if($productInfo->inter_state=='Y')
                                                        <td>{{ '-' }}</td>
                                                        <td>{{ '-' }}</td>
                                                        <td>{{ '-' }}</td>
                                                        <td>{{ '-' }}</td>
                                                        <td>
                                                            <span>{{ $tax_items->tax_value/2 }}</small></span>
                                                        </td>
                                                        <td>
                                                            <span>{{ $value->tax_value/2 }}</small></span>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <span>{{ $tax_items->tax_value/2 }}</small></span>
                                                        </td>
                                                        <td>
                                                            <span>{{ $value->tax_value/2 }}</small></span>
                                                        </td>
                                                        <td>
                                                            <span>{{ $tax_items->tax_value/2 }}</small></span>
                                                        </td>
                                                        <td>
                                                            <span>{{ $value->tax_value/2 }}</small></span>
                                                        </td>
                                                        <td>{{ '-' }}</td>
                                                        <td>{{ '-' }}</td>
                                                    @endif
                                                    <td>
                                                        <span>{{ $value->msale_price }}</span>
                                                    </td> --}}
                                                    @if(!isset($obj))<td class="ir_txt_center">
                                                        <a class="btn btn-xs del_row dlt_button">
                                                            <iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon>
                                                        </a>
                                                    </td>@endif
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
                        <div class="col-md-6 mt-3">
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
                        <div class="col-md-6 mt-3">
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
                                                @foreach ($errors->get('file_button.*') as $messages)
                                                    @foreach ($messages as $message)
                                                        <div class="error_alert text-danger">{{ $message }}</div>
                                                    @endforeach
                                                @endforeach
                                                <p class="text-danger errorFile"></p>
                                                <div class="image-preview-container">
                                                    @if (isset($obj->file) && $obj->file)
                                                        @php($files = explode(',', $obj->file))
                                                        @foreach ($files as $file)
                                                            @php($fileExtension = pathinfo($file, PATHINFO_EXTENSION))
                                                            @if ($fileExtension == 'pdf')
                                                                <a class="text-decoration-none"
                                                                    href="{{ $baseURL }}uploads/quotation/{{ $file }}"
                                                                    target="_blank">
                                                                    <img src="{{ $baseURL }}assets/images/pdf.png"
                                                                        alt="PDF Preview" class="img-thumbnail mx-2"
                                                                        width="100px">
                                                                </a>
                                                            @elseif($fileExtension == 'doc' || $fileExtension == 'docx')
                                                                <a class="text-decoration-none"
                                                                    href="{{ $baseURL }}uploads/quotation/{{ $file }}"
                                                                    target="_blank">
                                                                    <img src="{{ $baseURL }}assets/images/word.png"
                                                                        alt="Word Preview" class="img-thumbnail mx-2"
                                                                        width="100px">
                                                                </a>
                                                            @else
                                                                <a class="text-decoration-none"
                                                                    href="{{ $baseURL }}uploads/quotation/{{ $file }}"
                                                                    target="_blank">
                                                                    <img src="{{ $baseURL }}uploads/quotation/{{ $file }}"
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
                        {{-- <div class="col-md-3">
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

                            <div class="row">
                                <label>@lang('index.discount')</label>
                                <div class="input-group">
                                    {!! Form::text('discount', isset($obj->discount) && $obj->discount ? $obj->discount : null, [
                                        'class' => 'form-control discount cal_row',
                                        'data-special_ignore' => 'ignore',
                                        'id' => 'discount',
                                        'placeholder' => 'Discount',
                                    ]) !!}
                                    <span class="input-group-text">{{ $setting->currency }}</span>
                                </div>
                            </div>

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
                        <input class="form-control supplier_credit_limit" type="hidden"> --}}
                    </div>
                    <!-- /.box-body -->
                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-12 mb-2 d-flex gap-3 flex-column flex-md-row">
                            <input type="hidden" name="button_click_type" id="button_click_type">
                            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><iconify-icon
                                    icon="solar:check-circle-broken"></iconify-icon>@lang('index.submit')</button>
                            {{-- <button type="button" name="button" id="download_btn" value="button"
                                class="btn bg-blue-btn"><iconify-icon
                                    icon="solar:download-square-broken"></iconify-icon>@lang('index.save_download')</button>
                            <button type="button" name="button" id="email_btn" value="button"
                                class="btn bg-blue-btn"><iconify-icon
                                    icon="material-symbols-light:mark-email-read-outline"></iconify-icon>@lang('index.save_email')</button>
                            <button type="button" name="button" id="print_btn" value="button"
                                class="btn bg-blue-btn"><iconify-icon
                                    icon="solar:printer-2-broken"></iconify-icon>@lang('index.save_print')</button> --}}
                            <a class="btn bg-second-btn" href="{{ route('quotation.index') }}"><iconify-icon
                                    icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
    <div class="modal fade" id="customerModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">
                        @lang('index.add_customer')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="control-label">@lang('index.name')<span class="ir_color_red">
                                            *</span></label>
                                    <div>
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="Name" value="">
                                        <div class="customer_err_msg_contnr">
                                            <p class="customer_err_msg text-danger"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="control-label">@lang('index.phone') <span
                                            class="required_star">*</span></label>
                                    <div>
                                        <input type="text" class="form-control integerchk" id="phone"
                                            name="phone" placeholder="Phone" value="">
                                        <div class="customer_phone_err_msg_contnr err_cust">
                                            <p class="customer_phone_err_msg text-danger"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2">
                                <div class="form-group">
                                    <label class="control-label">@lang('index.email') <span
                                            class="required_star">*</span></label>
                                    <div>
                                        <input type="text" class="form-control" id="emailAddress" name="emailAddress"
                                            placeholder="Email" value="">
                                        <div class="customer_email_err_msg_contnr err_cust">
                                            <p class="customer_email_err_msg text-danger"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="control-label">@lang('index.address')</label>
                                    <div>
                                        <textarea class="form-control" rows="3" name="supAddress" placeholder="Address"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="control-label">@lang('index.note')</label>
                                    <div>
                                        <textarea class="form-control" rows="4" name="note" placeholder="Enter ..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-blue-btn" value="submit" id="addCustomer"><iconify-icon
                            icon="solar:check-circle-broken"></iconify-icon> @lang('index.submit')</button>
                </div>
            </div>
        </div>
    </div>
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
                            <label class="col-sm-4 control-label">@lang('index.product_name') <span
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
                                            name="unit_price_modal" id="" placeholder="Unit Price" value="">
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
                            <div class="col-md-12 d-none" id="batch_sec">
                                <table class="table table-bordered mt-2">
                                    <thead>
                                        <tr>
                                            <th class="w-30">@lang('index.batch_no')</th>
                                            <th class="w-30">@lang('index.current_stock')</th>
                                            <th class="w-40">@lang('index.sale_qty')</th>
                                        </tr>
                                    </thead>
                                    <tbody id="batch_table_body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer ir_d_block">
                    <button type="button" class="btn bg-blue-btn" id="addToCart"><iconify-icon icon="solar:check-circle-broken"></iconify-icon>@lang('index.add_to_cart')</button>
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
    <script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/addSales.js' !!}"></script>
    <script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/customer.js' !!}"></script>
    <script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/quotation.js' !!}"></script>
    <script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/imagePreview.js' !!}"></script>
@endsection
