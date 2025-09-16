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
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="top-left-header">{{ isset($title) && $title ? $title : '' }}</h2>
                <input type="hidden" class="datatable_name" data-title="{{ isset($title) && $title ? $title : '' }}" data-id_name="datatable">
            </div>
            <div class="col-md-6 text-end">
                <h5 class="mb-0">Total Customer I/O: {{ $total_customer_ios }}</h5>
            </div>
        </div>
    </section>
    <div class="box-wrapper">
        <div class="table-box">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>@lang('index.sn')</th>
                            <th>@lang('index.po_no')</th>
                            <th>@lang('index.customer')(Code)</th>
                            <th>@lang('index.date')</th>
                            <th>@lang('index.status')</th>
                            <th>@lang('index.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($obj && !empty($obj))
                        <?php
                        $i = count($obj);
                        ?>
                        @endif
                         @foreach ($obj as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td> 
                                <td>{{ $value->po_no .'/'. $value->line_item_no }}</td>
                                <td>{{ $value->customer->name }}<br> ({{ $value->customer->customer_id }})</td>
                                <td>{{  date('d-m-Y', strtotime($value->date)) }}</td>
                                <td>
                                    @if($value->status == 'Inward')
                                    <span class="badge bg-secondary">Inward</span>
                                    @else
                                    <span class="badge bg-success">Outward</span>
                                    @endif
                                </td>
                                <td>
                                    @if($value->status == 'Inward')
                                        <a href="#" class="button-warning open-calendar" data-id="{{ $value->id }}"  
                                            data-bs-toggle="modal" data-bs-target="#calendarModal">
                                            <i class="fa fa-calendar tiny-icon"></i>
                                        </a>
                                    @endif
                                    <a href="{{ url('customer_io') }}/{{ encrypt_decrypt($value->id, 'encrypt') }}"
                                        class="button-info" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="@lang('index.view_details')"><i class="fa fa-eye tiny-icon"></i></a>
                                    <a href="{{ url('customer_io') }}/{{ encrypt_decrypt($value->id, 'encrypt') }}/edit"
                                        class="button-success" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="@lang('index.edit')"><i class="fa fa-edit tiny-icon"></i></a>
                                    <a href="#" class="delete button-danger"
                                        data-form_class="alertDelete1" type="submit"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.delete')">
                                        <form action="{{ route('customer_io.destroy', $value->id) }}"
                                            class="alertDelete1" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <i class="fa fa-trash tiny-icon"></i>
                                        </form>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>

    </div>
    <div class="modal fade" id="calendarModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('index.calendar')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::model('', [
                    'id' => 'add_form',
                    'method' => 'POST',
                    'route' => ['customer_io.inward_to_outward'],
                    ]) !!}
                    @csrf
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-sm-10 mb-3">
                            <div class="form-group">
                                <input type="hidden" name="customer_io_id" id="customer_io_id" value="">
                                <label>@lang('index.date') <span class="required_star">*</span></label>
                                {!! Form::text('inward_date', null, [
                                    'class' => 'form-control',
                                    'id' => 'inward_date',
                                    'placeholder' => 'Date',
                                ]) !!}
                                @if ($errors->has('inward_date'))
                                <div class="error_alert text-danger">
                                    {{ $errors->first('inward_date') }}
                                </div>
                                @endif
                                <div class="text-danger" id="inward_date_error"></div>
                            </div>
                        </div>
                        <div class="col-sm-10 mb-3">
                            <div class="form-group">
                                <label>@lang('index.notes') </label>
                                <textarea name="notes" class="form-control" id="notes" placeholder="@lang('index.notes')"></textarea>
                                @if ($errors->has('notes'))
                                    <div class="error_alert text-danger">
                                        {{ $errors->first('notes') }}
                                    </div>
                                @endif
                                <div class="text-danger" id="notes_error"></div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <button type="submit" name="submit" value="submit"
                                class="btn w-100 bg-blue-btn">@lang('index.submit')</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="modal fade" id="filterModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('index.customer_order')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::model('', [
                    'id' => 'add_form',
                    'method' => 'GET',
                    'enctype' => 'multipart/form-data',
                    'route' => ['customer_io.index'],
                    ]) !!}
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                {!! Form::text('startDate', (isset($startDate)&&$startDate!='') ? date('d-m-Y',strtotime($startDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"Start Date", 'id' => 'order_start_date']) !!}
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                {!! Form::text('endDate', (isset($endDate)&&$endDate!='') ? date('d-m-Y',strtotime($endDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"End Date", 'id' => 'order_complete_date']) !!}
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.customer') </label>
                                <select name="customer_id" id="fil_customer_id" class="form-control select2">
                                    <option value="">@lang('index.select')</option>
                                    @if(isset($customer_id))
                                    @foreach ($customers as $key => $value)
                                    <option value="{{ $value->id }}"
                                        {{ isset($customer_id) && $customer_id == $value->id ? 'selected' : '' }}>
                                        {{ $value->name }} ({{ $value->customer_id }})
                                    </option>
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
                            <a href="{{ route('customer_io.index') }}" style="text-decoration: none;color:white;"><button type="button" value="reset" class="btn bg-second-btn w-100">Reset</button></a>
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
<script src="{!! $baseURL . 'frequent_changing/js/order.js' !!}"></script>
<script>
    $("#fil_customer_id").select2({
        dropdownParent: $("#filterModal"),
    });
    $(document).on("click", ".open-calendar", function () {
        let customerIoId = $(this).data("id"); 
        $("#customer_io_id").val(customerIoId); 
    });
    $(document).on("submit", "#add_form", function (e) {
        e.preventDefault(); 
        let form = $(this);
        let actionUrl = form.attr("action"); 
        let formData = form.serialize(); 
        let inwardDate = $('#inward_date').val().trim(); 
        let notes = $('#notes').val() ? $('#notes').val().trim() : '';
        
        let isValid = true;
        $('#inward_date_error').text('');
        $('#notes_error').text('');
        
        if (!inwardDate) {
            $('#inward_date_error').text('The date field is required.');
            isValid = false;
        }
        if (notes.length > 255) {
            $('#notes_error').text('The notes cannot exceed 255 characters.');
            isValid = false;
        }
        if (isValid) {
            $.ajax({
                url: actionUrl,
                type: "POST",
                data: formData,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function (response) {
                    if (response.success) {
                        let modalEl = document.getElementById('calendarModal');
                        let modal = bootstrap.Modal.getInstance(modalEl);
                        modal.hide(); 
                        location.reload();
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    alert("Something went wrong. Please try again.");
                }
            });
        }
    });
    $('#calendarModal').on('hide.bs.modal', function () {
        $('#inward_date_error').text('');
    });
</script>
@endsection