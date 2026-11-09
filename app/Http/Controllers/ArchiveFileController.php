<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArchiveFileRequest;
use App\Models\Archive;
use App\Models\ArchiveFile;
use App\Services\ArchiveFileService;
use Illuminate\Http\RedirectResponse;

class ArchiveFileController extends Controller
{
    public function __construct(
        private ArchiveFileService $fileService
    ) {}

    /**
     * Uploading files to an existing archive.
     */
    public function store(StoreArchiveFileRequest $request, Archive $archive): RedirectResponse
    {
        $this->fileService->uploadFiles(
            $archive,
            $request->file('files'),
            $request->user()->id
        );

        return redirect()
            ->route('archives.show', $archive)
            ->with('success', 'Fichiers ajoutés avec succès.');
    }

    /**
     * Download file.
     */
    public function download(ArchiveFile $file)
    {
        $this->authorize('download', $file->archive);

        return $this->fileService->downloadFile($file);
    }

    /**
     * Delete file.
     */
    public function destroy(ArchiveFile $file): RedirectResponse
    {
        $this->authorize('update', $file->archive);

        $archive = $file->archive;
        $this->fileService->deleteFile($file);

        return redirect()
            ->route('archives.show', $archive)
            ->with('success', 'Fichier supprimé avec succès.');
    }
}
