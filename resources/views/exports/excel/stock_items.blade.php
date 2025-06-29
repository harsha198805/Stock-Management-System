<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Code</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->code }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->unit_price, 2) }}</td>
                <td>
                    @if($item->status == 1)
                        Active
                    @elseif($item->status == 0)
                        Inactive
                    @elseif($item->status == 2)
                        Out of Stock
                    @else
                        Unknown
                    @endif
                </td>
                <td>{{ $item->created_at->format('Y-m-d') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
