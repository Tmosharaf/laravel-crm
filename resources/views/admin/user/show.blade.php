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

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full  text-sm text-left text-gray-500 dark:text-gray-400">
                <tbody>
                    <tr
                        class="border-b dark:bg-gray-800 dark:border-gray-700  bg-white ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            Name
                        </th>
                        <td class="px-6 py-4">
                            {{ $user->name }}
                        </td>
                    </tr>
                    <tr
                        class="border-b dark:bg-gray-800 dark:border-gray-700 bg-gray-50 ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            Email
                        </th>
                        <td class="px-6 py-4">
                            {{ $user->email }}
                        </td>
                    </tr>
                    <tr
                        class="border-b dark:bg-gray-800 dark:border-gray-700  bg-white ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            Phone
                        </th>
                        <td class="px-6 py-4">
                            {{ $user->phone }}
                        </td>
                    </tr>
                    <tr
                        class="border-b dark:bg-gray-800 dark:border-gray-700 bg-gray-50 ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            Address
                        </th>
                        <td class="px-6 py-4">
                            {{ $user->address }}
                        </td>
                    </tr>

                    <tr
                        class="border-b dark:bg-gray-800 dark:border-gray-700  bg-white ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            Roles
                        </th>
                        <td class="px-6 py-4 capitalize">
                            {{ $user->roles->pluck('name')->implode(', ') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>
@endsection
