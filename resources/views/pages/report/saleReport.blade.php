@extends('layouts.app')
@section('content')
    <?php
    $baseURL = getBaseURL();
    $setting = getSettingsInfo();
    $base_color = '#6ab04c';
    if (isset($setting->base_color) && $setting->base_color) {
        $base_color = $setting->base_color;
    }
    ?>
    <section class="main-content-wrapper">
        @include('utilities.messages')
        <section class="content-header">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="top-left-header">{{ isset($title) && $title ? $title : '' }}</h2>
                    <input type="hidden" class="datatable_name" data-filter="yes" data-title="{{ isset($title) && $title ? $title : '' }}"
                        data-id_name="datatable">
                </div>
                <div class="col-md-2">
                </div>
            </div>
        </section>
        @if($startDate != '' || $endDate != '')
        <div class="my-2">
            <h4 class="ir_txtCenter_mt0">
                Date:
                {{($startDate != '') ? date('d-m-Y',strtotime($startDate)):''}}
                {{($endDate != '') ? ' - '.date('d-m-Y',strtotime($endDate)):''}}
            </h4>
        </div>
        @endif
        <div class="box-wrapper">
            <div class="table-box">
                <!-- /.box-header -->
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="width_1_p">@lang('index.sn')</th>
                                <th class="width_10_p">@lang('index.sale_date')</th>
                                <th class="width_10_p">@lang('index.invoice_no')</th>
                                <th class="width_10_p">@lang('index.challan_no')</th>
                                <th class="width_10_p">Customer Name (Code)</th>
                                <th class="width_10_p">@lang('index.total_amount')</th>
                                <th class="width_10_p">@lang('index.paid_amount')</th>
                                <th class="width_10_p">@lang('index.due_amount')</th>
                                <th class="width_10_p">@lang('index.status')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($obj && !empty($obj))
                                <?php
                                $i = 1;
                                ?>
                            @endif
                            @foreach ($obj as $value)
                                <tr>
                                    <td class="c_center">{{ $i++ }}</td>
                                    <td>{{ getDateFormat($value->sale_date) }}</td>
                                    <td>{{ $value->reference_no }}</td>
                                    <td>{{ $value->challan_no }}</td>
                                    <td>{{ getCustomerNameById($value->customer_id) }} ({{ getCustomerCodeById($value->customer_id) }})</td>
                                    <td>{{ getAmtCustom($value->grand_total) }}</td>
                                    <td>{{ getAmtCustom($value->pay) }}</td>
                                    <td>{{ getAmtCustom($value->bal) }}</td>
                                    {{-- <td>{{ getCurrency($value->discount) }}</td> --}}
                                    <td><h6>@if($value->receive_status=="Paid") <span class="badge bg-success">Paid</span> @elseif($value->receive_status=="Initiated") <span class="badge bg-danger">Initiated</span> @else <span class="badge bg-info">Partially Paid</span>@endif</h6></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="modal fade" id="filterModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">@lang('index.inspect_list')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        {!! Form::model('', [
                            'id' => 'sale_report',
                            'method' => 'GET',
                            'enctype' => 'multipart/form-data',
                            'route' => ['report.sales'],
                        ]) !!}
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="form-group">
                                    {!! Form::text('startDate', (isset($startDate)&&$startDate!='') ? date('d-m-Y',strtotime($startDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"Start Date", 'id' => 'sale_start_date']) !!}
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="form-group">
                                    {!! Form::text('endDate', (isset($endDate)&&$endDate!='') ? date('d-m-Y',strtotime($endDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"End Date", 'id' => 'sale_complete_date']) !!}
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="form-group">
                                    <label>@lang('index.customer') </label>
                                    <select name="customer_id" id="customer_id" class="form-control select2">
                                        <option value="">@lang('index.select')</option>
                                        @if(isset($customer_id))
                                            @foreach ($customers as $key => $value)
                                                <option value="{{ $value->id }}"
                                                    {{ isset($customer_id) && $customer_id == $value->id ? 'selected' : '' }}>
                                                    {{ $value->name }} ({{ $value->customer_id }})</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mt-3">
                                <button type="submit" name="submit" value="submit"
                                    class="btn w-100 bg-blue-btn">@lang('index.submit')</button>
                            </div>
                            <div class="col-md-4 mt-3">
                                <a href="{{ route('report.sales') }}" style="text-decoration: none;color:white;"><button type="button" value="reset" class="btn bg-second-btn w-100">Reset</button></a>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="{!! $baseURL . 'assets/datatable_custom/jquery-3.3.1.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/jquery.dataTables.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/dataTables.bootstrap4.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/dataTables.buttons.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/buttons.html5.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/buttons.print.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/jszip.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/pdfmake.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/vfs_fonts.js' !!}"></script>
    <script src="{!! $baseURL . 'frequent_changing/newDesign/js/forTable.js' !!}"></script>
    <script src="{!! $baseURL . 'frequent_changing/js/custom_report.js' !!}"></script>
    <script src="{!! $baseURL . 'frequent_changing/js/sales.js' !!}"></script>
    <script>
        function parseDMYtoDate(dmy) {
            const [day, month, year] = dmy.split('-');
            return new Date(`${year}-${month}-${day}`);
        }
        $('#sale_start_date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        }).on('changeDate', function (e) {
            const startDate = e.date;
            $('#sale_complete_date').datepicker('setStartDate', startDate);
            const completeDateVal = $('#sale_complete_date').val();
            if (completeDateVal) {
                const completeDate = parseDMYtoDate(completeDateVal);
                if (completeDate < startDate) {
                    $('#sale_complete_date').datepicker('update', startDate);
                }
            }
        });
        $('#sale_complete_date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        }).on('changeDate', function (e) {
            const completeDate = e.date;
            const startDateVal = $('#sale_start_date').val();
            if (startDateVal) {
                const startDate = parseDMYtoDate(startDateVal);
                if (completeDate < startDate) {
                    $('#sale_complete_date').datepicker('update', startDate);
                }
            }
        });
        $("#customer_id").select2({
            dropdownParent: $("#filterModal"),
        });
    </script>
@endsection
