<div class="container mt-4">
    <h3 class="mb-3">Staff Dashboard</h3>
    <ul class="list-group">
        <li class="list-group-item">
            <a href="{{ route('stock-items.index') }}" class="text-decoration-none">Manage Stock</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('procurements.index') }}" class="text-decoration-none">View Procurements</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('purchase-orders.index') }}" class="text-decoration-none">View Purchase Orders</a>
        </li>
    </ul>
</div>