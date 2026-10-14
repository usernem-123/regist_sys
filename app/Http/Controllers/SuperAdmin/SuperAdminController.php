<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SuperAdminController extends Controller
{
    
public function index(): Response
{
    return Inertia::render('super-admin/dashboard', [
        'stats' => [
            'users' => User::count(),
            'activeUsers' => User::where('is_active', true)->count(),
            'students' => DB::table('students')->count(),
            'programs' => DB::table('programs')->count(),
            'academicRecords' => DB::table('academic_records')->count(),
            'documentRequests' => DB::table('document_requests')->count(),
            'roles' => Role::count(),
            'permissions' => Permission::count(),
        ],

        'roleCounts' => Role::query()
            ->withCount('users')
            ->orderBy('name')
            ->get(['id', 'name', 'users_count']),

        'recentUsers' => User::query()
            ->latest('created_at')
            ->limit(5)
            ->get(['id', 'name', 'email', 'created_at']),
    ]);
}

}
