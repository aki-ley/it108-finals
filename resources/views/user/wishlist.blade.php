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

    @if(session()->has('error'))
            <div class="flex justify-center items-center w-full fixed top-0 right-0 left-0 z-50">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white bg-opacity-90 rounded-lg shadow">
                        <button type="button" class="close absolute top-3 end-2.5 text-gray-500 hover:text-red-500 " data-dismiss="alert" onclick="closeAlert()">
                            <i class="ph-bold ph-x"></i>
                        </button>
                        <div class="p-4 md:p-5 text-center">
                            <h3 class="mt-5 mb-5 text-lg font-normal text-red-500">{{ session()->get('error') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(session()->has('message'))
            <div class="flex justify-center items-center w-full fixed top-0 right-0 left-0 z-50">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white bg-opacity-90 rounded-lg shadow">
                        <button type="button" class="close absolute top-3 end-2.5 text-gray-500 hover:text-red-500 " data-dismiss="alert" onclick="closeAlert()">
                            <i class="ph-bold ph-x"></i>
                        </button>
                        <div class="p-4 md:p-5 text-center">
                            <h3 class="mt-5 mb-5 text-lg font-normal text-green-500">{{ session()->get('message') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        @endif

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
                                        <form action="{{ route('remove_wishlist', $item->wishlist_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE') <!-- Specify DELETE method for RESTful compliance -->
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

        
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const button = document.querySelector('[data-drawer-toggle="default-sidebar"]');
        const sidebar = document.getElementById('default-sidebar');
        const dashboardLink = document.getElementById('dashboard-link');

        button.addEventListener('click', function () {
            sidebar.classList.toggle('-translate-x-full');
        });

        dashboardLink.addEventListener('click', function () {
            sidebar.classList.add('-translate-x-full');
        });
    });
    function closeAlert() {
        const alert = document.querySelector('[data-dismiss="alert"]').closest('.flex');
        alert.style.display = 'none';
    }
    </script>


</body>
</html>