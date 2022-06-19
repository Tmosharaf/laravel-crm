@extends('layouts.admin')

@section('content')
    <main class="w-full flex-grow p-6">
        <h1 class="text-3xl text-black pb-6">Users</h1>
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
                            <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Email</th>
                            <th class="w-1/5 text-left py-3 px-4 uppercase font-semibold text-sm">Address</th>
                            <th class=" text-left py-3 px-4 uppercase font-semibold text-sm">Phone</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Role</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($users as $user)
                            <tr>
                                <td class="align-top text-left py-3 px-4">{{ $user->id }}</td>
                                <td class="align-top text-left py-3 px-4">{{ $user->name }}</td>
                                <td class="align-top text-left py-3 px-4">{{ $user->email }}</td>
                                <td class="align-top text-left py-3 px-4">{{ $user->address }}</td>
                                <td class="align-top text-left py-3 px-4">{{ $user->phone }}</td>

                                <td class="align-top text-left py-3 px-4">{{ $user->roles->pluck('name')->implode(', ') }}
                                </td>

                                <td class="align-top text-left py-3 px-2 flex flex-row justify-around">
                                    <a href="{{ route('users.show', $user) }}" class="text-blue-500">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('users.edit', $user) }}" class="text-blue-500">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @role('admin')
                                        <form action="{{ route('users.destroy', $user) }}" method="post"
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
        {{ $users->links() }}

    </main>
@endsection
