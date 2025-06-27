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

<p><strong>Reference No:</strong> {{ $procurement->reference_no }}</p>
<p><strong>Procurement Date:</strong> {{ \Carbon\Carbon::parse($procurement->procurement_date)->format('d M Y') }}</p>
<p><strong>Status:</strong> {{ ucfirst($procurement->status) }}</p>
<p><strong>Supplier:</strong> {{ $procurement->supplier->name ?? 'N/A' }}</p>

<h4>Items</h4>
<table>
    <thead>
        <tr>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Sub Total</th>
        </tr>
    </thead>
    <tbody>
        @php $grandTotal = 0; @endphp
        @foreach($procurement->items as $item)
            @php
                $subTotal = $item->quantity * $item->unit_price;
                $grandTotal += $subTotal;
            @endphp
            <tr>
                <td>{{ $item->stockItem->name ?? 'N/A' }}</td>
                <td>{{ $item->quantity }}</td>
                <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                <td class="text-right">{{ number_format($subTotal, 2) }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" class="text-right"><strong>Grand Total</strong></td>
            <td class="text-right"><strong>{{ number_format($grandTotal, 2) }}</strong></td>
        </tr>
    </tbody>
</table>

</body>
</html>
