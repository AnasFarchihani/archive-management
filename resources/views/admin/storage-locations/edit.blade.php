@extends('layouts.app')

@section('title', 'Modifier un emplacement')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
    <li class="breadcrumb-item active" aria-current="page">Administration</li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.storage-locations.index') }}">Emplacements</a></li>
@endsection

@section('content')
    <div class="page-head">
        <div>
            <h1>Modifier : {{ $storageLocation->name }}</h1>
            <p class="text-muted mb-0">
                Bâtiments, salles, armoires, étagères et boîtes
            </p>
        </div>
        <div class="page-actions"></div>
    </div>

    <form class="card" action="{{ route('admin.storage-locations.update', $storageLocation) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.storage-locations._form', ['storageLocation' => $storageLocation])
        <div class="card-footer bg-white d-flex flex-column flex-sm-row justify-content-end gap-2">
            <a class="btn btn-light" href="{{ route('admin.storage-locations.index') }}">Annuler</a>
            <button class="btn btn-primary" type="submit"><i class="bi bi-check-lg me-1"></i>Enregistrer</button>
        </div>
    </form>
@endsection