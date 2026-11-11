@extends('layouts.app_1')

@section('title', 'Détails du log')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Log #{{ $auditLog->id }}</h1>
        <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-secondary">← Retour</a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Informations générales</div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Date</dt>
                        <dd class="col-sm-8">{{ $auditLog->created_at->format('d/m/Y H:i:s') }}</dd>

                        <dt class="col-sm-4">Utilisateur</dt>
                        <dd class="col-sm-8">{{ $auditLog->user?->name ?? '—' }}</dd>

                        <dt class="col-sm-4">Action</dt>
                        <dd class="col-sm-8">
                            <span class="badge bg-secondary">{{ $auditLog->action }}</span>
                        </dd>

                        <dt class="col-sm-4">Modèle</dt>
                        <dd class="col-sm-8">{{ $auditLog->model_type ?? '—' }}</dd>

                        <dt class="col-sm-4">ID Modèle</dt>
                        <dd class="col-sm-8">{{ $auditLog->model_id ?? '—' }}</dd>

                        <dt class="col-sm-4">Description</dt>
                        <dd class="col-sm-8">{{ $auditLog->description ?? '—' }}</dd>

                        <dt class="col-sm-4">Adresse IP</dt>
                        <dd class="col-sm-8">{{ $auditLog->ip_address ?? '—' }}</dd>

                        <dt class="col-sm-4">User Agent</dt>
                        <dd class="col-sm-8"><small>{{ $auditLog->user_agent ?? '—' }}</small></dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            @if($auditLog->old_values)
                <div class="card mb-3">
                    <div class="card-header bg-warning">Anciennes valeurs</div>
                    <div class="card-body">
                        <pre class="mb-0">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                </div>
            @endif

            @if($auditLog->new_values)
                <div class="card">
                    <div class="card-header bg-success text-white">Nouvelles valeurs</div>
                    <div class="card-body">
                        <pre class="mb-0">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection