<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BackendController extends Controller
{
    function dashboard() {
        return view('dashboard');
    }

    function user_list() {
        $users = User::where('id', '!=', Auth::id())->get();

        return view('admin.users_list.user_list', compact('users'));
    }

    function user_delete($user_id) {
        User::find($user_id)->delete();

        return back()->with('user_delete', 'User deleted!');
    }

    function add_user(Request $req) {
        $req->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
            'confirm_password'=>'required',
        ]);

        if($req->password != $req->confirm_password) {
            return back()->with('not_match', "Password doesn't matched!");
        }

        User::insert([
            'name'=>$req->name,
            'email'=>$req->email,
            'password'=>Hash::make($req->password),
        ]);

        return back()->with('user_add', 'User added successfully!');
    }
}
