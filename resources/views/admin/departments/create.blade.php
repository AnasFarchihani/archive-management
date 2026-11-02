@extends('layouts.app')

@section('title', 'Nouveau département')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
    <li class="breadcrumb-item active" aria-current="page">Administration</li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.departments.index') }}">Départements</a></li>
@endsection

@section('content')
    <div class="page-head">
        <div>
            <h1>Nouveau département</h1>
            <p class="text-muted mb-0">
                Registre des départements
            </p>
        </div>
        <div class="page-actions"></div>
    </div>

    <form class="card" action="{{ route('admin.departments.store') }}" method="POST">
        @csrf
        @include('admin.departments._form', ['department' => null])
        <div class="card-footer bg-white d-flex flex-column flex-sm-row justify-content-end gap-2">
            <a class="btn btn-light" href="{{ route('admin.departments.index') }}">Annuler</a>
            <button class="btn btn-primary" type="submit"><i class="bi bi-check-lg me-1"></i>Enregistrer</button>
        </div>
    </form>
@endsection