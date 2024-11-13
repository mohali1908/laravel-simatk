<!DOCTYPE html>
<html>
<head>
    <title>Daily Purchase Report</title>
</head>
<body>
    <h1>Daily Purchase Report</h1>
    <p>Date Range: {{ $start_date }} to {{ $end_date }}</p>

    <table border="1" cellspacing="0" cellpadding="8">
        <thead>
            <tr>
                <th>No</th>
                <th>Item</th>
                <th>Date</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($allData as $key => $purchase)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $purchase->name }}</td>
                    <td>{{ $purchase->date }}</td>
                    <td>{{ $purchase->buying_qty }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
