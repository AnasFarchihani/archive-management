@extends('layouts.app')

@section('title', "Emplacements")

@section('breadcrumbs')
    <li class="breadcrumb-item">Accueil</li>
    <li class="breadcrumb-item active" aria-current="page">Emplacements</li>
@endsection

@section('content')
    <div class="page-head">
        <div>
            <h1>Emplacements Physiques</h1>
            <p class="text-muted mb-0">Bâtiments, salles, armoires, étagères et boîtes</p>
        </div>
        <div class="page-actions">
            <a 
                href="{{ route('admin.storage-locations.create') }}"
                class="btn btn-primary"
                type="button"
                data-new="#locModal"
                data-title-new="Nouvel emplacement">
                <i class="bi bi-plus-lg me-1"></i>
                Nouvel emplacement
            </a>
        </div>
    </div>
    <div class="card">
        <div class="table-responsive">
            <table
                class="table table-hover align-middle mb-0"
                data-view-href="#"
                data-source=""
                data-per="8"
                data-actions="edit,toggle"
                data-edit-href=""
                data-sort="">
                <thead>
                    <tr>
                        <th scope="col" data-col="building">Nom</th>
                        <th scope="col" data-col="floor">Étage</th>
                        <th scope="col" data-col="room">Salle</th>
                        <th scope="col" data-col="cabinet">Armoire</th>
                        <th scope="col" data-col="shelf">Archives</th>
                        <th scope="col" data-col="box">Statut</th>
                        <th scope="col" data-col="actions" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($locations as $loc)
                    <tr>
                        <td><strong>{{ $loc->name }}</strong></td>
                        <td>{{ $loc->floor ?? '-' }}</td>
                        <td>{{ $loc->room ?? '-' }}</td>
                        <td>{{ $loc->cabinet ?? '-' }}</td>
                        <td>{{ $loc->archives_count}}</td>
                        <td>
                            @if($loc->is_active)
                                <span class="badge rounded-pill bg-success-subtle text-success-emphasis">Actif</span>
                            @else
                                <span class="badge rounded-pill bg-secondary-subtle text-secondary-emphasis">Inactif</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <a
                                    href="{{ route('admin.storage-locations.show', $loc) }}"
                                    class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a
                                    href="{{ route('admin.storage-locations.edit', $loc) }}"
                                    class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-4 text-muted">Aucun emplacement.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">{{ $locations->links() }}</div>
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