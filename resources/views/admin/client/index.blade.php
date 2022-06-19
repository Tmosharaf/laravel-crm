@extends('layouts.admin')

@section('content')

@php
    error_reporting(0);
@endphp
    <main class="w-full flex-grow p-6">
        <h1 class="text-3xl text-black pb-6">clients</h1>
        <x-bladewind.button color="purple">
            <a href="{{ route('clients.create') }}">Create</a>
        </x-bladewind.button>
        <div class="w-full max-w-md m-auto">
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
        <div class="w-full mt-6">
            <div class="bg-white overflow-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class=" text-left py-3 px-4 uppercase font-semibold text-sm">Id.</th>
                            <th class="w-1/5 text-left py-3 px-4 uppercase font-semibold text-sm">Name</th>
                            <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Company</th>
                            <th class="w-1/5 text-left py-3 px-4 uppercase font-semibold text-sm">Address</th>
                            <th class=" text-left py-3 px-4 uppercase font-semibold text-sm">Phone</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Email</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Active</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($clients as $client)
                            <tr>
                                <td class="align-top text-left py-3 px-4">{{ $client->id }}</td>
                                <td class="align-top text-left py-3 px-4"><a class="underline text-blue-500" href="{{ route('clients.show', $client) }}">{{ $client->name }}</a></td>
                                <td class="align-top text-left py-3 px-4">{{ $client->company }}</td>
                                <td class="align-top text-left py-3 px-4">{{ $client->address }}</td>
                                <td class="align-top text-left py-3 px-4">{{ $client->phone }}</td>
                                <td class="align-top text-left py-3 px-4">{{ $client->email }}</td>
                                <td class="align-top text-left py-3 px-4">
                                    {!! $client->active ? '<span class="bg-blue-400 cursor-default text-white px-2 py-1 rounded-md">Yes</span>' : "<span class='bg-yellow-300 cursor-default text-white px-2 py-1 rounded-md'>No</span>" !!}
                                </td>

                                <td class="align-top text-left py-3 px-2 flex flex-row justify-around">
                                    <a href="{{ route('clients.show', $client) }}" class="text-blue-500">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @role('admin')
                                    <a href="{{ route('clients.edit', $client) }}" class="text-blue-500">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                        <form action="{{ route('clients.destroy', $client) }}" method="post"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-500"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @endrole
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $clients->links() }}

    </main>
@endsection
