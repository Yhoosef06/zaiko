<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\RolePermission;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        $isAdmin = Auth::user()->roles->contains('name', 'admin') ? true : false;
        $rolePermissions = RolePermission::with('role', 'permission')->get();
        // Fetch manager and borrower roles specifically
        $managerRole = Role::where('name', 'manager')->first();
        $borrowerRole = Role::where('name', 'borrower')->first();

        // Get manager and borrower permissions
        $managerPermissions = $managerRole ? $managerRole->permissions : [];
        $borrowerPermissions = $borrowerRole ? $borrowerRole->permissions : [];

        $roles = Role::all();
        $permissions = Permission::all();
        return view('pages.admin.listOfRoles')->with(compact('managerPermissions', 'borrowerPermissions', 'roles', 'permissions', 'isAdmin'));
    }

    public function store(Request $request)
    {
        $role_id = $request->input('role_id');
        $permission_id = $request->input('permission_id');
        $role = Role::find($role_id);
        try {
            $existingPermission = RolePermission::where('role_id', $role_id)
                ->where('permission_id', $permission_id)
                ->exists();

            if ($existingPermission) {
                return back()->with('danger', 'Permission is already assigned to ' . $role->name . '.');
            }

            RolePermission::create([
                'role_id' => $role_id,
                'permission_id' => $permission_id,
            ]);

        } catch (\Throwable $th) {
            return back()->with('danger', 'There was an error when adding the permission');
        }

        return back()->with('success', 'Permission added successfully.');
    }
    public function delete($id)
    {
        $permission = Permission::find($id);

        if (!$permission) {
            return back()->with('danger', 'Permission not found.');
        }
        $permission->roles()->detach();
        RolePermission::where('permission_id', $id)->delete();
        return back()->with('success', 'Permission removed successfully.');
    }


}
