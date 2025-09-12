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
                {!! Form::model('', [
                    'id' => 'manufacture_form',
                    'method' => 'POST',
                    'enctype' => 'multipart/form-data',
                    'route' => ['customer_io.store'],
                ]) !!}
                @csrf
                <div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.reference_no') <span class="required_star">*</span></label>
                                <input type="text" name="reference_no" class="form-control" placeholder="@lang('index.reference_no') ">
                                <div class="error_alert text-danger">
                                    {{ $errors->first('reference_no') }}
                                </div>
                                <div class="text-danger d-none"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.partners') <span class="required_star">*</span></label>
                                <select name="" id="customer_id" class="form-control select2">
                                    <option value="">@lang('index.select')</option>
                                    <option value="Nisha(CUS001)">Nisha(P001)</option>
                                    <option value="Kishore(CUS001)">Kishore(P001)</option>
                                </select>
                                <div class="error_alert text-danger">
                                    {{ $errors->first('po_no') }}
                                </div>
                                <div class="text-danger d-none"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.date') <span class="required_star">*</span></label>
                                {!! Form::text('po_date', old('po_date', date('d-m-Y')), [
                                'class' => 'form-control',
                                'id' => 'date',
                                'placeholder' => 'Date',
                                ]) !!}
                                @if ($errors->has('date'))
                                <div class="error_alert text-danger">
                                    {{ $errors->first('date') }}
                                </div>
                                @endif
                                <div class="text-danger d-none"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                               <label>Contact Person Name </label>
                                <input type="text" name="cp_name[]" class="form-control" placeholder="Contact Person Name" value="Nithin">
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                               <label>Phone Number </label>
                                <input type="text" name="cp_phn_no[]" class="form-control" placeholder="Phone Number" value="7419632580">
                            </div>
                        </div>
                         <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                               <label>Email </label>
                                <input type="text" name="cp_email[]" class="form-control" placeholder="Email" value="nithin@gmail.com">
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
                                            <th class="w-100-p">@lang('index.line_item_no')</th>
                                            <th class="ir_txt_center">@lang('index.actions')</th>
                                        </tr>
                                    </thead>
                                    <tbody class="add_partner">
                                        <tr class="rowCount">
                                           
                                        </tr>
                                    </tbody>
                                </table>
                                <button id="partner" class="btn bg-blue-btn w-10 mb-2 mt-2" type="button">@lang('index.add_more')</button>
                             </div>
                        </div>
                    </div>
                    <div class="row mt-3 gap-2">
                        <div class="col-sm-6 col-md-6 mb-2">
                            <div class="form-group">
                                <label>Upload Document</label>
                                <input type="hidden" name="file_old" value="">
                                <input type="file" name="file_button" id="file_button"
                                    class="form-control file_checker_global image_preview"
                                    accept="image/png,image/jpeg,image/jpg,application/pdf,.doc,.docx" multiple>
                                <p class="text-danger errorFile"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
                            <button type="submit" name="submit" value="submit"
                                class="btn bg-blue-btn order_submit_button"><iconify-icon
                                    icon="solar:check-circle-broken"></iconify-icon>@lang('index.submit')</button>
                            <a class="btn bg-second-btn" href="{{ route('partner_io.index') }}"><iconify-icon
                                    icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/inward_outward.js?v=1.0' !!}"></script>
@endsection