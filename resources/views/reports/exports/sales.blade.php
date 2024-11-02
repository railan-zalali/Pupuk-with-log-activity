<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Sales Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18pt;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .summary {
            margin-top: 20px;
            padding: 10px;
            background-color: #f8f9fa;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9pt;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Sales Report</h1>
        <p>Period: {{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}</p>
        <p>Generated on: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="summary">
        <p><strong>Total Sales:</strong> {{ $totalSales }}</p>
        <p><strong>Total Amount:</strong> Rp {{ number_format($totalAmount, 0, ',', '.') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Invoice</th>
                <th>Customer</th>
                <th>Total Amount</th>
                <th>Payment</th>
                <th>Cashier</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr>
                    <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $sale->invoice_number }}</td>
                    <td>{{ $sale->customer ? $sale->customer->name : '-' }}</td>
                    <td>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($sale->payment_method) }}</td>
                    <td>{{ $sale->user->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>{{ config('app.name') }} - Sales Report</p>
        <p>Page 1</p>
    </div>
</body>

</html>
