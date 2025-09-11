@extends('layouts.app')

@section('script_top')
    <?php
    $setting = getSettingsInfo();
    $tax_setting = getTaxInfo();
    $baseURL = getBaseURL();
    ?>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ $baseURL. 'assets/bower_components/jquery-ui/jquery-ui.css' }}">
@endpush

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
                    'id' => 'product_form',
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'enctype' => 'multipart/form-data',
                    'route' => ['finishedproducts.update', isset($obj->id) && $obj->id ? $obj->id : ''],
                ]) !!}
                @csrf
                <div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 mb-2 col-lg-4">
                            <div class="form-group">
                                <label>@lang('index.part_no') <span class="required_star">*</span></label>
                                <input type="text" name="code" id="code"
                                    class="check_required form-control @error('code') is-invalid @enderror"
                                    placeholder="@lang('index.part_no')" value="{{ isset($obj->code) ? $obj->code : old('code') }}" onfocus="select()">
                                <div class="text-danger d-none"></div>
                                @error('code')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.part_name') <span class="required_star">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="check_required form-control @error('name') is-invalid @enderror"
                                    placeholder="@lang('index.part_name')" value="{{ isset($obj) && $obj ? $obj->name : old('name') }}">
                                <div class="text-danger d-none"></div>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.product_category') <span class="required_star">*</span></label>
                                <select class="form-control @error('category') is-invalid @enderror select2" name="category"
                                    id="category_id">
                                    <option value="">@lang('index.select_category')</option>
                                    @foreach ($categories as $value)
                                        <option
                                            {{ isset($obj->category) && $obj->category == $value->id || old('category') == $value->id ? 'selected' : '' }}
                                            value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger d-none"></div>
                                @error('category')
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
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.sin_no') </label>
                                <input type="text" name="danish_sin_no" id="danish_sin_no"
                                    class="check_required form-control @error('danish_sin_no') is-invalid @enderror"
                                    placeholder="@lang('index.sin_no')" value="{{ isset($obj) && $obj ? $obj->danish_sin_no : old('danish_sin_no') }}">
                                <div class="text-danger d-none"></div>
                                @error('danish_sin_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>Rev </label>
                                <input type="text" name="rev" class="form-control" placeholder="Rev" value="{{ isset($obj) ? $obj->rev : old('rev') }}">
                                <div class="text-danger d-none"></div>
                                @error('rev')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>Operation </label>
                                <input type="text" name="operation" class="form-control" placeholder="Operation" value="{{ isset($obj) ? $obj->operation : old('operation') }}">
                                <div class="text-danger d-none"></div>
                                @error('operation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.drawer_no')<span class="required_star">*</span></label>
                                <select class="form-control select2" name="drawer_no" id="drawer_no">
                                    <option value="">@lang('index.select')</option>
                                    @foreach ($drawers as $value)
                                        <option value="{{ $value->drawer_no }}"
                                            {{ old('drawer_no', ($obj->drawer_no ?? '')) == $value->drawer_no ? 'selected' : '' }}>
                                            {{ $value->drawer_no }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="text-danger d-none"></div>
                                @error('drawer_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>Scope</label>
                                <input type="text" name="scope" class="form-control" placeholder="Scope" value="{{ isset($obj) ? $obj->scope : old('scope') }}">
                                <div class="text-danger d-none"></div>
                                @error('scope')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.part_name') </label>
                                <input type="text" name="part_name" id="part_name"
                                    class="check_required form-control @error('part_name') is-invalid @enderror"
                                    placeholder="@lang('index.part_name')" value="{{ isset($obj) && $obj ? $obj->part_name : old('part_name') }}">
                                <div class="text-danger d-none"></div>
                                @error('part_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.part_no') </label>
                                <input type="text" name="part_no" id="part_no"
                                    class="check_required form-control @error('part_no') is-invalid @enderror"
                                    placeholder="@lang('index.part_no')" value="{{ isset($obj) && $obj ? $obj->part_no : old('part_no') }}">
                                <div class="text-danger d-none"></div>
                                @error('part_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.description') <span class="required_star">*</span></label>
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="{{ __('index.description') }}" rows="3">{{ isset($obj) && $obj->description ? $obj->description : old('description') }}</textarea>
                                <div class="text-danger d-none"></div>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.remarks')</label>
                                <textarea name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror" placeholder="{{ __('index.remarks') }}" rows="3">{{ isset($obj) && $obj->remarks ? $obj->remarks : old('remarks') }}</textarea>
                                @error('remarks')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <h4 class="">@lang('index.raw_material_consumption_cost') (BoM)</h4>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.material_category')<span class="required_star">*</span></label>
                                <select tabindex="4"
                                    class="form-control @error('mat_cat_id') is-invalid @enderror select2 select2-hidden-accessible"
                                    name="mat_cat_id" id="mat_cat_id">
                                    <option value="">@lang('index.select')</option>
                                    @foreach ($rmaterialcats as $rmc)
                                        <option value="{{ $rmc->id }}" {{ isset($fp_rmaterials) && $fp_rmaterials[0]['mat_cat_id'] === $rmc->id ? 'selected' : '' }}>{{ $rmc->name }}</option>             
                                    @endforeach
                                </select>
                                @error('mat_cat_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.raw_material_name') (Code)<span class="required_star">*</span></label>
                                @if(isset($rmaterials) && $rmaterials)
                                    <select tabindex="4" class="form-control @error('rmaterial') is-invalid @enderror select2 select2-hidden-accessible" name="rmaterial" id="rmaterial">
                                        <option value="">@lang('index.select')</option>
                                        @foreach($rmaterials as $rm)
                                            <option value="{{ $rm->id.'|'.$rm->name.'|'.$rm->code }}">{{ $rm->name }} ({{ $rm->code }})</option>
                                        @endforeach
                                    </select>
                                @else 
                                    <select tabindex="4" class="form-control @error('rmaterial') is-invalid @enderror select2 select2-hidden-accessible" name="rmaterial" id="rmaterial">
                                        <option value="">@lang('index.select')</option>
                                    </select>
                                @endif  
                                @error('rmaterial')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive rawmaterialsec" id="purchase_cart">
                                <table class="table">
                                    <thead>
                                        <th class="w-10 text-start">@lang('index.sn')</th>
                                        <th class="w-20">@lang('index.raw_material_name')(@lang('index.code'))</th>
                                        <th class="w-10 text-end">@lang('index.actions')</th>
                                    </thead>
                                    <tbody class="add_tr">
                                        @if (isset($fp_rmaterials) && $fp_rmaterials)
                                            @foreach ($fp_rmaterials as $key => $value)
                                                <tr class="rowCount" data-id="{{ $value->rmaterials_id }}">
                                                    <td class="width_1_p">
                                                        <p class="set_sn"></p>
                                                    </td>
                                                    <td><input type="hidden" value="{{ $value->rmaterials_id }}"
                                                            name="rm_id[]">
                                                        <span>{{ getRMName($value->rmaterials_id) }}</span>
                                                    </td>
                                                    <td class="text-end"><a
                                                            class="btn btn-xs del_row dlt_button"><iconify-icon
                                                                icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h4 class="">@lang('index.manufacture_stages')</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('index.manufacture_stages')</label>
                                <select tabindex="4"
                                    class="form-control @error('productionstage') is-invalid @enderror select2 select2-hidden-accessible"
                                    name="productionstage" id="productionstage">
                                    <option value="">@lang('index.select')</option>
                                    @foreach ($productionstage as $ps)
                                        <option value="{{ $ps->id . '|' . $ps->name }}">{{ $ps->name }}</option>
                                    @endforeach
                                </select>

                                @error('productionstage')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive" id="purchase_cart">
                                <table class="table" id="drageable">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th class="width_1_p text-start">@lang('index.sn')</th>
                                            <th class="width_20_p stage_header text-left">
                                                @lang('index.stage')</th>
                                            <th class="width_20_p stage_header">@lang('index.required_time')</th>
                                            <th class="width_1_p ir_txt_center">@lang('index.actions')</th>
                                        </tr>
                                    </thead>
                                    <tbody class="add_tr2 sort_menu">

                                        @if (isset($fp_productionstages) && $fp_productionstages)
                                            @php
                                                $total_month = 0;
                                                $total_hour = 0;
                                                $total_day = 0;
                                                $total_mimute = 0;
                                            @endphp
                                            @foreach ($fp_productionstages as $key => $value)
                                                <?php                                               

                                                $total_value = $value->stage_month * 2592000 + $value->stage_day * 86400 + $value->stage_hours * 3600 + $value->stage_minute * 60;
                                                $months = floor($total_value / 2592000);
                                                $hours = floor(($total_value % 86400) / 3600);
                                                $days = floor(($total_value % 2592000) / 86400);
                                                $minuts = floor(($total_value % 3600) / 60);
                                                
                                                $total_month += $months;
                                                $total_hour += $hours;
                                                $total_day += $days;
                                                $total_mimute += $minuts;
                                                
                                                $total_stages = $total_month * 2592000 + $total_hour * 3600 + $total_day * 86400 + $total_mimute * 60;
                                                $total_months = floor($total_stages / 2592000);
                                                $total_hours = floor(($total_stages % 86400) / 3600);
                                                $total_days = floor(($total_stages % 2592000) / 86400);
                                                $total_minutes = floor(($total_stages % 3600) / 60);
                                                
                                                ?>
                                                <tr class="rowCount2 align-middle ui-state-default" data-id="{{ $value->productionstage_id }}">
                                                <td><span class="handle me-2"><iconify-icon icon="radix-icons:move"></iconify-icon></span></td>
                                                    <td class="width_1_p">
                                                        <p class="set_sn2 m-0"></p>
                                                    </td>
                                                    <td class="stage_name text-left"><input type="hidden"
                                                            value="{{ $value->productionstage_id }}"
                                                            name="producstage_id[]">
                                                        <span>{{ getProductionStages($value->productionstage_id) }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            {{-- <div class="col-md-3">
                                                                <div class="input-group"><input
                                                                        class="form-control @error('title') is-invalid @enderror stage_aligning"
                                                                        type="text" id="month_limit"
                                                                        name="stage_month[]" min="0"
                                                                        max="02" value="{{ $value->stage_month }}"
                                                                        placeholder="Month"><span
                                                                        class="input-group-text">@lang('index.months')</span>
                                                                </div>
                                                            </div> --}}

                                                            {{-- <div class="col-md-3">
                                                                <div class="input-group"><input
                                                                        class="form-control @error('title') is-invalid @enderror stage_aligning"
                                                                        type="text" id="day_limit" name="stage_day[]"
                                                                        min="0" max="31"
                                                                        value="{{ $value->stage_day }}"
                                                                        placeholder="Days"><span
                                                                        class="input-group-text">@lang('index.days')</span>
                                                                </div>
                                                            </div> --}}

                                                            <div class="col-md-6">
                                                                <div class="input-group"><input
                                                                        class="form-control @error('title') is-invalid @enderror stage_aligning"
                                                                        type="text" id="hours_limit"
                                                                        name="stage_hours[]" min="0"
                                                                        max="24" value="{{ $value->stage_hours }}"
                                                                        placeholder="Hours"><span
                                                                        class="input-group-text">@lang('index.hours')</span>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="input-group"><input
                                                                        class="form-control @error('title') is-invalid @enderror stage_aligning"
                                                                        type="text" id="minute_limit"
                                                                        name="stage_minute[]" min="0"
                                                                        max="60" value="{{ $value->stage_minute }}"
                                                                        placeholder="Minutes"><span
                                                                        class="input-group-text">@lang('index.minutes')</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="ir_txt_center"><a
                                                            class="btn btn-xs del_row dlt_button"><iconify-icon
                                                                icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tr class="align-middle">
                                        <td></td>
                                        <td class="width_1_p"></td>
                                        <td class="width_1_p">@lang('index.total')</td>
                                        <td class="width_20_p stage_header">
                                            <div class="row">
                                                {{-- <div class="col-md-3">
                                                    <div class="input-group">
                                                        <input
                                                            class="form-control @error('title') is-invalid @enderror stage_aligning stage_color"
                                                            readonly type="text" id="t_month"
                                                            value="{{ isset($total_months) && $total_months ? $total_months : '' }}"
                                                            placeholder="Months">
                                                        <span class="input-group-text">@lang('index.months')</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group">
                                                        <input
                                                            class="form-control @error('title') is-invalid @enderror stage_aligning stage_color"
                                                            readonly type="text" id="t_day"
                                                            value="{{ isset($total_days) && $total_days ? $total_days : '' }}"
                                                            placeholder="Days">
                                                        <span class="input-group-text">@lang('index.days')</span>
                                                    </div>
                                                </div> --}}
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <input
                                                            class="form-control @error('title') is-invalid @enderror stage_aligning stage_color"
                                                            readonly type="text" id="t_hours"
                                                            value="{{ isset($total_hours) && $total_hours ? $total_hours : '' }}"
                                                            placeholder="Hours">
                                                        <span class="input-group-text">@lang('index.hours')</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <input
                                                            class="form-control @error('title') is-invalid @enderror stage_aligning stage_color"
                                                            readonly type="text" id="t_minute"
                                                            value="{{ isset($total_minutes) && $total_minutes ? $total_minutes : '' }}"
                                                            placeholder="Minutes">
                                                        <span class="input-group-text">@lang('index.minutes')</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="width_1_p ir_txt_center"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="row mt-2">
                    <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
                        <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><iconify-icon
                                icon="solar:check-circle-broken"></iconify-icon>@lang('index.submit')</button>
                        <a class="btn bg-second-btn" href="{{ route('finishedproducts.index') }}"><iconify-icon
                                icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script type="text/javascript" src="{!!  $baseURL . 'assets/bower_components/jquery-ui/jquery-ui.min.js'  !!}"></script>
    <script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/addFinishedProduct.js?v=1.2' !!}"></script>
@endsection
