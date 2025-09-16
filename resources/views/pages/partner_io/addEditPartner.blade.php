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
                {!! Form::model(isset($partner_io) && $partner_io ? $partner_io : '', [
                    'id' => 'manufacture_form',
                    'method' => isset($partner_io) && $partner_io ? 'PATCH' : 'POST',
                    'enctype' => 'multipart/form-data',
                    'route' => ['partner_io.update', isset($partner_io->id) && $partner_io->id ? $partner_io->id : ''],
                ]) !!}
                @csrf
                <div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.reference_no') <span class="required_star">*</span></label>
                                <input type="text" name="reference_no" id="reference_no" class="form-control" placeholder="@lang('index.reference_no')" value="{{ isset($partner_io->reference_no) ? $partner_io->reference_no : '' }}" {{ isset($partner_io->reference_no) ? 'readonly' : '' }}>
                                <div class="text-danger d-none"></div>
                                @error('reference_no')
                                <div class="text-danger">
                                    {{ $errors->first('reference_no') }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.partners')(Code) <span class="required_star">*</span></label>
                                <input type="hidden" name="partner_id" value="{{ isset($partner_io->id) ?? '' }}">
                                <select name="partner_id" id="partner_id" class="form-control select2" >
                                    <option value="">@lang('index.select')</option>
                                    @foreach($partners as $partner)
                                        <option {{ (isset($partner_io->partner_id) && $partner_io->partner_id == $partner->id) || old('partner_io') == $partner->id ? 'selected' : '' }} value="{{ $partner->id }}">{{ $partner->name .'('.$partner->partner_id.')'}}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger d-none"></div>
                                @error('partner_id')
                                <div class="text-danger">
                                    {{ $errors->first('partner_id') }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.date') <span class="required_star">*</span></label>
                                {!! Form::text('io_date', old('io_date', isset($partner_io) ? $partner_io->io_date : date('d-m-Y')), [
                                'class' => 'form-control',
                                'id' => 'io_date',
                                'placeholder' => 'Date',
                                ]) !!}
                                <div class="text-danger d-none"></div>
                                @if ($errors->has('io_date'))
                                <div class="error_alert text-danger">
                                    {{ $errors->first('io_date') }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                               <label>Phone Number <span class="required_star">*</span></label>
                                <input type="text" name="phn_no" id="phn_no" class="form-control" placeholder="Phone Number" value="{{ isset($partner_detail->phone) ? $partner_detail->phone : '' }}">
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
                                <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="{{ isset($partner_detail->email) ? $partner_detail->email : '' }}">
                                <div class="text-danger d-none"></div>
                                @error('email')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                               <label>Delivery Address <span class="required_star">*</span></label>
                                <textarea name="d_address" id="d_address" class="form-control" rows="3">{{ isset($partner_io->d_address) ? $partner_io->d_address : '' }}</textarea>
                                <div class="text-danger d-none"></div>
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
                                            <th class="w-100-p">@lang('index.line_item_number')</th>
                                            @if(!isset($partnerOrderDetails))<th class="ir_txt_center">@lang('index.actions')</th>@endif
                                        </tr>
                                    </thead>
                                    <tbody class="add_partner">
                                        <?php $i = 1; ?>
                                        @if(isset($partnerOrderDetails))
                                            <tr class="rowCount" data-id="{{ $partnerOrderDetails->id }}">
                                                <td class="width_1_p ir_txt_center">{{ $i++ }}</td>
                                                <td>
                                                    <input type="hidden" name="detail_id[]" value="{{ $partnerOrderDetails->id }}">
                                                    <input type="hidden" name="type[]" value="{{ $partnerOrderDetails->type }}">
                                                    <select class="form-control type select2" id="type_{{ $i }}" {{ isset($partnerOrderDetails) ? 'disabled' : ''  }}>
                                                        <option value="">Please Select</option>
                                                        <option {{ (isset($partnerOrderDetails->type) && $partnerOrderDetails->type == 1) || old('type') == 1 ? 'selected' : '' }} value="1" >@lang('index.gauges/checkinginstruments')</option>
                                                        <option {{ (isset($partnerOrderDetails->type) && $partnerOrderDetails->type == 2) || old('type') == 2 ? 'selected' : '' }} value="2">@lang('index.measuringinstruments')</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="ins_category[]" value="{{ $partnerOrderDetails->ins_category }}">
                                                    <select class="form-control ins_category select2" name="ins_category[]" id="ins_category_{{ $i }}" {{ isset($partnerOrderDetails) ? 'disabled' : ''  }}>
                                                        <option value="">Please Select</option>
                                                        @foreach($instrument_categories as $instrument_cat)
                                                            <option value="{{ $instrument_cat->id }}" 
                                                                {{ ($instrument_cat->id == $partnerOrderDetails->ins_category || old('ins_category') == $instrument_cat->id) ? 'selected' : '' }}>
                                                                {{ $instrument_cat->category }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="ins_name[]" value="{{ $partnerOrderDetails->ins_name }}">
                                                    <select class="form-control ins_name select2" name="ins_name[]" id="ins_name_{{ $i }}" {{ isset($partnerOrderDetails) ? 'disabled' : ''  }}>
                                                        <option value="">Please Select</option>
                                                        @foreach($instruments as $instrument)
                                                            <option value="{{ $instrument->id }}" 
                                                                {{ ($instrument->id == $partnerOrderDetails->ins_name || old('ins_name') == $instrument->id) ? 'selected' : '' }}>
                                                                {{ $instrument->instrument_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="qty[]" class="check_required form-control integerchk qty_c" placeholder="Quantity" id="quantity_{{ $i }}" value="{{ isset($partnerOrderDetails->qty) ? $partnerOrderDetails->qty : '' }}" />
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="remarks[]" placeholder="Remarks" id="remarks">{{ isset($partnerOrderDetails->remarks) ? $partnerOrderDetails->remarks : '' }}</textarea>
                                                </td>
                                                <td>
                                                    <input type="text" name="line_item_no[]" class="form-control" placeholder="Line Item No" value="{{ isset($partnerOrderDetails->line_item_no) ? $partnerOrderDetails->line_item_no : '' }}" />
                                                </td>
                                                @if(!isset($partnerOrderDetails))
                                                <td class="ir_txt_center"><a class="btn btn-xs del_row remove-tr dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>
                                                @endif
                                            </tr>
                                        @endif
                                        <tr class="rowCount">
                                        </tr>
                                    </tbody>
                                </table>
                                @if(!isset($partnerOrderDetails))
                                <button id="partner_io" class="btn bg-blue-btn w-10 mb-2 mt-2" type="button">@lang('index.add_more')</button>
                                @endif
                             </div>
                        </div>
                    </div>
                    <div class="row mt-3 gap-2">
                        <div class="col-sm-6 col-md-6 mb-2">
                            <div class="form-group">
                                <label>Upload Document</label>
                                <input type="hidden" name="file_old" value="{{ isset($partner_io->file) && $partner_io->file ? $partner_io->file : '' }}">
                               <input type="file" name="file_button" id="file_button"
                                    class="form-control @error('title') is-invalid @enderror file_checker_global image_preview"
                                    accept="image/png,image/jpeg,image/jpg,application/pdf,.doc,.docx">
                                <p class="text-danger errorFile"></p>
                                <div class="image-preview-container">
                                    @if(isset($partner_io->file) && $partner_io->file != '')
                                    <div class="pt-10 pb-10">
                                        <div class="text-left">
                                            <h3 class="pt-20 pb-20">Documents</h3>
                                            <div class="d-flex flex-wrap gap-3">
                                                @php
                                                    $file = $partner_io->file;
                                                    $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                                                @endphp

                                                @if(in_array($fileExtension, ['pdf']))
                                                    <a class="text-decoration-none" href="{{ url('uploads/partner_io/' . $file) }}" target="_blank">
                                                        <img src="{{ url('assets/images/pdf.png') }}" alt="PDF Preview" class="img-thumbnail mx-2" width="100">
                                                    </a>
                                                @elseif(in_array($fileExtension, ['doc', 'docx']))
                                                    <a class="text-decoration-none" href="{{ url('uploads/partner_io/' . $file) }}" target="_blank">
                                                        <img src="{{ url('assets/images/word.png') }}" alt="Word Preview" class="img-thumbnail mx-2" width="100">
                                                    </a>
                                                @else
                                                    <a class="text-decoration-none" href="{{ url('uploads/partner_io/' . $file) }}" target="_blank">
                                                        <img src="{{ url('uploads/partner_io/' . $file) }}" alt="File Preview" class="img-thumbnail mx-2" width="100">
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
                                class="btn bg-blue-btn partner_io_submit_button"><iconify-icon
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
<select id="hidden_type" class="display_none">
    <option {{ (isset($obj->type) && $obj->type == 1) || old('type') == 1 ? 'selected' : '' }} value="1">@lang('index.gauges/checkinginstruments')</option>
    <option {{ (isset($obj->type) && $obj->type == 2) || old('type') == 2 ? 'selected' : '' }} value="2">@lang('index.measuringinstruments')</option>
</select>
@endsection
@section('script')
    <script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/inward_outward.js?v=1.0' !!}"></script>
@endsection