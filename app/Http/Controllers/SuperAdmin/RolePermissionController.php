<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('super-admin/permissions/index', [
            'roles' => Role::query()
                ->with('permissions:id,name')
                ->withCount('users')
                ->orderBy('name')
                ->get(['id', 'name']),

            'permissions' => Permission::query()
                ->orderBy('name')
                ->get(['id', 'name']),
        ]);
    }

    public function toggle(
        Role $role,
        Permission $permission
    ): RedirectResponse {
        abort_if(
            $role->name === 'Super Admin',
            403,
            'Super Admin permissions cannot be changed here.'
        );

        abort_if(
            $role->guard_name !== $permission->guard_name,
            422,
            'The role and permission use different guards.'
        );

        if ($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);
        } else {
            $role->givePermissionTo($permission);
        }

        return back()->with('success', 'Role access updated.');
    }
}
