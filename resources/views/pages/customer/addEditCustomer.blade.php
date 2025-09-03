@extends('layouts.app')
@section('script_top')
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
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'route' => ['customers.update', isset($obj->id) && $obj->id ? $obj->id : ''],
                ]) !!}
                @csrf
                <div>
                    <div class="row">
                        {{-- <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.vendor_code') <span class="required_star">*</span></label>
                                <input type="text" name="vendor_code" id="vendor_code"
                                    class="check_required form-control @error('vendor_code') is-invalid @enderror"
                                    placeholder="@lang('index.vendor_code')"
                                    value="{{ isset($obj->vendor_code) ? $obj->vendor_code : old('vendor_code') }}"
                                    onfocus="select()" maxlength="10">
                                <div class="text-danger d-none"></div>
                                @error('vendor_code')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label>@lang('index.customer_name') <span class="required_star">*</span></label>
                                <input type="hidden" name="customer_id" value="{{ isset($obj->customer_id) ? $obj->customer_id : $customer_id }}"
                                    onfocus="select()">
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="{{ __('index.customer_name') }}"
                                    value="{{ isset($obj) && $obj->name ? $obj->name : old('name') }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label>@lang('index.phone') <span class="required_star">*</span></label>
                                <input type="text" name="phone" id="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="{{ __('index.phone') }}" value="{{ isset($obj) && $obj->phone ? $obj->phone : old('phone') }}">
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label>@lang('index.email')</label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="{{ __('index.email') }}" value="{{ isset($obj) && $obj->email ? $obj->email : old('email') }}">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{--<div class="col-md-4 mb-3">
                            <div class="d-flex justify-content-between">
                                <div class="form-group w-100 me-2">
                                    <label>@lang('index.opening_balance')</label>
                                    <input type="text" name="opening_balance" id="opening_balance"
                                        class="form-control @error('opening_balance') is-invalid @enderror integerchk"
                                        placeholder="{{ __('index.opening_balance') }}" value="{{ isset($obj) && $obj->opening_balance ? $obj->opening_balance : old('opening_balance') }}">
                                    @error('opening_balance')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group w-100">
                                    <label>&nbsp;</label>
                                    <select class="form-control @error('opening_balance_type') is-invalid @enderror select2"
                                        name="opening_balance_type" id="opening_balance_type">
                                        <option value="Debit" {{ isset($obj) && $obj->opening_balance_type == 'Debit' || old('opening_balance_type') == 'Debit' ? 'selected' : '' }}>@lang('index.debit')</option>
                                        <option value="Credit" {{ isset($obj) && $obj->opening_balance_type == 'Credit' || old('opening_balance_type') == 'Credit' ? 'selected' : '' }}>@lang('index.credit')</option>
                                    </select>
                                    @error('opening_balance_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label>@lang('index.credit_limit')</label>
                                <input type="text" name="credit_limit" id="credit_limit"
                                    class="form-control @error('credit_limit') is-invalid @enderror integerchk"
                                    placeholder="{{ __('index.credit_limit') }}" value="{{ isset($obj) && $obj->credit_limit ? $obj->credit_limit : old('credit_limit') }}">
                                @error('credit_limit')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label>@lang('index.default_discount')</label>
                                <input type="text" name="discount" id="discount"
                                    class="form-control @error('discount') is-invalid @enderror integerchkPercent"
                                    placeholder="{{ __('index.default_discount') }}" value="{{ isset($obj) && $obj->discount ? $obj->discount : old('discount') }}">
                                @error('discount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>--}}
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label>@lang('index.customer_type') <span class="required_star">*</span></label>
                                <select class="form-control @error('customer_type') is-invalid @enderror select2" name="customer_type" id="customer_type">
                                    <option value="">Select</option>
                                    <option value="Retail"
                                        {{ (isset($obj) && $obj->customer_type == 'Retail') || old('customer_type') == 'Retail' ? 'selected' : '' }}>
                                        @lang('index.retail')
                                    </option>
                                    <option value="Wholesale"
                                        {{ (isset($obj) && $obj->customer_type == 'Wholesale') || old('customer_type') == 'Wholesale' ? 'selected' : '' }}>
                                        @lang('index.wholesale')
                                    </option>
                                </select>
                                @error('customer_type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label>@lang('index.gst_no') </label>
                                <input type="text" name="gst_no" id="gst_no"
                                    class="form-control @error('gst_no') is-invalid @enderror"
                                    placeholder="{{ __('index.gst_no') }}"
                                    value="{{ isset($obj) && $obj->gst_no ? $obj->gst_no : old('gst_no') }}">
                                @error('gst_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label>@lang('index.pan_no') </label>
                                <input type="text" name="pan_no"
                                    class="form-control @error('pan_no') is-invalid @enderror"
                                    id="pan_no" placeholder="@lang('index.pan_no')"
                                    value="{{ isset($obj) && $obj->pan_no ? $obj->pan_no : old('pan_no') }}">
                                @error('pan_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.hsn')</label>
                                <input type="text" name="hsn_sac_no" id="hsn_sac_no"
                                    class="check_required form-control @error('hsn_sac_no') is-invalid @enderror"
                                    placeholder="@lang('index.hsn')" value="{{ isset($obj) && $obj ? $obj->hsn_sac_no : old('hsn_sac_no') }}">
                                <div class="text-danger d-none"></div>
                                @error('hsn_sac_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label>@lang('index.ecc_no') </label>
                                <input type="text" name="ecc_no" id="ecc_no"
                                    class="form-control @error('ecc_no') is-invalid @enderror"
                                    placeholder="{{ __('index.ecc_no') }}"
                                    value="{{ isset($obj) && $obj->ecc_no ? $obj->ecc_no : old('ecc_no') }}">
                                @error('ecc_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.landmark') </label>
                                <input type="text" name="area" id="area"
                                    class="form-control @error('area') is-invalid @enderror"
                                    placeholder="{{ __('index.landmark') }}"
                                    value="{{ isset($obj) && $obj->area ? $obj->area : old('area') }}">
                                @error('area')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.address')</label>
                                <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror"
                                    placeholder="{{ __('index.address') }}" rows="3">{!! isset($obj) && $obj->address ? $obj->address : old('address') !!}</textarea>
                                @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.note')</label>
                                <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror"
                                    placeholder="{{ __('index.note') }}" rows="3" >{{ isset($obj) && $obj->note ? $obj->note : old('note') }}</textarea>
                                @error('note')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
                            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><iconify-icon
                                    icon="solar:check-circle-broken"></iconify-icon>@lang('index.submit')</button>
                            <a class="btn bg-second-btn" href="{{ route('customers.index') }}"><iconify-icon
                                    icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection

@section('script_bottom')
@endsection
