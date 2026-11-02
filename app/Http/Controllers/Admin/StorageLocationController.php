<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStorageLocationRequest;
use App\Http\Requests\UpdateStorageLocationRequest;
use App\Models\StorageLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StorageLocationController extends Controller
{

    public function index(): View
    {
        $locations = StorageLocation::withCount('archives')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.storage-locations.index', compact('locations'));
    }

    public function create(): View
    {
        return view('admin.storage-locations.create');
    }

    public function store(StoreStorageLocationRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);

        StorageLocation::create($data);

        return redirect()
            ->route('admin.storage-locations.index')
            ->with('success', 'Emplacement créé avec succès.');
    }

    public function show(StorageLocation $storageLocation): View
    {
        $storageLocation->loadCount('archives');
        return view('admin.storage-locations.show', compact('storageLocation'));
    }

    public function edit(StorageLocation $storageLocation): View
    {
        return view('admin.storage-locations.edit', compact('storageLocation'));
    }

    public function update(UpdateStorageLocationRequest $request, StorageLocation $storageLocation): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $storageLocation->update($data);

        return redirect()
            ->route('admin.storage-locations.index')
            ->with('success', 'Emplacement mis à jour avec succès.');
    }

    public function destroy(StorageLocation $storageLocation): RedirectResponse
    {
        $storageLocation->update(['is_active' => false]);

        return redirect()
            ->route('admin.storage-locations.index')
            ->with('success', 'Emplacement désactivé avec succès.');
    }
}
