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

    <body class="bg-slate-100">
        @include('user.navbar')

        <section class="flex flex-col w-1/2 lg:w-1/3 xl:w-1/4 mx-auto p-8 md:p-10 2xl:p-12 3xl:p-14 mt-20 rounded-2xl shadow-md bg-white">
            <div class="rounded-xl mx-auto">
                <div class="flex space-x-6">
                    <i class="ph-bold ph-package text-4xl text-yellow-500"></i>
                    <div class="flex-col text-base md:text-xl">
                        <p class="font-semibold"> Order Successful!</p>
                        <p class=""> Order ID: #123456789</p>
                    </div>
                </div>
                <p class="mt-4 text-center">Redirecting in <span id="countdown">5</span> seconds...</p>
            </div>
        </section>
<script type="text/javascript">
    let countdown = 5;
    const countdownElement = document.getElementById('countdown');
    const interval = setInterval(() => {
        countdown--;
        countdownElement.textContent = countdown;
        if (countdown === 0) {
            clearInterval(interval);
            window.location.href = "{{ url('/') }}";
        }
    }, 1000);
</script>
    </body>
</html>