<?php

namespace App\Observers;

use App\Models\Archive;
use App\Services\AuditLogService;

class ArchiveObserver
{
    public function __construct(
        private AuditLogService $audit
    ) {}

    public function created(Archive $archive): void
    {
        $this->audit->logCreated($archive);
    }

    public function updated(Archive $archive): void
    {
        $this->audit->logUpdated(
            $archive,
            $archive->getOriginal(),
            $archive->getChanges()
        );
    }

    public function deleted(Archive $archive): void
    {
        $this->audit->logDeleted($archive);
    }

    public function restored(Archive $archive): void
    {
        $this->audit->logRestored($archive);
    }
}
