@extends('layouts.app')

@section('title', $department->name)

@section('breadcrumbs')
    <li class="breadcrumb-item">Accueil</li>
    <li class="breadcrumb-item active" aria-current="page">Départements</li>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>{{ $department->name }} <small class="text-muted">({{ $department->code }})</small></h1>
        <a href="{{ route('admin.departments.index') }}" class="btn btn-primary">← Retour</a>
    </div>
    <div class="card">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Code</dt><dd class="col-sm-9">{{ $department->code }}</dd>
                <dt class="col-sm-3">Description</dt><dd class="col-sm-9">{{ $department->description ?? '—' }}</dd>
                <dt class="col-sm-3">Utilisateurs</dt><dd class="col-sm-9">{{ $department->users_count }}</dd>
                <dt class="col-sm-3">Archives</dt><dd class="col-sm-9">{{ $department->archives_count }}</dd>
                <dt class="col-sm-3">Statut</dt>
                <dd class="col-sm-9">
                    @if($department->is_active)
                        <span class="badge bg-success">Actif</span>
                    @else
                        <span class="badge bg-secondary">Inactif</span>
                    @endif
                </dd>
            </dl>
        </div>
    </div>
@endsection
