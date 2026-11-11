<?php

namespace App\Listeners;

use App\Services\AuditLogService;
use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin
{
    public function __construct(
        private AuditLogService $audit
    ) {}

    public function handle(Login $event): void
    {
        $this->audit->logAuth('login', $event->user->id);
    }
}
