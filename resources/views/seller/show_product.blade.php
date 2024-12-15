
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

    <div class="">

        <div class="">
        <div class="">
        

    <div class="p-4 sm:ml-64">
        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left">
                <thead class="uppercase">
                    <tr class="border-2">
                        <th scope="col" class="px-4 py-3">Product Name</th>
                        <th scope="col" class="px-4 py-3">Description</th>
                        <th scope="col" class="px-4 py-3">Quantity</th>
                        <th scope="col" class="px-4 py-3">Price</th>
                        <th scope="col" class="px-4 py-3">Image</th>
                        <th scope="col" class="px-4 py-3"></th>
                        <th scope="col" class="px-4 py-3"></th>
                        <th scope="col" class="px-4 py-3">Action</th>

                    </tr>
                </thead>
                @foreach($products as $product)
                <tr class="border-b text-black">
                    <td class="px-4 py-4">{{$product->product_title}}</td>
                    <td class="px-4 py-4">{{$product->description}}</td>
                    <td class="px-4 py-4">{{$product->quantity}}</td>
                    <td class="px-4 py-4">₱{{number_format($product->price)}}</td>
                    <td class="px-2 py-4">
                        <img class="w-32 h-full" src="/product/{{$product->image1}}">
                    </td>
                    <td class="px-2 py-4">
                        <img class="w-32 h-full" src="/product/{{$product->image2}}">
                    </td>
                    <td class="px-2 py-4">
                        <img class="w-32 h-full" src="/product/{{$product->image3}}">
                    </td>

                    <td>
                        <form action="{{ route('product.remove', $product->product_id) }}" method="POST">
                            @csrf
                            @method('DELETE') <!-- Specify DELETE method for RESTful compliance -->
                            <button type="submit" class="text-sm font-medium hover:underline text-red-600">
                                <i class="fa-solid fa-x me-1.5 text-red-600"></i> Remove
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        </div>
        </div>
    </div>
    </body>
</html>
