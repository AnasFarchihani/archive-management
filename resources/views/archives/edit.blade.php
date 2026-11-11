@extends('layouts.app')

@section('title', 'Modifier archive')

@section('breadcrumbs')
<li class="breadcrumb-item">Accueil</li>
<li class="breadcrumb-item active" aria-current="page">Archives</li>
<li class="breadcrumb-item active" aria-current="page">Modifier</li>
@endsection

@section('content')
    <div class="page-head">
        <div>
            <h1>Modifier : {{ $archive->document_number }}</h1>
        </div>
        <div class="page-actions"></div>
    </div>

    <form action="{{ route('archives.update', $archive) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('archives._form', ['archive' => $archive])
        <div class="card-footer bg-white d-flex flex-column flex-sm-row justify-content-end gap-2">
            <a class="btn btn-light" href="{{ route('archives.index') }}">Annuler</a>
            <button class="btn btn-primary" type="submit"><i class="bi bi-check-lg me-1"></i>Enregistrer</button>
        </div>
    </form>
@endsection