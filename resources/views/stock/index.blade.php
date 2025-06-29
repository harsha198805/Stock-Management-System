@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Stock Item Management</h2>
        <div>
            <a href="{{ route('stock-items.create') }}" class="btn btn-primary me-2">
                Add New Stock Item
            </a>
            <a href="{{ route('stock-items.export.excel', request()->query()) }}" class="btn btn-success">
                <i class="fa fa-file-excel-o"></i> Export to Excel
            </a>
        </div>
    </div>

    <form method="GET" action="{{ route('stock-items.index') }}" class="row g-2 mb-3">
        <div class="col-md-2">
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control" placeholder="Start Date">
        </div>

        <div class="col-md-2">
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control" placeholder="End Date">
        </div>

        <div class="col-md-2">
            <select name="status" id="status" class="form-select">
                <option value="">All Status</option>
                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Out of Stock</option>
            </select>
        </div>

        <div class="col-md-1">
            <select name="sort_dir" id="sort_dir" class="form-select">
                <option value="desc" {{ request('sort_dir') == 'desc' ? 'selected' : '' }}>Descending</option>
                <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Ascend</option>
           </select>
        </div>

        <div class="col-md-3">
            <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Search by name or code">
        </div>
        <div class="col-md-1 d-grid">
            <button type="submit" class="btn btn-outline-secondary">Search</button>
        </div>
        <div class="col-md-1 d-grid">
            <a href="{{ route('stock-items.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($items->isEmpty())
        <div class="alert alert-warning">No stock items found.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>Item Name</th>
                        <th>Item Code</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $index => $item)
                        <tr>
                            <td>{{ $items->firstItem() + $index }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rs. {{ number_format($item->unit_price, 2) }}</td>
                            <td data-label="Status">
                                @if($item->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @elseif($item->status == 0)
                                    <span class="badge bg-warning text-dark">Inactive</span>
                                @elseif($item->status == 2)
                                    <span class="badge bg-danger">Out of Stock</span>
                                @else
                                    <span class="badge bg-secondary">Unknown</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('stock-items.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                @if(auth()->user()->role === 'Admin')
                                    <form action="{{ route('stock-items.destroy', $item->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-3">
            {{ $items->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#status, #sort_dir').on('change', function() {
            $(this).closest('form').submit();
        });

        $('input[type="date"]').on('change', function() {
            $(this).closest('form').submit();
        });
    });
</script>
@endpush
