
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
                @foreach($products as $product)
                <div>
                    <hr class="my-4 border-t-2 border-gray-200 w-full">
                    <div class="space-y-4 md:flex md:gap-6 md:space-y-0">
                        <a href="#" class="">
                            <img class="h-40" src="/product/{{$product->image1}}" alt="Product" class="object-cover size-14 hover-image pb-[2px] hover:bg-black">
                        </a>
                        <div class="grid grid-cols-4 w-full">
                            <div class="col-span-3">
                                <p class="text-xl font-bold">{{$product->product_title}}</p>
                                <p class="">Description: {{$product->description}}</p>
                                <p class="">Quantity: {{$product->quantity}}</p>
                                <p class="font-semibold">Price: ₱{{number_format($product->price)}}</p>
                            </div>
                            <div class="col-span-1 flex flex-row space-x-2 justify-center items-center">
                                <button class="py-2 px-4 bg-black rounded-xl"><i class="text-2xl ph-bold ph-pencil-simple text-green-500"></i></button>
                                <form action="{{ route('product.remove', $product->product_id) }}" method="POST">
                                @csrf
                                @method('DELETE') <!-- Specify DELETE method for RESTful compliance -->
                                <button type="submit" class="py-2 px-4 bg-black rounded-xl"><i class="text-2xl ph-bold ph-x text-red-500"></i></button>
                                </form>
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
