@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h4>Ticket Reference: {{ $ticket->reference }}</h4>
    <p><strong>Customer:</strong> {{ $ticket->customer_name }}</p>
    <p><strong>Description:</strong> {{ $ticket->description }}</p>

    <h5 class="mt-4">Agent Replies</h5>
    @forelse ($ticket->replies as $reply)
        <div class="alert alert-secondary mb-2">{{ $reply->reply }}</div>
    @empty
        <p>No replies yet.</p>
    @endforelse
</div>
@endsection
