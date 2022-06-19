<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;


Route::get('/auto-login', function () {
    abort_unless(app()->environment('local'), 403);


    auth()->login(User::first());

    return redirect()->route('dashboard.index');
})->name('login.devs')->middleware('guest');






Route::get('/', function () {
    return view('auth.login');
});

require __DIR__ . '/auth.php';



Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function () {

    Route::get('/', [AdminController::class, 'index'])
        ->name('dashboard.index');

    Route::put('users/{user}/role/edit', [UserController::class, 'updateRole'])->name('users.role.edit');

    Route::get('project/{project}/media/{media}/delete', [ProjectController::class, 'deleteMedia'])
        ->name('project.media.delete');

    Route::get('project/task/{task}/softdelete', [TaskController::class, 'softDelete'])
        ->name('task.softdelete');
    Route::get('project/task/{task}/restore', [TaskController::class, 'restore'])
        ->name('task.restore');
    Route::resources([
        'users'     => UserController::class,
        'clients'   =>  ClientController::class,
        'projects'  =>  ProjectController::class,
        'tasks'  =>     TaskController::class
    ]);

    //TODO: Implements Softdeletes
    // API Routes and Controllers
// API Eloquent Resources
// API Auth with Sanctum
// Override API Error Handling and Status Codes
// Try-Catch and Laravel Exceptions
// Customizing Error Pages
// Mailables and Mail Facade
// Notifications System: Email
// Automated Tests for CRUD Operations



});
