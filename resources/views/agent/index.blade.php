@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3>All Tickets</h3>

    <form method="GET" action="{{ url('agent/tickets') }}" class="row g-2 mb-3">
        <div class="col-md-2">
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control" placeholder="Start Date">
        </div>

        <div class="col-md-2">
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control" placeholder="End Date">
        </div>

        <div class="col-md-2">
            <select name="status" id="status" class="form-select">
                <option value="">All Status</option>
                <option value="opened" {{ $status == 'opened' ? 'selected' : '' }}>Opened</option>
                <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
            </select>
        </div>
        <div class="col-md-4">
            <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Search by customer name">
        </div>
<div class="col-md-1 d-grid">
    <button type="submit" class="btn btn-secondary">Search</button>
</div>
<div class="col-md-1 d-grid">
    <a href="{{ url('agent/tickets') }}" class="btn btn-outline-secondary">Reset</a>
</div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Ref</th>
                <th>Name</th>
                <th>Email</th>
                <th>Date And Time</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tickets as $ticket)
            <tr class="{{ $ticket->is_opened ? '' : 'table-success' }}">
                <td data-label="#"> {{ $loop->iteration + ($tickets->firstItem() - 1) }} </td>
                <td data-label="Ref"> {{ $ticket->reference }} </td>
                <td data-label="Name"> {{ $ticket->customer_name }} </td>
                <td data-label="Email"> {{ $ticket->email }} </td>
                <td data-label="Date And Time"> {{ $ticket->created_at }} </td>
                <td data-label="Status">
                    @if($ticket->is_opened)
                    <span class="badge bg-success">Opened</span>
                    @else
                    <span class="badge bg-warning text-dark">Pending</span>
                    @endif
                </td>
                <td data-label="Action">
                    <a href="{{ url('agent/tickets/'.$ticket->id) }}" class="btn btn-sm btn-primary">View & Reply</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $tickets->links('pagination::bootstrap-5') }}
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