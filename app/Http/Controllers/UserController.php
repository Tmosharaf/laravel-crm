<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        $users  = User::with('roles')->paginate(8);

        if(Auth()->user()->roles->first()->name == 'user')
        {
            $users  = User::with('roles')
                        ->where('id', Auth()->user()->id)
                        ->paginate();
        }

        return view('admin.user.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.user.show', compact('user'));
    }

    public function edit(User $user){
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);
        if($validated['password'] == null){
            $validated['password'] = $user->password;
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function updateRole(Request $request, User $user)
    {
        if(Auth::user()->id == $user->id){
            return redirect()->back()->with('error', 'You can not change your own role');
        }
        $user->syncRoles($request->role);
        return redirect()->back()->with('success', 'User role updated successfully');
    }

    public function destroy(User $user){
        if(Auth::id() == $user->id){
            return redirect()->route('users.index')->with('error', 'You can not delete yourself');
        }
        if(Auth::user()->hasRole('user')){
            return redirect()->route('users.index')->with('error', 'You are not permitted.');
        }



        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
