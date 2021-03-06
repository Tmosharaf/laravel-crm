<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Redis\Limiters\DurationLimiterBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tag;

class TaskController extends Controller
{

    public function __construct() {
        $this->middleware('role:admin|user')->only('index', 'show');
        $this->middleware('role:admin')->only('create', 'store', 'edit', 'update', 'destroy', 'softDelete');

    }


    public function index(Request $request)
    {


        if (auth()->user()->hasRole('admin')) {


            if ($request->filter === 'softdeleted') {
                $tasks = Task::with('user', 'project')
                    ->onlyTrashed()
                    ->paginate();
            }elseif ($request->filter === 'all') {
                $tasks = Task::with('user', 'project')
                    ->withTrashed()
                    ->paginate(4);
            }elseif($request->filter == null) {
                $tasks = Task::with('user', 'project')
                    ->paginate(4);
            }

        } else {
            $tasks = Auth::user()->tasks()
            ->with('user', 'project')
            ->paginate(4);
        }

        return view('admin.task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::all('id', 'name');
        $users = User::all('id', 'name');

        return view('admin.task.create', compact('projects', 'users'));
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
            'project_id'     =>  'exists:projects,id',
            'user_id'       =>  'exists:users,id',
        ]) + [
            'is_active' =>  1, //Default Value for project active or not
            'client_id' =>  Project::find($request->project_id)->client_id,
        ];
        $task = Task::create($validated);



        if ($request->hasFile('task_files')) {
            $fileAdders = $task
                ->addMultipleMediaFromRequest(['task_files'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('task_files', 'task');
                });
        }


        return redirect()->route('tasks.index')->with('success', 'Task Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('admin.task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }


    public function softDelete(Task $task)
    {
        $task->delete();

        return back()->with('success', 'Task Soft Deleted Successfully');
    }



    public function destroy(Task $task)
    {
        $task->forceDelete();

        return back()->with('success', 'Task Deleted Successfully');
    }

    public function restore($id)
    {
        $task = Task::withTrashed()->findOrFail($id)->restore();


        return back()->with('success', 'Task Restored Successfully');
    }

    public function taskCompleted(Task $task)
    {
        if ($task->is_active) {
            $task->is_active = 0;
            $task->save();
            return back()->with('success', 'Task Completed Successfully');
        } else {
            return back()->with('success', 'Task Completed Already');
        }
    }
}
