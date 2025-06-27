@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Procurements</h2>

    <a href="{{ route('procurements.create') }}" class="btn btn-primary mb-3">Add New Procurement</a>
    <a href="{{ route('procurements.export.excel') }}" class="btn btn-success mb-3">Export to Excel</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="GET" action="{{ route('procurements.index') }}" class="row g-2 mb-4">

        <div class="col-md-2">
            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" placeholder="Start Date">
        </div>

        <div class="col-md-2">
            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" placeholder="End Date">
        </div>

        <div class="col-md-2">
            <select name="status" id="status" class="form-select">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>

            <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search by reference no" value="{{ request('search') }}">
        </div>

        <div class="col-md-1">
            <button type="submit" class="btn btn-outline-secondary">Search</button>
        </div>

        <div class="col-md-1">
            <a href="{{ route('procurements.index') }}" class="btn btn-secondary w-100">Reset</a>
        </div>
    </form>
        @if($procurements->isEmpty())
        <div class="alert alert-warning">No record found.</div>
    @else
    <table class="table table-bordered">
        <thead class="table-success">
            <tr>
                <th>Reference No</th>
                <th>Date</th>
                <th>Status</th>
                <th>Items Count</th>
                <th>Supplier</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($procurements as $procurement)
            <tr>
                <td>{{ $procurement->reference_no }}</td>
                <td>{{ \Carbon\Carbon::parse($procurement->procurement_date)->format('Y-m-d') }}</td>
                <td data-label="Status">
                    @if($procurement->status === 'approved')
                        <span class="badge bg-success">Approved</span>
                    @elseif($procurement->status === 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @elseif($procurement->status === 'rejected')
                        <span class="badge bg-danger">Rejected</span>
                    @else
                        <span class="badge bg-secondary">Unknown</span>
                    @endif
                </td>
                <td>{{ $procurement->items->count() }}</td>
                <td>{{ $procurement->supplier->name ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('procurements.edit', $procurement) }}" class="btn btn-sm btn-warning">Edit</a>
                    <a href="{{ route('procurements.pdf', $procurement->id) }}" class="btn btn-sm btn-info" target="_blank">PDF</a>
                    <a href="{{ route('procurements.export', $procurement->id) }}" class="btn btn-sm btn-success">Export Excel</a>
                    <form action="{{ route('procurements.destroy', $procurement) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete this procurement?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $procurements->links() }}
    @endif
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#status').on('change', function() {
            $(this).closest('form').submit();
        });

        $('input[type="date"]').on('change', function() {
            $(this).closest('form').submit();
        });
    });
</script>
@endpush