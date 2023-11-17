<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\RolePermission;

class RoleController extends Controller
{
    public function index()
    {
        $rolePermissions = RolePermission::with('role', 'permission')->get();
        $groupedRolePermissions = [];

        foreach ($rolePermissions as $rolePermission) {
            $roleName = $rolePermission->role->name; // Update this with the actual attribute holding the role name
            $permissionName = $rolePermission->permission->name;
            $permissionId = $rolePermission->id; // Assuming this holds the ID of the permission

            if (!isset($groupedRolePermissions[$roleName])) {
                $groupedRolePermissions[$roleName] = [];
            }

            $groupedRolePermissions[$roleName][] = [
                'name' => $permissionName,
                'id' => $permissionId,
            ];
        }
        $roles = Role::all();
        $permissions = Permission::all();
        return view('pages.admin.listOfRoles')->with(compact('groupedRolePermissions', 'roles', 'permissions'));
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
                return back()->with('danger', 'Permission is already assigned to '. $role->name .'.');
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
        $permission = RolePermission::find($id);

        if (!$permission) {
            return back()->with('danger', 'Permission not found.');
        }

        $permission->delete();

        return back()->with('success', 'Permission removed successfully.');
    }
}
