
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
    <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl m-5">Activity Log</h2>

    <!-- Dropdown for filtering user type -->
    <div class="m-4">
        <label for="usertypeFilter" class="block text-sm font-medium text-gray-700">Filter by User Type:</label>
        <select id="usertypeFilter" class="mt-1 block w-50% border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
            <option value="">All</option>
            @foreach ($activityLogs->unique('usertype') as $log)
                <option value="{{ $log->usertype }}">{{ $log->usertype }}</option>
            @endforeach
        </select>
    </div>

    <button id="filterButton" class="px-4 py-2 bg-blue-500 text-white rounded-md" onclick="filterTable()">Apply Filter</button>

    <table id="activityLogTable" class="w-full text-sm text-left mt-5">
        <thead class="uppercase">
            <tr class="border-2">
                <th scope="col" class="px-6 py-3">Log ID</th>
                <th scope="col" class="px-6 py-3">Updated by</th>
                <th scope="col" class="px-6 py-3">Action Performed</th>
                <th scope="col" class="px-6 py-3">Table Name</th>
                <th scope="col" class="px-6 py-3">Column Data</th>
                <th scope="col" class="px-6 py-3">Date</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($activityLogs as $log)

        <tr class="border-b text-black" data-usertype="{{ $log->usertype }}">
            <td class="px-6 py-4">{{ $log->log_id }}</td>
            <td class="px-6 py-4">{{ $log->usertype }}</td>
            <td class="px-6 py-4">{{ $log->action_performed }}</td>
            <td class="px-6 py-4">{{ $log->table_name }}</td>
            <td class="px-6 py-4">{{ $log->column_data }}</td>
            <td class="px-6 py-4">{{ $log->updated_at }}</td>
        @endforeach
        </tr>
    </tbody>
    </table>
</div>

</div>
</div>
</div>

<script>
<script>
    function filterTable() {
        const filter = document.getElementById('usertypeFilter').value;
        const rows = document.querySelectorAll('#activityLogTable tbody tr');

        rows.forEach(row => {
            const userType = row.getAttribute('data-usertype');
            if (filter === "" || userType === filter) {
                row.style.display = ""; // Show row
            } else {
                row.style.display = "none"; // Hide row
            }
        });
    }
</script>
    
</script>

</body>
</html>
