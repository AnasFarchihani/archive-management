<?php

namespace App\Observers;

use App\Models\StorageLocation;
use App\Services\AuditLogService;

class StorageLocationObserver
{
    public function __construct(
        private AuditLogService $audit
    ) {}

    public function created(StorageLocation $location): void
    {
        $this->audit->logCreated($location);
    }

    public function updated(StorageLocation $location): void
    {
        $this->audit->logUpdated(
            $location,
            $location->getOriginal(),
            $location->getChanges()
        );
    }

    public function deleted(StorageLocation $location): void
    {
        $this->audit->logDeleted($location);
    }
}
