@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Dashboard</h2>

    @php $role = auth()->user()->role; @endphp

    @if ($role === 'Admin')
        @include('dashboard.admin')
    @elseif ($role === 'Manager')
        @include('dashboard.manager')
    @elseif ($role === 'Staff')
        @include('dashboard.staff')
    @else
        <div class="alert alert-danger">
            No dashboard view available for your role.
        </div>
    @endif
</div>
@endsection