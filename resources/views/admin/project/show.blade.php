@extends('layouts.admin')
@section('content')
    <main class="w-full flex-grow p-6">
        <x-bladewind.button color="purple" class="mb-4">
            <a href="{{ route('projects.index') }}">Back</a>

        </x-bladewind.button>

        @if ($project->is_active)
        <form action="{{ route('project.completed', $project) }}" method="post">
            @csrf

            <x-bladewind.button color="red" class="mb-4" can_submit="true"> Project Completed</x-bladewind.button>

        </form>
        @endif

        <div class="w-full max-w-md m-auto">
            @if (session('success'))
                <x-bladewind.alert>
                    {{ session('success') }}
                </x-bladewind.alert>
            @endif
            @if (session('error'))
                <x-bladewind.alert type="error">
                    {{ session('error') }}
                </x-bladewind.alert>
            @endif

        </div>


        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

            <table class="w-full  text-sm text-left text-gray-500 dark:text-gray-400">
                <tbody>
                    <tr class="border-b dark:bg-gray-800 dark:border-gray-700  bg-white ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            Name
                        </th>
                        <td class="px-6 py-4">
                            {{ $project->name }}
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-50">
                        <td class="px-6 py-4 capitalize">
                            Client
                        </td>
                        <td class="px-6 py-4">
                            {{ $project->client->name }}
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-50">
                        <td class="px-6 py-4">
                            Description
                        </td>
                        <td class="px-6 py-4">
                            {{ $project->description }}
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-50">
                        <td class="px-6 py-4">
                            Opening Date
                        </td>
                        <td class="px-6 py-4">
                            {{ $project->start_date }}
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-50">
                        <td class="px-6 py-4 capitalize">
                            Deadline
                        </td>
                        <td class="px-6 py-4">
                            Project Deadline Ends In: <span class="py-2 px-4 bg-yellow-300 text-white rounded-lg">
                                {{ \Carbon\Carbon::now()->diffInDays($project->end_date) }}</span> Days
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-50">
                        <td class="px-6 py-4 capitalize">
                            active
                        </td>
                        <td class="px-6 py-4">
                            @if ($project->is_active)
                                <span class="bg-blue-400 cursor-default text-white px-2 py-1 rounded-md">Yes</span>
                            @else
                                <span class="bg-yellow-400 cursor-default text-white px-2 py-1 rounded-md">No</span>
                            @endif
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-50">
                        <td class="px-6 py-4 capitalize">User</td>
                        <td class="px-6 py-4">{{ $project->user->name }}</td>
                    </tr>
                    <tr class="border-b bg-gray-50">
                        <td class="px-6 py-4 capitalize">Tasks</td>
                        <td>
                            <div class="flex flex-col">

                                @foreach ($project->tasks as $task)
                                    <div class="border-b-2">
                                        <h2 class="text-lg inline">{{ $task->name }}</h2> |
                                        {{ $task->user->name }} |
                                        {{ $task->is_active ? 'Active' : 'Inactive' }}
                                        {{-- <a href="{{ route('task.softdelete', $task) }}" class="inline bg-red-400 px-4 py-2 text-white rounded-md"><i class="fas fa-trash"></i></a> --}}
                                        <form action="{{ route('task.softdelete', $task) }}" method="post">
                                            @csrf
                                            <button type="submit"
                                                class="inline bg-red-400 px-4 py-2 text-white rounded-md"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                @endforeach

                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
            <div class="p-4 bg-white mt-8">
                <h1 class="font-semibold text-2xl mb-4">Project Files</h1>
                <div class="flex flex-wrap justify-between justify-items-start justify-self-start">
                    @foreach ($project->getMedia('project_files') as $media)
                        <div class="w-5/12 mb-4">
                            <img src="{{ asset('storage/project/') . '/' . $media->id . '/' . $media->file_name }}"
                                alt="{{ $media->name }}" class="w-full h-auto">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
@endsection
