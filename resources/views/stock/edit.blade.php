@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Stock Item</h2>
    <form method="POST" action="{{ route('stock-items.update', $item->id) }}">
        @csrf
        @method('PUT')
        @include('stock.partials.form', ['item' => $item])
    </form>
</div>
@endsection