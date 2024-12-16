
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

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl m-5">Users</h2>
            <table class="w-full text-sm text-left">
                <thead class="uppercase">
                    <tr class="border-2">
                        <th scope="col" class="px-6 py-3">Username</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Join Date</th>
                        <th scope="col" class="px-6 py-3">Role</th>
                        <th scope="col" class="px-6 py-3">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="border-b text-black">
                        <td class="px-6 py-4">{{$user->name}}</td>
                        <td class="px-6 py-4">{{$user->email}}</td>
                        <td class="px-6 py-4">{{$user->created_at}}</td>
                        <td class="px-6 py-4">
                            {{$user->usertype}}
                            <button class="edit-button text-sm font-medium hover:underline text-gray-600" onclick="toggleEditForm({{ $user->user_id }})">
                                <i class="fa-solid fa-x me-1.5 text-gray-600"></i>Edit
                            </button>

                            <form id="edit-form-{{ $user->user_id }}" action="{{ route('user.edit_role', $user->user_id) }}" action="" method="POST" style="display: none;">
                                @csrf
                                @method('PUT') <!-- Use PUT for updates -->
                                <select name="usertype" required class="mt-2 w-20 text-sm rounded-lg">
                                    <option value="admin" {{ $user->usertype == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="seller" {{ $user->usertype == 'seller' ? 'selected' : '' }}>Seller</option>
                                    <option value="user" {{ $user->usertype == 'user' ? 'selected' : '' }}>User </option>
                                </select>
                                <button type="submit" class="text-sm font-medium hover:underline text-gray-600">
                                    <i class="fa-solid fa-x me-1.5 text-gray-600"></i>Submit
                                </button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('user.remove', $user->user_id) }}" method="POST">
                                @csrf
                                @method('DELETE') <!-- Specify DELETE method for RESTful compliance -->
                                <button type="submit" class="text-sm font-medium hover:underline text-red-600">
                                    <i class="fa-solid fa-x me-1.5 text-red-600"></i> Delete User
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

    <script>

    function toggleEditForm(userId) {
        const form = document.getElementById(`edit-form-${userId}`);
        if (form.style.display === "none" || form.style.display === "") {
            form.style.display = "block"; // Show the form
        } else {
            form.style.display = "none"; // Hide the form
        }
    }

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