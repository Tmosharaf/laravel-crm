@extends('layouts.admin')

@section('content')

    <main class="w-full flex-grow p-6 bg-gray-50">
        <h1 class="text-3xl text-black pb-2">Create Client Profile</h1>
        <x-bladewind.button color="purple" class="mb-4">
            <a href="{{ route('clients.index') }}">Back</a>

        </x-bladewind.button>
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
                <x-bladewind.alert type="error">
                    {{ session('error') }}
                </x-bladewind.alert>
            @endif

        </div>
        @role('admin')
            <form action="{{ route('projects.update', $project) }}" enctype="multipart/form-data" method="post" class="w-full max-w-2xl mx-auto">
                @csrf
                @method('PUT')
                <div class="mb-6 ">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                        Project Name
                    </label>
                    <input type="text" name="name" id="name" value="{{ $project->name }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                        Project Description
                    </label>
                    <x-bladewind.textarea name="description" selected_value="{{ $project->description }}"/>
                </div>
                <div class="mb-6 flex flex-row space-x-2">
                    <div class="w-1/2">
                        <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">
                            Start Date
                        </label>
                        <x-bladewind.datepicker name="start_date" default_date="{{ $project->start_date }}" />
                    </div>
                    <div class="w-1/2">
                        <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">
                            End Date
                        </label>
                        <x-bladewind.datepicker name="end_date" default_date="{{ $project->end_date }}" />
                    </div>
                </div>

                <div class="mb-6">
                    <label for="clients" class="block text-gray-700 text-sm font-bold mb-2">
                        Clients
                    </label>
                    
                    <select id="clients" name="client_id"
                        class="bg-white border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option >Choose a Client</option>
                        @foreach ($clients as $client)
                            <option
                                {{ $project->client_id == $client->id ? 'selected' : '' }}
                                value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>

                </div>
                <div class="mb-6">
                    <label for="users" class="block text-gray-700 text-sm font-bold mb-2">
                        users
                    </label>
                    <select id="users" name="user_id"
                        class="bg-white border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected="">Choose an User</option>
                        @foreach ($users as $user)
                        <option
                            {{ $project->user_id == $user->id ? 'selected' : '' }}
                            value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                        
                    </select>

                </div>
                <div class="mb-6">

                    <label class="block text-gray-700 text-sm font-bold mb-2" for="multiple_files">Upload  files</label>
                    <input class="block w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" 
                    id="multiple_files" 
                    name="project_files[]"
                    type="file" 
                    multiple=""
                    >
                                                            
                </div>
                <div class="mb-6">
                    <div class="flex flex-wrap justify-between justify-items-start justify-self-start" >
                        @foreach ($project->getMedia('project_files') as $media)
                            <div class=" mb-4 text-center">
                                <img src="{{ asset('storage/project/') .'/'.  $media->id .'/'. $media->file_name }}" alt="{{ $media->name }}" 
                                class="w-auto max-h-14 mx-2">
                                <a href="{{ route('project.media.delete', [$project, $media]) }}" class="">
                                    <i class="fas fa-trash text-red-500 hover:text-red-600"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

               
                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Update
                    </button>
                </div>
            </form>
        @endrole
    </main>
@endsection
