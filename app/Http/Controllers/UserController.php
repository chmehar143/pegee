<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UsersRequest;
use File;
use Intervention\Image\Facades\Image;
use Auth;

class UserController extends Controller {

    public function editUserProfile() {
        $page = 'edit-profile';
        $id = Auth::user()->id;
        if (trim($id) != "") {
            $user = User::findOrFail($id);
            return view('user.edit-user-profile', ['user' => $user, 'page' => $page, 'title' => 'Profile']);
        } else {
            return redirect()->route('edit.profile')->with('error', 'Some Error Occour!');
        }
    }

    public function updateUserProfile(UsersRequest $request) {
        if (Auth::user()->id != "") {
            $user = User::findOrFail(Auth::user()->id);
            if (!is_null($request->file('profile_picture'))) {
                if (file_exists(public_path('uploads/propic/thumbnail/' . Auth::user()->profile_picture)) && is_file(public_path('uploads/propic/thumbnail/' . Auth::user()->profile_picture))) {
                    unlink(public_path('uploads/propic/thumbnail/' . Auth::user()->profile_picture));
                }
                if (file_exists(public_path('uploads/propic/original/' . Auth::user()->profile_picture)) && is_file(public_path('uploads/propic/original/' . Auth::user()->profile_picture))) {
                    unlink(public_path('uploads/propic/original/' . Auth::user()->profile_picture));
                }
                $thumbnail_path = public_path('uploads/propic/thumbnail/');
                $original_path = public_path('uploads/propic/original/');
                $file_name = 'user_' . Auth::user()->id . '_' . str_random(32) . '.' . $request['profile_picture']->extension();
                File::makeDirectory($thumbnail_path, $mode = 0755, true, true);
                File::makeDirectory($original_path, $mode = 0755, true, true);
                Image::make($request['profile_picture'])
                        ->resize(261, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })
                        ->save($original_path . $file_name)
                        ->resize(90, 90)
                        ->save($thumbnail_path . $file_name);
                $user->profile_picture = $file_name;
            }
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->phone_no = $request->input('phone_no');
            $user->gender = $request->input('gender');
            $user->save();
            return redirect()->route('edit.profile')->with('success', 'Profile was successful updated!');
        } else {
            return redirect()->route('edit.profile')->with('error', 'Some Error Occour!');
        }
    }

}
