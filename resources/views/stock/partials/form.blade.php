<div class="mb-3">
    <label>Item Name</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $item->name ?? '') }}" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Item Code</label>
    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $item->code ?? '') }}" required>
    @error('code')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Quantity</label>
    <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $item->quantity ?? 0) }}" required>
    @error('quantity')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Unit Price</label>
    <input type="number" step="0.01" name="unit_price" class="form-control @error('unit_price') is-invalid @enderror" value="{{ old('unit_price', $item->unit_price ?? 0) }}" required>
    @error('unit_price')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control @error('status') is-invalid @enderror">
        <option value="1" {{ old('status', $item->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
        <option value="0" {{ old('status', $item->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
        <option value="2" {{ old('status', $item->status ?? 1) == 2 ? 'selected' : '' }}>Out of Stock</option>
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-success">Save</button>
<a href="{{ route('stock-items.index') }}" class="btn btn-secondary">Cancel</a>
