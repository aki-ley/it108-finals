
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css'); }}">
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/bold/style.css"/>
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/fill/style.css"/>
        <script type="text/javascript" src="{{ URL::asset('js/main.js') }}"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <title>UP TREND</title>
    </head>

    <body>
    @include('user.navbar')
    
    <div class="p-10 sm:p-20">

    <div class="flex justify-center">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
            @foreach($products as $product)
                <div class="group">
                    <div class="relative">
                        <a href="{{ url('product_details', $product->product_id) }}"><img src="{{ URL('product/' . $product->image1) }}" alt="" class="object-cover main-image"></a>
                        <button class=" align-middle absolute top-4 right-4"><i class="text-2xl ph-bold ph-heart-straight"></i></button>
                    </div>
                    <div class="pt-1 hidden group-hover:inline-flex gap-[2px]">
                        <img src="{{ URL('product/' . $product->image1) }}" alt="" class="object-cover size-14 hover-image border-b-4 border-transparent hover:border-black">
                        <img src="{{ URL('product/' . $product->image2) }}" alt="" class="object-cover size-14 hover-image border-b-4 border-transparent hover:border-black">
                        <img src="{{ URL('product/' . $product->image3) }}" alt="" class="object-cover size-14 hover-image border-b-4 border-transparent hover:border-black">
                    </div>
                    <div class="py-2">
                        <div class=""><a href="{{ url('product_details', $product->product_id) }}">
                            <p class="font-semibold">{{ $product->product_title }}</p>
                            <p class="mt-1 font-semibold">₱{{ number_format($product->price, 2) }}</p></a>
                            <p class="mt-1 text-gray-500">{{($product->quantity) }} Available</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    </div>

    </body>
</html>