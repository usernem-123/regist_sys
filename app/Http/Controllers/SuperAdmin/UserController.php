<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        $users = User::query()
            ->with('roles:id,name')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->trim()->toString();

                $query->where(function ($query) use ($search) {
                    $query->where('name', 'ilike', "%{$search}%")
                        ->orWhere('email', 'ilike', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('super-admin/users/index', [
            'users' => $users,
            'filters' => $request->only('search'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('super-admin/users/create', [
            'roles' => Role::query()
            ->where('name', '!=', 'Super Admin')
            ->orderBy('name')
            ->get(['id', 'name']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => [
                'required',
                'string',
                Rule::exists('roles', 'name'),
                Rule::notIn(['Super Admin']),
            ],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
            ]);

            $user->is_active = $validated['is_active'] ?? true;
            $user->save();

            $user->assignRole($validated['role']);
        });

        return redirect()
            ->route('superadmin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user): Response
    {
        $user->load('roles:id,name');

        return Inertia::render('super-admin/users/edit', [
            'user' => $user,
            'roles' => Role::query()
                ->when(
                    !$user->hasRole('Super Admin'),
                    fn ($query) => $query->where('name', '!=', 'Super Admin')
                )
                ->orderBy('name')
                ->get(['id', 'name']),
                    ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $roleRule = $user->hasRole('Super Admin')
        ? Rule::in(['Super Admin'])
        : Rule::notIn(['Super Admin']);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => [
                'required',
                'string',
                Rule::exists('roles', 'name'),
                $roleRule,
            ],
            'is_active' => ['required', 'boolean'],
        ]);

        if (
            $user->hasRole('Super Admin') &&
            (
                $validated['role'] !== 'Super Admin' ||
                !$validated['is_active']
            )
        ) {
            return back()->withErrors([
                'user' => 'A Super Admin role or active status cannot be changed here.',
            ]);
        }

        if ($user->id === $request->user()->id && !$validated['is_active']) {
            return back()->withErrors([
                'user' => 'You cannot deactivate your own account.',
            ]);
        }

        DB::transaction(function () use ($validated, $user) {
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->is_active = $validated['is_active'];

            if (!empty($validated['password'])) {
                $user->password = $validated['password'];
            }

            $user->save();
            $user->syncRoles([$validated['role']]);
        });

        return redirect()
            ->route('superadmin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function toggleActive(User $user): RedirectResponse
    {
        if ($user->hasRole('Super Admin')) {
            return back()->withErrors([
                'user' => 'A Super Admin account cannot be deactivated here.',
            ]);
        }

        if ($user->id === request()->user()->id) {
            return back()->withErrors([
                'user' => 'You cannot deactivate your own account.',
            ]);
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return back()->with('success', 'User status updated successfully.');
    }
}