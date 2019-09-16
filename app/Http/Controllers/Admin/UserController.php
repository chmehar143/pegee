<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\ModelFilters\AdminFilters\UserFilter;
use Illuminate\Http\Request;
use App\Http\Requests\EditUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class UserController extends Controller {

    /**
     * Admin authentication
     */
    public function __construct() {
        $this->middleware('admin.auth')->except('logout');
    }

    public function showUsersList(Request $request) {
        $page = "users-list";
        $users = User::filter($request->all(), UserFilter::class)->paginateFilter(5);
        $sampleRequest = Config::get('constants.SAMPLEREQUEST');
        return view('admin.user.show-users-list', [
            'users' => $users,
            'sampleRequest' => $sampleRequest,
            'page' => $page
        ]);
    }

    public function editUserForm($id) {
        $user = User::findOrFail($id);
        return view('admin.user.edit-user-form', ['user' => $user]);
    }

    public function updateUserForm(EditUserRequest $request) {
        if ($request->input('user_id') != "") {
            $user = User::findOrFail($request->input('user_id'));
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->phone_no = $request->input('phone_no');
            $user->gender = $request->input('gender');
            $user->save();
            return redirect()->route('users.list')->with('success', 'User was successfully updated!');
        } else {
            return redirect()->route('users.list')->with('error', 'Some error occour!');
        }
    }

    public function activateUserForm($id) {
        if ($id != "") {
            $user = User::findOrFail($id);
            $user->status = 1;
            $user->save();
            return redirect()->route('users.list')->with('success', 'User was successfully activated!');
        } else {
            return redirect()->route('users.list')->with('error', 'Some error occour!');
        }
    }

    public function deactivateUserForm($id) {
        if ($id != "") {
            $user = User::findOrFail($id);
            $user->status = -1;
            $user->save();
            return redirect()->route('users.list')->with('success', 'User was successfully deactivated!');
        } else {
            return redirect()->route('users.list')->with('error', 'Some error occour!');
        }
    }

    public function blockUserForm($id) {
        if ($id != "") {
            $user = User::findOrFail($id);
            $user->status = 0;
            $user->save();
            return redirect()->route('users.list')->with('success', 'User was successfully blocked!');
        } else {
            return redirect()->route('users.list')->with('error', 'Some error occour!');
        }
    }

    public function enableSampleRequest($id) {
        if ($id != "") {
            $user = User::findOrFail($id);
            $user->sample_request = 1;
            $user->save();
            return redirect()->route('users.list')->with('success', 'Sample request was successfully enabled!');
        } else {
            return redirect()->route('users.list')->with('error', 'Some error occour!');
        }
    }

    public function disableSampleRequest($id) {
        if ($id != "") {
            $user = User::findOrFail($id);
            $user->sample_request = 2;
            $user->save();
            return redirect()->route('users.list')->with('success', 'Sample request was successfully diabled!');
        } else {
            return redirect()->route('users.list')->with('error', 'Some error occour!');
        }
    }

}
