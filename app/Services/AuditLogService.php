<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLogService
{
    /**
     * General procedure registration.
     */
    public function log(
        string $action,
        ?Model $model = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $description = null,
        ?int $userId = null
    ): AuditLog {
        return AuditLog::create([
            'user_id' => $userId ?? Auth::id(),
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model?->getKey(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'description' => $description,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    /**
     * Create registration.
     */
    public function logCreated(Model $model): AuditLog
    {
        return $this->log(
            action: 'created',
            model: $model,
            newValues: $this->sanitize($model->getAttributes()),
            description: "Création de {$this->modelName($model)} #{$model->getKey()}"
        );
    }

    /**
     * Record an update.
     */
    public function logUpdated(Model $model, array $oldValues, array $newValues): AuditLog
    {
        // We only record variable fields.
        $changed = array_keys($newValues);
        $oldFiltered = array_intersect_key($oldValues, array_flip($changed));

        return $this->log(
            action: 'updated',
            model: $model,
            oldValues: $this->sanitize($oldFiltered),
            newValues: $this->sanitize($newValues),
            description: "Modification de {$this->modelName($model)} #{$model->getKey()}"
        );
    }

    /**
     * Delete registration
     */
    public function logDeleted(Model $model): AuditLog
    {
        return $this->log(
            action: 'deleted',
            model: $model,
            oldValues: $this->sanitize($model->getAttributes()),
            description: "Suppression de {$this->modelName($model)} #{$model->getKey()}"
        );
    }

    /**
     * Record a restore.
     */
    public function logRestored(Model $model): AuditLog
    {
        return $this->log(
            action: 'restored',
            model: $model,
            description: "Restauration de {$this->modelName($model)} #{$model->getKey()}"
        );
    }

    /**
     * File upload registration.
     */
    public function logDownloaded(Model $model): AuditLog
    {
        return $this->log(
            action: 'downloaded',
            model: $model,
            description: "Téléchargement de {$this->modelName($model)} #{$model->getKey()}"
        );
    }

    /**
     * Login/Logout registration.
     */
    public function logAuth(string $action, int $userId): AuditLog
    {
        return $this->log(
            action: $action,
            userId: $userId,
            description: $action === 'login' ? 'Connexion' : 'Déconnexion'
        );
    }

    /**
     * Removing sensitive fields.
     */
    private function sanitize(array $values): array
    {
        unset(
            $values['password'],
            $values['remember_token'],
            $values['two_factor_secret'],
            $values['two_factor_recovery_codes'],
        );

        return $values;
    }

    /**
     * abbreviated model name
     */
    private function modelName(Model $model): string
    {
        return class_basename($model);
    }
}
