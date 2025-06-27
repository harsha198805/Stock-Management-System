@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Procurement: {{ $procurement->reference_no }}</h2>

    <form method="POST" action="{{ route('procurements.update', $procurement) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Reference No</label>
            <input type="text" name="reference_no" class="form-control @error('reference_no') is-invalid @enderror"
                   value="{{ old('reference_no', $procurement->reference_no) }}" required>
            @error('reference_no')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Procurement Date</label>
            <input type="date" name="procurement_date" class="form-control @error('procurement_date') is-invalid @enderror"
                   value="{{ old('procurement_date', \Carbon\Carbon::parse($procurement->procurement_date)->format('Y-m-d')) }}" required>
            @error('procurement_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="pending" {{ old('status', $procurement->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ old('status', $procurement->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ old('status', $procurement->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <hr>

        <h4>Items</h4>
        <table class="table" id="items-table">
            <thead>
                <tr>
                    <th>Stock Item</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th><button type="button" class="btn btn-sm btn-primary" id="add-item">Add Item</button></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $oldItems = old('items', $procurement->items->toArray());
                    $index = 0;
                @endphp

                @foreach($oldItems as $item)
                <tr>
                    <td>
                        <select name="items[{{ $index }}][stock_item_id]" class="form-control" required>
                            <option value="">Select item</option>
                            @foreach($stockItems as $stock)
                                <option value="{{ $stock->id }}" {{ $stock->id == $item['stock_item_id'] ? 'selected' : '' }}>
                                    {{ $stock->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="items[{{ $index }}][quantity]" class="form-control" value="{{ $item['quantity'] ?? 1 }}" required>
                    </td>
                    <td>
                        <input type="number" step="0.01" name="items[{{ $index }}][unit_price]" class="form-control" value="{{ $item['unit_price'] ?? 0 }}" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-item">Remove</button>
                        @if(isset($item['id']))
                            <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item['id'] }}">
                        @endif
                    </td>
                </tr>
                @php $index++; @endphp
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-success">Update Procurement</button>
        <a href="{{ route('procurements.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let itemsTable = document.querySelector('#items-table tbody');
        let addItemBtn = document.getElementById('add-item');
        let itemIndex = {{ $index }};

        addItemBtn.addEventListener('click', function () {
            let row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <select name="items[${itemIndex}][stock_item_id]" class="form-control" required>
                        <option value="">Select item</option>
                        @foreach($stockItems as $stock)
                            <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="items[${itemIndex}][quantity]" class="form-control" required>
                </td>
                <td>
                    <input type="number" step="0.01" name="items[${itemIndex}][unit_price]" class="form-control" required>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-item">Remove</button>
                </td>
            `;
            itemsTable.appendChild(row);
            itemIndex++;
        });

        itemsTable.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-item')) {
                e.target.closest('tr').remove();
            }
        });
    });
</script>
@endsection
