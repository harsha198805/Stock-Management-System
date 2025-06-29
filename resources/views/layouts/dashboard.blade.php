@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Dashboard</h3>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary h-100">
                <div class="card-body">
                    <h5 class="card-title">Stock Items</h5>
                    <p class="display-4">{{ $stockCount }}</p>
                    <a href="{{ route('stock-items.index') }}" class="btn btn-light btn-sm">Manage Stock</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success h-100">
                <div class="card-body">
                    <h5 class="card-title">Procurements</h5>
                    <p class="display-4">{{ $procurementCount }}</p>
                    <a href="{{ route('procurements.index') }}" class="btn btn-light btn-sm">View Procurements</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-info h-100">
                <div class="card-body">
                    <h5 class="card-title">Purchase Orders</h5>
                    <p class="display-4">{{ $purchaseOrderCount }}</p>
                    <a href="{{ route('purchase-orders.index') }}" class="btn btn-light btn-sm">View POs</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
