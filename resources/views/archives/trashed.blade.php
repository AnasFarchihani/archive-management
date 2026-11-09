@extends('layouts.app')

@section('title', 'Corbeille')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
<li class="breadcrumb-item active" aria-current="page"><a href="{{ route('archives.index') }}">Archives</a></li>
@endsection

@section('content')
    <div class="page-head">
        <div>
            <h1>Corbeille</h1>
            <p class="text-muted mb-0">Archives supprimées logiquement</p>
        </div>
        <div class="page-actions"></div>
    </div>
        <div class="card" data-table-wrap>
            <div class="card-body border-bottom">
                <div class="row g-2 align-items-center">
                    <div class="col-12 col-lg-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-search"></i></span>
                            <input
                            type="search"
                            class="form-control"
                            data-search
                            placeholder="Rechercher dans la corbeille…"
                            aria-label="Rechercher"/>
                        </div>
                    </div>
                    <div class="col-6 col-lg">
                        <select
                            class="form-select"
                            data-filter="type"
                            aria-label="Filtrer : Tous les types">
                            <option value="">Tous les types</option>
                            <option>Contrat</option>
                        </select>
                    </div>
                    <div class="col-6 col-lg">
                        <select
                            class="form-select"
                            data-filter="department"
                            aria-label="Filtrer : Tous les départements">
                            <option value="">Tous les départements</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-auto d-grid d-lg-flex gap-2 ms-lg-auto">
                        <button class="btn btn-outline-secondary" type="button" data-export>
                            <i class="bi bi-download me-1"></i>Exporter (CSV)
                        </button>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col" data-col="number">N° de document</th>
                            <th scope="col" data-col="title">Titre</th>
                            <th scope="col" data-col="status">Département</th>
                            <th scope="col" data-col="deletedAt">Supprimé le</th>
                            <th scope="col" data-col="actions" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($archives as $archive)
                            <tr>
                                <td>{{ $archive->document_number }}</td>
                                <td>{{ $archive->title }}</td>
                                <td>{{ $archive->department->name }}</td>
                                <td>{{ $archive->deleted_at->format('d/m/Y H:i') }}</td>
                                <td class="text-end">
                                    <form action="{{ route('archives.restore', $archive->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">Corbeille vide.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
@endsection