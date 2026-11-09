<?php

namespace App\Policies;

use App\Models\Archive;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArchivePolicy
{
    /**
     * Admin: Everyone. User: Department Archives
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Admin: Everyone. User: Archives of his department only.
     */
    public function view(User $user, Archive $archive): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $archive->department_id === $user->department_id;
    }

    /**
     * Admin: All departments User: Only his department.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Admin: Everyone. User: Only what they created + in their department.
     */
    public function update(User $user, Archive $archive): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $archive->department_id === $user->department_id
            && $archive->created_by === $user->id;
    }

    /**
     * Admin: Everyone. User: Only what they created.
     */
    public function delete(User $user, Archive $archive): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $archive->department_id === $user->department_id
            && $archive->created_by === $user->id;
    }

    /**
     * Recover deleted archives.
     */
    public function restore(User $user, Archive $archive): bool
    {
        return $user->isAdmin()
            || ($archive->department_id === $user->department_id
                && $archive->created_by === $user->id);
    }

    /**
     * Download archive files.
     */
    public function download(User $user, Archive $archive): bool
    {
        return $this->view($user, $archive);
    }

    /**
     * Add a file to an existing archive
     */
    public function uploadFile(User $user, Archive $archive): bool
    {
        return $this->view($user, $archive);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Archive $archive): bool
    {
        return false;
    }
}
