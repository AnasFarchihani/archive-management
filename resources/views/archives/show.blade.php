@extends('layouts.app')

@section('title', $archive->document_number)

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
<li class="breadcrumb-item active" aria-current="page"><a href="{{ route('archives.index') }}">Archives</a></li>
@endsection

@section('content')
    <div data-archive-page>
        <div class="page-head">
            <div>
                <h1><span>{{ $archive->document_number }} — {{ $archive->title }}</span></h1>
                <p class="text-muted mb-0">Fiche détaillée de l'archive</p>
            </div>
            <div class="page-actions">
                <a class="btn btn-secondary" href="{{ route('archives.index') }}">
                    ← Retour
                </a>
                @can('update', $archive)
                    <a class="btn btn-primary" href="{{ route('archives.edit', $archive) }}">
                        <i class="bi bi-pencil me-1"></i>Modifier
                    </a>
                @endcan
                @can('delete', $archive)
                    <form action="{{ route('archives.destroy', $archive) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Supprimer cette archive ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger" data-trash-one>
                            <i class="bi bi-trash3 me-1"></i>Mettre à la corbeille
                        </button>
                    </form>
                @endcan
            </div>
        </div>

        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-body">
                        {{-- Informations --}}
                        <h2 class="h6 mb-3">Informations</h2>
                        <dl class="row g-3 mb-0">
                            <div class="col-sm-6 col-lg-4">
                                <dt class="text-muted small fw-normal">N° de document</dt>
                                <dd class="mb-0">{{ $archive->document_number }}</dd>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <dt class="text-muted small fw-normal">Titre</dt>
                                <dd class="mb-0">{{ $archive->title }}</dd>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <dt class="text-muted small fw-normal">Objet</dt>
                                <dd class="mb-0">{{ $archive->subject ?? '—' }}</dd>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <dt class="text-muted small fw-normal"> Expéditeur / source </dt>
                                <dd class="mb-0">{{ $archive->sender ?? '—' }}</dd>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <dt class="text-muted small fw-normal">Date de dépôt</dt>
                                <dd class="mb-0">{{ $archive->submission_date->format('d/m/Y') }}</dd>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <dt class="text-muted small fw-normal">Date d'expiration</dt>
                                <dd class="mb-0">{{ $archive->expiry_date?->format('d/m/Y') ?? '—' }}</dd>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <dt class="text-muted small fw-normal"> Département </dt>
                                <dd class="mb-0"><strong>{{ $archive->department->code }}</strong></dd>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <dt class="text-muted small fw-normal">Type</dt>
                                <dd class="mb-0">{{ $archive->document_type->label() }}</dd>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <dt class="text-muted small fw-normal">Statut</dt>
                                <dd class="mb-0">
                                    <span class="badge bg-{{ $archive->archive_status->badgeColor() }}">
                                        {{ $archive->archive_status->label() }}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        {{-- Fichiers --}}
                        <h2 class="h6 mb-3">Fichiers ({{ $archive->files->count() }})</h2>
                        <ul class="file-list list-unstyled mb-0">
                            <li class="file-item">
                                {{-- <i class="bi bi-file-earmark-pdf fs-3 text-danger"></i> --}}
                                <div class="flex-grow-1">
                                    @if($archive->files->isEmpty())
                                        <p class="text-muted mb-0">Aucun fichier.</p>
                                        @else
                                            <table class="table table-sm mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Nom</th>
                                                        <th>Taille</th>
                                                        <th>Ajouté par</th>
                                                        <th class="text-end">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($archive->files as $file)
                                                        <tr>
                                                            <td>{{ $file->original_name }}</td>
                                                            <td>{{ $file->humanSize() }}</td>
                                                            <td>{{ $file->uploader->name }}</td>
                                                            <td class="text-end">
                                                                <a href="{{ route('files.download', $file) }}"
                                                                    class="btn btn-sm btn-outline-primary">
                                                                    <i class="bi bi-download"></i>
                                                                </a>
                                                                @can('update', $archive)
                                                                    <form action="{{ route('files.destroy', $file) }}"
                                                                        method="POST" class="d-inline"
                                                                        onsubmit="return confirm('Supprimer ce fichier ?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button class="btn btn-sm btn-outline-danger">
                                                                            <i class="bi bi-trash3"></i>
                                                                        </button>
                                                                    </form>
                                                                @endcan
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                    @endif
                                    
                                </div>
                            </li>
                        </ul>
                        {{-- Upload additional files --}}
                        @can('uploadFile', $archive)
                            <div class="card mt-3">
                                <div class="card-header">Ajouter des fichiers</div>
                                <div class="card-body">
                                    <form action="{{ route('archives.files.store', $archive) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-2">
                                            <input type="file" name="files[]" class="form-control" multiple
                                            accept=".pdf,.doc,.docx,.xls,.xlsx" required>
                                        </div>
                                        <button class="btn btn-primary btn-sm">Téléverser</button>
                                    </form>
                                </div>
                            </div>
                        @endcan
                        {{--  --}}
                    </div>

                </div>
                <div class="card">
                    <div class="card-body">
                        <h2 class="h6 mb-3">Historique d'activité</h2>
                        <ul class="activity list-unstyled mb-0">
                            <li>
                                <span class="act-dot"></span>
                                <div>
                                    <div>Consultation par Karim Tazi</div>
                                    <small class="text-muted">Aujourd'hui, 09:14</small>
                                </div>
                            </li>
                            <li>
                                <span class="act-dot"></span>
                                <div>
                                    <div>Modification de l'emplacement par Sara Benali</div>
                                    <small class="text-muted">12/09/2026, 16:40</small>
                                </div>
                            </li>
                            <li>
                                <span class="act-dot"></span>
                                <div>
                                    <div>Création de la fiche par Sara Benali</div>
                                    <small class="text-muted">03/09/2026, 10:02</small>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h6 mb-3">Emplacement physique : {{ $archive->storageLocation->name }}</h2>
                        <dl class="row g-2 mb-0" id="">
                            <div class="col-6">
                                <dt class="text-muted small fw-normal">Étage</dt>
                                <dd class="mb-0">{{ $archive->storageLocation->floor }}</dd>
                            </div>
                            <div class="col-6">
                                <dt class="text-muted small fw-normal">Salle</dt>
                                <dd class="mb-0">{{ $archive->storageLocation->room }}</dd>
                            </div>
                            <div class="col-6">
                                <dt class="text-muted small fw-normal">Armoire</dt>
                                <dd class="mb-0">{{ $archive->storageLocation->cabinet }}</dd>
                            </div>
                            <div class="col-6">
                                <dt class="text-muted small fw-normal">Étagère</dt>
                                <dd class="mb-0">{{ $archive->storageLocation->shelf }}</dd>
                            </div>
                            <div class="col-6">
                                <dt class="text-muted small fw-normal">Boîte</dt>
                                <dd class="mb-0">{{ $archive->storageLocation->box }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body small">
                        <h2 class="h6 mb-3">Suivi</h2>
                        <p class="mb-1">
                            <span class="text-muted">Créé par</span> {{ $archive->creator->name }}
                        </p>
                        <p class="mb-1">
                            <span class="text-muted">Créé le</span> {{ $archive->created_at->format('d/m/Y') }}
                        </p>
                        <p class="mb-0">
                            <span class="text-muted">Dernière modification</span> {{ $archive->updated_at->format('d/m/Y') }}
                        </p>
                    </div>
                </div>
            </div>
            </div>
        </div>
@endsection