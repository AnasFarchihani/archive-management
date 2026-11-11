<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{

    public function index(Request $request): View
    {
        $query = User::with('department');

        // Search by name or email

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtering by role

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filtering by status (active/inactive)

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active === '1');
        }

        // Filtering by departments

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        $users = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'departments' => Department::orderBy('name')->get(),
            'roles' => UserRole::cases(),
        ]);
    }

    public function create(): View
    {
        $departments = Department::orderBy('name')->get();
        $roles = UserRole::cases();

        return view('admin.users.create', compact('departments', 'roles'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['is_active'] = $request->boolean('is_active', true);

        User::create($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $departments = Department::orderBy('name')->get();
        $roles = UserRole::cases();

        return view('admin.users.edit', compact('user', 'departments', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_active'] = $request->boolean('is_active');
        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->update(['is_active' => false]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Utilisateur désactivé avec succès.');
    }
}
