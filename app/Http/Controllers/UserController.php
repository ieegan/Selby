<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('dashboard.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('dashboard.users.create', compact('roles'));
    }

    public function store()
    {
        request()->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'nullable|unique:users,email',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => request()->name,
            'username' => request()->username,
            'email' => request()->email,
            'password' => bcrypt(request()->password),
        ]);

        $user->syncRoles(request()->role);

        return redirect()->route('user.index')->with('status', 'User creates!');
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return view('dashboard.users.edit', compact('user','roles'));
    }

    public function update(User $user)
    {
        request()->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,'.$user->id,
            'email' => 'nullable|unique:users,email,'.$user->id,
        ]);

        $update = [
            'name' => request()->name,
            'username' => request()->username,
            'email' => request()->email
        ];

        if (request()->password){
            $update['password'] = bcrypt(request()->password);
        }

        $user->update($update);

        $user->syncRoles(request()->role);

        return redirect()->route('user.index')->with('status', 'User updated!');
    }
}
