@extends('layouts.admin')

@section('content')

    <main class="w-full flex-grow p-6">
        <h1 class="text-3xl text-black pb-6">Tasks</h1>
        <x-bladewind.button color="purple">
            <a href="{{ route('tasks.create') }}">Create</a>
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
        <div class="w-full max-w-md m-auto">
            <form method="get" action="{{ route('tasks.index') }}">
                <select type="input" name="filter" onchange="this.form.submit()">
                    <option value="all">All</option>  
                    <option value="softdeleted" {{ 'filter=softdeleted' ? 'selected' : '' }}>Deleted</option>  
                </select> 
                </form>
                
                
        </div>
        <div class="w-full mt-6">
            <div class="bg-white overflow-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class=" text-left py-3 px-4 uppercase font-semibold text-sm">Id.</th>
                            <th class="w-1/5 text-left py-3 px-4 uppercase font-semibold text-sm">Task Name</th>
                            <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Project</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Active</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Start</th>
                            <th class=" text-left py-3 px-4 uppercase font-semibold text-sm">End In</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">User</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($tasks as $task)
                            <tr>
                                <td class="align-top text-left py-3 px-4">{{ $task->id }}</td>
                                <td class="align-top text-left py-3 px-4">{{ $task->name }}</td>
                                <td class="align-top text-left py-3 px-4">{{ $task->project->name }}</td>
                                <td class="align-top text-left py-3 px-4">{{ $task->status ? 'Active' : 'Inactive' }}</td>
                                <td class="align-top text-left py-3 px-4">{{ $task->start_date }}</td>
                                <td class="align-top text-left py-3 px-4">{!! $task->endsIn !!}</td>
                                <td class="align-top text-left py-3 px-4">{{ $task->user->name }}</td>

                                <td class="align-top text-left py-3 px-2 flex flex-row justify-around">
                                    <a href="{{ route('tasks.show', $task) }}" class="text-blue-500">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @role('admin')
                                    <a href="{{ route('tasks.edit', $task) }}" class="text-blue-500">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                        <form action="{{ route('tasks.destroy', $task) }}" method="post"
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
        {{ $tasks->links() }}

    </main>
    
@endsection
