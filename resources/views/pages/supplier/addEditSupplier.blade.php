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
                {!! Form::model(isset($obj) && $obj ? $obj : '', [
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'route' => ['suppliers.update', isset($obj->id) && $obj->id ? $obj->id : ''],
                ]) !!}
                @csrf
                <div>
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group mb-3">
                                <label>@lang('index.supplier_name') <span class="required_star">*</span></label>
                                <input type="hidden" name="supplier_id" value="{{ isset($obj->supplier_id) ? $obj->supplier_id : $supplier_id }}"
                                    onfocus="select()" readonly>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ isset($obj->name) && $obj->name ? $obj->name : old('name') }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="col-md-6 col-lg-4">
                            <div class="form-group mb-3">
                                <label>@lang('index.contact_person')</label>
                                <input type="text" name="contact_person" id="contact_person"
                                    class="form-control @error('contact_person') is-invalid @enderror"
                                    placeholder="Contact Person" value="{{ isset($obj->contact_person) && $obj->contact_person ? $obj->contact_person : old('contact_person') }}">
                                @error('contact_person')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group mb-3">
                                <label>@lang('index.phone') <span class="required_star">*</span></label>
                                <input type="text" name="phone" id="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="Phone" value="{{ isset($obj->phone) && $obj->phone ? $obj->phone : old('phone') }}">
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group mb-3">
                                <label>@lang('index.email')</label>
                                <input type="text" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ isset($obj->email) && $obj->email ? $obj->email : old('email') }}">
                                @error('email')
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
                        
                        {{--<div class="col-md-6 col-lg-4">
                            <div class="d-flex justify-content-between">
                                <div class="form-group w-100 me-2">
                                    <label>@lang('index.opening_balance')</label>
                                    <input type="text" name="opening_balance" id="opening_balance"
                                        class="form-control @error('opening_balance') is-invalid @enderror integerchk"
                                        placeholder="Opening Balance" value="{{ isset($obj->opening_balance) && $obj->opening_balance ? $obj->opening_balance : old('opening_balance') }}">
                                    @error('opening_balance')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group w-100">
                                    <label>&nbsp;</label>
                                    <select class="form-control @error('opening_balance_type') is-invalid @enderror select2"
                                        name="opening_balance_type" id="opening_balance_type">
                                        <option value="Debit"
                                            {{ isset($obj) && $obj->opening_balance_type  == 'Debit' || old('opening_balance_type') == 'Debit' ? 'selected' : '' }}>
                                            @lang('index.debit')</option>
                                        <option value="Credit"
                                            {{ isset($obj) && $obj->opening_balance_type  == 'Credit' || old('opening_balance_type') == 'Credit' ? 'selected' : '' }}>
                                            @lang('index.credit')</option>
                                    </select>
                                    @error('opening_balance_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label class="control-label">@lang('index.credit_limit')</label>
                                <div>
                                    <input type="text"
                                        class="form-control @error('title') is-invalid @enderror integerchk"
                                        id="credit_limit" name="credit_limit" placeholder="Credit Limit"
                                        value="{{ isset($obj) && $obj->credit_limit ? $obj->credit_limit : old('credit_limit')  }}">
                                </div>
                            </div>
                        </div>--}}
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group mb-3">
                                <label>@lang('index.address')</label>
                                <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror"
                                    placeholder="Address" rows="3">{{ isset($obj->address) && $obj->address ? $obj->address : old('address') }}</textarea>
                                @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group mb-3">
                                <label>@lang('index.note')</label>
                                <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror"
                                    placeholder="note" rows="3">{{ isset($obj->note) && $obj->note ? $obj->note : old('note') }}</textarea>
                                @error('note')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <h3 class="mb-2 mt-1">Contact Information</h3>
                    <div class="add_scp">
                        @if(isset($supplier_contact_info) && $supplier_contact_info->count() > 0)
                            {{-- Edit case: loop through existing contacts --}}
                            @foreach($supplier_contact_info as $key => $contact_info)
                                <div class="card mb-3 shadow-sm border-0 rounded-3">
                                    <div class="card-body">
                                        <div class="row align-items-center cp-row">
                                            <div class="col-md-1 mb-3 d-flex align-items-center justify-content-center">
                                                <label class="serial-no">{{ $key + 1 }}</label>
                                                <input type="hidden" name="scp_serial[]" value="{{ $key + 1 }}">
                                                <input type="hidden" name="scp_id[]" value="{{ $contact_info->id ?? '' }}">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="form-group">
                                                    <label>Contact Person Name </label>                                                    
                                                    <input type="text" name="scp_name[]" class="form-control" placeholder="Contact Person Name" value="{{ $contact_info->scp_name ?? old('scp_name') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="form-group">
                                                    <label>Department </label>
                                                    <input type="text" name="scp_department[]" class="form-control" placeholder="Department" value="{{ $contact_info->scp_department ?? old('scp_department') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="form-group">
                                                    <label>Designation </label>
                                                    <input type="text" name="scp_designation[]" class="form-control" placeholder="Designation" value="{{ $contact_info->scp_designation ?? old('scp_designation') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-3 text-center">
                                            </div>
                                            <div class="col-md-1 mb-3 text-center">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="form-group">
                                                    <label>Phone Number </label>
                                                    <input type="text" name="scp_phone[]" class="form-control" placeholder="Phone Number" value="{{ $contact_info->scp_phone ?? old('scp_phone') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="form-group">
                                                    <label>Email </label>
                                                    <input type="text" name="scp_email[]" class="form-control" placeholder="Email" value="{{ $contact_info->scp_email ?? old('scp_email') }}">
                                                </div>
                                            </div>
                                            @if($key==0)
                                                <div class="col-md-4 mb-3 mt-1">
                                                    <button id="supContactPerson" class="btn bg-blue-btn mt-4" type="button">@lang('index.add_more')</button>
                                                </div>
                                            @else
                                                @if(isset($supplier_contact_info) && $supplier_contact_info->count() > 0)
                                                <div class="col-md-4 mt-4">
                                                    <a href="#" class="sup_c_del button-danger"
                                                        data-contact_id="{{ $contact_info->id }}" type="submit"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.delete')">
                                                        <i class="fa fa-trash tiny-icon"></i>
                                                    </a>
                                                </div>
                                                @else
                                                    <div class="col-md-4 mt-4">
                                                        <button type="button" class="btn btn-xs del_row dlt_button">
                                                            <iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon>
                                                        </button>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="card mb-3 shadow-sm border-0 rounded-3">
                                <div class="card-body">
                                    <div class="row align-items-center cp-row">
                                        <div class="col-md-1 mb-3 d-flex align-items-center justify-content-center">
                                            <label class="serial-no">1</label>
                                            <input type="hidden" name="scp_serial[]" value="1">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="form-group">
                                                <label>Contact Person Name </label>
                                                <input type="hidden" name="scp_id[]" value="">
                                                <input type="text" name="scp_name[]" class="form-control" placeholder="Contact Person Name" value="{{ old('scp_name.0') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="form-group">
                                                <label>Department </label>
                                                <input type="text" name="scp_department[]" class="form-control" placeholder="Department" value="{{ old('scp_department.0') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="form-group">
                                                <label>Designation </label>
                                                <input type="text" name="scp_designation[]" class="form-control" placeholder="Designation" value="{{ old('scp_designation.0') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3 text-center">
                                        </div>
                                        <div class="col-md-1 mb-3 text-center">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="form-group">
                                                <label>Phone Number </label>
                                                <input type="text" name="scp_phone[]" class="form-control" placeholder="Phone Number" value="{{ old('scp_phone.0') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="form-group">
                                                <label>Email </label>
                                                <input type="text" name="scp_email[]" class="form-control" placeholder="Email" value="{{ old('scp_email.0') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3 mt-1">
                                            <button id="supContactPerson" class="btn bg-blue-btn mt-4" type="button">@lang('index.add_more')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
                            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><iconify-icon
                                    icon="solar:check-circle-broken"></iconify-icon>@lang('index.submit')</button>
                            <a class="btn bg-second-btn" href="{{ route('suppliers.index') }}"><iconify-icon
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
    <script>
        let i = 1;
        function updateSerialLabels() {
            document.querySelectorAll(".serial-no").forEach((el, index) => {
                el.textContent = index + 1;
                el.nextElementSibling.value = index + 1;
            });
        }
        let base_url = $('#base_url').val();
        let hidden_base_url = $("#hidden_base_url").val();
        let hidden_alert = $(".hidden_alert").val();
        let hidden_ok = $(".hidden_ok").val();
        let hidden_cancel = $(".hidden_cancel").val();
        let thischaracterisnotallowed = $(".thischaracterisnotallowed").val();
        let are_you_sure = $(".are_you_sure").val();
        $(document).on("click", "#supContactPerson", function (e) {
            ++i;
            let newRow = `
                <div class="card mb-3 shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <div class="row mt-3" id="cp_row_${i}">
                            <div class="col-md-1 mb-3 d-flex align-items-center justify-content-center">
                                <label class="form-control-plaintext text-center serial-no"></label>
                                <input type="hidden" name="scp_serial[]" value="">
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label>Contact Person Name</label>
                                    <input type="text" name="scp_name[]" class="form-control" placeholder="Contact Person Name">
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label>Department</label>
                                    <input type="text" name="scp_department[]" class="form-control" placeholder="Department">
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label>Designation</label>
                                    <input type="text" name="scp_designation[]" class="form-control" placeholder="Designation">
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                            </div>
                            <div class="col-md-1 mb-3">
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" name="scp_phone[]" class="form-control" placeholder="Phone Number">
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="scp_email[]" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3 mt-4">
                                <button type="button" class="btn btn-xs del_row dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            $(".add_scp").append(newRow);
            updateSerialLabels();
        });
        /* $(document).on("click", ".del_row", function () {
            $(this).closest(".row").remove();
        }); */
        $(document).on("click", ".del_row", function () {
            if ($(".add_scp .card").length > 1) {
                $(this).closest(".card").remove();
                updateSerialLabels();
            } else {
                alert("At least one contact must remain.");
            }
        });
        $('body').on('click', '.sup_c_del', function (e) {
            e.preventDefault();
            let contact_id = $(this).attr('data-contact_id');
            // console.log("contact_id",contact_id);
            swal({
                title: hidden_alert+"!",
                text: are_you_sure,
                cancelButtonText:hidden_cancel,
                confirmButtonText:hidden_ok,
                confirmButtonColor: '#3c8dbc',
                showCancelButton: true
            }, function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "POST",
                        url: hidden_base_url + "contactDelete",
                        data: {
                            contact_id: contact_id
                        },
                        dataType: "json",
                        success: function(data) {
                            let hidden_alert = data.status ? "Success" : "Error";
                            swal({
                                title: hidden_alert + "!",
                                text: data.message,
                                cancelButtonText: hidden_cancel,
                                confirmButtonText: hidden_ok,
                                confirmButtonColor: "#3c8dbc",
                            }, function() {
                                location.reload();
                            });
                        },
                        error: function() {
                            console.error("Failed to fetch product details.");
                        },
                    });
                }
            });
        });
    </script>
@endsection
