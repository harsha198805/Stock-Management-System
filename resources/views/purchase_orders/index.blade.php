@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Purchase Orders</h2>

    <form method="GET" action="{{ route('purchase-orders.index') }}" class="row g-2 mb-4">
        <div class="col-md-3">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                class="form-control" 
                placeholder="Search by Order ID or Procurement Ref No" 
                autocomplete="off"
            />
        </div>

        <div class="col-md-2">
            <input 
                type="date" 
                name="start_date" 
                class="form-control" 
                value="{{ request('start_date') }}" 
                placeholder="Start Date"
            />
        </div>

        <div class="col-md-2">
            <input 
                type="date" 
                name="end_date" 
                class="form-control" 
                value="{{ request('end_date') }}" 
                placeholder="End Date"
            />
        </div>

        <div class="col-md-1">
            <button type="submit" class="btn btn-outline-secondary">Search</button>
        </div>

        <div class="col-md-1">
            <a href="{{ route('purchase-orders.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-success">
            <tr>
                <th>ID</th>
                <th>Procurement Ref No</th>
                <th>Date</th>
                <th>Total Cost</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->procurement->reference_no ?? '-' }}</td>
                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                    <td>
                        Rs. {{
                            number_format(
                                $order->procurement->items->sum(fn($item) =>
                                    $item->quantity * $item->unit_price
                                ),
                                2
                            )
                        }}
                    </td>
                    <td>
                        <a href="{{ route('purchase-orders.pdf', $order->id) }}" class="btn btn-sm btn-primary">
                            Download PDF
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <div class="text-center alert alert-warning m-0">
                            No purchase orders found.
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
        {{ $orders->links() }}
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {

        $('input[type="date"]').on('change', function() {
            $(this).closest('form').submit();
        });
    });
</script>
@endpush
