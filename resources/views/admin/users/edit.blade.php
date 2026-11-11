@extends('layouts.app')

@section('title', 'Modifier un utilisateur')

@section('breadcrumbs')
    <li class="breadcrumb-item">Accueil</li>
    <li class="breadcrumb-item active" aria-current="page">Utilisateurs</li>
    <li class="breadcrumb-item active" aria-current="page">Modifier</li>
@endsection

@section('content')
    <div class="page-head">
        <div>
            <h1>Modifier : {{ $user->name }}</h1>
            <p class="text-muted mb-0">
                Renseignez les informations de l'utilisateur
            </p>
        </div>
        <div class="page-actions"></div>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="card">
        @csrf
        @method('PUT')

        @include('admin.users._form', ['user' => $user])
        <div class="card-footer bg-white d-flex flex-column flex-sm-row justify-content-end gap-2">
            <a class="btn btn-light" href="{{ route('admin.users.index') }}">Annuler</a>
            <button class="btn btn-primary" type="submit"></i>Mettre à jour</button>
        </div>
    </form>
@endsection