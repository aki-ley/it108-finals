<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/bold/style.css"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>UP TREND</title>
</head>

<body>
    @include('user.navbar')
    @include('user.alert')
            
    <section class="py-8 md:py-16">
        <div class="max-w-screen-lg px-4 mx-auto 2xl:px-0">
            <div class="lg:grid lg:grid-cols-5 group">

                <div class="col-span-3 shrink-0 max-w-md lg:max-w-lg mx-auto grid grid-cols-5 gap-4">
                    <div class="col-span-1 flex flex-col gap-2">
                        <img src="{{ URL('product/' . $product->image1) }}" alt="" class="object-cover size-24 hover-image rounded-md hover-image">
                        <img src="{{ URL('product/' . $product->image2) }}" alt="" class="object-cover size-24 hover-image rounded-md hover-image">
                        <img src="{{ URL('product/' . $product->image3) }}" alt="" class="object-cover size-24 hover-image rounded-md hover-image">
                    </div>
                    <div class="col-span-4">
                        <img src="{{ URL('product/' . $product->image1) }}" alt="" class="object-cover hover-image rounded-md main-image">
                    </div>
                </div>

                <div class="col-span-2 mt-6 sm:mt-8 lg:mt-0">
                    <p class="text-2xl font-bold sm:text-3xl ">{{ $product->product_title }}</p>

                    <div class="mt-4 sm:items-center sm:gap-4 sm:flex">
                        <h1 class="text-lg font-semibold sm:text-xl">₱{{ number_format($product->price, 2) }}</h1>
                    </div>

                    <div>
                        <p class="text-base font-bold sm:text-xl mt-10">Select Size</p>
                        <p id="size-error" class="text-red-500 mt-4 hidden">Please select a size.</p>
                        <div class="mt-6 grid grid-cols-2 gap-1">
                            <button class="border-2 hover:border-black py-2 px-4 rounded-md text-lg size-btn" data-size="US M 11 / W 12.5">US M 11 / W 12.5</button>
                            <button class="border-2 hover:border-black py-2 px-4 rounded-md text-lg size-btn" data-size="US M 10.5 / W 12">US M 10.5 / W 12</button>
                            <button class="border-2 hover:border-black py-2 px-4 rounded-md text-lg size-btn" data-size="US M 10 / W 11.5">US M 10 / W 11.5</button>
                            <button class="border-2 hover:border-black py-2 px-4 rounded-md text-lg size-btn" data-size="US M 9.5 / W 11">US M 9.5 / W 11</button>
                            <button class="border-2 hover:border-black py-2 px-4 rounded-md text-lg size-btn" data-size="US M 9 / W 10.5">US M 9 / W 10.5</button>
                            <button class="border-2 hover:border-black py-2 px-4 rounded-md text-lg size-btn" data-size="US M 8.5 / W 10">US M 8.5 / W 10</button>
                        </div>
                    </div>

                    <!-- Quantity controls -->
                    <div class="mt-6 sm:mt-8">
                        <p class="text-base font-bold sm:text-xl">Quantity</p>
                        <div class="flex items-center mt-4">
                            <button type="button" class="decrease-quantity px-4 py-2 border rounded-l-lg border-gray-300 border-r-0 bg-black text-white" id="decrease-quantity">-</button>
                            <input type="number" id="quantity" name="quantity" value="1" class="focus:border-black focus:ring-black w-12 py-2 text-center border border-gray-300" min="1" max="99" step="1" oninput="this.value = this.value.slice(0, 2)">
                            <button type="button" class="increase-quantity px-4 py-2 border rounded-r-lg border-gray-300 border-l-0 bg-black text-white" id="increase-quantity">+</button>
                        </div>
                    </div>

                    <div class="grid grid-cols-5 gap-2">
                        <form class="mt-6 gap-2 sm:items-center grid col-span-4 sm:mt-8" action="{{ url('add_cart', $product->product_id) }}" method="POST" id="add-to-cart-form">
                            @csrf
                            <!-- Size -->
                            <input type="hidden" name="size" id="selected-size" value="">
                            <!-- Hidden input for selected image (dynamic) -->
                            <input type="hidden" name="image1" id="selected-image" value="{{ URL('product/' . $product->image1) }}">
                            <!-- Quantity -->
                            <input type="hidden" name="quantity" id="hidden-quantity" value="1">
                            <!-- Add to Cart Button -->
                            <button type="submit" class="flex items-center justify-center py-2.5 text-sm sm:text-lg font-medium rounded-lg bg-black text-white">
                                <i class="ph-bold ph-bag mr-2"></i>
                                Add to bag
                            </button>
                            
                        </form>

                        <form class="mt-6 gap-2 sm:items-center grid col-span-1 sm:mt-8" action="{{ route('wishlist.view') }}" method="POST">
                            @csrf
                            <!-- Hidden input field to send the product ID -->
                            <input type="hidden" name="product_id" value="{{ $product->product_id }}">

                            <button type="submit" class="flex items-center justify-center py-2.5 text-sm sm:text-lg font-medium rounded-lg bg-black text-white">
                                <i class="ph-bold ph-heart-straight text-sm sm:text-lg"></i>
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Handle size selection
        const sizeButtons = document.querySelectorAll('.size-btn');
        const selectedSizeInput = document.getElementById('selected-size');
        const sizeError = document.getElementById('size-error');
        const quantityInput = document.getElementById('quantity');
        const hiddenQuantityInput = document.getElementById('hidden-quantity');

        sizeButtons.forEach(button => {
            button.addEventListener('click', function() {
                sizeButtons.forEach(btn => btn.classList.remove('bg-gray-200'));
                this.classList.add('bg-gray-200');
                selectedSizeInput.value = this.getAttribute('data-size');
                sizeError.classList.add('hidden');
            });
        });

        // Quantity increase/decrease
        document.getElementById('increase-quantity').addEventListener('click', function() {
            quantityInput.value = parseInt(quantityInput.value) + 1;
            hiddenQuantityInput.value = quantityInput.value;
        });

        document.getElementById('decrease-quantity').addEventListener('click', function() {
            if (parseInt(quantityInput.value) > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
                hiddenQuantityInput.value = quantityInput.value;
            }
        });

        // Sync quantity with hidden input
        quantityInput.addEventListener('input', function() {
            hiddenQuantityInput.value = quantityInput.value;
        });

        document.querySelectorAll('.hover-image').forEach(image => {
            image.addEventListener('click', function() {
                selectedImageInput.value = this.src;
            });
        });

        // Form submission validation
        document.getElementById('add-to-cart-form').addEventListener('submit', function(event) {
            if (!selectedSizeInput.value) {
                event.preventDefault();
                sizeError.classList.remove('hidden');
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            const sizeButtons = document.querySelectorAll('.size-btn');
            const imageButtons = document.querySelectorAll('.hover-image');

            let sizeSelected = false;
            let imageSelected = false;

            sizeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    sizeButtons.forEach(btn => btn.classList.remove('bg-gray-200'));
                    this.classList.add('bg-gray-200');
                    selectedSizeInput.value = this.getAttribute('data-size');
                    sizeSelected = true;
                });
            });
        });

    </script>
</body>

<script defer src="{{ URL::asset('js/main.js') }}"></script>
</html>
