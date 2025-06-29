<!DOCTYPE html>
<html>
<head>
    <title>Purchase Order #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 40px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        p {
            margin: 4px 0;
        }
        .header {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            vertical-align: top;
        }
        th {
            background-color: #f0f0f0;
        }
        td.amount {
            text-align: right;
        }
        .total-row td {
            font-weight: bold;
            background-color: #fafafa;
        }
        .signature {
            margin-top: 60px;
        }
    </style>
</head>
<body>

    <h2>Purchase Order</h2>

    <div class="header">
        <p><strong>Purchase Order ID:</strong> {{ $order->id }}</p>
        <p><strong>Procurement Ref No:</strong> {{ $order->procurement->reference_no ?? 'N/A' }}</p>
        <p><strong>Date:</strong> {{ $order->created_at->format('Y-m-d') }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->procurement->status ?? 'N/A') }}</p>
        <p><strong>Supplier:</strong> {{ $order->procurement->supplier->name ?? 'N/A' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 45%;">Item Name</th>
                <th style="width: 15%;">Quantity</th>
                <th style="width: 20%;">Unit Price</th>
                <th style="width: 20%;">Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($order->procurement->items as $item)
                @php 
                    $sub = $item->quantity * $item->unit_price;
                    $total += $sub;
                @endphp
                <tr>
                    <td>{{ $item->stockItem->name ?? 'N/A' }}</td>
                    <td class="amount">{{ $item->quantity }}</td>
                    <td class="amount">{{ number_format($item->unit_price, 2) }}</td>
                    <td class="amount">{{ number_format($sub, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3" style="text-align:right;">Total</td>
                <td class="amount">{{ number_format($total, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="signature">
        <p><strong>Approved By:</strong> _________________________</p>
        <p style="margin-top:10px;"><strong>Date:</strong> ________________________________</p>
    </div>

</body>
</html>
