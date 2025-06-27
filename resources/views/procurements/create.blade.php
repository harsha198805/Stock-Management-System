@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Procurement</h2>

    <form method="POST" action="{{ route('procurements.store') }}">
        @csrf

        <div class="mb-3">
            <label>Reference No</label>
            <input type="text" name="reference_no" class="form-control" value="{{ old('reference_no', $referenceNo ?? '') }}" readonly>
            @error('reference_no')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Procurement Date</label>
                <input type="date" name="procurement_date" class="form-control @error('procurement_date') is-invalid @enderror" value="{{ old('procurement_date', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
            @error('procurement_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label>Supplier</label>
            <select name="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror" required>
                <option value="">Select Supplier</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
            @error('supplier_id')
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
                @if(old('items'))
                    @foreach(old('items') as $i => $item)
                        <tr>
                            <td>
                                <select name="items[{{ $i }}][stock_item_id]" class="form-control" required>
                                    <option value="">Select item</option>
                                    @foreach($stockItems as $stock)
                                        <option value="{{ $stock->id }}" {{ $stock->id == $item['stock_item_id'] ? 'selected' : '' }}>{{ $stock->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" name="items[{{ $i }}][quantity]" class="form-control" value="{{ $item['quantity'] }}" required></td>
                            <td><input type="number" step="0.01" name="items[{{ $i }}][unit_price]" class="form-control" value="{{ $item['unit_price'] }}" required></td>
                            <td><button type="button" class="btn btn-danger btn-sm remove-item">Remove</button></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>
                            <select name="items[0][stock_item_id]" class="form-control" required>
                                <option value="">Select item</option>
                                @foreach($stockItems as $stock)
                                    <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="items[0][quantity]" class="form-control" required></td>
                        <td><input type="number" step="0.01" name="items[0][unit_price]" class="form-control" required></td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-item">Remove</button></td>
                    </tr>
                @endif
            </tbody>
        </table>

        <button type="submit" class="btn btn-success">Save Procurement</button>
        <a href="{{ route('procurements.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let itemsTable = document.getElementById('items-table').getElementsByTagName('tbody')[0];
        let addItemBtn = document.getElementById('add-item');
        let itemIndex = {{ old('items') ? count(old('items')) : 1 }};

        addItemBtn.addEventListener('click', function () {
            let newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>
                    <select name="items[${itemIndex}][stock_item_id]" class="form-control" required>
                        <option value="">Select item</option>
                        @foreach($stockItems as $stock)
                            <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" name="items[${itemIndex}][quantity]" class="form-control" required></td>
                <td><input type="number" step="0.01" name="items[${itemIndex}][unit_price]" class="form-control" required></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-item">Remove</button></td>
            `;
            itemsTable.appendChild(newRow);
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
