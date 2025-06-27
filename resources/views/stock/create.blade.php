@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Stock Item</h2>
    <form method="POST" action="{{ route('stock-items.store') }}">
        @csrf
        @include('stock.partials.form', ['item' => null])
    </form>
</div>
@endsection