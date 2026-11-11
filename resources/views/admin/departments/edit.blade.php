@extends('layouts.app')

@section('title', 'Modifier un département')

@section('breadcrumbs')
    <li class="breadcrumb-item">Accueil</li>
    <li class="breadcrumb-item active" aria-current="page">Départements</li>
    <li class="breadcrumb-item active" aria-current="page">Modifier</li>
@endsection

@section('content')
    <div class="page-head">
        <div>
            <h1>Modifier : {{ $department->name }}</h1>
        </div>
        <div class="page-actions"></div>
    </div>

    <form class="card" action="{{ route('admin.departments.update', $department) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.departments._form', ['department' => $department])
        <div class="card-footer bg-white d-flex flex-column flex-sm-row justify-content-end gap-2">
            <a class="btn btn-light" href="{{ route('admin.departments.index') }}">Annuler</a>
            <button class="btn btn-primary" type="submit">Mettre à jour</button>
        </div>
    </form>
@endsection