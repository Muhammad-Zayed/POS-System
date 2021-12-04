<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:users_read')->only('index');
        $this->middleware('permission:users_create')->only(['create','store']);
        $this->middleware('permission:users_update')->only(['edit','update']);
        $this->middleware('permission:users_delete')->only('destroy');
    }

    public function index(Request $request)
    {   
        // Search Is Local scope
        $users = User::whereRoleIs('admin')
        ->Search()->latest()->Paginate(10);
        return view('dashboard.users.index',compact('users'));
    }

    public function create()
    {
        return view('dashboard.users.create');

    }

    public function store(UserRequest $request)
    {
        $userData = $request->except(['password','password_confimation' ,'permissions' ,'image']);
        $userData['password'] = Hash::make($request->password);

        if($request->hasFile('image')){
            Image::make($request->image)
            ->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/user_images/'. $request->image->hashName()));
            $userData['image'] = $request->image->hashName();
        }

        $user = User::create($userData);



        $user->attachRole('admin');
        $user->syncPermissions($request->permissions);

        session()->flash('success' , __('site.added_successfully'));
        return redirect()->route('dashboard.users.index');
    }
 
    public function edit(User $user)
    {   

        return view('dashboard.users.edit' ,compact('user'));
    }


    public function update(UserRequest $request, User $user)
    {
        $userData = $request->except(['permissions' , 'image']);
        
        if($request->hasFile('image')){

            if($user->image != 'default.png'){
                Storage::disk('public_uploads')->delete('/user_images/'.$user->image);
            }

            Image::make($request->image)
            ->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/user_images/'. $request->image->hashName()));
            $userData['image'] = $request->image->hashName();
        }
        
        $user->update($userData);


        $user->syncPermissions($request->permissions);

        session()->flash('success' , __('site.updated_successfully'));
        return redirect()->route('dashboard.users.index');
    }
 
    public function destroy(User $user)
    {

        if($user->image != 'default.png'){
            Storage::disk('public_uploads')->delete('/user_images/'.$user->image);
        }
        $user->delete();

        session()->flash('success' , __('site.deleted_successfully'));
        return redirect()->route('dashboard.users.index');

    }
}
