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
                <div class="col-md-6">
                    @if (routePermission('manufacture.print'))
                        <a href="javascript:void();" target="_blank" class="btn bg-second-btn print_invoice"
                            data-id="{{ $obj->id }}"><iconify-icon icon="solar:printer-broken"></iconify-icon>
                            @lang('index.print')</a>
                    @endif
                    <a href="{{ route('download_manufacture_details', encrypt_decrypt($obj->id, 'encrypt')) }}"
                        target="_blank" class="btn bg-second-btn print_btn"><iconify-icon
                            icon="solar:cloud-download-broken"></iconify-icon>
                        @lang('index.download')</a>
                    @if (routePermission('manufacture.index'))
                        <a class="btn bg-second-btn" href="{{ route('productions.index') }}"><iconify-icon
                                icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
                    @endif
                </div>
            </div>
        </section>
        <section class="content">
            <div class="col-md-12">
                <div class="card" id="dash_0">
                    <div class="card-body p30">
                        <div class="m-auto b-r-5">
                            <table>
                                <tr>
                                    <td class="w-50">
                                        <h3 class="pb-7">{{ getCompanyInfo()->company_name }}</h3>
                                        <p class="pb-7 rgb-71">{{ safe(getCompanyInfo()->address) }}</p>
                                        <p class="pb-7 rgb-71">@lang('index.email') : {{ safe(getCompanyInfo()->email) }}</p>
                                        <p class="pb-7 rgb-71">@lang('index.phone') : {{ safe(getCompanyInfo()->phone) }}</p>
                                        <p class="pb-7 rgb-71">@lang('index.website') : <a href="{{ getCompanyInfo()->website }}" target="_blank">{{ safe(getCompanyInfo()->website) }}</a>
                                        </p>
                                    </td>
                                    <td class="w-50 text-right">
                                        <img src="{!! getBaseURL() .
                                            (isset(getWhiteLabelInfo()->logo) ? 'uploads/white_label/' . getWhiteLabelInfo()->logo : 'images/logo.png') !!}" alt="site-logo">
                                    </td>
                                </tr>
                            </table>
                            <div class="text-center pt-10 pb-10">
                                <h2 class="color-000000 pt-20 pb-20">@lang('index.manufacture_details')</h2>
                            </div>
                            <table>
                                <tr>
                                    <td class="w-50">
                                        <p class="pb-7">
                                            <span class="">@lang('index.ppcrc_no'):</span>
                                            {{ $obj->reference_no }}
                                        </p>
                                        {{-- <p class="pb-7 rgb-71">
                                            <span class="">@lang('index.date'):</span>
                                            {{ getDateFormat($obj->created_at) }}
                                        </p> --}}
                                        {{-- <p class="pb-7 rgb-71">
                                            <span class="">@lang('index.manufacture_type'):</span>
                                            @if ($obj->manufacture_type == 'ime')
                                                Instant Manufacture Entry
                                            @elseif($obj->manufacture_type == 'mbs')
                                                Manufacture by Scheduling
                                            @elseif($obj->manufacture_type == 'fco')
                                                From Customer Order
                                            @endif
                                        </p> --}}
                                        <p class="pb-7 rgb-71">
                                            <span class="">@lang('index.status'):</span>
                                            @if ($obj->manufacture_status == 'draft')
                                                Draft
                                            @elseif($obj->manufacture_status == 'inProgress')
                                                In Progress
                                            @elseif($obj->manufacture_status == 'done')
                                                Done
                                            @endif
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class="">@lang('index.start_date'):</span>
                                            {{ getDateFormat($obj->start_date) }}
                                        </p>
                                    </td>
                                    <td class="w-50 text-right">
                                        @php $prodInfo = getFinishedProductInfo($obj->product_id); @endphp
                                        <p class="pb-7">
                                            <span class="">@lang('index.part_no'):</span>
                                            {{ $prodInfo->code }}
                                        </p>
                                        <p class="pb-7">
                                            <span class="">@lang('index.part_name'):</span>
                                            {{ $prodInfo->name }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class="">@lang('index.quantity'):</span>
                                            {{ $obj->product_quantity }}
                                        </p>
                                        <p class="pb-7 rgb-71">
                                            <span class="">@lang('index.delivery_date'):</span>
                                            {{ $obj->complete_date != null ? getDateFormat($obj->complete_date) : 'N/A' }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <h5>@lang('index.raw_material_consumption_cost') (RoM)</h5>
                            <table class="w-100 mt-10">
                                <thead class="b-r-3 bg-color-000000">
                                    <tr>
                                        <th class="w-5 text-start">@lang('index.sn')</th>
                                        <th class="w-10 text-start">@lang('index.owner')</th>
                                        <th class="w-10 text-start">Stock Type</th>
                                        <th class="w-30 text-start">@lang('index.raw_material_name')(@lang('index.code'))</th>
                                        <th class="w-15 text-start">Heat No</th>
                                        <th class="w-15 text-start">@lang('index.stock')</th>
                                        <th class="w-15 text-start">@lang('index.consumption')</th>
                                        {{-- <th class="w-20 text-right">@lang('index.total_cost')</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($m_rmaterials) && $m_rmaterials)
                                        <?php
                                        $i = 1;
                                        ?>
                                        @foreach ($m_rmaterials as $key => $value)
                                            <tr class="rowCount">
                                                <td class="width_1_p">
                                                    <p class="set_sn">{{ $i++ }}</p>
                                                </td>
                                                <td class="text-start">{{ isset($value->owner_type) && $value->owner_type==1 ? 'Owner' : 'Customer' }}</td>
                                                <td class="text-start">{{ isset($value->stk_user_id) && $value->owner_type == 1 ?  getSupplierNameCode($value->stk_user_id) : getCustomerNameById($value->stk_user_id).'('.getCustomerCodeById($value->stk_user_id).')' }}</td>
                                                <td class="text-start">{{ getRMName($value->rmaterials_id) }}</td>
                                                <td class="text-start">{{ getheatNo($value->rmaterials_id) }}</td>
                                                <td class="text-start">{{ $value->stock }} {{ getStockUnitById($value->stock_id) }}</td>
                                                <td class="text-start">{{ $value->consumption }}
                                                    {{ getStockUnitById($value->stock_id) }}
                                                </td>
                                                {{-- <td class="text-right padding-0">{{ getAmtCustom($value->total_cost) }}
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                {{-- <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-start fw-bold">@lang('index.total_raw_material_cost') :</td>
                                        <td class="text-right fw-bold">{{ getAmtCustom($obj->mrmcost_total) }}</td>
                                    </tr>
                                </tfoot> --}}
                            </table>
                            {{--<hr>
                             <h5>@lang('index.non_inventory_cost')</h5>
                            <table class="w-100 mt-10">
                                <thead class="b-r-3 bg-color-000000">
                                    <tr>
                                        <th class="w-5 text-start">@lang('index.sn')</th>
                                        <th class="w-40 text-start">@lang('index.non_inventory_items')</th>
                                        <th class="w-20 text-start">@lang('index.non_inventory_cost')</th>
                                        <th class="w-20 text-right">@lang('index.account')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($m_nonitems) && $m_nonitems)
                                        <?php
                                        $j = 1;
                                        ?>
                                        @foreach ($m_nonitems as $key => $value)
                                            <tr class="rowCount">
                                                <td class="width_1_p">
                                                    <p class="set_sn">{{ $j++ }}</p>
                                                </td>
                                                <td class="text-start"> {{ getNonInventroyItem($value->noninvemtory_id) }}
                                                </td>
                                                <td class="text-start padding-0">{{ getAmtCustom($value->nin_cost) }}</td>
                                                <td class="text-right">{{ getAccountName($value->account_id) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td class="text-start fw-bold">@lang('index.total_non_inventory_cost') :</td>
                                        <td class="text-start fw-bold">{{ getAmtCustom($obj->mnoninitem_total) }}</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table> --}}
                            @if (isset($m_stages) && $m_stages && count($m_stages) > 0)
                                <hr>
                                <h5>@lang('index.manufacture_stages')</h5>
                                <table class="w-100 mt-10">
                                    <thead class="b-r-3 bg-color-000000">
                                        <tr>
                                            <th class="w-5 text-left">@lang('index.sn')</th>
                                            <th class="w-30 text-left">@lang('index.stage')</th>
                                            {{-- <th class="w-15 text-center">@lang('index.required_months')</th> --}}
                                            {{-- <th class="w-15 text-center">@lang('index.required_days')</th> --}}
                                            <th class="w-15 text-center">@lang('index.required_time')</th>
                                            <th class="w-15 text-center">Setup Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($m_stages) && $m_stages)
                                            <?php
                                            $k = 1;
                                            // $total_month = 0;
                                            // $total_day = 0;
                                            // $total_hour = 0;
                                            $total_mimute = 0;$total_req_min = 0;$total_set_min = 0;
                                            ?>
                                            @foreach ($m_stages as $key => $value)
                                                <?php
                                                $total_req_min += $value->stage_minute;
                                                $total_set_min += $value->stage_set_minute;
                                                $total_mimute += $value->stage_minute + $value->stage_set_minute;
                                                $checked = '';
                                                $tmp_key = $key + 1;
                                                if ($obj->stage_counter == $tmp_key) {
                                                    $checked = 'checked=checked';
                                                }
                                                
                                                ?>
                                                <tr class="rowCount">
                                                    <td class="width_1_p">
                                                        <p class="set_sn">{{ $k++ }}</p>
                                                    </td>
                                                    <td class="text-left">
                                                        {{ getProductionStages($value->productionstage_id) }}</td>
                                                    {{-- <td class="text-center">{{ $value->stage_month }}</td> --}}
                                                    {{-- <td class="text-center">{{ $value->stage_day }}
                                                    </td> --}}
                                                    <td class="text-center">{{ $value->stage_minute }}
                                                    </td>
                                                    <td class="text-center">{{ $value->stage_set_minute }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="text-right pr-10">@lang('index.total') :</td>
                                            {{-- <td class="text-center">
                                                {{ isset($total_months) && $total_months ? $total_months : '' }}</td> --}}
                                            {{-- <td class="text-center">
                                                {{ isset($total_days) && $total_days ? $total_days : '' }}
                                            </td> --}}
                                            {{-- <td class="text-center">
                                                {{ isset($total_hours) && $total_hours ? $total_hours : '' }}</td> --}}
                                            <td class="text-center">
                                                {{ isset($total_mimute) && $total_mimute ? $total_mimute : '' }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            @endif
                            <table>
                                <tr>
                                    <td valign="top" class="w-50">
                                        <div class="pt-20">
                                            <h4 class="d-block pb-10">@lang('index.note')</h4>
                                            <div class="">
                                                <p class="h-180 color-black">
                                                    {{ $obj->note }}
                                                </p>
                                            </div>
                                            <h4 class="d-block pb-10">@lang('index.files')</h4>
                                            <div class="">
                                                @if (isset($obj->file) && $obj->file)
                                                    @php($files = explode(',', $obj->file))
                                                    @foreach ($files as $file)
                                                        @php($fileExtension = pathinfo($file, PATHINFO_EXTENSION))
                                                        @if ($fileExtension == 'pdf')
                                                            <a class="text-decoration-none"
                                                                href="{{ $baseURL }}uploads/manufacture/{{ $file }}"
                                                                target="_blank">
                                                                <img src="{{ $baseURL }}assets/images/pdf.png"
                                                                    alt="PDF Preview" class="img-thumbnail mx-2"
                                                                    width="100px">
                                                            </a>
                                                        @elseif($fileExtension == 'doc' || $fileExtension == 'docx')
                                                            <a class="text-decoration-none"
                                                                href="{{ $baseURL }}uploads/manufacture/{{ $file }}"
                                                                target="_blank">
                                                                <img src="{{ $baseURL }}assets/images/word.png"
                                                                    alt="Word Preview" class="img-thumbnail mx-2"
                                                                    width="100px">
                                                            </a>
                                                        @else
                                                            <a class="text-decoration-none"
                                                                href="{{ $baseURL }}uploads/manufacture/{{ $file }}"
                                                                target="_blank">
                                                                <img src="{{ $baseURL }}uploads/manufacture/{{ $file }}"
                                                                    alt="File Preview" class="img-thumbnail mx-2"
                                                                    width="100px">
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    {{-- <td class="w-50">
                                        <table class="mt-10 mb-10">
                                            <tr>
                                                <td class="w-50 border-top-dotted-gray border-bottom-dotted-gray">
                                                    <p class="">@lang('index.tax') :</p>
                                                    <small><strong>{{ $tax_items->tax_type.'('.$tax_items->tax_value.'%)'}}</strong></small>
                                                </td>
                                                <td class="w-50 text-right">
                                                    <p>{{ getAmtCustom($obj->tax_value) }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                        <table>
                                            <tr>
                                                <td class="w-50">
                                                    <p class="">@lang('index.total_cost')</p>
                                                </td>
                                                <td class="w-50 text-right">
                                                    <p>{{ getAmtCustom($obj->mtotal_cost) }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                        <table>
                                            <tr>
                                                <td class="w-50">
                                                    <p class="">@lang('index.profit_margin') (%)</p>
                                                </td>
                                                <?php
                                                // $price = round($obj->mtotal_cost);
                                                // $profit = $price * ($obj->mprofit_margin/100);
                                                ?>
                                                <td class="w-50 text-right">
                                                    <p>{{ getAmtCustom($profit) }}</p>
                                                </td>
                                            </tr>
                                        </table>

                                        <table class="mt-10 mb-10">
                                            <tr>
                                                <td class="w-50 border-top-dotted-gray border-bottom-dotted-gray">
                                                    <p class="">@lang('index.sale_price') :</p>
                                                </td>
                                                <td class="w-50 text-right">
                                                    <p>{{ getAmtCustom($obj->msale_price) }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td> --}}
                                </tr>
                            </table>
                            <table class="mt-50">
                                <tr>
                                    <td class="w-50">
                                    </td>
                                    <td class="w-50 text-right">
                                        <p class="rgb-71 d-inline border-top-e4e5ea pt-10">@lang('index.authorized_signature')</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </section>


    </section>


@endsection

@section('script')
    <script type="text/javascript" src="{!! $baseURL . 'assets/bower_components/gantt/js/jquery.fn.gantt.js' !!}"></script>
    <script type="text/javascript" src="{!! $baseURL . 'assets/bower_components/gantt/js/jquery.cookie.min.js' !!}"></script>
    <script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/addManufactures.js' !!}"></script>
    <script type="text/javascript" src="{!! $baseURL . 'frequent_changing/js/genchat.js' !!}"></script>
    <script src="{!! $baseURL . 'frequent_changing/js/manufacture.js' !!}"></script>
@endsection
