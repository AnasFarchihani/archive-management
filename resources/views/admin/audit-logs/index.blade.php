@extends('layouts.app')

@section('title', "Journal d'audit")

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
<li class="breadcrumb-item active" aria-current="page">Administration</li>
<li class="breadcrumb-item active" aria-current="page">Journal d'audit</li>
@endsection

@section('content')
<div class="page-head">
    <div>
        <h1>Journal d'audit</h1>
        <p class="text-muted mb-0">Historique en lecture seule des actions</p>
    </div>
    <div class="page-actions"></div>
</div>
<div class="card" data-table-wrap>
    <div class="card-body border-bottom">
        <div class="row g-2 align-items-center">
            <div class="col-12 col-lg-4">
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="bi bi-search"></i>
                    </span>
                    <input
                    type="search"
                    class="form-control"
                    data-search placeholder="Rechercher…"
                    aria-label="Rechercher">
                </div>
            </div>
            <div class="col-6 col-lg">
                <select
                    class="form-select"
                    data-filter="action"
                    aria-label="Filtrer : Toutes les actions">
                    <option value="">Toutes les actions</option>
                    <option>Connexion</option>
                    <option>Création</option>
                    <option>Modification</option>
                    <option>Suppression</option>
                    <option>Restauration</option>
                    <option>Export</option>
                </select>
            </div>
            <div class="col-6 col-lg">
                <select
                    class="form-select"
                    data-filter="user"
                    aria-label="Filtrer : Tous les utilisateurs">
                    <option value="">Tous les utilisateurs</option>
                    <option>Sara Benali</option>
                    <option>Youssef El Amrani</option>
                    <option>Nadia Chraibi</option>
                    <option>Karim Tazi</option>
                </select>
            </div>
            <div class="col-6 col-lg">
                <input
                    type="date"
                    class="form-control"
                    data-date-from
                    aria-label="À partir du">
                </div>
                <div class="col-12 col-lg-auto d-grid d-lg-flex gap-2 ms-lg-auto">
                    <button class="btn btn-outline-secondary" type="button" data-export>
                        <i class="bi bi-download me-1"></i>
                        Exporter (CSV)
                    </button>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table
                class="table table-hover
                align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col" data-col="date">Date</th>
                        <th scope="col" data-col="user">Utilisateur</th>
                        <th scope="col" data-col="action">Action</th>
                        {{-- <th scope="col" data-col="record">Modèle</th> --}}
                        <th scope="col" data-col="ip">Description</th>
                        <th scope="col" data-col="ip">Détails</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $log->user?->name ?? '-' }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $log->action }}</span>
                            </td>
                            <td>{{ Str::limit($log->description, 60) }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.audit-logs.show', $log) }}"
                                    class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-muted">Aucun log.</td></tr>
                    @endforelse
                </tbody>
                </table>
            </div>
<div class="empty d-none" data-empty>
    <i class="bi bi-inbox"></i>
    <p class="fw-semibold mb-1">Aucun résultat</p>
    <p class="text-muted mb-0">Modifiez ou effacez vos filtres pour afficher des éléments.</p>
</div>
<div class="card-footer bg-white d-flex flex-wrap gap-2 justify-content-between align-items-center">
    <small class="text-muted" data-count></small>
    <nav aria-label="Pagination">
        <ul class="pagination pagination-sm mb-0" data-pager></ul>
    </nav>
</div>
</div>
@endsection