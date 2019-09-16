<?php

namespace App\Http\Controllers\Admin;

use App\AdminUser;
use App\ModelFilters\AdminFilters\AdminUserFilter;
use Illuminate\Http\Request;
use App\Http\Requests\AdminUsersRequest;
use App\Http\Controllers\Controller;

class AdminUserController extends Controller {

    /**
     * Admin authentication
     */
    public function __construct() {
        $this->middleware('admin.auth')->except('logout');
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function showAdminsList(Request $request) {
        $page = "admins-list";
        $admin_users = AdminUser::filter($request->all(), AdminUserFilter::class)->paginateFilter(5);
        return view('admin.admin-user.show-admins-list', ['admin_users' => $admin_users, 'page' => $page]);
    }

    /**
     * 
     * Show admin form
     */
    public function showAdminForm() {
        $page = "create-admin";
        return view('admin.admin-user.show-admin-form', ['page' => $page]);
    }

    /**
     * 
     * @param \App\Http\Controllers\Admin\AdminUsersRequest $request
     * @return type
     */
    public function saveAdminForm(AdminUsersRequest $request) {
        $admin_user = AdminUser::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => bcrypt($request->input('password')),
                    'role' => 1
        ]);
        $admin_user->save();

        return redirect()->route('admins.list')->with('success', 'Admin was successfully added!');
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function editAdminForm($id) {
        $admin_user = AdminUser::findOrFail($id);
        return view('admin.admin-user.edit-admin-form', ['admin_user' => $admin_user]);
    }

    /**
     * 
     * @param \App\Http\Controllers\Admin\AdminUsersRequest $request
     * @return type
     */
    public function updateAdminForm(AdminUsersRequest $request) {
        if ($request->input('admin_id') != "") {
            $admin_user = AdminUser::findOrFail($request->input('admin_id'));
            $admin_user->name = $request->input('name');
            $admin_user->email = $request->input('email');
            $admin_user->password = bcrypt($request->input('password'));
            $admin_user->role = 1;
            $admin_user->save();
            return redirect()->route('admins.list')->with('success', 'Admin was successfully updated!');
        } else {
            return redirect()->route('admins.list')->with('error', 'Some error occour!');
        }
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function deleteAdminForm($id) {
        if ($id != "") {
            $user = AdminUser::findOrFail($id);
            $user->delete();
            return redirect()->route('admins.list')->with('success', 'Admin was successfully deleted!');
        } else {
            return redirect()->route('admins.list')->with('error', 'Some error occour!');
        }
    }

}
