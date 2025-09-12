@extends('layouts.app')

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
                    'route' => ['rawmaterials.update', isset($obj->id) && $obj->id ? $obj->id : ''],
                ]) !!}
                @csrf
                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label>@lang('index.mat_type') <span class="required_star">*</span></label>
                            <select class="form-control @error('mat_type_id') is-invalid @enderror select2" name="mat_type_id" id="mat_type_id">
                                <option value="">@lang('index.select')</option>
                                @foreach ($material_types as $value)
                                    <option
                                        {{ (isset($obj->mat_type_id) && $obj->mat_type_id == $value->id) || old('mat_type_id') == $value->id ? 'selected' : '' }}
                                        value="{{ $value->id }}">{{ $value->type_name }}</option>
                                @endforeach
                            </select>
                            @error('mat_type_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label>@lang('index.material_category') <span class="required_star">*</span></label>
                            <select class="form-control @error('category') is-invalid @enderror select2" name="category"
                                id="category">
                                <option value="">@lang('index.select')</option>
                                @foreach ($categories as $value)
                                    <option
                                        {{ (isset($obj->category) && $obj->category == $value->id) || old('category') == $value->id ? 'selected' : '' }}
                                        value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label>@lang('index.material_code') <span class="required_star">*</span></label>
                            <input type="text" name="code" id="code"
                                class="form-control @error('code') is-invalid @enderror" placeholder="@lang('index.material_code')"
                                value="{{ isset($obj->code) ? $obj->code : old('code') }}" onfocus="select()">
                            @error('code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label>@lang('index.raw_material_name') <span class="required_star">*</span></label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" placeholder="@lang('index.raw_material_name')"
                                value="{{ isset($obj->name) ? $obj->name : old('name') }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="col-sm-12 mb-2 col-md-4" id="insert_type_div" style="{{ isset($obj->category) && $obj->category == 1 || old('category') == 1 ? '' : 'display:none;' }}">
                        <div class="form-group">
                            <label>@lang('index.ins_type') <span class="required_star">*</span></label>
                            <select class="form-control @error('insert_type') is-invalid @enderror select2" name="insert_type" id="insert_type">
                                <option value="">@lang('index.select')</option>
                                <option {{ (isset($obj->insert_type) && $obj->insert_type == 1) || old('insert_type') == 1 ? 'selected' : '' }} value="1">Consumable</option>
                                <option {{ (isset($obj->insert_type) && $obj->insert_type == 2) || old('insert_type') == 2 ? 'selected' : '' }} value="2">Non Consumable</option>
                            </select>
                            <div class="text-danger d-none"></div>
                            @error('insert_type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label>@lang('index.diameter') </label>
                            <input type="text" name="diameter" id="diameter"
                                class="form-control @error('diameter') is-invalid @enderror" placeholder="@lang('index.diameter')" value="{{ isset($obj->diameter) ? $obj->diameter : old('diameter') }}">
                            @error('diameter')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label>@lang('index.heat_no') </label>
                            <input type="text" name="heat_no" id="heat_no"
                                class="form-control @error('heat_no') is-invalid @enderror" placeholder="@lang('index.heat_no')"
                                value="{{ isset($obj->heat_no) ? $obj->heat_no : old('heat_no') }}">
                            @error('heat_no')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label>Old Material No </label>
                            <input type="text" name="old_mat_no" id="old_mat_no"
                                class="form-control @error('old_mat_no') is-invalid @enderror" placeholder="Old Material No"
                                value="{{ isset($obj->old_mat_no) ? $obj->old_mat_no : old('old_mat_no') }}">
                            @error('old_mat_no')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label>@lang('index.description') <span class="required_star">*</span></label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="{{ __('index.description') }}" rows="3">{{ isset($obj) && $obj->description ? $obj->description : old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label>@lang('index.remarks')</label>
                            <textarea name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror" placeholder="{{ __('index.remarks') }}" rows="3">{{ isset($obj) && $obj->remarks ? $obj->remarks : old('remarks') }}</textarea>
                            @error('remarks')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
                        <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><iconify-icon
                                icon="solar:check-circle-broken"></iconify-icon>@lang('index.submit')</button>
                        <a class="btn bg-second-btn" href="{{ route('rawmaterials.index') }}"><iconify-icon
                                icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
                    </div>
                </div>
                <!-- /.box-body -->
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection
@section('script')
    <?php
    $baseURL = getBaseURL();
    ?>
    <script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/addRawMaterial.js' !!}"></script>    
@endsection
