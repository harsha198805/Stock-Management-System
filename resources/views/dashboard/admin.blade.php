<div class="container mt-4">
    <h3 class="mb-4">Staff Dashboard</h3>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Stock Items</h5>
                    <p class="card-text display-4">{{ $stockCount ?? 0 }}</p>
                    <a href="{{ route('stock-items.index') }}" class="btn btn-light btn-sm">Manage Stock</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Procurements</h5>
                    <p class="card-text display-4">{{ $procurementCount ?? 0 }}</p>
                    <a href="{{ route('procurements.index') }}" class="btn btn-light btn-sm">View Procurements</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Purchase Orders</h5>
                    <p class="card-text display-4">{{ $purchaseOrderCount ?? 0 }}</p>
                    <a href="{{ route('purchase-orders.index') }}" class="btn btn-light btn-sm">View Purchase Orders</a>
                </div>
            </div>
        </div>
    </div>

    <ul class="list-group">
        <li class="list-group-item">
            <a href="{{ route('users.index') }}" class="text-decoration-none">Manage Users</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="text-decoration-none">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</div>
