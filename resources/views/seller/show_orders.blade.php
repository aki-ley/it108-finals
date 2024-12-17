
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css'); }}">
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/bold/style.css"/>
        <script type="text/javascript" src="{{ URL::asset('js/main.js') }}"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <title>UP TREND</title>
    </head>

    <body>
    @include('seller.navbar')
    <div class="p-4 sm:ml-64">
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
        <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm md:p-6">
            <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl">Current Listing</h2>
            @foreach($orders as $order)
            <div class="mt-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm md:p-6">
                <p class="text-xl font-semibold">Order ID: {{ $order->order_id }}</p>
                <hr class="my-4 border-t-2 border-gray-200 w-full">
                <div class="space-y-4 md:flex md:gap-6 md:space-y-0">
                    <a href="#" class="">
                        <!-- Display the first image in the product_images string -->
                        @php
                            $product_images = explode(', ', $order->product_images); 
                            $image = $product_images[0];  // Get the first image
                        @endphp
                        <img class="h-40" src="{{ URL('product/' . $image) }}" alt="Product" class="object-cover size-14 hover-image pb-[2px] hover:bg-black">
                    </a>
                    <div class="grid grid-cols-5 w-full">
                        <div class="col-span-2">
                            <p class="text-xl font-bold"></p>
                            <p class="font-semibold">Name: {{ $order->name }}</p>
                            <p class=""><span class="font-semibold">Address: </span>{{ $order->address }}</p>
                            <p class=""><span class="font-semibold">Email: </span>{{ $order->email }}</p>
                            <p class=""><span class="font-semibold">Contact No.: </span>{{ $order->phone }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="font-semibold">Product: {{ $order->product_titles }}</p>
                            <p class=""><span class="font-semibold">Size: </span>{{ $order->sizes }}</p>
                            <p class=""><span class="font-semibold">Quantity: </span>{{ $order->quantities }}</p>
                            <p class=""><span class="font-semibold">Price: </span>₱{{number_format($order->product_prices, 2) }}</p>
                            <p class="font-semibold">Total Price: </span>₱{{number_format($order->total_price, 2) }}</p>
                        </div>
                        <div class="col-span-1">
                            <p class=""><span class="font-semibold">Payment Status: </span>{{ $order->payment_status }}</p>
                            <p class=""><span class="font-semibold">Delivery Status: </span>{{ $order->delivery_status }}</p>
                            @if($order->delivery_status === 'Delivered')
                                <p class="text-gray-500 hidden">Delivered</p>
                            @else
                                <a href="{{ route('delivered', ['id' => $order->order_id]) }}"
                                class="w-full flex items-center justify-center rounded-lg bg-black px-5 py-2.5 text-sm font-medium text-white">
                                    Delivered
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

    
    </body>
</html>
