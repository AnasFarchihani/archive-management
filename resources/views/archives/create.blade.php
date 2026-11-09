@extends('layouts.app')

@section('title', 'Nouvelle archive')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
<li class="breadcrumb-item active" aria-current="page"><a href="{{ route('archives.index') }}">Archives</a></li>
@endsection

@section('content')
    <div class="page-head">
        <div>
            <h1>Nouvelle archive</h1>
            <p class="text-muted mb-0">
                Renseignez les informations du document à archiver
            </p>
        </div>
        <div class="page-actions"></div>
    </div>
    
    <form action="{{ route('archives.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('archives._form', ['archive' => null])
        <div class="card-footer bg-white d-flex flex-column flex-sm-row justify-content-end gap-2">
            <a class="btn btn-light" href="{{ route('archives.index') }}">Annuler</a>
            <button class="btn btn-primary" type="submit"><i class="bi bi-check-lg me-1"></i>Enregistrer</button>
        </div>
    </form>
        
@endsection