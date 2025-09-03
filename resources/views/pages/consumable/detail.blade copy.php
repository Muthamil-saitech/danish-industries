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
                                {{-- @if (isset($productionScheduling) && $productionScheduling) --}}
                                    <?php //$k = 1; ?>
                                    {{-- @foreach ($productionScheduling as $key => $value) --}}
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100 border shadow position-relative">
                                                <a class="position-absolute top-0 end-0 m-2 button-success" id="stockAdjBtn" data-bs-toggle="modal" data-bs-target="#consumableModal" title="Edit"><i class="fa fa-edit tiny-icon"></i></a>
                                                {{-- <a href="#" class="position-absolute top-0 end-0 m-2 button-success" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.edit')" data-bs-target="#consumableModal" ><i class="fa fa-edit tiny-icon"></i></a> --}}
                                                <div class="card-body">
                                                    <p class="mb-1"><strong>@lang('index.ppcrc_no'):</strong> {{ isset($manufacture) ? $manufacture->reference_no : '' }}</p>
                                                    <p class="mb-1"><strong>@lang('index.production_stage'):</strong> <span class="badge bg-warning text-dark">Grinding</span></p>
                                                    <p class="mb-1"><strong>@lang('index.employees'):</strong> Kannan (EMP-001)</p>
                                                    <p class="mb-1"><strong>@lang('index.material_name') (Code):</strong> Tap (MATT001)</p>
                                                    <p class="mb-1"><strong>@lang('index.quantity'):</strong> 20</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100 border shadow position-relative">
                                                <a class="position-absolute top-0 end-0 m-2 button-success" id="stockAdjBtn" data-bs-toggle="modal" data-bs-target="#consumableModal" title="Edit"><i class="fa fa-edit tiny-icon"></i></a>
                                                <div class="card-body">
                                                    <p class="mb-1"><strong>@lang('index.ppcrc_no'):</strong> {{ isset($manufacture) ? $manufacture->reference_no : '' }}</p>
                                                    {{-- <p class="mb-1"><strong>@lang('index.production_stage'):</strong> <span class="badge bg-warning text-dark">Slotting</span></p> --}}
                                                    <p class="mb-1"><strong>@lang('index.employees'):</strong> Kumar (EMP-002)</p>
                                                    <p class="mb-1"><strong>@lang('index.material_name') (Code):</strong> Box (MATT002)</p>
                                                    <p class="mb-1"><strong>@lang('index.quantity'):</strong> 100</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100 border shadow position-relative">
                                                <a class="position-absolute top-0 end-0 m-2 button-success" id="stockAdjBtn" data-bs-toggle="modal" data-bs-target="#consumableModal" title="Edit"><i class="fa fa-edit tiny-icon"></i></a>
                                                <div class="card-body">
                                                    <p class="mb-1"><strong>@lang('index.ppcrc_no'):</strong> {{ isset($manufacture) ? $manufacture->reference_no : '' }}</p>
                                                    <p class="mb-1"><strong>@lang('index.production_stage'):</strong> <span class="badge bg-warning text-dark">Cutting</span></p>
                                                    <p class="mb-1"><strong>@lang('index.employees'):</strong> Kannan (EMP-001)</p>
                                                    <p class="mb-1"><strong>@lang('index.material_name') (Code):</strong> Rubber (MAT003)</p>
                                                    <p class="mb-1"><strong>@lang('index.quantity'):</strong> 10</p>
                                                </div>
                                            </div>
                                        </div>
                                    {{-- @endforeach --}}
                                {{-- @else --}}
                                    {{-- <div class="col-12">
                                        <p class="text-muted">@lang('No data available.')</p>
                                    </div> --}}
                                {{-- @endif --}}
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
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-sm-12 mb-2 col-md-6">
                                    <div class="form-group">
                                        <label>@lang('index.production_stage') </label>
                                        <select name="production_stage" id="production_stage" class="form-control @error('production_stage') is-invalid @enderror select2">
                                            <option value="">@lang('index.select')</option>
                                            @foreach ($m_stages as $stage)
                                                <option value="{{ $stage->productionstage_id }}">{{ getProductionStages($stage->productionstage_id) }}</option>
                                            @endforeach
                                        </select>
                                        @error('production_stage')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-2 col-md-6">
                                    <div class="form-group">
                                        <label>@lang('index.employees') <span class="required_star">*</span></label>
                                        <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror select2">
                                            <option value="">@lang('index.select')</option>
                                            {{-- @foreach ($employees as $emp)
                                                <option value="{{ $emp->id }}">{{ getEmpCode($emp->id) }}</option>
                                            @endforeach --}}
                                        </select>
                                        @error('user_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-2 col-md-6">
                                    <div class="form-group">
                                        <label>@lang('index.material_name') (Code) <span class="required_star">*</span></label>
                                        <select name="mat_id" id="mat_id" class="form-control @error('mat_id') is-invalid @enderror select2">
                                            <option value="">@lang('index.select')</option>
                                            @foreach ($consumable_materials as $material)
                                                <option value="{{ $material->id }}">{{ getRMName($material->id) }}</option>
                                            @endforeach
                                        </select>
                                        @error('mat_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-2 col-md-6">
                                    <div class="form-group">
                                        <label>@lang('index.quantity') </label>
                                        <input type="text" name="qty" id="qty" class="form-control @error('qty') is-invalid @enderror" placeholder="@lang('index.quantity')">
                                        @error('qty')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-blue-btn stock_adjust_btn"><iconify-icon icon="solar:check-circle-broken"></iconify-icon>
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
    $('#production_stage').select2({
        dropdownParent: $('#consumableModal')
    });
    $('#user_id').select2({
        dropdownParent: $('#consumableModal')
    });
    $('#mat_id').select2({
        dropdownParent: $('#consumableModal')
    });
    </script>
@endsection