<?php

namespace App\Listeners;

use App\Services\AuditLogService;
use Illuminate\Auth\Events\Logout;

class LogSuccessfulLogout
{
    public function __construct(
        private AuditLogService $audit
    ) {}

    public function handle(Logout $event): void
    {
        if ($event->user) {
            $this->audit->logAuth('logout', $event->user->id);
        }
    }
}
