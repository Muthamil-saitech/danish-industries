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
<!-- Optional theme -->
<input type="hidden" id="edit_mode" value="{{ isset($obj) && $obj ? $obj->id : null }}">
<section class="main-content-wrapper">
    @include('utilities.messages')
    <section class="content-header">
        <div class="row">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <button id="job_add" data-bs-toggle="modal" data-id="{{ $obj->id }}" data-bs-target="#jobUpl" class="btn bg-second-btn" title="Job Card Upload Form" type="button"><i class="fa-regular fa-circle-up"></i>&nbsp;Upload</button>
                @if (routePermission('manufacture.print'))
                <a href="javascript:void();" target="_blank" class="btn bg-second-btn print_job_card"
                    data-id="{{ $obj->id }}"><iconify-icon icon="solar:printer-broken"></iconify-icon>
                    @lang('index.print')</a>
                @endif
                <!--<a href="{{ route('download_job_card', encrypt_decrypt($obj->id, 'encrypt')) }}"
                        target="_blank" class="btn bg-second-btn print_btn"><iconify-icon
                            icon="solar:cloud-download-broken"></iconify-icon>
                        @lang('index.download')</a> -->
                @if (routePermission('manufacture.index'))
                <a class="btn bg-second-btn" href="{{ route('productions.index') }}"><iconify-icon
                        icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
                @endif
            </div>
        </div>
    </section>
    @if(isset($latest_form) && $latest_form!='')
    <div style="width: 98%; max-width: 1100px; margin: 30px auto;">
        <img src="{!! getBaseURL() .
                        (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png') !!}" alt="Logo Image" class="img-fluid mb-2">
        <!-- <h3 style="text-align: center; font-weight: bold; font-size: 22px; margin-bottom: 5px;">{{ strtoupper($setting->name_company_name) }}</h3> -->
        <p style="text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 10px;">{{ isset($title) && $title ? strtoupper($title) : '' }}</p>
        <img src="{{ $baseURL }}uploads/job_card_form/{{ $latest_form }}" alt="route_card_form" class="img-fluid">
    </div>
    @else
    <div style="width: 98%; max-width: 1100px; margin: 30px auto; font-family: Arial, sans-serif;  padding: 18px;">
        <div style="text-align: center;">
            <img src="{!! getBaseURL() .
                        (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png') !!}" alt="Logo Image" class="img-fluid mb-2">
            <!-- <h3 style="margin: 0; font-size: 22px;">{{ strtoupper($setting->name_company_name) }}</h3> -->
            <p style="font-size: 14px; margin-bottom: 10px">{{ strtoupper($setting->address) }}</p>
        </div>
        <h3 style="text-align: center; margin-bottom: 10px; font-size: 18px;">{{ isset($title) && $title ? strtoupper($title) : '' }}</h3>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <div><b>WORK CENTRE: </b></div>
            <div>
                <div style="margin-bottom: 10px;margin-right:100px;"><b>Sl. No: </b></div>
                <div style="margin-right:100px;"><b>Date: </b></div>
            </div>
        </div>
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <thead>
                <tr>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">OPR NAME</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">SHIFT</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">
                        PART NO.<br>
                        <span style="font-weight: bold; border-top: 1px solid #000;">PPRC.No</span>
                    </th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">ITEM NAME</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">OPRN STAGE</th>
                    <th colspan="3" style="border: 1px solid #000; padding: 4px;">SETTING TIME</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">CYCLE TIME IN MIN</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">IDEAL TIME IN MIN</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">ACHIEVED QTY</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">ACCEPTED QTY</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">REJECTED QTY</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">REWORK QTY</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">IN TIME MIN</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">OUT TIME MIN</th>
                    <th rowspan="2" style="border: 1px solid #000; padding: 4px;">OPERATOR SIGN</th>
                </tr>
                <tr>
                    <th style="border: 1px solid #000; padding: 4px;">START</th>
                    <th style="border: 1px solid #000; padding: 4px;">END</th>
                    <th style="border: 1px solid #000; padding: 4px;">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"><br><br></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; border-right: 1px solid #000; padding: 20px;"></td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; padding: 20px;">&nbsp;</td>
                    <td style="border-left: 1px solid #000; border-right: 1px solid #000; padding: 20px;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"><br></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"><br></td>
                    <td style="border-left: 1px solid #000; padding: 20px;"></td>
                    <td style="border-left: 1px solid #000; border-right: 1px solid #000; padding: 20px;"></td>
                </tr>
                <tr>
                    <td colspan="5" style="border: 1px solid #000; text-align: right; padding: 5px;"></td>
                    <td colspan="2" style="border: 1px solid #000; text-align: right; padding: 5px;"><strong>TOTAL TIME</strong></td>
                    <td colspan="1" style="border: 1px solid #000; text-align: right; padding: 5px;"></td>
                    <td colspan="1" style="border: 1px solid #000; text-align: right; padding: 5px;"></td>
                    <td colspan="1" style="border: 1px solid #000; text-align: right; padding: 5px;"></td>
                    <td colspan="1" style="border: 1px solid #000; text-align: right; padding: 5px;"></td>
                    <td colspan="1" style="border: 1px solid #000; text-align: right; padding: 5px;"></td>
                    <td colspan="1" style="border: 1px solid #000; text-align: right; padding: 5px;"></td>
                    <td colspan="1" style="border: 1px solid #000; text-align: right; padding: 5px;"></td>
                    <td colspan="1" style="border: 1px solid #000; text-align: right; padding: 5px;"></td>
                    <td colspan="1" style="border: 1px solid #000; text-align: right; padding: 5px;"></td>
                    <td colspan="1" style="border: 1px solid #000; text-align: right; padding: 5px;"></td>
                </tr>
            </tbody>
        </table>
        <p class="text-end" style="padding-right:50px; padding-top:5px; font-size: 9px;"><b>PRODUCTION INCHARGE</b></p>
        <div style="display: flex; justify-content: space-between; margin-top: 20px;">
            <div style="width: 53%;">
                <p style="font-size: 16px; font-weight: bold;">OPERATION STAGE</p>
                <p style="font-size: 16px;">
                <div style="display: flex; gap: 20px;">
                    <span style="width: 150px;"> 01. Skin Turn </span><span> 08. Drilling / Tap </span>
                </div>
                <div style="display: flex; gap: 20px;">
                    <span style="width: 150px;"> 02. Finishing-1 </span><span> 09. Milling</span>
                </div>
                <div style="display: flex; gap: 20px">
                    <span style="width: 150px;"> 03. Finishing-2</span><span>10. Special Operation</span>
                </div>
                <div style="display: flex; gap: 20px">
                    <span style="width: 150px;"> 04. Roughing-1</span><span> 11. Cutting </span>
                </div>
                <div style="display: flex; gap: 20px">
                    <span style="width: 150px;"> 05. Roughing-2 </span><span> 12. Spot Facing </span>
                </div>
                <div style="display: flex; gap: 20px">
                    <span style="width: 150px;"> 06. Drilling</span><span> 13. Rework</span>
                </div>
                <div style="display: flex; gap: 20px">
                    <span style="width: 150px;"> 07. Reaming </span><span> 14. Grinding</span>
                </div>
                </p>
            </div>
            <div style="width: 47%;">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <tr>
                        <td style="border: 1px solid #000; padding: 3px;">Note:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td style="text-align:center; border: 1px solid #000; padding: 3px;">OPR SIGN</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #000; padding: 3px;">1</td>
                        <td style="border: 1px solid #000; padding: 3px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #000; padding: 3px;">2</td>
                        <td style="border: 1px solid #000; padding: 3px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #000; padding: 3px;">3</td>
                        <td style="border: 1px solid #000; padding: 3px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #000; padding: 3px;">4</td>
                        <td style="border: 1px solid #000; padding: 3px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #000; padding: 3px;">5</td>
                        <td style="border: 1px solid #000; padding: 3px;">&nbsp;</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @endif
    <div class="modal fade" id="jobUpl" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Upload Job Card Form</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <form id="job_upload_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="file" name="image" class="form-control" id="job_file" accept=".jpg,.jpeg,.png" required>
                        <input type="hidden" name="manufacture_id" id="manufacture_id" class="form-control">
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
<script type="text/javascript" src="{!! $baseURL . 'assets/bower_components/gantt/js/jquery.fn.gantt.js' !!}"></script>
<script type="text/javascript" src="{!! $baseURL . 'assets/bower_components/gantt/js/jquery.cookie.min.js' !!}"></script>
<script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/addManufactures.js' !!}"></script>
<script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/genchat.js' !!}"></script>
<script src="{!! $baseURL . 'frequent_changing/js/manufacture.js' !!}"></script>
<script>
    $(document).on("click", "#job_add", function(e) {
        let manufacture_id = $(this).data('id');
        $("#manufacture_id").val(manufacture_id);
    });
    $(document).on('change', "#job_file", function() {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        const file = this.files[0];
        $('#job_img_err').remove();
        if (file && !allowedTypes.includes(file.type)) {
            $(this).after('<small id="job_img_err" class="text-danger">Only JPG, JPEG, or PNG files are allowed.</small>');
            $(this).val('');
        }
        if (file && file.size > 1048576) {
            $(this).after('<small id="job_img_err" class="text-danger">Maximum allowed file size is 1MB.</small>');
            $(this).val('');
        }
    });
    $('#job_upload_form').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let hidden_cancel = $("#hidden_cancel").val();
        let hidden_ok = $("#hidden_ok").val();
        $.ajax({
            url: "{{ route('job-card-upload') }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function(response) {
                $('#jobUpl').modal('hide');
                alert("File Uploaded Successfully!");
                location.reload();

            },
            error: function(xhr) {
                let errMsg = xhr.responseJSON?.message || "Upload failed.";
                alert(errMsg);
            }
        });
    });
</script>
@endsection