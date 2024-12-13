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
    
    <div class="p-10 sm:p-20">

        <div class="flex justify-center">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
                <div class="group">
                    <a href=""><img src="{{ URL('images/shoes/aj1midwhite.jpg') }}" alt="" class="object-cover main-image"></a>
                        <div class="pt-1 hidden group-hover:inline-flex gap-[2px]">
                            <img src="{{ URL('images/shoes/aj1midwhite.jpg') }}" alt="" class="object-cover size-14 hover-image border-b-4 border-transparent hover:border-black">
                            <img src="{{ URL('images/shoes/aj1midblackwhite.jpg') }}" alt="" class="object-cover size-14 hover-image border-b-4 border-transparent hover:border-black">
                            <img src="{{ URL('images/shoes/aj1midblackred.jpg') }}" alt="" class="object-cover size-14 hover-image border-b-4 border-transparent hover:border-black">
                        </div>
                        <div class="py-4 flex justify-between">
                            <div class=""><a href="">
                                <p class="font-semibold">Air Jordan 1</p>
                                <p>Men's Shoes</p>
                                <p>3 Colours</p>
                                <p class="mt-2 font-semibold">₱4,719</p></a>
                            </div>
                            <div class="flex flex-col items-end justify-start space-y-2">
                                <div class="flex space-x-2">
                                    <button class="border border-gray-300 rounded-lg px-2 py-1 hover:bg-black hover:text-white"><i class="ph-bold ph-heart-straight align-middle"></i>
                                </div>
                            </div>
                        </div>
                </div>

            </div>
        </div>

    </div>

    </body>
</html>