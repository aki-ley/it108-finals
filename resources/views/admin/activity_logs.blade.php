
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
    @include('admin.navbar')

    <div class="">

<div class="">
<div class="">


<div class="p-4 sm:ml-64">
<div class="overflow-x-auto relative shadow-md sm:rounded-lg">
    <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl m-5">Orders</h2>
    <table class="w-full text-sm text-left mt-5">
        <thead class="uppercase">
            <tr class="border-2">
                <th scope="col" class="px-6 py-3">Log ID</th>
                <th scope="col" class="px-6 py-3">User ID</th>
                <th scope="col" class="px-6 py-3">Action Performed</th>
                <th scope="col" class="px-6 py-3">Table Name</th>
                <th scope="col" class="px-6 py-3">Column Data</th>

      
            </tr>
        </thead>
        <tbody>
        @foreach ($activityLogs as $log)

        <tr class="border-b text-black">
            <td class="px-6 py-4">{{ $log->log_id }}</td>
            <td class="px-6 py-4">{{ $log->user_id }}</td>
            <td class="px-6 py-4">{{ $log->action_performed }}</td>
            <td class="px-6 py-4">{{ $log->table_name }}</td>
            <td class="px-6 py-4">{{ $log->column_data }}</td>

        @endforeach
        </tr>
    </tbody>
    </table>
</div>

</div>
</div>
</div>

    </body>
</html>
