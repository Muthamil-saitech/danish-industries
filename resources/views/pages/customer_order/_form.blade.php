@php
    $orderType = isset($customerOrder->order_type) && $customerOrder->order_type ? $customerOrder->order_type : '';
@endphp
<input type="hidden" name="currency" id="only_currency_sign" value={{ getCurrencyOnly() }}>
<div>
    <div class="row">
        <div class="col-sm-12 mb-2 col-md-4">
            <div class="form-group">
                <label>@lang('index.po_no') <span class="required_star">*</span></label>
                <input type="text" name="reference_no" id="code"
                    class="check_required form-control @error('reference_no') is-invalid @enderror"
                    placeholder="{{ __('index.po_no') }}"
                    value="{{ isset($customerOrder->reference_no) ? $customerOrder->reference_no : old('reference_no') }}"
                    onfocus="select()" {{ isset($customerOrder) ? 'readonly' : ''  }}>
                <div class="text-danger d-none"></div>
                @error('reference_no')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-sm-12 mb-2 col-md-4">
            <div class="form-group">
                <label>@lang('index.customer') <span class="required_star">*</span></label>
                @if(isset($customerOrder) && $customerOrder->id)
                    <input type="hidden" name="customer_id" value="{{ $customerOrder->customer_id }}">
                    <select class="form-control select2" disabled>
                        <option value="">@lang('index.select')</option>
                        @foreach ($customers as $key => $customer)
                            <option value="{{ $key }}" {{ $customerOrder->customer_id == $key ? 'selected' : '' }}>
                                {{ $customer }}
                            </option>
                        @endforeach
                    </select>
                @else 
                    <select name="customer_id" id="customer_id" class="form-control select2">
                        <option value="">@lang('index.select')</option>
                        @foreach ($customers as $key => $customer)
                            <option value="{{ $key }}" {{ old('customer_id') == $key ? 'selected' : '' }}>
                                {{ $customer }}
                            </option>
                        @endforeach
                    </select>
                @endif
                <div class="text-danger d-none"></div>
                @error('customer_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-sm-12 mb-2 col-md-4">
            <div class="form-group">
                <label>@lang('index.order_type') <span class="required_star">*</span></label>
                @if(isset($customerOrder))
                    <input type="hidden" name="order_type" id="order_type" value="{{ isset($customerOrder) ? $customerOrder->order_type : "" }}">
                    <select class="form-control @error('order_type') is-invalid @enderror select2" {{ isset($customerOrder) ? 'disabled' : ''  }}>
                        <option value="">@lang('index.select')</option>
                        @foreach ($orderTypes as $key => $orderType)
                            <option value="{{ $key }}"
                                {{ isset($customerOrder->order_type) && $customerOrder->order_type == $key ? 'selected' : '' }}>
                                {{ $orderType }}</option>
                        @endforeach
                    </select>
                @else
                    <select name="order_type" id="order_type" class="form-control @error('order_type') is-invalid @enderror select2" {{ isset($customerOrder) ? 'disabled' : ''  }}>
                        <option value="">@lang('index.select')</option>
                        @foreach ($orderTypes as $key => $orderType)
                            <option value="{{ $key }}"
                                {{ isset($customerOrder->order_type) && $customerOrder->order_type == $key ? 'selected' : '' }}>
                                {{ $orderType }}</option>
                        @endforeach
                    </select>
                @endif
                <div class="text-danger d-none"></div>
                @error('order_type')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-12 col-md-6 mb-2 col-lg-8">
            <div class="form-group">
                <label>@lang('index.delivery_address')</label>
                <textarea name="delivery_address" id="delivery_address" cols="30" rows="10" class="form-control @error('delivery_address') is-invalid @enderror" placeholder="{{ __('index.delivery_address') }}">{{ isset($customerOrder->delivery_address) ? $customerOrder->delivery_address : old('delivery_address') }}</textarea>
                <div class="text-danger d-none"></div>
                @error('delivery_address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive" id="fprm">
                @php
                    $showIColumns = false;
                    $showCSColumns = false;
                    if (isset($orderDetails)) {
                        foreach ($orderDetails as $od) {
                            if ($od->inter_state === 'Y') {
                                $showIColumns = true;
                            }
                            if ($od->inter_state === 'N') {
                                $showCSColumns = true;
                            }
                        }
                    }
                @endphp
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-50-p">@lang('index.sn')</th>
                            <th class="w-220-p">Part Name(Part No)</th>
                            <th class="w-220-p">@lang('index.raw_material_name')(Code)</th>
                            <th class="w-220-p">@lang('index.raw_quantity')</th>
                            <th class="w-220-p">@lang('index.prod_quantity')</th>
                            <th class="w-220-p">@lang('index.unit_price')</th>
                            {{-- <th class="w-220-p">@lang('index.discount')</th> --}}
                            <th class="w-220-p">@lang('index.tax_type')</th>
                            <th class="w-220-p">@lang('index.inter_state')</th>
                            <th class="w-75-p" id="cgst_th" style="{{ $showCSColumns ? '' : 'display: none;' }}">CGST (%)</th>
                            <th class="w-75-p" id="sgst_th" style="{{ $showCSColumns ? '' : 'display: none;' }}">SGST (%)</th>
                            <th class="w-150-p" id="igst_th" style="{{ $showIColumns ? '' : 'display: none;' }}">IGST (%)</th>
                            <th class="w-220-p">@lang('index.delivery_date')</th>
                            <th class="w-220-p">@lang('index.subtotal')</th>
                            <th class="w-220-p">@lang('index.production_status')</th>
                            <th class="w-220-p">@lang('index.delivered') Quantity</th>
                            @if(!isset($orderDetails))<th class="ir_txt_center">@lang('index.actions')</th>@endif
                        </tr>
                    </thead>
                    <tbody class="add_trm">
                        <?php $i = 0; ?>
                        @if (isset($orderDetails) && $orderDetails)
                            @foreach ($orderDetails as $key => $value)
                                <?php $i++; ?>
                                <tr class="rowCount" data-id="{{ $value->id }}">
                                    <td class="width_1_p ir_txt_center">{{ $i }}</td>
                                    <td>
                                        <input type="hidden" name="product[]" value="{{ $value->product_id }}">
                                        <select id="fproduct_id_{{ $i }}"
                                            class="form-control @error('title') is-invalid @enderror fproduct_id select2" {{ isset($orderDetails) ? 'disabled' : ''  }}>
                                            <option value="">@lang('index.please_select')</option>
                                            @foreach ($productList as $product)
                                                <option value="{{ $product->id }}" @selected($product->id == $value->product_id)>
                                                    {{ $product->name }} ({{ $product->code }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="hidden" name="raw_material[]" value="{{ $value->raw_material_id }}">
                                        <select  id="rm_id_{{ $i }}"
                                            class="form-control @error('title') is-invalid @enderror rm_id select2" {{ isset($orderDetails) ? 'disabled' : ''  }}>
                                            <option value="">@lang('index.please_select')</option>
                                            @foreach ($rawMaterialList as $rm)
                                                <option value="{{ $rm->id }}"
                                                    @selected($rm->id == optional($value)->raw_material_id)>
                                                    {{ $rm->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="raw_quantity[]" onfocus="this.select();"
                                            class="check_required form-control @error('title') is-invalid @enderror integerchk rquantity_c"
                                            placeholder="Raw Quantity" value="{{ $value->raw_qty }}"
                                            id="rquantity_{{ $i }}">
                                    </td>
                                    <td>
                                        <input type="number" name="prod_quantity[]" onfocus="this.select();"
                                            class="check_required form-control @error('title') is-invalid @enderror integerchk pquantity_c"
                                            placeholder="Quantity" value="{{ $value->quantity }}"
                                            id="pquantity_{{ $i }}">
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" name="sale_price[]" onfocus="this.select();"
                                                class="check_required form-control @error('title') is-invalid @enderror integerchk sale_price_c"
                                                placeholder="Unit Price" value="{{ $value->sale_price }}"
                                                id="sale_price_{{ $i }}">
                                            <span class="input-group-text"> {{ $setting->currency }}</span>
                                        </div>
                                    </td>
                                    {{-- <td>
                                        <div class="input-group">
                                            <input type="text" id="discount_percent_{{ $i }}"
                                                name="discount_percent[]" onfocus="this.select();"
                                                class="check_required form-control @error('title') is-invalid @enderror integerchk discount_percent_c"
                                                value="{{ $value->discount_percent }}" placeholder="Discount">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </td> --}}
                                    <td>
                                        <input type="hidden" name="tax_type[]" value="{{ $value->tax_type }}">
                                        <select id="tax_type_id_{{ $i }}"
                                            class="form-control @error('title') is-invalid @enderror tax_type_id select2" {{ isset($orderDetails) ? 'disabled' : ''  }}>
                                            <option value="">@lang('index.please_select')</option>
                                            @foreach ($tax_types as $tax)
                                                <option value="{{ $tax->id }}" @selected($tax->id == $value->tax_type)>
                                                    {{ $tax->tax_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <div class="form-group radio_button_problem">
                                            <div class="radio">
                                                <label>
                                                    <input tabindex="1" type="radio" name="disabled_inter_state[{{ $i }}]" id="inter_state_yes_{{ $i }}"
                                                        value="Y" @if(isset($value->inter_state) && $value->inter_state === 'Y') checked @endif disabled>
                                                    @lang('index.yes')
                                                </label>
                                                <label>
                                                    <input tabindex="2" type="radio" name="disabled_inter_state[{{ $i }}]" id="inter_state_no_{{ $i }}"
                                                        value="N" @if(isset($value->inter_state) && $value->inter_state === 'N') checked @endif disabled>
                                                    @lang('index.no')
                                                </label>
                                            </div>
                                            <input type="hidden" name="inter_state[{{ $i }}]" value="{{ $value->inter_state }}">
                                        </div>
                                    </td>
                                    <td class="cgst_cell" style="{{ ($showCSColumns && $value->inter_state == 'N') ? '' : 'display: none;' }}">
                                        <input type="hidden" name="cgst[]" class="form-control cgst_input" value="{{ $value->cgst }}">
                                        <input type="text" class="form-control cgst_input" value="{{ $value->cgst }}" {{ isset($orderDetails) ? 'disabled' : ''  }}>
                                    </td>
                                    <td class="sgst_cell" style="{{ ($showCSColumns && $value->inter_state == 'N') ? '' : 'display: none;' }}">
                                        <input type="hidden" name="sgst[]" class="form-control sgst_input" value="{{ $value->sgst }}">
                                        <input type="text" class="form-control sgst_input" value="{{ $value->sgst }}" {{ isset($orderDetails) ? 'disabled' : ''  }}>
                                    </td>
                                    <td class="igst_cell" style="{{ ($showIColumns && $value->inter_state == 'Y') ? '' : 'display: none;' }}">
                                        <input type="hidden" name="igst[]" class="form-control igst_input" value="{{ $value->igst }}" {{ isset($orderDetails) ? 'disabled' : ''  }}>
                                        <input type="text" class="form-control igst_input" value="{{ $value->igst }}">
                                    </td>
                                    <td>
                                        @if(isset($orderDetails))
                                            {!! Form::text('disabled_delivery_date_product[]', $value->delivery_date != '' ? date('d-m-Y', strtotime($value->delivery_date)) : '', [
                                                'class' => 'form-control order_delivery_date',
                                                'placeholder' => 'Delivery Date',
                                                'disabled'
                                            ]) !!}
                                            {!! Form::hidden('delivery_date_product[]', $value->delivery_date != '' ? date('d-m-Y', strtotime($value->delivery_date)) : '') !!}
                                        @else
                                            {!! Form::text('delivery_date_product[]', date('d-m-Y'), [
                                                'class' => 'form-control order_delivery_date',
                                                'placeholder' => 'Delivery Date'
                                            ]) !!}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" id="sub_total_{{ $i }}"
                                            name="sub_total[]"
                                            class="form-control @error('title') is-invalid @enderror sub_total_c"
                                            value="{{ $value->sub_total }}" placeholder="Subtotal"
                                            readonly="">
                                            <span class="input-group-text"> {{ $setting->currency }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="hidden" name="status[]" value="{{ $value->status }}">
                                        <select id="fstatus_id_{{ $i }}"
                                            class="form-control @error('title') is-invalid @enderror fstatus_id select2" {{ isset($orderDetails) ? 'disabled' : ''  }}>
                                            <option value="none" {{ $value->status == 'none' ? 'selected' : '' }}>
                                                @lang('index.none')
                                            </option>
                                            <option value="in_progress"
                                                {{ $value->status == 'in_progress' ? 'selected' : '' }}>
                                                @lang('index.in_progress')
                                            </option>
                                            <option value="done" {{ $value->status == 'done' ? 'selected' : '' }}>
                                                @lang('index.done')
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="hidden" name="delivered_qty[]" value="{{ $value->delivered_qty }}">
                                        <input type="number" class="check_required form-control @error('title') is-invalid @enderror integerchk" placeholder="@lang('index.delivered')" value="{{ $value->delivered_qty }}" id="delivered_{{ $i }}" {{ isset($orderDetails) ? 'disabled' : ''  }}>
                                    </td>
                                    @if(!isset($orderDetails))
                                    <td class="ir_txt_center"><a class="btn btn-xs del_row dlt_button"><iconify-icon
                                                icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                @if(!isset($orderDetails))
                <button id="finishProduct" class="btn bg-blue-btn w-10 mb-2 mt-2" type="button">@lang('index.add_more')</button>
                @endif
            </div>
        </div>
    </div>
    <div class="row mt-2 gap-2">
        <button class="btn bg-blue-btn w-20 stockCheck" data-bs-toggle="modal" data-bs-target="#stockCheck"
            type="button">@lang('index.check_stock')</button>
        {{-- <button class="btn bg-blue-btn w-20 estimateCost" data-bs-toggle="modal" data-bs-target="#estimateCost"
            type="button">@lang('index.estimate_cost_date')</button> --}}
    </div>
    <div class="row mt-3 {{ isset($orderInvoice) && count($orderInvoice) > 0 ? '' : 'd-none' }}"
        id="invoice_quotations_sections">
        <div class="col-md-12">
            <h4 class="header_right">@lang('index.invoice_quotations')</h4>

            <div class="table-responsive" id="fprm">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="width_1_p">@lang('index.sn')</th>
                            <th class="width_10_p">@lang('index.type')</th>
                            <th class="width_20_p">@lang('index.date')</th>
                            <th class="width_20_p">@lang('index.amount')</th>
                            <th class="width_20_p">@lang('index.paid')</th>
                            <th class="width_20_p">@lang('index.due')</th>
                            {{-- <th class="width_20_p">@lang('index.order_due')</th> --}}
                            {{-- <th class="width_3_p ir_txt_center">@lang('index.actions')</th> --}}
                        </tr>
                    </thead>
                    <tbody class="add_order_inv">
                        <?php $i = 0; ?>
                        @if (isset($orderInvoice) && $orderInvoice)
                            @foreach ($orderInvoice as $key => $value)
                                <?php $i++; ?>
                                <tr class="rowCount" data-id="{{ $value->id }}">
                                    <td class="width_1_p ir_txt_center">{{ $i }}</td>
                                    <td>
                                        <input type="text" name="invoice_type[]" value="{{ $value->invoice_type }}" id="invoice_type_{{ $i }}"
                                            class="form-control @error('title') is-invalid @enderror" {{ isset($orderDetails) ? 'readonly' : ''  }}>
                                    </td>
                                    <td>
                                        <input type="hidden" name="invoice_date[]" value="{{ date('d-m-Y',strtotime($value->invoice_date)) }}">
                                        {!! Form::text('invoice_date[]', date('d-m-Y',strtotime($value->invoice_date)), [
                                            'class' => 'form-control order_delivery_date',
                                            'placeholder' => 'Invoice Date',
                                            'disabled'
                                        ]) !!}
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" id="invoice_amount_{{ $i }}"
                                                name="invoice_amount[]"
                                                class="form-control @error('title') is-invalid @enderror invoice_amount_c"
                                                value="{{ round($value->amount) }}" placeholder="Amount" {{ isset($orderDetails) ? 'readonly' : ''  }}>
                                            <span class="input-group-text"> {{ $setting->currency }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" id="paid_amount_{{ $i }}"
                                                name="invoice_paid[]"
                                                class="form-control @error('title') is-invalid @enderror paid_amount_c"
                                                value="{{ round($value->paid_amount) }}" placeholder="Paid" {{ isset($orderDetails) ? 'readonly' : ''  }}>
                                            <span class="input-group-text"> {{ $setting->currency }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" id="due_amount_{{ $i }}"
                                                name="invoice_due[]"
                                                class="form-control @error('title') is-invalid @enderror due_amount_c"
                                                value="{{ round($value->due_amount) }}" placeholder="Due" {{ isset($orderDetails) ? 'readonly' : ''  }}>
                                            <span class="input-group-text"> {{ $setting->currency }}</span>
                                        </div>
                                    </td>
                                    {{-- <td>
                                        <div class="input-group">
                                            <input type="number" id="order_due_amount_{{ $i }}"
                                                name="invoice_order_due[]"
                                                class="form-control @error('title') is-invalid @enderror order_due_amount_c"
                                                value="{{ round($value->order_due_amount) }}" placeholder="Order Due" {{ isset($orderDetails) ? 'readonly' : ''  }}>
                                            <span class="input-group-text"> {{ $setting->currency }}</span>
                                        </div>
                                    </td> --}}
                                    {{-- <td class="ir_txt_center">
                                        @if ($value->invoice_type !== 'Quotation' && $loop->index !== 0)
                                            <a class="btn btn-xs del_inv_row dlt_button"><iconify-icon
                                                    icon="solar:trash-bin-minimalistic-broken"></iconify-icon>
                                            </a>
                                        @endif

                                    </td> --}}
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{-- <button id="orderInvoices" class="btn bg-blue-btn w-10 mt-2" data-bs-toggle="modal"
                    data-bs-target="#invoiceModal" type="button"
                    {{ $orderType == 'Quotation' ? 'disabled' : '' }}>@lang('index.add_more')</button> --}}
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-6 col-md-6 mb-2">
            <div class="form-group">
                <label>Upload Document</label>
                <input type="hidden" name="file_old" value="{{ isset($obj->file) && $obj->file ? $obj->file : '' }}">
                <input type="file" name="file_button" id="file_button"
                    class="form-control @error('title') is-invalid @enderror file_checker_global image_preview"
                    accept="image/png,image/jpeg,image/jpg,application/pdf,.doc,.docx">
                <p class="text-danger errorFile"></p>
                <div class="image-preview-container">
                    @if (isset($obj->file) && $obj->file)
                        @php($file = $obj->file)
                        {{-- @foreach ($files as $file) --}}
                            @php($fileExtension = pathinfo($file, PATHINFO_EXTENSION))
                            @if ($fileExtension == 'pdf')
                                <a class="text-decoration-none"
                                    href="{{ $baseURL }}uploads/order/{{ $file }}"
                                    target="_blank">
                                    <img src="{{ $baseURL }}assets/images/pdf.png"
                                        alt="PDF Preview" class="img-thumbnail mx-2"
                                        width="100px">
                                </a>
                            @elseif($fileExtension == 'doc' || $fileExtension == 'docx')
                                <a class="text-decoration-none"
                                    href="{{ $baseURL }}uploads/order/{{ $file }}"
                                    target="_blank">
                                    <img src="{{ $baseURL }}assets/images/word.png"
                                        alt="Word Preview" class="img-thumbnail mx-2"
                                        width="100px">
                                </a>
                            @else
                                <a class="text-decoration-none"
                                    href="{{ $baseURL }}uploads/order/{{ $file }}"
                                    target="_blank">
                                    <img src="{{ $baseURL }}uploads/order/{{ $file }}"
                                        alt="File Preview" class="img-thumbnail mx-2"
                                        width="100px">
                                </a>
                            @endif
                        {{-- @endforeach --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-6 col-md-6 mb-2">
            <div class="form-group">
                <label>@lang('index.quotation_note')</label>
                <textarea name="quotation_note" id="quotation_note" class="form-control @error('title') is-invalid @enderror" placeholder="{{ __('index.quotation_note') }}" rows="3">{{ isset($customerOrder) ?$customerOrder->quotation_note : "" }}</textarea>
                <input type="hidden" name="total_subtotal" id="total_subtotal"
                        value="{{ isset($customerOrder->total_amount) ? $customerOrder->total_amount : 0 }}"
                        class="form-control input_aligning" placeholder="@lang('index.total')"
                        readonly="">
            </div>
        </div>

        <div class="col-sm-6 col-md-6 mb-2">
            <div class="form-group">
                <label>@lang('index.internal_note')</label>
                <textarea name="internal_note" id="internal_note" class="form-control @error('title') is-invalid @enderror" placeholder="{{ __('index.internal_note') }}" rows="3">{{ isset($customerOrder) ?$customerOrder->internal_note : "" }}</textarea>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
            <button type="submit" name="submit" value="submit"
                class="btn bg-blue-btn order_submit_button"><iconify-icon
                    icon="solar:check-circle-broken"></iconify-icon>@lang('index.submit')</button>
            <a class="btn bg-second-btn" href="{{ route('customer-orders.index') }}"><iconify-icon
                    icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
        </div>
    </div>
</div>
<select id="hidden_product" class="display_none">
    @foreach ($productList as $value)
        <option value="{{ $value->id ?? '' }}">{{ $value->name }} ({{ $value->code }})</option>
    @endforeach
</select>
<select id="hidden_tax_type" class="display_none">
    @foreach ($tax_types as $value)
        <option value="{{ $value->id ?? '' }}">{{ $value->tax_type ?? '' }}</option>
    @endforeach
</select>
<input type="hidden" id="default_currency" value="{{ $setting->currency }}" />
