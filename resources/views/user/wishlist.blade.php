<!-- resources/views/home/wishlist.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/bold/style.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>UP TREND - Wishlist</title>
</head>

<body>
    @include('user.navbar')

    <section class="bg-white py-8 antialiased md:py-16">
    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
        <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl">Wishlist</h2>

            @forelse ($wishlistItems as $item) <!-- Loop through wishlistItems -->
                <div class="mt-6 sm:mt-8 md:gap-6 lg:flex lg:items-start xl:gap-8">
                    <div class="mx-auto w-full flex-none lg:max-w-2xl xl:max-w-4xl">
                        <div class="space-y-6">
                            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm md:p-6">
                                <div class="space-y-4 md:flex md:items-center md:justify-between md:gap-6 md:space-y-0">
                                    <a href="#" class="shrink-0 md:order-1">
                                        <!-- Display product image -->
                                        <img class="h-40 object-cover" 
                                            src="{{ URL('product/' . $item->image1) }}" 
                                            alt="{{ $item->product_title }}" />
                                    </a>
                                    <div class="w-full min-w-0 flex-1 space-y-4 md:order-2 md:max-w-md">
                                        <div>
                                            <!-- Display product title -->
                                            <a href="#" class="text-base font-medium text-gray-900 hover:underline">
                                                {{ $item->product_title }}
                                            </a>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <!-- Display product price -->
                                            <span class="text-base font-bold text-gray-900">
                                                ₱{{ number_format($item->price, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between md:order-3 md:justify-end">
                                        <!-- Remove product from wishlist -->
                                        <form action="" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm font-medium hover:underline text-red-600">
                                                <i class="fa-solid fa-x me-1.5 text-red-600"></i> Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 mt-6">Your wishlist is empty.</p>
            @endforelse
        </div>
    </section>


</body>
</html>