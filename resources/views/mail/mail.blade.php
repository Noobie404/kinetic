<!DOCTYPE html>
<html>
<head>
    <title>{{ $details['title'] }}</title>
</head>
<body>
    <h1>Hello {{ $details['body']['customer_name'] }}</h1>
    <p>Bill Date: {{ date('Y-m-d', strtotime($details['body']['bill_date'])) }}</p>
    <p>Amount: {{ $details['body']['amount'] }}</p>
    <p>Status: {{ $details['body']['status'] == 1 ? 'Paid' : 'Due' }}</p>
    <p>Due: {{ $details['body']['due'] }}</p>
    <p>Paid: {{ $details['body']['paid'] }}</p>
</body>
</html>
