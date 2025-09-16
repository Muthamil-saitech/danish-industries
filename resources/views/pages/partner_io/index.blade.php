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
                <input type="hidden" class="datatable_name"  data-title="{{ isset($title) && $title ? $title : '' }}" data-id_name="datatable">
            </div>
            <div class="col-md-6 text-end">
                <h5 class="mb-0">Total Partner I/O:  {{ $total_partner_ios }}</h5>
            </div>
        </div>
    </section>
    <div class="box-wrapper">
        <div class="table-box">
            <!-- /.box-header -->
            <div class="table-responsive">
                <table id="datatable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>@lang('index.sn')</th>
                            <th>@lang('index.reference_no')</th>
                            <th>@lang('index.partners')(Code)</th>
                            <th>@lang('index.date')</th>
                            <th>@lang('index.type')</th>
                            <th>@lang('index.category')</th>
                            <th>@lang('index.instrument_name')(Code)</th>
                            <th>@lang('index.quantity')</th>
                            <th>@lang('index.status')</th>
                            <th>@lang('index.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($obj && !empty($obj))
                        <?php
                        $i = count($obj); $j = 1;
                        ?>
                        @endif
                        @foreach ($obj as $value)
                            @foreach ($value->details as $detail)
                            <tr>
                                <td>{{ $j++ }}</td>
                                <td>{{ $value->reference_no .'/'. $detail->line_item_no }}</td>
                                <td>{{ $value->partner->name . '(' . $value->partner->partner_id . ')' }}</td>
                                <td>{{  date('d-m-Y', strtotime($value->io_date)) }}</td>
                                @if($detail->type == '1')
                                    <td>Gauges/Checking Instruments</td>
                                @else
                                    <td>Measuring Instruments</td>
                                @endif
                                @php 
                                    $ins_category = \App\InstrumentCategory::where('id',$detail->ins_category)->first();
                                    $instrument = \App\Instrument::where('id',$detail->ins_name)->first();
                                @endphp
                                <td>{{ $ins_category->category }}</td>
                                <td>{{ $instrument->instrument_name }}</td>
                                <td>{{ $detail->qty ?? '-' }}</td>
                                <td>
                                    @if($detail->status == 'Inward')
                                    <span class="badge bg-secondary">Inward</span>
                                    @else
                                    <span class="badge bg-success">Outward</span>
                                    @endif
                                </td>
                                <td>
                                    @if($detail->status == 'Inward')
                                        <a href="#" class="button-warning open-calendar" data-id="{{ $detail->id }}"  
                                            data-bs-toggle="modal" data-bs-target="#calendarModal">
                                            <i class="fa fa-calendar tiny-icon"></i>
                                        </a>
                                    @endif
                                    <a href="{{ url('partner_io') }}/{{ encrypt_decrypt($detail->id, 'encrypt') }}"
                                        class="button-info" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="@lang('index.view_details')"><i class="fa fa-eye tiny-icon"></i></a>
                                    <a href="{{ url('partner_io') }}/{{ encrypt_decrypt($detail->id, 'encrypt') }}/edit"
                                        class="button-success" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="@lang('index.edit')"><i class="fa fa-edit tiny-icon"></i></a>
                                    <a href="#" class="delete button-danger"
                                        data-form_class="alertDelete1" type="submit"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.delete')">
                                        <form action="{{ route('partner_io.destroy', $detail->id) }}"
                                            class="alertDelete1" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <i class="fa fa-trash tiny-icon"></i>
                                        </form>
                                    </a>
                                </td>
                            </tr>
                            @endforeach 
                        @endforeach
                    </tbody>
                </table>
            </div>
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
                    'route' => ['partner_io.inward_to_outward'],
                    ]) !!}
                    @csrf
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-sm-10 mb-3">
                            <div class="form-group">
                                <input type="hidden" name="partner_io_id" id="partner_io_id" value="">
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
                                <textarea name="notes" id="notes" class="form-control" placeholder="@lang('index.notes')"></textarea>
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
        let partnerIoId = $(this).data("id"); 
        $("#partner_io_id").val(partnerIoId); 
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