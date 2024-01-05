<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserProfile extends Controller
{
    function user_profile() {
        return view('admin.user_info_update.user_profile');
    }

    function basic_update(Request $req) {
       User::find(Auth::id())->update([
        'name'=>$req->name,
        'email'=>$req->email,
       ]);

       return back()->with('info_updated', 'Information Updated!');
    }

    function password_update(UserPasswordRequest $req) {
        $user = User::find(Auth::id()); 

        if(Hash::check($req->current_password, $user->password)) {
            $user->update([
                'password'=>Hash::make($req->password),
            ]);

            return back()->with('password_update', 'Password Updated!');
        }else {
            return back()->with('wrong_password', "Current password doesn't match!");
        }
    }

    function photo_update(Request $req) {
        $req->validate([
            'photo'=>'required',
            'photo'=>'mimes:jpg, png, webp',
            'photo'=>'file|max:1024',
            'photo'=>'dimensions:min_width=200,min_height=200',
            // 'photo'=>Rule::dimensions()->maxWidth(700)->maxHeight(700)->ratio(3 / 2),
        ]);

        $photo = $req->photo;
        $extension = $photo->extension();
        $file_name = Auth::id().'.'.$extension;
        $upload_path = 'uploads/users_photo/';

        if(Auth::user()->photo == null) {
            Image::make($photo)->save(public_path($upload_path.$file_name));

            User::find(Auth::id())->update([
                'photo'=>$file_name,
            ]);

            return back()->with('uploaded', 'Profile Photo Updated!');
        }else {
            $present_image = public_path($upload_path.Auth::user()->photo);
            unlink($present_image);

            Image::make($photo)->save(public_path($upload_path.$file_name));

            User::find(Auth::id())->update([
                'photo'=>$file_name,
            ]);

            return back()->with('uploaded', 'Profile Photo Updated!');
        }
    }
}
