@auth
    @php $role = auth()->user()->role; $currentRoute = request()->route()->getName(); @endphp

    <nav id="sidebarMenu" class="d-none d-lg-block custom-sidebar sidebar p-3" style="width: 250px; min-height: 100vh;">
        <h5 class="mb-4">Menu</h5>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active bg-success text-white' : '' }}" href="{{ route('dashboard') }}">
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('stock-items.*') ? 'active bg-success text-white' : '' }}" href="{{ route('stock-items.index') }}">
                    Manage Stock
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('procurements.*') ? 'active bg-success text-white' : '' }}" href="{{ route('procurements.index') }}">
                    Procurements
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('purchase-orders.*') ? 'active bg-success text-white' : '' }}" href="{{ route('purchase-orders.index') }}">
                    Purchase Orders
                </a>
            </li>
            @if($role === 'Admin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.*') ? 'active bg-success text-white' : '' }}" href="{{ route('users.index') }}">
                        Manage Users
                    </a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link text-danger" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>

    {{-- Mobile Sidebar --}}
    <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="mobileSidebarLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active bg-success text-white' : '' }}" href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('stock-items.*') ? 'active bg-success text-white' : '' }}" href="{{ route('stock-items.index') }}">
                        Manage Stock
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('procurements.*') ? 'active bg-success text-white' : '' }}" href="{{ route('procurements.index') }}">
                        Procurements
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('purchase-orders.*') ? 'active bg-success text-white' : '' }}" href="{{ route('purchase-orders.index') }}">
                        Purchase Orders
                    </a>
                </li>
                @if($role === 'Admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('users.*') ? 'active bg-success text-white' : '' }}" href="{{ route('users.index') }}">
                            Manage Users
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link text-danger" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                        Logout
                    </a>
                    <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
@endauth
