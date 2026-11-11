<?php

namespace App\Observers;

use App\Models\User;
use App\Services\AuditLogService;

class UserObserver
{
    public function __construct(
        private AuditLogService $audit
    ) {}

    public function created(User $user): void
    {
        $this->audit->logCreated($user);
    }

    public function updated(User $user): void
    {
        $this->audit->logUpdated(
            $user,
            $user->getOriginal(),
            $user->getChanges()
        );
    }

    public function deleted(User $user): void
    {
        $this->audit->logDeleted($user);
    }
}
