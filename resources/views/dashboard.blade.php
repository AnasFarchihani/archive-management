@extends('layouts.app')

@section('title', "Tableau de bord")

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('dashboard') }}">Accueil</a></li>
@endsection

@section('content')
    <div class="page-head">
        <div>
            <h1>Tableau de bord</h1>
            <p class="text-muted mb-0">
                Vue d'ensemble de l'activité des archives
            </p>
        </div>
        <div class="page-actions">
            <a class="btn btn-primary" href="{{ route('archives.create') }}">
                <i class="bi bi-plus-lg me-1"></i>Nouvelle archive
            </a> 
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-6 col-xl-3">
            <div class="card stat">
                <div class="card-body d-flex align-items-center gap-3">
                    <span class="stat-icon">
                        <i class="bi bi-archive"></i>
                    </span>
                    <div>
                        <div class="stat-num" data-stat="archives">-</div>
                        <div class="text-muted small">Archives au total</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="card stat">
                <div class="card-body d-flex align-items-center gap-3">
                    <span class="stat-icon">
                        <i class="bi bi-people"></i>
                    </span>
                    <div>
                        <div class="stat-num" data-stat="users">–</div>
                        <div class="text-muted small">Utilisateurs actifs</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="card stat">
                <div class="card-body d-flex align-items-center gap-3">
                    <span class="stat-icon">
                        <i class="bi bi-geo-alt"></i>
                    </span>
                    <div>
                        <div class="stat-num" data-stat="locations">–</div>
                        <div class="text-muted small">Emplacements</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="card stat">
                <div class="card-body d-flex align-items-center gap-3">
                    <span class="stat-icon">
                        <i class="bi bi-hourglass-split"></i>
                    </span>
                    <div>
                        <div class="stat-num" data-stat="pending">–</div>
                        <div class="text-muted small">Éléments en attente</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h6">Archives ajoutées par mois</h2>
                    <div data-chart="Archives ajoutées par mois"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h6">Répartition par statut</h2>
                    <div data-chart="status" class="d-flex flex-column align-items-center gap-3"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <h2 class="h6">Documents récemment ajoutés</h2>
            <div class="card" data-table-wrap>
                <div class="table-responsive">
                    <table
                        class="table table-hover align-middle mb-0"
                        data-source=""
                        data-per="5"
                        data-actions="view"
                        data-edit-href=""
                        data-sort="date-desc"
                        data-deleted="false" >
                        <thead>
                            <tr>
                                <th scope="col" data-col="number">N°</th>
                                <th scope="col" data-col="title">Titre</th>
                                <th scope="col" data-col="type">Type</th>
                                <th scope="col" data-col="status">Statut</th>
                                <th scope="col" data-col="date">Date</th>
                                <th scope="col" data-col="actions" class="text-end"> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ARC-2026-0026</td>
                                <td>Facture fournisseur n° 125</td>
                                <td>Facture</td>
                                <td>
                                    <span class="badge rounded-pill bg-danger-subtle text-danger-emphasis">Expiré</span>
                                </td>
                                <td>16/08/2026</td>
                                <td>16/08/2026</td>
                                <td class="text-end" >
                                    <div class="d-inline-flex gap-1">
                                        <a
                                        href="#"
                                        class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- ******** --}}
                <div class="empty d-none" data-empty>
                    <i class="bi bi-inbox"></i>
                    <p class="fw-semibold mb-1">Aucun résultat</p>
                    <p class="text-muted mb-0">
                        Modifiez ou effacez vos filtres pour afficher des éléments.
                    </p>
                </div>
                <div class="card-footer bg-white d-flex flex-wrap gap-2 justify-content-between align-items-center">
                    <small class="text-muted" data-count></small>
                    <nav aria-label="Pagination">
                        <ul class="pagination pagination-sm mb-0" data-pager></ul>
                    </nav>
                </div>
            </div>
            {{-- ******** --}}
            </div>

            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h6">Actions rapides</h2>
                        <div class="d-grid gap-2">
                            <a
                                class="btn btn-outline-primary text-start"
                                href="{{ route('archives.create') }}" >
                                <i class="bi bi-plus-circle me-2"></i>
                                Nouvelle archive
                            </a>
                            <a
                                class="btn btn-outline-primary text-start"
                                href="{{ route('archives.index') }}" >
                                <i class="bi bi-search me-2"></i>
                                Consulter le registre
                            </a>
                            <a
                                class="btn btn-outline-primary text-start"
                                href="locations.html" >
                                <i class="bi bi-geo-alt me-2"></i>
                                Gérer les emplacements
                            </a>
                            <a
                                class="btn btn-outline-primary text-start"
                                href="trash.html" >
                                <i class="bi bi-trash3 me-2"></i>
                                Ouvrir la corbeille
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h2 class="h6">Activité récente</h2>
                            <ul class="activity list-unstyled mb-0">
                                <li>
                                    <span class="act-dot"></span>
                                    <div>
                                        <div>Sara Benali a créé ARC-2026-0026</div>
                                        <small class="text-muted">Il y a 12 min</small>
                                    </div>
                                </li>
                                <li>
                                    <span class="act-dot"></span>
                                    <div>
                                        <div>Karim Tazi a modifié ARC-2026-0019</div>
                                        <small class="text-muted">Il y a 1 h</small>
                                    </div>
                                </li>
                                <li>
                                    <span class="act-dot"></span>
                                    <div>
                                        <div>Imane Ouazzani a restauré ARC-2026-0009</div>
                                        <small class="text-muted">Il y a 3 h</small>
                                    </div>
                                </li>
                                <li>
                                    <span class="act-dot"></span>
                                    <div>
                                        <div>Omar Alaoui a exporté le registre</div>
                                        <small class="text-muted">Hier</small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
@endsection