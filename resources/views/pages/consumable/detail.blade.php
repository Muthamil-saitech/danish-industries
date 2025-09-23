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
                    <h2 class="top-left-header">{{ isset($title) && $title ? $title : '' }}</h2>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="col-md-12">
                <div class="card" id="dash_0">
                    <div class="card-body p30">
                        <div class="m-auto b-r-5">
                            <div class="row mt-4">
                                <div class="table-box">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="ir_w_1"> @lang('index.sn')</th>
                                                    <th class="ir_w_16">@lang('index.ppcrc_no')</th>
                                                    <th class="ir_w_16">@lang('index.production_stage')</th>
                                                    <th class="ir_w_16">@lang('index.employees')</th>
                                                    <th class="ir_w_16">@lang('index.material_name')(@lang('index.code'))</th>
                                                    <th class="ir_w_16">@lang('index.incharge')</th>
                                                    <th class="ir_w_16">@lang('index.quantity')</th>
                                                    <th class="ir_w_5">@lang('index.actions')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($consumables as $value)
                                                    <tr>
                                                        <td class="ir_txt_center">{{ $loop->iteration }}</td>
                                                        <td>{{ $value->ppcrc_no ? $value->ppcrc_no : '' }}</td>
                                                        <td>
                                                            <span class="badge bg-warning text-dark">
                                                                {{ getProductionStage($value->production_stage) }}
                                                            </span>
                                                        </td>
                                                        <td>{{ getEmpCode($value->user_id) }}</td>
                                                        <td>{{ getRMName($value->mat_id) }}</td>
                                                        <td>{{ getEmpCode($value->incharge_user_id) }}</td>
                                                        <td>{{ $value->qty.' '.$value->unit }}</td>
                                                        <td>
                                                            <a class="button-success consumeBtn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#consumableModal"
                                                            data-id="{{ $value->id }}"
                                                            data-production_stage="{{ $value->production_stage }}"
                                                            data-manufacture_id="{{ $value->manufacture_id }}"
                                                            data-ppcrc_no="{{ $value->ppcrc_no }}"
                                                            data-user_id="{{ $value->user_id }}"
                                                            data-mat_id="{{ $value->mat_id }}"
                                                            data-qty="{{ $value->qty }}"
                                                            data-unit="{{ $value->unit }}"
                                                            data-incharge_user_id="{{ $value->incharge_user_id }}"
                                                            title="Edit">
                                                                <i class="fa fa-edit tiny-icon"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">No consumables added.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade" id="consumableModal" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">@lang('index.edit_consumable')</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i data-feather="x"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" id="consumableForm">
                            <div class="row">
                                <input type="hidden" name="consumable_id" id="consumable_id">
                                <input type="hidden" name="manufacture_id" id="manufacture_id">
                                <input type="hidden" name="ppcrc_no" id="ppcrc_no">
                                <input type="hidden" name="production_stage" id="production_stage">
                                <input type="hidden" name="user_id" id="user_id">
                                <input type="hidden" name="mat_id" id="mat_id">
                                <input type="hidden" name="unit" id="unit">
                                <input type="hidden" name="incharge_user_id" id="incharge_user_id">
                                {{-- <div class="col-sm-12 mb-2 col-md-6">
                                    <div class="form-group">
                                        <label>@lang('index.production_stage') </label>                                        
                                        <select name="production_stage" id="production_stage" class="form-control @error('production_stage') is-invalid @enderror select2">
                                            <option value="">@lang('index.select')</option>
                                            @foreach ($m_stages as $stage)
                                                <option value="{{ $stage->productionstage_id }}">{{ getProductionStages($stage->productionstage_id) }}</option>
                                            @endforeach
                                        </select>
                                        <p class="text-danger stage_err"></p>
                                    </div>
                                </div> --}}
                                {{-- <div class="col-sm-12 mb-2 col-md-6">
                                    <div class="form-group">
                                        <label>@lang('index.employees') </label>
                                        <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror select2">
                                            <option value="">@lang('index.select')</option>
                                        </select>
                                        <p class="text-danger user_err"></p>
                                    </div>
                                </div> --}}
                                {{-- <div class="col-sm-12 mb-2 col-md-6">
                                    <div class="form-group">
                                        <label>@lang('index.material_name') (Code) <span class="required_star">*</span></label>
                                        <select name="mat_id" id="mat_id" class="form-control @error('mat_id') is-invalid @enderror select2">
                                            <option value="">@lang('index.select')</option>
                                            @foreach ($consumable_materials as $material)
                                                <option value="{{ $material->id }}">{{ getRMName($material->id) }}</option>
                                            @endforeach
                                        </select>
                                        <p class="text-danger mat_err"></p>
                                    </div>
                                </div> --}}
                                {{-- <div class="col-sm-12 mb-2 col-md-6">
                                    <div class="form-group">
                                        <label>@lang('index.incharge') </label>
                                        <select name="incharge_user_id" id="incharge_user_id" class="form-control @error('incharge_user_id') is-invalid @enderror select2">
                                            <option value="">@lang('index.select')</option>
                                            @foreach ($consumable_users as $user)
                                                <option value="{{ $user->id }}">{{ getEmpCode($user->id) }}</option>
                                            @endforeach
                                        </select>
                                        <p class="text-danger incharge_err"></p>
                                    </div>
                                </div> --}}
                                <div class="col-sm-12 mb-2 col-md-3">
                                    <label>@lang('index.quantity') <span class="required_star">*</span></label>
                                </div>
                                <div class="col-sm-12 mb-2 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="qty" id="qty" class="form-control @error('qty') is-invalid @enderror" placeholder="@lang('index.quantity')">
                                        <p class="text-danger qty_err"></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-blue-btn consume_edit_btn"><iconify-icon icon="solar:check-circle-broken"></iconify-icon>
                            @lang('index.submit')</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script type="text/javascript" src="{!! $baseURL . 'assets/bower_components/gantt/js/jquery.fn.gantt.js' !!}"></script>
    <script type="text/javascript" src="{!! $baseURL . 'assets/bower_components/gantt/js/jquery.cookie.min.js' !!}"></script>
    <script>
    /* $('#production_stage').select2({
        dropdownParent: $('#consumableModal')
    });
    $('#user_id').select2({
        dropdownParent: $('#consumableModal')
    });
    $('#incharge_user_id').select2({
        dropdownParent: $('#consumableModal')
    });
    $('#mat_id').select2({
        dropdownParent: $('#consumableModal')
    }); */
    $(document).on("click", ".consumeBtn", function () {
        let id = $(this).data("id");
        let stage = $(this).data("production_stage");
        let user = $(this).data("user_id");
        let incharge = $(this).data("incharge_user_id");
        let mat = $(this).data("mat_id");
        let qty = $(this).data("qty");
        let unit = $(this).data("unit");
        let manufacture_id = $(this).data("manufacture_id");
        let ppcrc_no = $(this).data("ppcrc_no");
        $("#mat_id").val(mat);
        $("#qty").val(qty);
        $("#manufacture_id").val(manufacture_id);
        $("#ppcrc_no").val(ppcrc_no);
        $("#consumable_id").val(id);
        $("#user_id").val(user);
        $("#unit").val(unit);
        // $("#incharge_user_id").data("selected", incharge);
        $("#incharge_user_id").val(incharge);
        $("#production_stage").val(stage);
    });
    $(document).on("change", "#production_stage", function () {
        let production_stage = $(this).find(":selected").val();
        let manufacture_id = $("#manufacture_id").val();
        let hidden_base_url = $("#hidden_base_url").val();
        $.ajax({
            type: "POST",
            url: hidden_base_url + "getTaskPerson",
            data: { production_stage: production_stage, manufacture_id: manufacture_id },
            dataType: "json",
            success: function (data) {
                let users = data;
                let select = $("#user_id");
                select.empty();
                select.append('<option value="">Select</option>');
                users.forEach(function (user) {
                    if (user) {
                        let id = user.id;
                        let name = user.name;
                        let code = user.emp_code ?? '';
                        select.append('<option value="' + id + '">' + name + ' (' + code + ')' + '</option>');
                    }
                });
                let selectedUser = select.data("selected");
                if (selectedUser) {
                    select.val(selectedUser).trigger("change");
                }
            },
            error: function () {
                console.error("Failed to fetch product details.");
            },
        });
    });
    $(document).on("click", ".consume_edit_btn", function (e) {
        e.preventDefault();
        let status = true;
        let hidden_base_url = $("#hidden_base_url").val();
        let consumable_id = $("#consumable_id").val();
        let manufacture_id = $("#manufacture_id").val();
        // let production_stage = $("#production_stage").val();
        let user_id = $("#user_id").val();
        // let mat_id = $("#mat_id").val();
        let qty = $("#qty").val();
        // if(production_stage != "" && user_id == "") {
        //     $(".user_err").text("If Production Stage is selected, then select Task Person.");
        //     status = false;
        // } else {
        //     $(".user_err").text("");
        // }
        // if(mat_id == "") {
        //     $(".mat_err").text("The Material Name field is required");
        //     status = false;
        // } else {
        //     $(".mat_err").text("");
        // }
        if(qty == "") {
            $(".qty_err").text("The Quantity field is required");
            status = false;
        } else {
            $(".qty_err").text("");
        }
        if(status==false){
            return false;
        }
        $.ajax({
            type: "PUT",
            url: hidden_base_url + "consumable/" + consumable_id,
            data: $("#consumableForm").serialize(),
            success: function (data) {
                const modalEl = document.getElementById('consumableModal');
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) {
                    modalInstance.hide();
                }
                let hidden_alert = data.status ? "Success" : "Error";
                let hidden_cancel = $("#hidden_cancel").val();
                let hidden_ok = $("#hidden_ok").val();
                swal({
                    title: hidden_alert + "!",
                    text: data.message,
                    cancelButtonText: hidden_cancel,
                    confirmButtonText: hidden_ok,
                    confirmButtonColor: "#3c8dbc",
                }, function () {
                    location.reload();
                });
            },
            error: function () {},
        });
    });
    </script>
@endsection