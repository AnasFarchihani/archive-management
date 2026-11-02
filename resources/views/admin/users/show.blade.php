@extends('layouts.app')

@section('title', $user->name)

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
    <li class="breadcrumb-item active" aria-current="page">Administration</li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.users.index') }}"></a></li>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>{{ $user->name }}</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">← Retour</a>
    </div>

    <div class="card">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">E-mail</dt>
                <dd class="col-sm-9">{{ $user->email }}</dd>

                <dt class="col-sm-3">Rôle</dt>
                <dd class="col-sm-9">
                    <span class="badge bg-{{ $user->role->value === 'admin' ? 'danger' : 'info' }}">
                        {{ $user->role->label() }}
                    </span>
                </dd>

                <dt class="col-sm-3">Département</dt>
                <dd class="col-sm-9">{{ $user->department?->name ?? '—' }}</dd>

                <dt class="col-sm-3">Statut</dt>
                <dd class="col-sm-9">
                    @if($user->is_active)
                        <span class="badge bg-success">Actif</span>
                    @else
                        <span class="badge bg-secondary">Inactif</span>
                    @endif
                </dd>

                <dt class="col-sm-3">Créé le</dt>
                <dd class="col-sm-9">{{ $user->created_at->format('d/m/Y H:i') }}</dd>
            </dl>
        </div>
    </div>
@endsection