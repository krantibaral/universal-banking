<div class="form-group row">
    <!-- Receiver Field -->
    <div class="col-md-12">
        <label for="receiver_id">Receiver *</label>
        <select class="form-control" id="receiver_id" name="receiver_id" required>
            <option value="">Select Receiver</option>
            @foreach($customers as $customer)
                @if (!(auth()->user()->hasRole('Customer') && auth()->user()->customer->id == $customer->id))
                    <option value="{{ $customer->id }}" {{ old('receiver_id', $item->receiver_id ?? '') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->user->name ?? 'N/A' }}
                    </option>
                @endif
            @endforeach
        </select>
    </div>
</div>


<div class="form-group row">
    <!-- Amount Field -->
    <div class="col-md-12">
        <label for="amount">Amount *</label>
        <input type="number" required class="form-control" id="amount" name="amount"
            value="{{ old('amount', $item->amount ?? '') }}" placeholder="Enter amount" step="0.01" min="0.01">
    </div>
</div>

<div class="form-group row">
    <!-- Memo Field -->
    <div class="col-md-12">
        <label for="memo">Memo</label>
        <textarea class="form-control" id="memo" name="memo" rows="3"
            placeholder="Enter memo">{{ old('memo', $item->memo ?? '') }}</textarea>
    </div>
</div>

<!-- Hidden sender_id -->
<input type="hidden" name="sender_id" value="{{ auth()->user()->id }}">

@isset($item)
    <div class="form-group row">
        <div class="col-md-12">
            <label for="status">Status *</label>
            <select class="form-control" id="status" name="status" required>
                <option value="pending" {{ old('status', $item->status ?? '') == 'pending' ? 'selected' : '' }}>Pending
                </option>
                <option value="completed" {{ old('status', $item->status ?? '') == 'completed' ? 'selected' : '' }}>Completed
                </option>
                <option value="failed" {{ old('status', $item->status ?? '') == 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </div>
    </div>
@endisset