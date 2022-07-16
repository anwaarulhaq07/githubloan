<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\User;
use Auth;

class HomeController
{
    public function index()
    {
       $user =  Auth::user();
    //    $users = User::with('role_user')->where('user_id',$user_id)->get();
    //    return $users;
        $user_role_id = DB::table('role_user')->where('user_id',$user->id)->pluck('role_id')->first();
        $role = Role::where('id',$user_role_id)->pluck('title')->first();
        $roles = str_replace('/','-',$role);
        return view('home', compact('roles','user')); 
    }

}
