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
                {!! Form::model(isset($obj) && $obj ? $obj : '', [
                    'id' => 'drawingForm',
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'enctype' => 'multipart/form-data',
                    'route' => ['drawers.update', isset($obj->id) && $obj->id ? $obj->id : ''],
                ]) !!}
                @csrf
                <div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-6">
                            <div class="form-group">
                                <label>@lang('index.drawer_no') <span class="required_star">*</span></label>
                                <input type="text" name="drawer_no" id="drawer_no" class="form-control @error('drawer_no') is-invalid @enderror" placeholder="@lang('index.drawer_no')" value="{{ isset($obj) && $obj->drawer_no ? $obj->drawer_no : old('drawer_no') }}">
                                <p class="text-danger drawer_no_err"></p>
                                @error('drawer_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-6">
                            <div class="form-group">
                                <label>@lang('index.revision_no') <span class="required_star">*</span></label>
                                <input type="text" name="revision_no" id="revision_no" class="form-control @error('revision_no') is-invalid @enderror" placeholder="Revision No" value="{{ isset($obj) && $obj->revision_no ? $obj->revision_no : old('revision_no') }}">
                                <p class="text-danger rev_no_err"></p>
                                @error('revision_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-6">
                            <div class="form-group">
                                <label>@lang('index.revision_date') <span class="required_star">*</span></label>
                                {!! Form::text('revision_date', isset($obj->revision_date) && $obj->revision_date ? date('d-m-Y',strtotime($obj->revision_date)) : (old('revision_date') ?: ''), [
                                    'id' => 'rev_date',
                                    'class' => 'form-control revision_date',
                                    'placeholder' => 'Revision Date',
                                ]) !!}
                                <p class="text-danger rev_date_err"></p>
                                @error('revision_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-6">
                            <div class="form-group">
                                <label>@lang('index.drawer_loc') <span class="required_star">*</span></label>
                                <input type="text" name="drawer_loc" id="drawer_loc" class="form-control @error('drawer_loc') is-invalid @enderror" placeholder="@lang('index.drawer_loc')" value="{{ isset($obj) && $obj->drawer_loc ? $obj->drawer_loc : old('drawer_loc') }}">
                                <p class="text-danger drawer_loc_err"></p>
                                @error('drawer_loc')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-6">
                            <div class="form-group">
                                <label>Tools/Gauges List <span class="required_star">*</span></label>
                                <select multiple class="form-control @error('tools_id') is-invalid @enderror select2" name="tools_id[]" id="tools_id">
                                    <option value="">@lang('index.select')</option>
                                    @foreach($tools as $tool)
                                        <option {{ (collect(old('tools_id', isset($obj->tools_id) ? explode(',', $obj->tools_id) : []))->contains($tool->id)) ? 'selected' : '' }} value="{{ $tool->id }}">{{ $tool->tool_name }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger tool_err"></p>
                                @error('tools_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-5">
                            <div class="form-group">
                                <label>@lang('index.add_a_file') (@lang('index.max_size_1_mb'))</label>
                                <input type="file" name="drawer_img" id="drawer_img" class="form-control @error('drawer_img') is-invalid @enderror" accept=".jpeg,.jpg,.png,.svg" >
                                @error('drawer_img')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-1">
                            @if (isset($obj) && $obj->drawer_img!='')
                                <img src="{{ $baseURL }}uploads/drawer/{{ $obj->drawer_img }}" alt="Drawer Image" width="70px">
                            @endif
                        </div>
                        <div class="col-sm-12 mb-2 col-md-6">
                            <div class="form-group">
                                <label>@lang('index.manufacture_stages') <span class="required_star">*</span></label>
                                <select multiple class="form-control @error('stage_id') is-invalid @enderror select2" name="stage_id[]" id="stage_id">
                                    <option value="">@lang('index.select')</option>
                                    @foreach($productionstages as $stage)
                                        <option {{ (collect(old('stage_id', isset($obj->stage_id) ? explode(',', $obj->stage_id) : []))->contains($stage->id)) ? 'selected' : '' }} value="{{ $stage->id }}">{{ $stage->name }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger stage_err"></p>
                                @error('stage_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="add_pc mt-3">
                            @if(isset($obj) && $obj->program_code!='')
                                @php $program_codes = json_decode($obj->program_code,true); @endphp
                                @foreach($program_codes as $key => $program_code)
                                <div class="row">
                                    <div class="col-sm-12 mb-2 col-md-4">
                                        <div class="form-group">
                                            <label>@lang('index.program_code') <span class="required_star">*</span></label>
                                            <input type="text" name="program_code[]" id="program_code[]" class="form-control @error('program_code') is-invalid @enderror" placeholder="Program Code" value="{{ $program_code ?? old('program_code') }}">
                                            @error('program_code')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    @if($key==0)
                                        <div class="col-md-4 mb-3 mt-1">
                                            <button id="programCodeAdd" class="btn bg-blue-btn mt-4" type="button">@lang('index.add_more')</button>
                                        </div>
                                    @else
                                        @if(isset($program_codes) && count($program_codes) > 0)
                                        <div class="col-md-4 mt-4">
                                            <a href="#" class="pro_code button-danger"
                                                data-contact_id="" type="submit"
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
                                @endforeach
                            @else
                            <div class="row">
                                <div class="col-sm-12 mb-2 col-md-4">
                                    <div class="form-group">
                                        <label>@lang('index.program_code') <span class="required_star">*</span></label>
                                        <input type="text" name="program_code[]" id="program_code[]" class="form-control @error('program_code') is-invalid @enderror" placeholder="Program Code" value="{{ isset($obj) && $obj->program_code ? $obj->program_code : old('program_code') }}">
                                        <p class="text-danger pro_code_err"></p>
                                        @error('program_code')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3 mt-1">
                                    <button id="programCodeAdd" class="btn bg-blue-btn mt-4" type="button">@lang('index.add_more')</button>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h4 class="mb-0">Dimension Inspection</h4>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="w-5 text-center">@lang('index.sn')</th>
                                                <th class="w-5 text-center">Parameter <span class="required_star">*</span></th>
                                                <th class="w-5 text-center">Drawing Specification <span class="required_star">*</span></th>
                                                <th class="w-5 text-center">Inspection Method</th>
                                                <th class="w-5 text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="add_di_ins">
                                            @if(isset($drawing_parameters) && !empty($drawing_parameters))
                                                @foreach($drawing_parameters as $value)
                                                    @php
                                                        $isEmpty = empty($value->di_param);
                                                    @endphp
                                                    @if(!$isEmpty)
                                                        <tr class='rowDiCount'>
                                                            <td class='text-center'>{{ $loop->iteration }}</td>
                                                            <td class='text-center'><input type="text" class="form-control" name="di_param[]" maxlength='30' value="{{ $value->di_param }}"></td>
                                                            <td class='text-center'><input type="text" class="form-control" name="di_spec[]" maxlength='100' value="{{ $value->di_spec }}"></td>
                                                            <td class='text-center'><input type="text" class="form-control" name="di_method[]" maxlength='100' value="{{ $value->di_method }}"></td>
                                                            <td class='text-center'>
                                                                <a class="btn btn-xs del_row remove-tr dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    <button id="di_param_add" class="btn btn-xs bg-blue-btn mt-2"
                                        type="button">@lang('index.add_more')</button>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <h4 class="mb-0">Appearance Inspection</h4>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="w-5 text-center">@lang('index.sn')</th>
                                                <th class="w-5 text-center">Parameter <span class="required_star">*</span></th>
                                                <th class="w-5 text-center">Drawing Specification <span class="required_star">*</span></th>
                                                <th class="w-5 text-center">Inspection Method</th>
                                                <th class="w-5 text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="add_ap_ins">
                                            @if(isset($drawing_parameters) && !empty($drawing_parameters))
                                                @foreach($drawing_parameters as $value)
                                                    @php
                                                        $isEmpty = empty($value->ap_param);
                                                    @endphp
                                                    @if(!$isEmpty)
                                                        <tr class='rowDiCount'>
                                                            <td class='text-center'>{{ $loop->iteration }}</td>
                                                            <td class='text-center'><input type="text" class="form-control" name="ap_param[]" maxlength='30' value="{{ $value->ap_param }}"></td>
                                                            <td class='text-center'><input type="text" class="form-control" name="ap_spec[]" maxlength='100' value="{{ $value->ap_spec }}"></td>
                                                            <td class='text-center'><input type="text" class="form-control" name="ap_method[]" maxlength='100' value="{{ $value->ap_method }}"></td>
                                                            <td class='text-center'>
                                                                <a class="btn btn-xs del_row remove-tr dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    <button id="ap_param_add" class="btn btn-xs bg-blue-btn mt-2"
                                        type="button">@lang('index.add_more')</button>
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="row mt-2">
                    <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
                        <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><iconify-icon icon="solar:check-circle-broken"></iconify-icon>@lang('index.submit')</button>
                        <a class="btn bg-second-btn" href="{{ route('drawers.index') }}"><iconify-icon icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
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
        let i = 0;
        $(document).on("click", "#programCodeAdd", function (e) {
            ++i;
            let newRow = `
                <div class="row mt-3" id="pc_row_${i}">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Program Code <span class="text-danger">*</span></label>
                            <input type="text" name="program_code[]" class="form-control" placeholder="Program Code">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mt-4">
                        <button type="button" class="btn btn-xs del_row dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></button>
                    </div>
                </div>
            `;
            $(".add_pc").append(newRow);
        });
        $(document).ready(function() {
            $(".add_di_ins tr").addClass("rowDiCount");
            $(".add_ap_ins tr").addClass("rowApCount");
            resetSerialNumbers(".rowDiCount");
            resetSerialNumbers(".rowApCount");
        });
        function resetSerialNumbers(selector) {
            $(selector).each(function(index) {
                $(this).find("td:first").text(index + 1);
            });
        }
        $(document).on("click", "#di_param_add", function () {
            let html = "<tr class='rowDiCount'>";
            html += "<td class='text-center'></td>"; // will be updated
            html += "<td><input type='text' name='di_param[]' class='form-control' maxlength='30'></td>";
            html += "<td><input type='text' name='di_spec[]' class='form-control' maxlength='100'></td>";
            html += "<td><input type='text' name='di_method[]' class='form-control' maxlength='100'></td>";
            html += '<td class="text-center"><a class="btn btn-xs del_row remove-tr dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>';
            html += "</tr>";
            $(".add_di_ins").append(html);
            resetSerialNumbers(".add_di_ins .rowDiCount");
        });
        $(document).on("click", "#ap_param_add", function () {
            let html = "<tr class='rowApCount'>";
            html += "<td class='text-center'></td>"; // will be updated
            html += "<td><input type='text' name='ap_param[]' class='form-control'></td>";
            html += "<td><input type='text' name='ap_spec[]' class='form-control'></td>";
            html += "<td><input type='text' name='ap_method[]' class='form-control'></td>";
            html += '<td class="text-center"><a class="btn btn-xs del_row remove-tr dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>';
            html += "</tr>";
            $(".add_ap_ins").append(html);
            resetSerialNumbers(".add_ap_ins .rowApCount");
        });
        $(document).on("click", ".del_row", function () {
            $(this).closest(".row").remove();
        });
        /* $("#tools_id").select2({
            placeholder: "",
            closeOnSelect: false,
            allowClear: true,
            templateSelection: function () {
                let selected = $("#tools_id").select2('data');
                if (!selected || selected.length === 0) {
                    return $('<span class="select2-selection__placeholder">Select</span>');
                }
                if (selected.length > 3) {
                    return selected.slice(0, 3).map(s => s.text).join(", ") +
                        " +" + (selected.length - 3) + " more";
                }
                return selected.map(s => s.text).join(", ");
            }
        });
        $("#tools_id").on("select2:select select2:unselect", function () {
            let container = $(this).next('.select2-container').find('.select2-selection__rendered');
            let summary = $("#tools_id").select2('data');
            let text = "";

            if (summary.length > 3) {
                text = summary.slice(0, 3).map(s => s.text).join(", ") +
                    " +" + (summary.length - 3) + " more";
            } else if (summary.length > 0) {
                text = summary.map(s => s.text).join(", ");
            } else {
                text = '<span class="select2-selection__placeholder">Select</span>'; // 🔑 Show placeholder again
            }

            container.html('<li class="select2-selection__choice">' + text + '</li>');
        });
        $("#stage_id").select2({
            placeholder: "",
            closeOnSelect: false,
            allowClear: true,
            templateSelection: function () {
                let selected = $("#stage_id").select2('data');

                if (!selected || selected.length === 0) {
                    // 🔑 Return placeholder with proper class
                    return $('<span class="select2-selection__placeholder">Select</span>');
                }

                if (selected.length > 3) {
                    return selected.slice(0, 3).map(s => s.text).join(", ") +
                        " +" + (selected.length - 3) + " more";
                }

                return selected.map(s => s.text).join(", ");
            }
        });
        // Keep your custom summary handler
        $("#stage_id").on("select2:select select2:unselect", function () {
            let container = $(this).next('.select2-container').find('.select2-selection__rendered');
            let summary = $("#stage_id").select2('data');
            let text = "";

            if (summary.length > 3) {
                text = summary.slice(0, 3).map(s => s.text).join(", ") +
                    " +" + (summary.length - 3) + " more";
            } else if (summary.length > 0) {
                text = summary.map(s => s.text).join(", ");
            } else {
                text = '<span class="select2-selection__placeholder">Select</span>'; // 🔑 Show placeholder again
            }

            container.html('<li class="select2-selection__choice">' + text + '</li>');
        }); */
        $(document).on('submit', '#drawingForm', function (e) {
            // e.preventDefault();
            resetSerialNumbers(".rowDiCount");
            resetSerialNumbers(".rowApCount");
            let isValid = true;
            $('.is-invalid').removeClass('is-invalid');
            $('.rev_date_err, .drawer_no_err, .rev_no_err, .drawer_loc_err, .tool_err, .stage_err, .pro_code_err').text('');
            $('.add_di_ins .di-error-row, .add_ap_ins .ap-error-row').remove();
            let drawer_no = $('#drawer_no').val()?.trim() || '';
            let revision_no   = $('#revision_no').val()?.trim() || '';
            let rev_date = $('#rev_date').val()?.trim() || '';
            let drawer_loc  = $('#drawer_loc').val()?.trim() || '';
            let tools_id = $('#tools_id').val() || [];
            let stage_id = $('#stage_id').val() || [];
            let program_code = $('input[name="program_code[]"]').map(function () {
                return $(this).val()?.trim();
            }).get().filter(v => v !== '');
            if (!rev_date) $(".rev_date_err").text("The Revision Date field is required"), isValid=false;
            if (!drawer_no) $(".drawer_no_err").text("The Drawing No field is required"), isValid=false;
            if (!revision_no) $(".rev_no_err").text("The Revision No field is required"), isValid=false;
            if (!drawer_loc) $(".drawer_loc_err").text("The Drawing Location field is required"), isValid=false;
            if (tools_id.length === 0) {
                $(".tool_err").text("At least one tool/gauge is required");
                isValid = false;
            }
            if (stage_id.length === 0) {
                $(".stage_err").text("At least one stage is required");
                isValid = false;
            }
            if (program_code.length === 0) {
                $(".pro_code_err").text("At least one program code is required");
                isValid = false;
            }
            let diRows = $('.add_di_ins tr.rowDiCount');
            let diParamsSet = new Set();
            if (diRows.length < 1) {
                isValid = false;
                $('.add_di_ins').html('<tr class="di-error-row"><td colspan="5" class="text-danger text-center">At least one row is required.</td></tr>');
            } else {
                let diValid = true;
                diRows.each(function () {
                    const param = $(this).find('input[name="di_param[]"]').val()?.trim();
                    const spec  = $(this).find('input[name="di_spec[]"]').val()?.trim();
                    if (!param || !spec) {
                        diValid = false;
                        return;
                    }
                    if (diParamsSet.has(param)) {
                        diValid = false;
                    } else {
                        diParamsSet.add(param);
                    }
                });
                if (!diValid) {
                    isValid = false;
                    if (!$('.add_di_ins .di-error-row').length) {
                        $('.add_di_ins').append('<tr class="di-error-row"><td colspan="5" class="text-danger text-center">All fields are required and no duplicates allowed.</td></tr>');
                    }
                }
            }

            let apRows = $('.add_ap_ins tr.rowApCount');
            let apParamsSet = new Set();

            if (apRows.length < 1) {
                isValid = false;
                $('.add_ap_ins').html('<tr class="ap-error-row"><td colspan="5" class="text-danger text-center">At least one row is required.</td></tr>');
            } else {
                let apValid = true;
                apRows.each(function () {
                    const param = $(this).find('input[name="ap_param[]"]').val()?.trim();
                    const spec  = $(this).find('input[name="ap_spec[]"]').val()?.trim();

                    if (!param || !spec) {
                        apValid = false;
                        return;
                    }

                    if (apParamsSet.has(param)) {
                        apValid = false;
                    } else {
                        apParamsSet.add(param);
                    }
                });

                if (!apValid) {
                    isValid = false;
                    if (!$('.add_ap_ins .ap-error-row').length) {
                        $('.add_ap_ins').append('<tr class="ap-error-row"><td colspan="5" class="text-danger text-center">All fields are required and no duplicates allowed.</td></tr>');
                    }
                }
            }
            if (!isValid) {
                e.preventDefault();
            }
        });
        $(document).on("click", ".dlt_button", function () {
            const row = $(this).closest("tr");
            const parentTableBody = row.closest("tbody");
            row.remove();
            if (parentTableBody.hasClass("add_di_ins")) {
                resetSerialNumbers(".add_di_ins .rowDiCount");
            } else if (parentTableBody.hasClass("add_ap_ins")) {
                resetSerialNumbers(".add_ap_ins .rowApCount");
            }
        });
    </script>
@endsection
