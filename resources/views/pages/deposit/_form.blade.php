<div>
    <div class="row">
        <div class="col-sm-12 mb-2 col-md-4">
            <div class="form-group">
                <label for="code">@lang('index.reference_no') <span class="required_star">*</span></label>                
                <input type="text" name="reference_no" id="code" class="check_required form-control @error('reference_no') is-invalid @enderror" placeholder="@lang('index.reference_no')"
                    value="{{ isset($obj->reference_no) && $obj->reference_no ? $obj->reference_no : old('reference_no') }}" onfocus="select()">
                @error('reference_no')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-sm-12 mb-2 col-md-4">
            <div class="form-group">
                <label for="date">@lang('index.date') <span class="required_star">*</span></label>
                <input type="text" name="date" id="expense_date" class="form-control @error('date') is-invalid @enderror " placeholder="Date" value="{{ isset($obj->date) ? date('d-m-Y',strtotime($obj->date)) : old('date') }}">
                @error('date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-sm-12 mb-2 col-md-4">
            <div class="form-group">
                <label for="amount">@lang('index.amount') <span class="required_star">*</span></label>
                <input type="text" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="Amount"
                    value="{{ isset($obj->amount) ? $obj->amount : old('amount') }}">
                @error('amount')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 mb-2 col-md-4">
            <div class="form-group">
                <label>@lang('index.deposit_withdraw') <span class="required_star">*</span></label>
                <div class="d-flex align-items-center">
                    <div class="w-100">
                        <select class="form-control @error('type') is-invalid @enderror select2" id="type" name="type">
                            <option value="">@lang('index.please_select')</option>
                            <option {{ isset($obj->type) && $obj->type == 'Deposit' || old('type') == 'Deposit' ? 'selected' : 'Deposit' }}
                                value="Deposit">@lang('index.deposit')</option>
                            <option {{ isset($obj->type) && $obj->type == 'Withdraw' || old('type') == 'Withdraw' ? 'selected' : 'Withdraw' }}
                                value="Withdraw">@lang('index.withdraw')</option>
                        </select>
                    </div>
                </div>
                @error('type')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-sm-12 mb-2 col-md-4">
            <div class="form-group">
                <label>@lang('index.note')</label>
                <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror" placeholder="Note" rows="3">{{ isset($obj) && $obj->note ? $obj->note : old('note') }}</textarea>
                @error('note')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <input type="hidden" name="in_or_out" value="">
    <div class="row mt-2">
        <div class="col-sm-12 col-md-6 mb-2 d-flex gap-3">
            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><iconify-icon
                    icon="solar:check-circle-broken"></iconify-icon>@lang('index.submit')</button>
            <a class="btn bg-second-btn" href="{{ route('deposit.index') }}"><iconify-icon
                    icon="solar:round-arrow-left-broken"></iconify-icon>@lang('index.back')</a>
        </div>
    </div>
</div>