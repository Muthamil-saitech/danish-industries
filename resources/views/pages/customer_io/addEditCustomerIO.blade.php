@extends('layouts.app')

@section('script_top')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <?php
    $setting = getSettingsInfo();
    $tax_setting = getTaxInfo();
    $baseURL = getBaseURL();
    ?>
@endsection
@section('content')
    <section class="main-content-wrapper">
        <section class="content-header">
            <h3 class="top-left-header">{{ isset($title) && $title ? $title : '' }}</h3>
        </section>
        @include('utilities.messages')
        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- form start -->
                {!! Form::model(isset($order_io) && $order_io ? $order_io : '', [
                    'id' => 'manufacture_form',
                    'method' => isset($order_io) && $order_io ? 'PATCH' : 'POST',
                    'enctype' => 'multipart/form-data',
                    'route' => ['customer_io.update', isset($order_io->id) && $order_io->id ? $order_io->id : ''],
                ]) !!}
                @csrf
                <div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.po_no') <span class="required_star">*</span></label>
                                @if(isset($order_io->po_no) && !empty($order_io->po_no))
                                <select id="po_no_display" class="form-control select2" disabled>
                                    <option value="">@lang('index.select')</option>
                                    @foreach($customer_orders as $order)
                                        <option {{ $order_io->po_no == $order->reference_no ? 'selected' : '' }}
                                            value="{{ $order->reference_no }}"
                                            data-lineitem="{{ $order->line_item_no }}">
                                            {{ $order->reference_no.'/'.$order->line_item_no }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="po_no" value="{{ $order_io->po_no }}">
                            @else
                                <select name="po_no" id="po_no" class="form-control select2" required>
                                    <option value="">@lang('index.select')</option>
                                    @foreach($customer_orders as $order)
                                        <option {{ old('po_no') == $order->reference_no ? 'selected' : '' }}
                                            value="{{ $order->reference_no }}"
                                            data-lineitem="{{ $order->line_item_no }}">
                                            {{ $order->reference_no.'/'.$order->line_item_no }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            <input type="hidden" name="line_item_no" id="line_item_no"
                                value="{{ $order_io->line_item_no ?? '' }}">

                                @error('po_no')
                                <div class="text-danger">
                                    {{ $errors->first('po_no') }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.customer')(Code) <span class="required_star">*</span></label>
                                <input type="hidden" name="customer_id" id="customer_id" value="{{ isset($order_io->customer_id) ? $order_io->customer_id : ''  }}">
                                <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Customers" value="{{ isset($customer) ? $customer->name . '(' . $customer->customer_id . ')' : '' }}" readonly>
                                <div class="text-danger d-none"></div>
                                @error('customer_name')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.date') <span class="required_star">*</span></label>
                                {!! Form::text('date', old('date', isset($order_io) ? $order_io->date : date('d-m-Y')), [
                                    'class' => 'form-control',
                                    'id' => 'io_date',
                                    'placeholder' => 'Date',
                                ]) !!}
                                <div class="text-danger d-none"></div>
                                @if ($errors->has('date'))
                                <div class="text-danger">
                                    {{ $errors->first('date') }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                               <label>Phone Number <span class="required_star">*</span></label>
                                <input type="text" name="phn_no" id="c_phn_no" class="form-control" placeholder="Phone Number" value="{{ isset($customer->phone) ? $customer->phone : '' }}">
                                <div class="text-danger d-none"></div>
                                @error('phn_no')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                         <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                               <label>Email </label>
                                <input type="text" name="c_email" id="c_email" class="form-control" placeholder="Email" value="{{ isset($customer->email) ? $customer->email : '' }}">
                                <div class="text-danger d-none"></div>
                                @error('c_email')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                               <label>Delivery Address <span class="required_star">*</span></label>
                                <textarea name="d_address" id="d_address" class="form-control" rows="3">{{ isset($order_io->d_address) ? $order_io->d_address : '' }}</textarea>
                                @error('d_address')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive" id="ciofrm">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="w-50-p">@lang('index.sn')</th>
                                            <th class="w-100-p">@lang('index.type')</th>
                                            <th class="w-100-p">@lang('index.category')</th>
                                            <th class="w-100-p">@lang('index.instrument_name')(Code)</th>
                                            <th class="w-100-p">@lang('index.quantity')</th>
                                            <th class="w-100-p">@lang('index.remarks')</th>
                                            @if(!isset($customer_io_details))<th class="ir_txt_center">@lang('index.actions')</th>@endif
                                        </tr>
                                    </thead>
                                    <tbody class="add_cio">
                                        <?php $i = 1; ?>
                                        @if(isset($customer_io_details))
                                            @foreach($customer_io_details as $io_details)
                                                <tr class="rowCount" data-id="{{ $io_details->id }}">
                                                    <td class="width_1_p ir_txt_center">{{ $i++ }}</td>
                                                    <td>
                                                        <input type="hidden" name="detail_id[]" value="{{ $io_details->id }}">
                                                        <input type="hidden" name="type[]" value="{{ $io_details->type }}">
                                                        <select class="form-control type select2" id="type_{{ $i }}" {{ isset($io_details) ? 'disabled' : ''  }}>
                                                            <option value="">Please Select</option>
                                                            <option {{ (isset($io_details->type) && $io_details->type == 1) || old('type') == 1 ? 'selected' : '' }} value="1" >@lang('index.gauges/checkinginstruments')</option>
                                                            <option {{ (isset($io_details->type) && $io_details->type == 2) || old('type') == 2 ? 'selected' : '' }} value="2">@lang('index.measuringinstruments')</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="ins_category[]" value="{{ $io_details->ins_category }}">
                                                        <select class="form-control ins_category select2" name="ins_category[]" id="ins_category_{{ $i }}" {{ isset($io_details) ? 'disabled' : ''  }}>
                                                            <option value="">Please Select</option>
                                                            @foreach($instrument_categories as $instrument_cat)
                                                               <option value="{{ $instrument_cat->id }}" 
                                                                    {{ ($instrument_cat->id == $io_details->ins_category || old('ins_category') == $instrument_cat->id) ? 'selected' : '' }}>
                                                                    {{ $instrument_cat->category }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="ins_name[]" value="{{ $io_details->ins_name }}">
                                                        <select class="form-control ins_name select2" name="ins_name[]" id="ins_name_{{ $i }}" {{ isset($io_details) ? 'disabled' : ''  }}>
                                                            <option value="">Please Select</option>
                                                            @foreach($instruments as $instrument)
                                                               <option value="{{ $instrument->id }}" 
                                                                    {{ ($instrument->id == $io_details->ins_name || old('ins_name') == $instrument->id) ? 'selected' : '' }}>
                                                                    {{ $instrument->instrument_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="qty[]" class="check_required form-control integerchk qty_c" placeholder="Quantity" id="quantity_{{ $i }}" value="{{ isset($io_details->qty) ? $io_details->qty : '' }}" />
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="remarks[]" placeholder="Remarks" id="remarks">{{ isset($io_details->remarks) ? $io_details->remarks : '' }}</textarea>
                                                    </td>
                                                    @if(!isset($io_details))
                                                    <td class="ir_txt_center"><a class="btn btn-xs del_row remove-tr dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                @if(!isset($io_details))
                                <button id="customer_io" class="btn bg-blue-btn w-10 mb-2 mt-2" type="button">@lang('index.add_more')</button>
                                @endif
                             </div>
                        </div>
                    </div>
                    <div class="row mt-3 gap-2">
                        <div class="col-sm-6 col-md-6 mb-2">
                            <div class="form-group">
                                <label>Upload Document</label>
                                <input type="hidden" name="file_old" value="{{ isset($order_io->file) && $order_io->file ? $order_io->file : '' }}">
                               <input type="file" name="file_button" id="file_button"
                                    class="form-control @error('title') is-invalid @enderror file_checker_global image_preview"
                                    accept="image/png,image/jpeg,image/jpg,application/pdf,.doc,.docx">
                                <p class="text-danger errorFile"></p>
                                <div class="image-preview-container">
                                    @if(isset($order_io->file) && $order_io->file != '')
                                    <div class="pt-10 pb-10">
                                        <div class="text-left">
                                            <h3 class="pt-20 pb-20">Documents</h3>
                                            <div class="d-flex flex-wrap gap-3">
                                                @php
                                                    $file = $order_io->file;
                                                    $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                                                @endphp

                                                @if(in_array($fileExtension, ['pdf']))
                                                    <a class="text-decoration-none" href="{{ url('uploads/customer_io/' . $file) }}" target="_blank">
                                                        <img src="{{ url('assets/images/pdf.png') }}" alt="PDF Preview" class="img-thumbnail mx-2" width="100">
                                                    </a>
                                                @elseif(in_array($fileExtension, ['doc', 'docx']))
                                                    <a class="text-decoration-none" href="{{ url('uploads/customer_io/' . $file) }}" target="_blank">
                                                        <img src="{{ url('assets/images/word.png') }}" alt="Word Preview" class="img-thumbnail mx-2" width="100">
                                                    </a>
                                                @else
                                                    <a class="text-decoration-none" href="{{ url('uploads/customer_io/' . $file) }}" target="_blank">
                                                        <img src="{{ url('uploads/customer_io/' . $file) }}" alt="File Preview" class="img-thumbnail mx-2" width="100">
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
                            <button type="submit" name="submit" value="submit"
                                class="btn bg-blue-btn order_io_submit_button"><iconify-icon
                                    icon="solar:check-circle-broken"></iconify-icon>@lang('index.submit')</button>
                            <a class="btn bg-second-btn" href="{{ route('customer_io.index') }}"><iconify-icon
                                    icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
<select id="hidden_type" class="display_none">
    <option {{ (isset($obj->type) && $obj->type == 1) || old('type') == 1 ? 'selected' : '' }} value="1">@lang('index.gauges/checkinginstruments')</option>
    <option {{ (isset($obj->type) && $obj->type == 2) || old('type') == 2 ? 'selected' : '' }} value="2">@lang('index.measuringinstruments')</option>
</select>
@endsection
@section('script')
    <script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/inward_outward.js?v=1.0' !!}"></script>
@endsection