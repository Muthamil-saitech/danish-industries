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
            <!-- general form elements -->
            <div class="table-box">
                <!-- form start -->
                {!! Form::model(isset($manufacture) && $manufacture ? $manufacture : '', [
                    'id' => 'consumable_form',
                    'method' => isset($manufacture) && $manufacture ? 'PATCH' : 'POST',
                    'route' => ['consumable.update', isset($manufacture->id) && $manufacture->id ? $manufacture->id : ''],
                ]) !!}
                @csrf
                <div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.ppcrc_no') </label>
                                <input type="hidden" name="manufacture_id" id="manufacture_id"
                                    class="form-control @error('manufacture_id') is-invalid @enderror" value="{{ isset($manufacture) && $manufacture ? $manufacture->id : old('manufacture_id') }}" readonly>
                                <input type="text" name="ppcrc_no" id="ppcrc_no"
                                    class="form-control @error('ppcrc_no') is-invalid @enderror" placeholder="@lang('index.ppcrc_no')" value="{{ isset($manufacture) && $manufacture ? $manufacture->reference_no : old('reference_no') }}" readonly>
                                <p class="text-danger manufacture_err"></p>
                                @error('ppcrc_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.production_stage') </label>
                                <select name="production_stage" id="production_stage" class="form-control @error('production_stage') is-invalid @enderror select2">
                                    <option value="">@lang('index.select')</option>
                                    @foreach ($m_stages as $stage)
                                        <option value="{{ $stage->productionstage_id }}" {{ isset($stage->productionstage_id) && $stage->productionstage_id==old('production_stage') ? 'selected' : '' }}>{{ getProductionStages($stage->productionstage_id) }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger pro_stage_err"></p>
                                @error('production_stage')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.employees') </label>
                                <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror select2">
                                    <option value="">@lang('index.select')</option>
                                    @foreach ($employees as $emp)
                                        <option value="{{ $emp->id }}" {{ isset($emp) && $emp->id==old('user_id') ? 'selected' : '' }}>{{ getEmpCode($emp->id) }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger user_err"></p>
                                @error('user_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.material_name') (Code) <span class="required_star">*</span></label>
                                <select name="mat_id" id="mat_id" class="form-control @error('mat_id') is-invalid @enderror select2">
                                    <option value="">@lang('index.select')</option>
                                    @foreach ($consumable_materials as $material)
                                        <option value="{{ $material->id }}" {{ isset($material) && $material->id==old('mat_id') ? 'selected' : '' }}>{{ getRMName($material->id) }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger material_err"></p>
                                @error('mat_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.quantity') <span class="required_star">*</span></label>
                                <input type="text" name="qty" id="qty" class="form-control @error('qty') is-invalid @enderror" placeholder="@lang('index.quantity')" value="{{ old('qty') }}">
                                <p class="text-danger qty_err"></p>
                                @error('qty')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
                            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><iconify-icon
                                    icon="solar:check-circle-broken"></iconify-icon>@lang('index.submit')</button>
                            <a class="btn bg-second-btn" href="{{ route('consumable.index') }}"><iconify-icon
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
@section('script')
    <script type="text/javascript" src="{!!  $baseURL . 'assets/bower_components/jquery-ui/jquery-ui.min.js'  !!}"></script>
    <script>
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
                    // $(".select2").select2();
                },
                error: function () {
                    console.error("Failed to fetch product details.");
                },
            });
        });
        $(document).on('submit', '#consumable_form', function (e) {
            let isValid = true;
            $('.is-invalid').removeClass('is-invalid');
            $('.manufacture_err, .pro_stage_err, .user_err, .material_err, .qty_err').text('');
            let ppcrcNo  = $('#ppcrc_no').val()?.trim() || '';
            let productionStage  = $('#production_stage').val()?.trim() || '';
            let userId  = $('#user_id').val()?.trim() || '';
            let matId  = $('#mat_id').val()?.trim() || '';
            let qty  = $('#qty').val()?.trim() || '';
            if (!ppcrcNo) $(".manufacture_err").text("The PPCRC Number field is required"), isValid=false;
            if (productionStage && !userId) $(".user_err").text("If Production Stage is selected, then select Task Person."), isValid=false;
            if (!matId) $(".material_err").text("The Material Name field is required"), isValid=false;
            if (!qty) $(".qty_err").text("The Qty field is required"), isValid=false;
            if (!isValid) e.preventDefault();
        });
    </script>
@endsection
