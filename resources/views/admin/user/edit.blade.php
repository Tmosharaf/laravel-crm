@extends('layouts.admin')

@section('content')

    <main class="w-full flex-grow p-6 bg-gray-50">
        <h1 class="text-3xl text-black pb-2">User</h1>
        <div class="w-full max-w-2xl mx-auto mb-6">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">There were errors with your submission</strong>
                    <ul class="list-disc ml-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <x-bladewind.alert>
                    {{ session('success') }}
                </x-bladewind.alert>
            @endif
            @if (session('error'))
            <x-bladewind.alert
                type="error">
                {{ session('error') }}
            </x-bladewind.alert>
            @endif

        </div>
            <form action="{{ route('users.update', $user) }}" method="post" class="w-full max-w-2xl mx-auto">
                @csrf
                @method('PUT')
                <div class="mb-6 flex flex-row space-x-2">
                    <div class="w-1/2">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                            Name
                        </label>
                        <input type="text" name="name" id="name" value="{{ $user->name }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="w-1/2">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                            email
                        </label>
                        <input type="text" name="email" id="email" value="{{ $user->email }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                </div>
                <div class="mb-6">
                    <label for="address" class="block text-gray-700 text-sm font-bold mb-2">
                        address
                    </label>
                    <input type="text" name="address" id="address" value="{{ $user->address }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-6">
                    <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">
                        phone
                    </label>
                    <input type="text" name="phone" id="phone" value="{{ $user->phone }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex flex-row mb-4 space-x-2">
                    <div class="w-1/2">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                            Password
                        </label>
                        <input type="password" name="password" id="password"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="w-1/2">
                        <label for="password-confirm" class="block text-gray-700 text-sm font-bold mb-2">
                            Confirm Password
                        </label>
                        <input type="password" name="password_confirmation" id="password-confirm"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Update
                    </button>
                </div>
            </form>


            <form action="{{ route('users.role.edit', $user) }}" method="post" class=" mt-6 w-full max-w-2xl mx-auto">
                @csrf
                @method('PUT')
                <div class="mb-4">

                    <label for="role" class="block text-gray-700 text-sm font-bold mb-2">
                        Role
                    </label>
                    <select name="role" id="role"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="user" {{ $user->roles->pluck('name')->implode(', ') == 'user' ? 'selected' : '' }}>User
                        </option>
                        <option value="admin" {{ $user->roles->pluck('name')->implode(', ') == 'admin' ? 'selected' : '' }}>
                            Admin</option>
                    </select>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Update Role
                    </button>
                </div>

            </form>


    </main>
@endsection
