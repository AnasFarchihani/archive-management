@extends('layouts.app')

@section('title', "Registre des archives")

@section('breadcrumbs')
<li class="breadcrumb-item">Accueil</li>
<li class="breadcrumb-item active" aria-current="page">Archives</li>
<li class="breadcrumb-item active" aria-current="page">Registre des archives</li>
@endsection

@section('content')
<div class="page-head">
    <div>
        <h1>Registre des archives</h1>
        <p class="text-muted mb-0">Consultez, filtrez et gérez l'ensemble des archives</p>
    </div>
    <div class="page-actions">
        @if(auth()->user()->isAdmin())
            <a class="btn btn-outline-secondary" href="{{ route('archives.trashed') }}">
                Corbeille
            </a>
        @endif
        <a class="btn btn-primary" href="{{ route('archives.create') }}">
            <i class="bi bi-plus-lg me-1"></i>
            Nouvelle archive
        </a>
    </div>
</div>

{{-- Recherche et filtres --}}
<div class="card" data-table-wrap>
    <div class="card-body border-bottom">
        <form method="GET" action="{{ route('archives.index') }}">
            <div class="row g-2 align-items-center">
                <div class="col-12 col-lg-4">
                    <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="bi bi-search"></i>
                    </span>
                    <input
                    type="text"
                    name="search"
                    class="form-control"
                    data-search placeholder="N°, titre, expéditeur…" aria-label="Rechercher"
                    value="{{ request('search') }}">
                </div>
                
            </div>
            <div class="col-6 col-lg">
                <select
                    class="form-select"
                    name="status">
                    <option value="">- Status -</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->value }}"
                            {{ request('status') === $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-lg">
                <select
                    class="form-select"
                    name="type">
                    <option value="">- Type -</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->value }}"
                            {{ request('type') === $type->value ? 'selected' : '' }}>
                            {{ $type->label() }}
                        </option>
                    @endforeach
                    
                </select>
            </div>

            @if (auth()->user()->isAdmin())
                <div class="col-6 col-lg">
                    <select
                        class="form-select"
                        name="department_id">
                        <option value="">- Département -</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}"
                                {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                                {{  $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
                <div class="col-12 col-lg-auto d-grid d-lg-flex gap-2 ms-lg-auto">
                    <button class="btn btn-outline-primary w-100">
                        Filtrer
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th scope="col" data-col="number">N° de document</th>
                    <th scope="col" data-col="title">Titre</th>
                    <th scope="col" data-col="title">Objet </th>
                    <th scope="col" data-col="title">Expéditeur </th>
                    <th scope="col" data-col="department">Département</th>
                    <th scope="col" data-col="status">Statut</th>
                    <th scope="col" data-col="status">Type</th>
                    <th scope="col" data-col="date">Date de dépôt</th>
                    <th scope="col" data-col="date">Emplacement</th>
                    <th scope="col" data-col="actions" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($archives as $archive)
                    <tr>
                        <td><strong>{{ $archive->document_number }}</strong></td>
                        <td>{{ Str::limit($archive->title, 40) }}</td>
                        <td>{{ Str::limit($archive->subject, 40) }}</td>
                        <td>{{ Str::limit($archive->sender) }}</td>
                        <td>{{ $archive->department->code }}</td>
                        <td>
                            <span class="badge bg-{{ $archive->archive_status->badgeColor() }}">
                                {{ $archive->archive_status->label() }}
                            </span>
                            <td>{{ $archive->document_type }}</td>
                            <td>{{ $archive->submission_date->format('d/m/Y') }}</td>
                            <td>{{ $archive->storageLocation->name }}</td>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('archives.show', $archive) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @can('update', $archive)
                                    <a href="{{ route('archives.edit', $archive) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                @endcan
                                @can('delete', $archive)
                                    <form action="{{ route('archives.destroy', $archive) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Supprimer cette archive ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            Aucune archive trouvée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $archives->links() }}</div>
<div class="empty d-none" data-empty><i class="bi bi-inbox"></i><p class="fw-semibold mb-1">Aucun résultat</p><p class="text-muted mb-0">Modifiez ou effacez vos filtres pour afficher des éléments.</p></div>
<div class="card-footer bg-white d-flex flex-wrap gap-2 justify-content-between align-items-center"><small class="text-muted" data-count></small><nav aria-label="Pagination"><ul class="pagination pagination-sm mb-0" data-pager></ul></nav></div></div>
@endsection