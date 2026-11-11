<?php

namespace App\Observers;

use App\Models\Department;
use App\Services\AuditLogService;

class DepartmentObserver
{
    public function __construct(
        private AuditLogService $audit
    ) {}

    public function created(Department $department): void
    {
        $this->audit->logCreated($department);
    }

    public function updated(Department $department): void
    {
        $this->audit->logUpdated(
            $department,
            $department->getOriginal(),
            $department->getChanges()
        );
    }

    public function deleted(Department $department): void
    {
        $this->audit->logDeleted($department);
    }
}
