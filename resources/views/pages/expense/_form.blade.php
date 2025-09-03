<div>
    <div class="row">
        <div class="col-sm-12 col-md-6 mb-2 col-lg-4">
            <div class="form-group">
                <label>@lang('index.category') <span class="required_star">*</span></label>
                <div class="d-flex align-items-center">
                    <div class="w-100">
                        <select class="form-control @error('category_id') is-invalid @enderror select2" id="category_id"
                            name="category_id">
                            <option value="">@lang('index.select_category')</option>
                            @foreach ($expenseCategories as $value)
                                <option
                                    {{ isset($obj->category_id) && $obj->category_id == $value->id ? 'selected' : '' }}
                                    value="{{ $value->id }}">
                                    {{ $value->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 mb-2 col-lg-4">
            <div class="form-group">
                <label>@lang('index.date') <span class="required_star">*</span></label>
                <input type="text" name="date" id="expense_date"
                    class="form-control @error('date') is-invalid @enderror" readonly
                    placeholder="Date" value="{{ isset($obj) && $obj->date ? date('d-m-Y', strtotime($obj->date)) : (old('date') ? old('date') : date('d-m-Y')) }}">
                @error('date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-sm-12 col-md-6 mb-2 col-lg-4">
            <div class="form-group">
                <label>@lang('index.amount') <span class="required_star">*</span></label>
                <input type="text" name="amount" id="amount"
                    class="form-control @error('amount') is-invalid @enderror" placeholder="Amount" value="{{ isset($obj) && $obj->amount ? $obj->amount : old('amount') }}">

                @error('amount')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-sm-12 col-md-6 mb-2 col-lg-4">
            <div class="form-group">
                <label>@lang('index.responsible_person') <span class="required_star">*</span></label>
                <div class="d-flex align-items-center">
                    <div class="w-100">
                        <select class="form-control @error('employee_id') is-invalid @enderror select2" id="employee_id"
                            name="employee_id">
                            <option value="">@lang('index.select_responsible_person')</option>
                            @foreach ($employees as $value)
                                <option
                                    {{ isset($obj->employee_id) && $obj->employee_id == $value->id ? 'selected' : '' }}
                                    value="{{ $value->id }}">
                                    {{ $value->name . ' - ' . ucwords($value->designation) }}
                                </option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-sm-12 col-md-6 mb-2 col-lg-4">
            <div class="form-group">
                <label>@lang('index.account') <span class="required_star">*</span></label>
                <div class="d-flex align-items-center">
                    <div class="w-100">
                        <select class="form-control @error('account_id') is-invalid @enderror select2" id="account_id"
                            name="account_id">
                            <option value="">@lang('index.select_account')</option>
                            @foreach ($accountList as $value)
                                <option
                                    {{ isset($obj->account_id) && $obj->account_id == $value->id ? 'selected' : '' }}
                                    value="{{ $value->id }}">
                                    {{ $value->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('account_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col-sm-12 col-md-6 mb-2 col-lg-8" id="in_time_container">
            <div class="form-group">
                <label>@lang('index.note')</label>
                <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror" placeholder="Note" rows="3">{{ isset($obj) && $obj->note ? $obj->note : old('note') }}</textarea>
                @error('note')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <!-- /.box-body -->
    <input type="hidden" name="in_or_out" value="">
    <div class="row mt-2">
        <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><iconify-icon
                    icon="solar:check-circle-broken"></iconify-icon>@lang('index.submit')</button>
            <a class="btn bg-second-btn" href="{{ route('expense.index') }}"><iconify-icon
                    icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
        </div>
    </div>
</div>
