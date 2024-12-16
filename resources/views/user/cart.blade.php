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
        @include('user.navbar')
        @include('user.alert')


        <section class="bg-white py-8 antialiased md:py-16">
            <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
                <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl">Your Bag</h2>

                <div class="mt-6 sm:mt-8 md:gap-6 lg:flex lg:items-start xl:gap-8">
                    <div class="mx-auto w-full flex-none lg:max-w-2xl xl:max-w-4xl">
                        <div class="space-y-6">

                            @foreach($cartItems as $item)
                                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm md:p-6">
                                        <div class="grid grid-cols-5">
                                            <div class="col-span-1">
                                                <a href="#" class="">
                                                    <img class="h-40" src="{{ $item->image1 }}" alt="Product" class="object-cover size-14 hover-image pb-[2px] hover:bg-black">
                                                </a>
                                            </div>
                                            <div class="col-span-3">
                                                <a href="#" class="text-base font-medium text-gray-900 hover:underline ">{{ $item->product_title }}</a>
                                                <p class="text-sm text-gray-500 font-medium">Size: {{ $item->size }}</p>
                                                <p class="text-sm text-gray-500 font-medium">Quantity: {{ $item->quantity }}</p>
                                            </div>
                                            <div class="col-span-1 flex flex-col justify-between items-end">
                                                <form class="" action="{{ route('remove_cart', $item->cart_id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE') <!-- Specify the DELETE method -->
                                                    <button type="submit" class="text-lg">
                                                        <i class="ph-bold ph-trash"></i>
                                                    </button>
                                                </form>
                                                <p class="text-base font-semibold text-gray-900 ">Price: <span class="font-bold">₱{{ number_format($item->price, 2) }}</span></p>
                                            </div>
                                        </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <?php $shippingFee = 300; ?>
                    <div class="mx-auto mt-6 max-w-4xl flex-1 space-y-6 lg:mt-0 lg:w-full">
                        <div class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-6">
                            <p class="text-xl font-semibold text-gray-900">Order Summary</p>

                            <div class="space-y-4">
                                <div class="space-y-2">
                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="text-base font-normal text-gray-500">Bag</dt>
                                    <dd class="text-base font-medium text-gray-900 ">₱{{ number_format($totalPrice->total, 2) }}</dd>
                                </dl>
                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="text-base font-normal text-gray-500">Shipping Fee</dt>
                                    <dd class="text-base font-medium text-gray-900 ">₱{{ number_format($shippingFee, 2) }}</dd>
                                </dl>
                                </div>

                                <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                                    <dt class="text-base font-bold text-gray-900">Total</dt>
                                    <dd class="text-base font-bold text-gray-900">₱{{ number_format($totalPrice->total + $shippingFee, 2) }}</dd>
                                </dl>
                            </div>

                            <form action="{{url('/checkout')}}" method="GET" class="w-full">
                                <button type="submit" class="w-full flex items-center justify-center rounded-lg bg-black px-5 py-2.5 text-sm font-medium text-white">
                                    Proceed to checkout
                                </button>
                            </form>

                            <div class="flex items-center justify-center gap-2">
                                <span class="text-sm font-normal text-gray-500">or</span>
                                <a href="/shop_page" title="" class="inline-flex items-center gap-2 text-sm font-medium text-primary-700 underline hover:no-underline">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </body>
</html>
