<?php

namespace App\Services;

use App\Models\Archive;
use App\Models\ArchiveFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArchiveFileService
{
    /**
     * Upload multiple files to an archive.
     */
    public function uploadFiles(Archive $archive, array $files, int $userId): void
    {
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $this->uploadSingle($archive, $file, $userId);
            }
        }
    }

    /**
     * Upload one file.
     */
    public function uploadSingle(Archive $archive, UploadedFile $file, int $userId): ArchiveFile
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $storedName = Str::uuid() . '.' . $extension;
        $year = now()->format('Y');
        $directory = "archives/{$year}";
        $path = $file->storeAs($directory, $storedName, 'private');

        return ArchiveFile::create([
            'archive_id' => $archive->id,
            'original_name' => $file->getClientOriginalName(),
            'stored_name' => $storedName,
            'file_path' => $path,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'extension' => $extension,
            'uploaded_by' => $userId,
        ]);
    }

    /**
     * Delete a file (from storage + database).
     */
    public function deleteFile(ArchiveFile $file): void
    {
        if (Storage::disk('private')->exists($file->file_path)) {
            Storage::disk('private')->delete($file->file_path);
        }

        $file->delete();
    }

    /**
     * Download file.
     */
    public function downloadFile(ArchiveFile $file)
    {
        if (! Storage::disk('private')->exists($file->file_path)) {
            abort(404, 'Fichier introuvable.');
        }

        return Storage::disk('private')->download($file->file_path, $file->original_name);
    }
}
