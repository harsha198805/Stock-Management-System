@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3>Check Ticket Status</h3>
    <form method="POST" action="{{ url('/ticket/status/check') }}">
        @csrf
        <div class="mb-3">
            <label>Reference Number</label>
            <input type="text" name="reference" class="form-control" required>
        </div>
        <button class="btn btn-success">Check Status</button>
    </form>
</div>
@endsection
