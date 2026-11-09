<?php

namespace App\Http\Controllers;

use App\Enums\ArchiveStatus;
use App\Enums\DocumentType;
use App\Http\Requests\StoreArchiveRequest;
use App\Http\Requests\UpdateArchiveRequest;
use App\Models\Archive;
use App\Models\Department;
use App\Models\StorageLocation;
use App\Services\ArchiveFileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArchiveController extends Controller
{
    public function __construct(
        private ArchiveFileService $fileService
    ) {}

    public function index(Request $request): View
    {
        $query = Archive::with(['department', 'storageLocation', 'creator']);

        // Departments isolation
        if (! $request->user()->isAdmin()) {
            $query->where('department_id', $request->user()->department_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('document_number', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('sender', 'like', "%{$search}%");
            });
        }

        // Filtering
        if ($request->filled('status')) {
            $query->where('archive_status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('document_type', $request->type);
        }
        if ($request->filled('department_id') && $request->user()->isAdmin()) {
            $query->where('department_id', $request->department_id);
        }

        $archives = $query->latest()->paginate(15)->withQueryString();

        return view('archives.index', [
            'archives' => $archives,
            'statuses' => ArchiveStatus::cases(),
            'types' => DocumentType::cases(),
            'departments' => $request->user()->isAdmin()
                ? Department::orderBy('name')->get()
                : collect(),
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Archive::class);

        return view('archives.create', [
            'statuses' => ArchiveStatus::cases(),
            'types' => DocumentType::cases(),
            'locations' => StorageLocation::where('is_active', true)->orderBy('name')->get(),
            'departments' => $request->user()->isAdmin()
                ? Department::where('is_active', true)->orderBy('name')->get()
                : collect(),
        ]);
    }

    public function store(StoreArchiveRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Determine the section
        if ($request->user()->isAdmin()) {
            $data['department_id'] = $request->input('department_id');
        } else {
            $data['department_id'] = $request->user()->department_id;
        }

        $data['created_by'] = $request->user()->id;

        $archive = Archive::create($data);

        // Upload files
        if ($request->hasFile('files')) {
            $this->fileService->uploadFiles(
                $archive,
                $request->file('files'),
                $request->user()->id
            );
        }

        return redirect()
            ->route('archives.show', $archive)
            ->with('success', 'Archive créée avec succès.');
    }

    public function show(Archive $archive): View
    {
        $this->authorize('view', $archive);

        $archive->load(['department', 'storageLocation', 'creator', 'files.uploader']);

        return view('archives.show', compact('archive'));
    }

    public function edit(Archive $archive): View
    {
        $this->authorize('update', $archive);

        return view('archives.edit', [
            'archive' => $archive,
            'statuses' => ArchiveStatus::cases(),
            'types' => DocumentType::cases(),
            'locations' => StorageLocation::where('is_active', true)->orderBy('name')->get(),
            'departments' => Department::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateArchiveRequest $request, Archive $archive): RedirectResponse
    {
        $data = $request->validated();

        if ($request->user()->isAdmin()) {
            $data['department_id'] = $request->input('department_id');
        }

        $archive->update($data);

        // Upload new files if available
        if ($request->hasFile('files')) {
            $this->fileService->uploadFiles(
                $archive,
                $request->file('files'),
                $request->user()->id
            );
        }

        return redirect()
            ->route('archives.show', $archive)
            ->with('success', 'Archive mise à jour avec succès.');
    }

    public function destroy(Archive $archive): RedirectResponse
    {
        $this->authorize('delete', $archive);

        $archive->delete(); // Soft Delete

        return redirect()
            ->route('archives.index')
            ->with('success', 'Archive supprimée avec succès.');
    }

    /**
     * View deleted archives (Admin only).
     */
    public function trashed(Request $request): View
    {
        if (! $request->user()->isAdmin()) {
            abort(403);
        }

        $archives = Archive::onlyTrashed()
            ->with(['department', 'creator'])
            ->latest('deleted_at')
            ->paginate(15);

        return view('archives.trashed', compact('archives'));
    }

    /**
     * Recover a deleted archive.
     */
    public function restore(Request $request, int $id): RedirectResponse
    {
        $archive = Archive::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $archive);

        $archive->restore();

        return redirect()
            ->route('archives.show', $archive)
            ->with('success', 'Archive restaurée avec succès.');
    }
}
