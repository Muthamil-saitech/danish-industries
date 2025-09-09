@extends('layouts.app')
@section('script_top')
@endsection
@section('content')
<section class="main-content-wrapper">
    <section class="content-header">
        <h3 class="top-left-header">
            {{isset($title) && $title ? $title : ''}}
        </h3>
    </section>
    <div class="box-wrapper">
        <div class="table-box">
            <!-- form start -->
            {!! Form::model(isset($obj) && $obj ? $obj : '', ['method' => isset($obj) && $obj?'PATCH':'POST','route' => ['tools.update', isset($obj->id) && $obj->id?$obj->id:'']]) !!}
            @csrf
            <div>
                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-6">
                        <div class="form-group">
                            <label for="tool_name" class="col-form-label">@lang('index.tools_name') <span class="required_star">*</span></label>
                            <input type="text" name="tool_name" id="tool_name" class="form-control @error('tool_name') is-invalid @enderror" placeholder="@lang('index.tools_name')" value="{{ isset($obj->tool_name) ? $obj->tool_name : old('tool_name') }}">
                            @error('tool_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
                        <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><iconify-icon icon="solar:check-circle-broken"></iconify-icon>@lang('index.submit')</button>
                        <a class="btn bg-second-btn" href="{{ route('tools.index') }}"><iconify-icon icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</section>
@endsection