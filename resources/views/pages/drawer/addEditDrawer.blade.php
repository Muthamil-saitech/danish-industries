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
                                @error('drawer_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-6">
                            <div class="form-group">
                                <label>@lang('index.revision_no') <span class="required_star">*</span></label>
                                <input type="text" name="revision_no" id="revision_no" class="form-control @error('revision_no') is-invalid @enderror" placeholder="Revision No" value="{{ isset($obj) && $obj->revision_no ? $obj->revision_no : old('revision_no') }}">
                                @error('revision_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-6">
                            <div class="form-group">
                                <label>@lang('index.revision_date') <span class="required_star">*</span></label>
                                {!! Form::text('revision_date', isset($obj->revision_date) && $obj->revision_date ? date('d-m-Y',strtotime($obj->revision_date)) : (old('revision_date') ?: ''), [
                                    'class' => 'form-control revision_date',
                                    'placeholder' => 'Revision Date',
                                ]) !!}
                                @error('revision_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-6">
                            <div class="form-group">
                                <label>@lang('index.drawer_loc') <span class="required_star">*</span></label>
                                <input type="text" name="drawer_loc" id="drawer_loc" class="form-control @error('drawer_loc') is-invalid @enderror" placeholder="@lang('index.drawer_loc')" value="{{ isset($obj) && $obj->drawer_loc ? $obj->drawer_loc : old('drawer_loc') }}">
                                @error('drawer_loc')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-6">
                            <div class="form-group">
                                <label>@lang('index.program_code') <span class="required_star">*</span></label>
                                <input type="text" name="program_code" id="program_code" class="form-control @error('program_code') is-invalid @enderror" placeholder="Program Code" value="{{ isset($obj) && $obj->program_code ? $obj->program_code : old('program_code') }}">
                                @error('program_code')
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
                                <label>Tools/Gauges List</label>
                                <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" placeholder="Tools/Gauges List" rows="3">{{ isset($obj->notes) && $obj->notes ? $obj->notes : old('notes') }}</textarea>
                                @error('notes')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
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
