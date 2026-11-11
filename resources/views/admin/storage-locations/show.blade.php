@extends('layouts.app')

@section('title', $storageLocation->name)

@section('breadcrumbs')
    <li class="breadcrumb-item">Accueil</li>
    <li class="breadcrumb-item active" aria-current="page">Emplacements</li>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>{{ $storageLocation->name }}</h1>
        <a href="{{ route('admin.storage-locations.index') }}" class="btn btn-primary">← Retour</a>
    </div>
    <div class="card"><div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Étage</dt><dd class="col-sm-9">{{ $storageLocation->floor ?? '—' }}</dd>
            <dt class="col-sm-3">Salle</dt><dd class="col-sm-9">{{ $storageLocation->room ?? '—' }}</dd>
            <dt class="col-sm-3">Armoire</dt><dd class="col-sm-9">{{ $storageLocation->cabinet ?? '—' }}</dd>
            <dt class="col-sm-3">Étagère</dt><dd class="col-sm-9">{{ $storageLocation->shelf ?? '—' }}</dd>
            <dt class="col-sm-3">Boîte</dt><dd class="col-sm-9">{{ $storageLocation->box ?? '—' }}</dd>
            <dt class="col-sm-3">Description</dt><dd class="col-sm-9">{{ $storageLocation->description ?? '—' }}</dd>
            <dt class="col-sm-3">Archives</dt><dd class="col-sm-9">{{ $storageLocation->archives_count }}</dd>
            <dt class="col-sm-3">Statut</dt>
            <dd class="col-sm-9">
                @if($storageLocation->is_active)
                    <span class="badge bg-success">Actif</span>
                @else
                    <span class="badge bg-secondary">Inactif</span>
                @endif
            </dd>
        </dl>
    </div></div>
@endsection