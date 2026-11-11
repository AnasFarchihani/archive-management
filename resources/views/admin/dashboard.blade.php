@extends('layouts.app')

@section('title', "Tableau de bord")

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Accueil</li>
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
                        <div class="stat-num">{{ $stats['total_archives'] }}</div>
                        <div class="text-muted small">Archives (Supprimé {{ $stats['trashed_archives'] }})</div>
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
                        <div class="stat-num">{{ $stats['total_users'] }}</div>
                        <div class="text-muted small">Utilisateurs (actifs {{ $stats['active_users'] }})</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="card stat">
                <div class="card-body d-flex align-items-center gap-3">
                    <span class="stat-icon">
                        <i class="bi bi-diagram-3"></i>
                    </span>
                    <div>
                        <div class="stat-num">{{ $stats['total_departments'] }}</div>
                        <div class="text-muted small">Départements (actifs {{ $stats['active_departments'] }})</div>
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
                        <div class="stat-num">{{ $stats['total_locations'] }}</div>
                        <div class="text-muted small">Emplacements (actifs {{ $stats['active_locations'] }})</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h6">Archives par département</h2>
                    <div>
                        <ul class="list-group list-group-flush">
                            @forelse ($archivesByDepartment as $dept)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>{{ $dept->name }}</span>
                                    <span class="badge bg-primary">{{ $dept->archives_count }}</span>
                                </li>
                            @empty
                                
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h6">Archives par statut</h2>
                    <div>
                        <ul class="list-group list-group-flush">
                            @forelse ($archivesByStatus as $row)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span> {{ $row->archive_status->label() }} </span>
                                    <span class="badge bg-secondary">{{ $row->count }}</span>
                                </li>
                            @empty
                                <li class="list-group-item text-muted">Aucune archive.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <h2 class="h6">Documents récemment ajoutés</h2>
            <div class="card" data-table-wrap>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col" data-col="number">N° Document</th>
                                <th scope="col" data-col="title">Titre</th>
                                <th scope="col" data-col="type">Statut</th>
                                <th scope="col" data-col="status">Date</th>
                                <th scope="col" data-col="status">Département</th>
                                <th scope="col" data-col="status">Créé par </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentArchives as $archive)
                                <tr>
                                    <td>
                                        <a href="{{ route('archives.show', $archive) }}">
                                            {{ $archive->document_number }}
                                        </a>
                                    </td>
                                    <td>{{ Str::limit($archive->title, 50) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $archive->archive_status->badgeColor() }}">
                                            {{ $archive->archive_status->label() }}
                                        </span>
                                    </td>
                                    <td>{{ $archive->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $archive->department->code }}</td>
                                    <td>{{ $archive->creator->name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">Aucune archive.</td>
                                </tr>
                            @endforelse
                            
                        </tbody>
                    </table>
                </div>
            </div>
            
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
                                href="{{ route('archives.trashed') }}" >
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
                                @forelse ($recentActivities as $log)
                                    <li>
                                        <span class="act-dot"></span>
                                        <div>
                                            <div>{{ $log->user?->name ?? '-' }} - {{ $log->action}}</div>
                                            {{-- <div><span class="badge bg-secondary">{{ $log->action}}</span></div> --}}
                                            <small class="text-muted">{{ $log->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                    </li>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3 text-muted">Aucune activité.</td>
                                    </tr>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
@endsection