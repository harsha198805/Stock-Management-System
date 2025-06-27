@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h4>Ticket {{ $ticket->reference }}</h4>
    <p><strong>Name:</strong> {{ $ticket->customer_name }}</p>
    <p><strong>Email:</strong> {{ $ticket->email }}</p>
    <p><strong>Description:</strong> {{ $ticket->description }}</p>

    <hr>
    <h5>Reply</h5>
    <form method="POST" action="{{ url('agent/tickets/'.$ticket->id.'/reply') }}">
        @csrf
        <textarea name="reply" rows="3" class="form-control mb-3" required></textarea>
        <button class="btn btn-success">Send Reply</button>
    </form>

    <hr>
    <h5>Previous Replies</h5>
    @foreach ($ticket->replies as $reply)
        <div class="alert alert-info">{{ $reply->reply }}</div>
    @endforeach
</div>
@endsection
