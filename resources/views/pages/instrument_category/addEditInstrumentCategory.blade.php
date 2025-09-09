@extends('layouts.app')
@section('script_top')
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
                    'route' => ['instrument_category.update', isset($obj->id) && $obj->id ? $obj->id : ''],
                ]) !!}
                @csrf
                <div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-6">
                        <div class="form-group">
                            <label>@lang('index.type') <span class="required_star">*</span></label>
                            <select class="form-control @error('type') is-invalid @enderror select2" name="type"
                                id="type">
                                <option value="">@lang('index.select')</option>
                                <option {{ (isset($obj->type) && $obj->type == 1) || old('type') == 1 ? 'selected' : '' }} value="1">@lang('index.gauges/checkinginstruments')</option>
                                <option {{ (isset($obj->type) && $obj->type == 2) || old('type') == 2 ? 'selected' : '' }} value="2">@lang('index.measuringinstruments')</option>
                            </select>
                            @error('type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                        <div class="col-sm-12 mb-2 col-md-6">
                            <div class="form-group">
                                <label>@lang('index.instrument_category') <span class="required_star">*</span></label>
                                <input type="text" name="category" id="category" class="form-control @error('category') is-invalid @enderror" placeholder="@lang('index.instrument_category')" value="{{ isset($obj) && $obj->category ? $obj->category : old('category') }}">
                                @error('category')
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
                        <a class="btn bg-second-btn" href="{{ route('instrument_category.index') }}"><iconify-icon icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection

@section('script_bottom')
@endsection
