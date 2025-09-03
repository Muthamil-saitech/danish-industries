@extends('layouts.app')
@section('content')
    @php
    $baseURL = getBaseURL();
    $setting = getSettingsInfo();
    $base_color = '#6ab04c';
    if (isset($setting->base_color) && $setting->base_color) {
        $base_color = $setting->base_color;
    }
    @endphp

    <!-- Main content -->
    <section class="main-content-wrapper">
        @include('utilities.messages')

        <section class="content-header">
            <h3 class="top-left-header">
                @lang('index.tax_settings')
            </h3>

        </section>

        <div class="box-wrapper">
            <div class="table-box">
                {!! Form::model(isset($tax_items) && $tax_items ? $tax_items : '', [
                    'method' => 'POST',
                    'id' => 'tax_update',
                    'route' => ['tax.update'],
                ]) !!}
                @csrf
                    <div>
                        <div class="row">
                            <div class="col-sm-3 mb-2 col-sm-3 col-md-2 tax_fields_form">
                                <div class="form-group radio_button_problem">
                                    <input type="hidden" name="tax_id" id="tax_id" class="form-control"/>
                                    <label>@lang('index.collect_tax') <span class="required_star">*</span></label>
                                    <div class="radio">
                                        <label>
                                            <input tabindex="1" type="radio" name="collect_tax" id="collect_tax_yes"
                                                value="Yes" @checked(old('collect_tax') === 'Yes')>@lang('index.yes')
                                        </label>
                                        <label>
                                            <input tabindex="2" type="radio" name="collect_tax" id="collect_tax_no"
                                                value="No" @checked(old('collect_tax') === 'No')>@lang('index.no')
                                        </label>
                                    </div>
                                </div>
                                @error('collect_tax')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2 tax_yes_section {{ (isset($tax_items) && $tax_items->collect_tax == 'Yes') ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <label>@lang('index.tax_type') <span class="required_star">*</span></label>
                                    <select name="tax_type" id="tax_type"
                                        class="form-control @error('tax_type') is-invalid @enderror select2"
                                        placeholder="{{ __('index.tax_type') }}">
                                        <option value="" selected>Select</option>
                                        <option value="Labor" @selected(old('tax_type') === 'Labor')>Labor</option>
                                        <option value="Sales" @selected(old('tax_type') === 'Sales')>Sales</option>
                                    </select>
                                    @error('tax_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2 tax_yes_section {{ (isset($tax_items) && $tax_items->collect_tax == 'Yes') ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <label>Tax Value (%)<span class="required_star">*</span></label>
                                    <input type="text" name="tax_value" id="tax_value" class="form-control" value="{{ old('tax_value') }}"/>
                                    @error('tax_value')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2 tax_yes_section {{ (isset($tax_items) && $tax_items->collect_tax == 'Yes') ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <label>CGST (%)<span class="required_star">*</span></label>
                                    <input type="text" onfocus="select()" name="cgst" id="cgst" class="form-control" disabled value="{{ old('cgst') }}"/>
                                </div>
                            </div>
                            <div class="col-md-2 tax_yes_section {{ (isset($tax_items) && $tax_items->collect_tax == 'Yes') ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <label>SGST (%)<span class="required_star">*</span></label>
                                    <input type="text" onfocus="select()"  name="sgst" id="sgst" class="form-control" disabled value="{{ old('sgst') }}"/>
                                </div>
                            </div>
                            <div class="col-md-2 tax_yes_section {{ (isset($tax_items) && $tax_items->collect_tax == 'Yes') ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <label>IGST (%)<span class="required_star">*</span></label>
                                    <input type="text" onfocus="select()"  name="igst" id="igst" class="form-control" disabled value="{{ old('igst') }}"/>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <div class="row py-2 tax_fields_form">
                        <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
                            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn" id="tax-submit" @if(!$errors->any()) disabled @endif ><iconify-icon
                                    icon="solar:check-circle-broken"></iconify-icon>@lang('index.submit')</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                    <h3 class="top-left-header">Tax List</h3>
                    <div class="table-box">
                        <!-- /.box-header -->
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="ir_w_1">SN</th>
                                        <th class="ir_w_1">Collect Tax</th>
                                        <th class="ir_w_25">Tax Type</th>
                                        <th class="ir_w_16">Tax Value(%)</th>
                                        <th class="ir_w_16">CGST(%)</th>
                                        <th class="ir_w_16">SGST(%)</th>
                                        <th class="ir_w_16">IGST(%)</th>
                                        <th class="ir_w_16">Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $groupedTaxes = $taxes->groupBy('tax_id');
                                        $i = 1;
                                    @endphp

                                    @foreach ($groupedTaxes as $tax_id => $taxGroup)
                                        @php
                                            $first = $taxGroup->first();
                                            $cgst = $taxGroup->firstWhere('tax', 'CGST')->tax_rate ?? '';
                                            $sgst = $taxGroup->firstWhere('tax', 'SGST')->tax_rate ?? '';
                                            $igst = $taxGroup->firstWhere('tax', 'IGST')->tax_rate ?? '';
                                        @endphp
                                        <tr>
                                            <td class="ir_txt_center">{{ $i++ }}</td>
                                            <td>{{ $first->collect_tax }}</td>
                                            <td>{{ $first->tax_type }}</td>
                                            <td>{{ $first->tax_value }}</td>
                                            <td>{{ $cgst }}</td>
                                            <td>{{ $sgst }}</td>
                                            <td>{{ $igst }}</td>
                                            <td>
                                                <a class="button-success" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.edit')" onclick="editTax({{ $first->id }})"><i class="fa fa-edit tiny-icon"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
    </section>
@endsection

@section('script')
    <script src="{!! $baseURL . 'frequent_changing/js/taxes.js' !!}"></script>
    <script>
        $(document).ready(function () {
            $('.tax_yes_section').addClass('d-none');
            $('.tax_fields_form').addClass('d-none');
            window.editTax = function(id) {
                $.ajax({
                    url: '{{ $baseURL }}editTax/' + id,
                    type: 'GET',
                    success: function(data) {
                        data = JSON.parse(data);
                        if (data.length > 0) {
                            const first = data[0];
                            console.log("first",first);
                            $('#tax_id').val(first.tax_id);
                            if (first.collect_tax === 'Yes') {
                                $('#collect_tax_yes').prop('checked', true);
                                $('.tax_yes_section').removeClass('d-none');
                                $('.tax_fields_form').removeClass('d-none');
                            } else if (first.collect_tax === 'No') {
                                $('#collect_tax_no').prop('checked', true);
                                $('.tax_yes_section').addClass('d-none');
                                $('.tax_fields_form').removeClass('d-none');
                            }
                            $('#tax_type').val(first.tax_type).trigger('change');
                            $('#tax_value').val(first.tax_value);
                            data.forEach(function(item) {
                                if (item.tax === 'CGST') {
                                    $('#cgst').val(item.tax_rate);
                                } else if (item.tax === 'SGST') {
                                    $('#sgst').val(item.tax_rate);
                                } else if (item.tax === 'IGST') {
                                    $('#igst').val(item.tax_rate);
                                }
                            });
                            $('#tax-submit').prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        alert('Could not fetch tax data.');
                    }
                });
            }
        });
    </script>
@endsection
