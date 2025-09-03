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
<link rel="stylesheet" href="{{ getBaseURL() }}frequent_changing/css/pdf_common.css">
@endpush
@section('content')
<input type="hidden" id="edit_mode" value="{{ isset($obj) && $obj ? $obj->id : null }}">
<section class="main-content-wrapper">
    @include('utilities.messages')
    <section class="content-header">
        <div class="row">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <button id="report_file_upl" data-bs-toggle="modal" data-ins_id="{{ isset($inspection) ? $inspection->id : '' }}"  data-manufacture_id="{{ $manufacture->id }}" data-bs-target="#insReportUpl" class="btn bg-second-btn" title="Inspection Report Form Upload" type="button"><i class="fa-regular fa-circle-up"></i>&nbsp;Upload</button>
                <button type="button"
                    class="btn bg-warning text-white final_inspect_btn"
                    data-bs-toggle="modal"
                    data-bs-target="#checkedPersonModal"
                    data-id="{{ $manufacture->id }}"
                    {{ (!empty($inspection_approval) && is_object($inspection_approval) && $inspection_approval->status == '2') || (isset($inspection) && count($inspection->details)==0) ? 'disabled' : '' }}>
                    <i class="fa-regular fa-circle-check" data-bs-toggle="tooltip" data-bs-placement="top" title="Inspection Approval"></i>&nbsp;Approval
                </button>
                <a href="javascript:void();" target="_blank" class="btn bg-second-btn print_inspection" data-id="{{ $manufacture->id }}"><iconify-icon icon="solar:printer-broken"></iconify-icon>@lang('index.print')</a>
                {{-- <a href="{{ route('download_inspection_report', encrypt_decrypt($manufacture->id, 'encrypt')) }}"
                target="_blank" class="btn bg-second-btn print_btn"><iconify-icon icon="solar:cloud-download-broken"></iconify-icon>
                @lang('index.download')
                </a> --}}
                @if (routePermission('inspection-generate.index'))
                <a class="btn bg-second-btn" href="{{ route('inspection-generate.index') }}"><iconify-icon icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
                @endif
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
            @if(isset($latest_form) && $latest_form!='')
            <div style="width: 98%; max-width: 1100px; margin: 30px auto;">
                <div class="text-center">
                    <img src="{!! getBaseURL() .
                                (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png') !!}" alt="Logo Image" class="img-fluid mb-2">
                </div>
                <p style="text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 10px;">{{ isset($title) && $title ? strtoupper($title) : '' }}</p>
                <img src="{{ $baseURL }}uploads/inspection_report_files/{{ $latest_form }}" alt="inspection report file" class="img-fluid">
            </div>
            @else
            <div style="max-width: 1200px; margin: 30px auto; ">
                <div style="text-align: center; border-bottom: 1px solid #000; padding: 10px;">
                    <img src="{!! getBaseURL() .
                        (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png') !!}" alt="Logo Image" class="img-fluid mb-2">
                    <h3 style="font-weight: 700; text-decoration: underline; font-size: 20px; padding-bottom: 15px;">INSPECTION REPORT</h3>
                    <form style="display: flex; justify-content: center; gap: 30px; align-items: center;">
                        <div style="display: flex; align-items: center;">
                            <input type="checkbox" style="transform: scale(1.8); margin-right: 20px; border-radius: 0px;" disabled {{ $di_inspect_dimensions->count() > 0 && !is_object($inspection_approval) ? 'checked' : '' }}>
                            <label style="font-size: 20px;"> In-Process</label>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <input type="checkbox" style="transform: scale(1.8); margin-right: 20px;" disabled {{ is_object($inspection_approval) && $inspection_approval->status == '2' ? 'checked' : '' }}>
                            <label style="font-size: 20px;"> Final</label>
                        </div>
                    </form>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: start; padding: 10px;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-weight: 600; font-size: 16px; display: flex; justify-content: space-between; width: 100px;">CUSTOMER <span>:</span> </span>
                            <p style="margin: 5px; font-weight: 600;">{{ getCustomerNameById($manufacture->customer_id) }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-weight: 600; font-size: 16px; display: flex; justify-content: space-between; width: 100px;">PART NAME <span>:</span> </span>
                            <p style="margin: 5px; font-weight: 600;">{{ isset($finishProduct) ? $finishProduct->name : '' }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-weight: 600; font-size: 16px; display: flex; justify-content: space-between; width: 100px;">PART No. <span>:</span> </span>
                            <p style="margin: 5px; font-weight: 600;">{{ isset($finishProduct) ? $finishProduct->code : '' }}</p>
                        </div>
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">DRG No. <span>:</span> </span>
                            <p style="margin: 5px;">{{ $finishProduct->drawer_no }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">REV <span>:</span> </span>
                            <p style="margin: 5px;">{{ $finishProduct->rev }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">OPERATION <span>:</span> </span>
                            <p style="margin: 5px;">{{ $finishProduct->operation }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">PoNo <span>:</span> </span>
                            <p style="margin: 5px;">{{ getPoNo($manufacture->customer_order_id) }}</p>
                        </div>
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 150px;">MATERIAL <span>:</span> </span>
                            <p style="margin: 5px;">{{ materialName($manufacture->rawMaterials[0]->rmaterials_id).'-'.($material->code) }} {{ $material->diameter!='' ? 'DIA '.$material->diameter : '' }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 150px;">Total Quantity <span>:</span> </span>
                            <p style="margin: 5px;">{{ $manufacture->product_quantity }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 150px;">Sample Quantity <span>:</span> </span>
                            <p style="margin: 5px;">{{ $manufacture->product_quantity }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 150px;">Heat No. <span>:</span> </span><p style="margin: 5px;">{{ getheatNo($manufacture->rawMaterials[0]->rmaterials_id) }}</p>
                        </div>
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">Report No. <span>:</span> </span>
                            <p style="margin: 5px;">{{ 'IR' . str_pad($manufacture->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">Date <span>:</span> </span>
                            <p style="margin: 5px;"> {{ date('d/m/Y') }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">DC No. <span>:</span> </span>
                            <p style="margin: 5px;">{{ $material_stock->dc_no }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;"> <span style="font-size: 16px; display: flex; justify-content: space-between; width: 100px;">PPCRCNo. <span>:</span> </span>
                            <p style="margin: 5px;">{{ $manufacture->reference_no }}</p>
                        </div>
                    </div>
                </div>
                <div style="border:1px solid #000; border-top: none;">
                    <table style="width:100%; border-collapse:collapse; font-size:16px;">
                        <tr style="text-align:center;">
                            <th style='border: 1px solid #000; border-left: none;'>Sl.No</th>
                            <th style='border: 1px solid #000; padding: 10px;'>PARAMETER</th>
                            <th style='border: 1px solid #000; padding: 10px;'>DRAWING <br> SPEC.</th>
                            <th style='border: 1px solid #000; padding: 10px;'>INSP. <br>METHOD</th>
                            @foreach($di_inspect_dimensions->unique('set_no') as $dimension)
                                <th style="border: 1px solid #000; padding: 5px;">DBF {{ str_pad($displaySetNos[$dimension->set_no], 3, '0', STR_PAD_LEFT) }}</th>
                            @endforeach
                            {{-- <th style='border: 1px solid #000; border-right: none;'></th> --}}
                        </tr>
                        @if(isset($inspection) && $inspection && isset($inspection->details) && count($inspection->details) > 0)
                            <tr>
                                <th></th>
                                <th colspan="{{ 3 + $di_inspect_dimensions->unique('set_no')->count() }}" style="text-align: start; padding: 10px 7px;">Dimension Inspection</th>
                            </tr>
                            @foreach($inspection->details as $key => $value)
                                @if($value->di_param != '')
                                    <tr>
                                        <td style="width: 80px; border: 1px solid #000; padding: 10px 7px; border-left: none;">{{ $loop->iteration }}</td>
                                        <td style="width: 80px; border: 1px solid #000; padding: 10px 7px;">{{ $value->di_param }}</td>
                                        <td style="width: 80px; border: 1px solid #000; padding: 10px 7px;">{{ $value->di_spec }}</td>
                                        <td style="text-align: center; width: 80px; border: 1px solid #000; padding: 10px 7px;">{{ $value->di_method != '' ? $value->di_method : '-' }}</td>
                                        @foreach($di_inspect_dimensions->unique('set_no') as $setNo)
                                            <td style="width: 80px; border: 1px solid #000;">
                                                {{ $di_inspect_dimensions->where('set_no', $setNo->set_no)->where('inspect_param_id', $value->id)->first()->di_observed_dimension ?? '' }}
                                            </td>
                                        @endforeach
                                        {{-- <td style="width: 80px; border: 1px solid #000; padding: 10px 7px; border-right: none;"></td> --}}
                                    </tr>
                                @endif
                            @endforeach
                            <tr>
                                <th></th>
                                <th colspan="{{ 3 + $ap_inspect_dimensions->unique('set_no')->count() }}" style="text-align: start; padding: 10px 7px;">Appearance Inspection</th>
                            </tr>
                            @foreach($inspection->details as $key => $value)
                                @if($value->ap_param != '')
                                    <tr>
                                        <td style="border: 1px solid; padding: 10px 7px; width: 80px; border-left: none;">{{ $loop->iteration }}</td>
                                        <td style="border: 1px solid; padding: 10px 7px; width: 80px;">{{ $value->ap_param }}</td>
                                        <td style="border: 1px solid; padding: 10px 7px; width: 80px;">{{ $value->ap_spec }}</td>
                                        <td style="text-align: center; border: 1px solid; padding: 10px 7px; width: 80px;">{{ $value->ap_method != '' ? $value->ap_method : '-' }}</td>
                                        @foreach($ap_inspect_dimensions->unique('set_no') as $setNo)
                                            <td style="width: 80px; border: 1px solid #000;">
                                                {{ $ap_inspect_dimensions->where('set_no', $setNo->set_no)->where('inspect_param_id', $value->id)->first()->ap_observed_dimension ?? '' }}
                                            </td>
                                        @endforeach
                                        {{-- <td style="border: 1px solid; padding: 10px 7px; width: 80px; border-right: none;"></td> --}}
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </table>
                    <div style="display: flex; justify-content: space-around;">
                        <div style="padding-top: 5px;">
                            <p>INSPECTED BY</p>
                            <h5>{{ !empty($inspection_approval) && is_object($inspection_approval) ? getEmpCode($inspection_approval->inspected_by) : '' }}</h5><br>
                        </div>
                        <div style="padding-top: 5px;">
                            <p>CHECKED BY</p>
                            <h5>{{ !empty($inspection_approval) && is_object($inspection_approval) ? getEmpCode($inspection_approval->checked_by) : '' }}</h5><br>
                        </div>
                    </div>
                    <div style="text-align: center; margin-top: 20px;">
                        @if($currentPage > 1)
                            <a href="{{ request()->fullUrlWithQuery(['page' => $currentPage - 1]) }}" style="margin-right: 10px;">&laquo; Previous</a>
                        @endif
                        @if($currentPage < ceil($totalSets / $perPage))
                            <a href="{{ request()->fullUrlWithQuery(['page' => $currentPage + 1]) }}">Next &raquo;</a>
                        @endif
                    </div>
                </div>
                <p style="padding-top: 30px; padding-bottom: 100px; font-size: 13px;"><b>Remarks</b>&nbsp;&nbsp;{{ !empty($inspection_approval) && is_object($inspection_approval) ? $inspection_approval->remarks : '' }}</p>
            </div>
            @endif
        </div>
    </section>
    <div class="modal fade" id="checkedPersonModal" aria-hidden="true" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Inspection Report Approval</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            data-feather="x"></i></button>
                </div>
                <form id="inspect_approval">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="manufacture_id" class="manufacture_id">
                        <div class="row">
                            <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label>Inspected By <span class="required_star">*</span></label>
                                    <select class="form-control @error('inspected_by') is-invalid @enderror select2"
                                        name="inspected_by" id="inspected_by">
                                        <option value="">@lang('index.select')</option>
                                        @if (isset($manage_users) && $manage_users)
                                        @foreach ($manage_users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->name }}({{ $user->emp_code }})
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <p class="text-danger inspected_user_err"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-6">
                                <div class="form-group">
                                    <label>Checked By <span class="required_star">*</span></label>
                                    <select class="form-control @error('checked_by') is-invalid @enderror select2"
                                        name="checked_by" id="checked_by">
                                        <option value="">@lang('index.select')</option>
                                        @if (isset($manage_users) && $manage_users)
                                        @foreach ($manage_users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->name }}({{ $user->emp_code }})
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <p class="text-danger checked_user_err"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-12">
                                <div class="form-group">
                                    <label>Remarks </label>
                                    <textarea name="remarks" id="remarks" cols="30" rows="3" class="form-control" maxlength="100"></textarea>
                                    <p class="text-danger remark_error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-blue-btn">@lang('index.update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="insReportUpl" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Upload Inspection Report Form</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <form id="ins_report_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="file" name="image" class="form-control" id="ins_rep_file" accept=".jpg,.jpeg,.png" required>
                        <input type="hidden" name="manufacture_id" id="manufacture_id" class="form-control">
                        <input type="hidden" name="ins_id" id="ins_id" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-blue-btn">Upload</button>
                        <button type="button" class="btn bg-second-btn" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>
    let base_url = $("#hidden_base_url").val();
    $("#inspected_by").select2({
        dropdownParent: $("#checkedPersonModal"),
    });
    $("#checked_by").select2({
        dropdownParent: $("#checkedPersonModal"),
    });
    $(document).on("click", ".print_inspection", function() {
        viewInspectionReport($(this).attr("data-id"));
    });

    function viewInspectionReport(id) {
        open(
            base_url + "print_inspection/" + id,
            "Print Inspection Report",
            "width=1600,height=550"
        );
        newWindow.focus();
        newWindow.onload = function() {
            newWindow.document.body.insertAdjacentHTML("afterbegin");
        };
    }
    $(document).on("click", "#report_file_upl", function(e) {
        let ins_id = $(this).data('ins_id');
        $("#ins_id").val(ins_id);
        let manufacture_id = $(this).data('manufacture_id');
        $("#manufacture_id").val(manufacture_id);
    });
    $(document).on('change', "#ins_rep_file", function() {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        const file = this.files[0];
        $('#ir_img_err').remove();
        if (file && !allowedTypes.includes(file.type)) {
            $(this).after('<small id="ir_img_err" class="text-danger">Only JPG, JPEG, or PNG files are allowed.</small>');
            $(this).val('');
        }
        if (file && file.size > 1048576) {
            $(this).after('<small id="ir_img_err" class="text-danger">Maximum allowed file size is 1MB.</small>');
            $(this).val('');
        }
    });
    $('#ins_report_form').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let hidden_cancel = $("#hidden_cancel").val();
        let hidden_ok = $("#hidden_ok").val();
        $.ajax({
            url: "{{ route('inspection-report-upload') }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function(response) {
                $('#insReportUpl').modal('hide');
                alert("File Uploaded Successfully!");
                location.reload();
            },
            error: function(xhr) {
                let errMsg = xhr.responseJSON?.message || "Upload failed.";
                alert(errMsg);
            }
        });
    });
    $(document).on("click", ".final_inspect_btn", function() {
        let id = $(this).data("id");
        $(".manufacture_id").val(id);
    });
    $('#inspect_approval').on('submit', function(e) {
        e.preventDefault();
        let isValid = true;
        $('.inspected_user_err').text('');
        $('.checked_user_err').text('');
        $('.remark_error').text('');
        const inspectedBy = $('#inspected_by').val();
        const checkedBy = $('#checked_by').val();
        const remarks = $('#remarks').val().trim();
        if (!inspectedBy) {
            $('.inspected_user_err').text('Inspected By field is required.');
            isValid = false;
        }
        if (!checkedBy) {
            $('.checked_user_err').text('Checked By field is required.');
            isValid = false;
        }
        if (!isValid) {
            return;
        }
        let formData = new FormData(this);
        $.ajax({
            url: "{{ route('updateInspectionApproval') }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function(response) {
                $('#checkedPersonModal').modal('hide');
                alert("Updated Successfully!");
                location.reload();

            },
            error: function(xhr) {
                let errMsg = xhr.responseJSON?.message || "Something went wrong.";
                alert(errMsg);
            }
        });
    });
</script>
@endsection