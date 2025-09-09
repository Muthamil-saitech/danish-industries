@extends('layouts.app')
@section('script_top')
<?php
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
            <!-- general form elements -->
            <div class="table-box">
                <!-- form start -->
                {!! Form::model(isset($obj) && $obj ? $obj : '', [
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'route' => ['instruments.update', isset($obj->id) && $obj->id ? $obj->id : ''],
                ]) !!}
                @csrf
                <div>
                    <div class="row">
                        <div class="col-sm-6 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.type') <span class="required_star">*</span></label>
                                <select class="form-control @error('type') is-invalid @enderror select2" name="type"
                                    id="instrument_type">
                                    <option value="">@lang('index.select')</option>
                                    <option {{ (isset($obj->type) && $obj->type == 1) || old('type') == 1 ? 'selected' : '' }} value="1">@lang('index.gauges/checkinginstruments')</option>
                                    <option {{ (isset($obj->type) && $obj->type == 2) || old('type') == 2 ? 'selected' : '' }} value="2">@lang('index.measuringinstruments')</option>
                                </select>
                                @error('type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 mb-2 col-md-4">
                            <div class="form-group">    
                                <label>@lang('index.instrument_category') <span class="required_star">*</span></label>
                                <select class="form-control @error('category') is-invalid @enderror select2" name="category" id="category">
                                    <option value="">@lang('index.select')</option>
                                    @if(isset($obj->category))
                                        @foreach ($instrument_categories as $value)
                                            <option 
                                                {{ ((isset($obj->category) && $obj->category == $value->id) || old('category') == $value->id) ? 'selected' : '' }}
                                                value="{{ $value->id }}">{{ $value->category }}</option>
                                        @endforeach
                                    @elseif(old('type'))
                                        @php
                                            $old_instrument_categories = App\InstrumentCategory::where('del_status','Live')
                                                ->where('type', old('type'))
                                                ->get();
                                        @endphp
                                        @foreach ($old_instrument_categories as $value)
                                            <option 
                                                {{ (old('category') == $value->id) ? 'selected' : '' }}
                                                value="{{ $value->id }}">{{ $value->category }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('category')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.instrument_name') <span class="required_star">*</span></label>
                                <input type="text" name="instrument_name" id="instrument_name"
                                    class="check_required form-control @error('instrument_name') is-invalid @enderror instrument_name"
                                    placeholder="@lang('index.instrument_name')"
                                    value="{{ isset($obj->instrument_name) ? $obj->instrument_name : old('instrument_name') }}">
                                @error('instrument_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.code') <span class="required_star">*</span></label>
                                <input type="text" name="code" id="code"
                                    class="check_required form-control @error('code') is-invalid @enderror code"
                                    placeholder="@lang('index.code')"
                                    value="{{ isset($obj->code) ? $obj->code : old('code') }}">
                                @error('code')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.unit') <span class="required_star">*</span></label>
                                <select class="form-control @error('unit') is-invalid @enderror select2" name="unit" id="unit">
                                    <option value="">@lang('index.select_unit')</option>
                                    @foreach ($units as $value)
                                        <option
                                            {{ isset($obj->unit) && $obj->unit == $value->id || old('unit') == $value->id ? 'selected' : '' }}
                                            value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @error('unit')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.owner') <span class="required_star">*</span></label>
                                <select class="form-control @error('owner_type') is-invalid @enderror select2" name="owner_type"
                                    id="owner_type">
                                    <option value="">@lang('index.select')</option>
                                    <option {{ (isset($obj->owner_type) && $obj->owner_type == 1) || old('owner_type') == 1 ? 'selected' : '' }} value="1">@lang('index.owner')</option>
                                    <option {{ (isset($obj->owner_type) && $obj->owner_type == 2) || old('owner_type') == 2 ? 'selected' : '' }} value="2">@lang('index.customer')</option>
                                </select>
                                @error('owner_type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4 {{ (isset($obj) && $obj->owner_type == 2) || old('owner_type') == 2 ? '' : 'd-none' }}" id="cust_div">
                            <div class="form-group">
                                <label>@lang('index.customer') <span class="required_star">*</span></label>
                                <select class="form-control @error('customer_id') is-invalid @enderror select2" name="customer_id" id="customer_id">
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
                                <label>@lang('index.range/size') <span class="required_star">*</span></label>
                                <input type="text" name="range" id="range"
                                    class="check_required form-control @error('range') is-invalid @enderror range"
                                    placeholder="@lang('index.range/size')"
                                    value="{{ isset($obj->range) ? $obj->range : old('range') }}">
                                <div class="text-danger d-none"></div>
                                @error('range')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.accuracy') <span class="required_star">*</span></label>
                                <input type="text" name="accuracy" id="accuracy"
                                    class="check_required form-control @error('accuracy') is-invalid @enderror range"
                                    placeholder="@lang('index.accuracy')"
                                    value="{{ isset($obj->accuracy) ? $obj->accuracy : old('accuracy') }}">
                                <div class="text-danger d-none"></div>
                                @error('accuracy')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.make') <span class="required_star">*</span></label>
                                <input type="text" name="make" id="make"
                                    class="check_required form-control @error('make') is-invalid @enderror range"
                                    placeholder="@lang('index.make')"
                                    value="{{ isset($obj->make) ? $obj->make : old('make') }}">
                                <div class="text-danger d-none"></div>
                                @error('make')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.calibration_due') <span class="required_star">*</span></label>
                                {!! Form::text('calibration_due', isset($obj->calibration_due) && $obj->calibration_due ? date('Y-m-d',strtotime($obj->calibration_due)) : (old('calibration_due') ?: date('d-m-Y')), [
                                'class' => 'form-control',
                                'id' => 'calibration_due',
                                'placeholder' => 'Calibration Due',
                                ]) !!}
                                @if ($errors->has('calibration_due'))
                                <div class="error_alert text-danger">
                                    {{ $errors->first('calibration_due') }}
                                </div>
                                @endif
                                <div class="text-danger d-none"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.remarks')</label>
                                <textarea name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror" placeholder="{{ __('index.remarks') }}" rows="3">{{ old('remarks', isset($obj) ? $obj->remarks : '') }}</textarea>
                                @if ($errors->has('remarks'))
                                <div class="error_alert text-danger">
                                    {{ $errors->first('remarks') }}
                                </div>
                                @endif
                                <div class="text-danger d-none"></div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- /.box-body -->

                <div class="row mt-2">
                    <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
                        <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><iconify-icon icon="solar:check-circle-broken"></iconify-icon>@lang('index.submit')</button>
                        <a class="btn bg-second-btn" href="{{ route('instruments.index') }}"><iconify-icon icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
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
    <script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/instrument.js?v=1.0' !!}"></script>
@endsection