<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Page</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1 class="my-4">User Order Summary</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Total Price</th>
                    <th>Delivery Status</th>
                    <th>Product Image</th>
                    <th>Order Date</th>
                    <th>Quantity</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($userOrderSummaries as $summary)
                    <tr>
                        <td>{{ $summary->product_title }}</td>
                        <td>₱{{ number_format($summary->product_price, 2) }}</td>
                        <td>₱{{ number_format($summary->total_price, 2) }}</td>
                        <td>{{ $summary->delivery_status }}</td>
                        <td>
                            <img src="/product/{{$summary->productimage}}" alt="Product Image" width="50" height="50">
                        </td>
                        <td>{{ $summary->orderdate }}</td>
                        <td>{{ $summary->quantity }}</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No records found.</td>
                    </tr>
                @endforelse
            </tbody>


        </table>
    </div>
</body>
</html>
