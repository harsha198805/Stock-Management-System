@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h4>Thank you! Your ticket has been submitted.</h4>
    <p>Your reference number is: <strong>{{ $reference }}</strong></p>
    <a href="{{ url('/ticket/status') }}" class="btn btn-success mt-3">Check Ticket Status</a>
</div>
@endsection
