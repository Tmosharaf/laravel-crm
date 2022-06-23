<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct() {
        $this->middleware('role:admin|user')->only('index', 'show');
        $this->middleware('role:admin')->only('create', 'store', 'edit', 'update', 'destroy');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::with(['user', 'client'])->paginate(4);

        if(auth()->user()->hasRole('user')){
            $projects = Project::with(['user', 'client'])
                        ->where('user_id', auth()->id())
                        ->paginate(1);
        }

        return view('admin.project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::where('active', 1)->get([ 'id', 'name']);
        $users = User::all('id', 'name');
        return view('admin.project.create', compact('clients', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
        $validated = $request->validate([
            'name'  =>  'string|required|min:3',
            'description'   =>  'string|min:3',
            'start_date'    =>  'date_format:Y-m-d',
            'end_date'      =>  'date_format:Y-m-d',
            'client_id'     =>  'exists:clients,id',
            'user_id'       =>  'exists:users,id',
        ]) + [
            'is_active' =>  1 //Default Value for project active or not
        ];
        $project = Project::create($validated);
        


        if($request->hasFile('project_files')){
            $project->addMultipleMediaFromRequest(['project_files'])
            ->each(function($project){
                $project->toMediaCollection('project_files', 'project');
            });
        }

        return redirect()->route('projects.index')->with('success', 'Project Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $clients = Client::where('active', 1)->get([ 'id', 'name']);
        $users = User::all('id', 'name');
        return view('admin.project.edit', compact('project', 'clients', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name'  =>  'string|required|min:3',
            'description'   =>  'string|min:3',
            'start_date'    =>  'date_format:Y-m-d',
            'end_date'      =>  'date_format:Y-m-d',
            'client_id'     =>  'exists:clients,id',
            'user_id'       =>  'exists:users,id',
        ]) + [
            'is_active' =>  1 //Default Value for project active or not
        ];
        
        $project->update($validated);
    
        if($request->hasFile('project_files')){
            $project->addMultipleMediaFromRequest(['project_files'])
            ->each(function($project){
                $project->toMediaCollection('project_files', 'project');
            });
        }

        return back()->with('success', 'Project Created Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project Deleted Successfully');
    }

    public function deleteMedia(Project $project, $media_id)
    {
        $project->deleteMedia($media_id);
        return back()->with('success', 'Project File Deleted Successfully');        
    }

    public function projectCompleted(Project $project)
    {
        if($project->is_active){
            $project->is_active = 0;
            $project->save();
            return back()->with('success', 'Project Completed Successfully');  
        }else{
            return back()->with('success', 'Project Completed Already');
        }
          

    }



}
