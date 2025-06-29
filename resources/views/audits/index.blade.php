@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Audit Trail</h3>

       <form method="GET" action="{{ route('audits.index') }}" class="row g-2 mb-4">
        <div class="col-md-2">
            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" placeholder="Start Date">
        </div>
        <div class="col-md-2">
            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" placeholder="End Date">
        </div>

        <div class="col-md-2">
            <select name="event" id="event" class="form-select">
                <option value="">All Events</option>
                <option value="created" {{ request('event') == 'created' ? 'selected' : '' }}>Created</option>
                <option value="updated" {{ request('event') == 'updated' ? 'selected' : '' }}>Updated</option>
                <option value="deleted" {{ request('event') == 'deleted' ? 'selected' : '' }}>Deleted</option>
            </select>
        </div>
        
        <div class="col-md-2">
            <input type="text" name="user" class="form-control" placeholder="Search by user name" value="{{ request('user') }}">
        </div>

        <div class="col-md-2">
            <input type="text" name="model" class="form-control" placeholder="Search by model" value="{{ request('model') }}">
        </div>

        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-outline-secondary">Search</button>
            <a href="{{ route('audits.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    @if($audits->isEmpty())
        <div class="alert alert-warning">No record found.</div>
     @else   
    <table class="table table-bordered">
        <thead class="table-success">
            <tr>
                <th>No</th>
                <th>User Name</th>
                <th>Event</th>
                <th>Model</th>
                <th>Changes</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @foreach($audits as $audit)
                <tr>
                    <td>{{ $loop->iteration + $audits->firstItem() - 1 }}</td>
                    <td>{{ optional($audit->user)->name ?? 'System' }}</td>
                    <td>{{ $audit->event }}</td>
                    <td>{{ class_basename($audit->auditable_type) }}</td>
                    <td>
                        @foreach($audit->getModified() as $attribute => $values)
                            <div><strong>{{ $attribute }}:</strong> {{ $values['old'] ?? '-' }} → {{ $values['new'] ?? '-' }}</div>
                        @endforeach
                    </td>
                    <td>{{ $audit->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $audits->links() }}
    @endif
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#event').on('change', function() {
            $(this).closest('form').submit();
        });

        $('input[type="date"]').on('change', function() {
            $(this).closest('form').submit();
        });
    });
</script>
@endpush
