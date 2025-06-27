@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="text-center w-100">
        <h1 class="display-5 fw-bold">Welcome to the Stock Management System</h1>
        <p class="lead mb-4">Need help? Create a ticket or search your existing one below.</p>

        <div class="d-flex justify-content-center gap-3 flex-wrap mb-4">
            <a href="{{ url('/ticket/create') }}" class="btn btn-success btn-lg px-4">Create Ticket</a>
        </div>

        <!-- 🔍 Search Ticket -->
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <form method="GET" action="{{ url('/ticket/search') }}">
                    <div class="input-group">
                        <input type="text" name="query" class="form-control" placeholder="Enter Ticket Number or Email" required>
                        <button type="submit" class="btn btn-outline-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection