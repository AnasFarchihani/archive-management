<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function index(Request $request): View
    {
        $query = Department::withCount(['users', 'archives']);

        // Search by name or code
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // Filtering by status (active/inactive)
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active === '1');
        }

        $departments = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.departments.index', compact('departments'));
    }

    public function create(): View
    {
        return view('admin.departments.create');
    }

    public function store(StoreDepartmentRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);

        Department::create($data);

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Département créé avec succès.');
    }

    public function show(Department $department): View
    {
        $department->loadCount(['users', 'archives']);
        return view('admin.departments.show', compact('department'));
    }

    public function edit(Department $department): View
    {
        return view('admin.departments.edit', compact('department'));
    }

    public function update(UpdateDepartmentRequest $request, Department $department): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $department->update($data);

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Département mis à jour avec succès.');
    }

    public function destroy(Department $department): RedirectResponse
    {
        $department->update(['is_active' => false]);

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Département désactivé avec succès.');
    }
}
