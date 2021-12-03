<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('dashboard.users.index',compact('users'));
    }

    public function create()
    {
        return view('dashboard.users.create');

    }

    public function store(UserRequest $request)
    {
        $userData = $request->except(['password','password_confimation' ,'permissions']);
        $userData['password'] = Hash::make($request->password);
        $user = User::create($userData);

        $user->attachRole('admin');
        $user->syncPermissions($request->permissions);

        session()->flash('success' , __('site.added_successfully'));
        return redirect()->route('dashboard.users.index');
    }
 
    public function edit(User $user)
    {
        //
    }


    public function update(Request $request, User $user)
    {
        //
    }
 
    public function destroy(User $user)
    {
        //
    }
}
