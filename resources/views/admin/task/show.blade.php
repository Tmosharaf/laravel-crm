@extends('layouts.admin')
@section('content')
    <main class="w-full flex-grow p-6">
        <x-bladewind.button color="purple" class="mb-4">
            <a href="{{ route('tasks.index') }}">Back</a>

        </x-bladewind.button>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

            <table class="w-full  text-sm text-left text-gray-500 dark:text-gray-400">
                <tbody>
                    <tr class="border-b dark:bg-gray-800 dark:border-gray-700  bg-white ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            Name
                        </th>
                        <td class="px-6 py-4">
                            {{ $task->name }}
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-50">
                        <td class="px-6 py-4 capitalize">
                            Project Name
                        </td>
                        <td class="px-6 py-4">
                            <a class="text-blue-600" href="{{ route('projects.show', $task->project->id) }}">{{ $task->project->name }}</a>
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-50">
                        <td class="px-6 py-4 capitalize">
                            Client Name
                        </td>
                        <td class="px-6 py-4">
                            {{ $task->project->client->name }}
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-50">
                        <td class="px-6 py-4">
                            Description
                        </td>
                        <td class="px-6 py-4">
                            {{ $task->description }}
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-50">
                        <td class="px-6 py-4">
                            Opening Date
                        </td>
                        <td class="px-6 py-4">
                            {{ $task->start_date }}
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-50">
                        <td class="px-6 py-4 capitalize">
                            Deadline
                        </td>
                        <td class="px-6 py-4">
                            task Deadline Ends In: <span class="py-2 px-4 bg-yellow-300 text-white rounded-lg">
                                {{ \Carbon\Carbon::now()->diffInDays($task->end_date) }}</span> Days
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-50">
                        <td class="px-6 py-4 capitalize">
                            active
                        </td>
                        <td class="px-6 py-4">
                            {{ $task->status ? 'Active' : 'Inactive' }}
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-50">
                        <td class="px-6 py-4 capitalize">User</td>
                        <td class="px-6 py-4">{{ $task->user->name }}</td>
                    </tr>

                </tbody>
            </table>
            <div class="p-4 bg-white mt-8">
                <h1 class="font-semibold text-2xl mb-4">task Files</h1>
                <div class="flex flex-wrap justify-between justify-items-start justify-self-start" >
                    @foreach ($task->getMedia('task_files') as $media)
                        <div class="w-5/12 mb-4">
                            <img src="{{ asset('storage/task/') .'/'.  $media->id .'/'. $media->file_name }}" alt="{{ $media->name }}" 
                            class="w-full h-auto">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
@endsection
