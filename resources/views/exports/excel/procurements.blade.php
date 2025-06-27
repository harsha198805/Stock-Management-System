<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        th, td {
            border: 1px solid black;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        td.text-right {
            text-align: right;
        }
    </style>
</head>
<body>

<h2>Purchase Order Details</h2>
<h4>Items</h4>
<table>
    <thead>
        <tr>
            <th>Reference No</th>
            <th>Date</th>
            <th>Status</th>
            <th>Total Items</th>
            <th>Supplier</th>
        </tr>
    </thead>
    <tbody>
        @foreach($procurements as $proc)
            <tr>
                <td>{{ $proc->reference_no }}</td>
                <td>{{ \Carbon\Carbon::parse($proc->procurement_date)->format('Y-m-d') }}</td>
                <td>{{ ucfirst($proc->status) }}</td>
                <td>{{ $proc->items->count() }}</td>
                <td>{{ $proc->supplier->name ?? 'N/A' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>