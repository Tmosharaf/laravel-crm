@extends('layouts.admin')
@section('content')
    <main class="w-full flex-grow p-6">
        <x-bladewind.button color="purple" class="mb-4">
            <a href="{{ route('clients.index') }}">Back</a>

        </x-bladewind.button>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

            <table class="w-full  text-sm text-left text-gray-500 dark:text-gray-400">
                <tbody>
                    <tr class="border-b dark:bg-gray-800 dark:border-gray-700  bg-white ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            Name
                        </th>
                        <td class="px-6 py-4">
                            {{ $client->name }}
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-50">
                        <td class="px-6 py-4 capitalize">
                            company
                        </td>
                        <td class="px-6 py-4">
                            {{ $client->company }}
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-50">
                        <td class="px-6 py-4">
                            Email
                        </td>
                        <td class="px-6 py-4">
                            {{ $client->email }}
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-50">
                        <td class="px-6 py-4">
                            Phone
                        </td>
                        <td class="px-6 py-4">
                            {{ $client->phone }}
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-50">
                        <td class="px-6 py-4 capitalize">
                            address
                        </td>
                        <td class="px-6 py-4">
                            {{ $client->address }}
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-50">
                        <td class="px-6 py-4 capitalize">
                            active
                        </td>
                        <td class="px-6 py-4">
                            {{ $client->active ? 'Yes' : 'No' }}
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </main>
@endsection
