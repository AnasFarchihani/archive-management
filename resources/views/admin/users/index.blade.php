@extends('layouts.app')

@section('title', "Utilisateurs")

@section('breadcrumbs')
    <li class="breadcrumb-item">Accueil</li>
    <li class="breadcrumb-item active" aria-current="page">Utilisateurs</li>
@endsection

@section('content')
    <div class="page-head">
        <div>
            <h1>Utilisateurs</h1>
            <p class="text-muted mb-0">Comptes, rôles et départements</p>
        </div>
        <div class="page-actions">
            <a
                href="{{ route('admin.users.create') }}"
                class="btn btn-primary"
                type="button" data-new="#userModal"
                data-title-new="Nouvel utilisateur">
                <i class="bi bi-plus-lg me-1"></i>
                Nouvel utilisateur
            </a>
        </div>
    </div>

    <div class="card">
        <form method="GET" action="{{ route('admin.users.index') }}">
        <div class="card-body border-bottom">
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
                            data-search placeholder="Nom ou e-mail…"
                            value="{{ request('search') }}">
                        </div>
                    </div>
                
                <div class="col-6 col-lg">
                    <select class="form-select" name="role">
                        <option value="">- Rôles -</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->value }}"
                                {{ request('role') === $role->value ? 'selected' : '' }}>
                                {{ $role->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-lg">
                    <select class="form-select" name="department_id">
                        <option value="">- Département -</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}"
                                {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-lg">
                    <select class="form-select" name="is_active">
                        <option value="">- Statuts -</option>
                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Actif</option>
                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>
                <div class="col-12 col-lg-auto d-grid d-lg-flex gap-2 ms-lg-auto"></div>
                <div class="col-md-1">
                        <button class="btn btn-outline-primary w-100">Filtrer</button>
                </div>
            </div>
        </div>
    </form>
        <div class="table-responsive">
            <table
                class="table table-hover align-middle mb-0"
                data-view-href="#"
                data-source="" data-per="8"
                data-actions="edit,toggle"
                data-edit-href=""
                data-sort="">
                <thead>
                    <tr>
                        <th scope="col" data-col="name">Nom</th>
                        <th scope="col" data-col="email">E-mail</th>
                        <th scope="col" data-col="role">Rôle</th>
                        <th scope="col" data-col="department">Département</th>
                        <th scope="col" data-col="status">Statut</th>
                        <th scope="col" data-col="actions" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-{{ $user->role->value === 'admin' ? 'danger' : 'info' }}">
                                {{ $user->role->label() }}
                            </span>
                        </td>
                        <td>{{ $user->department?->name ?? '-' }}</td>
                        <td>
                            @if ($user->is_active)
                                <span class="badge rounded-pill bg-success-subtle text-success-emphasis">Actif</span>
                                @else
                                <span class="badge rounded-pill bg-secondary-subtle text-secondary-emphasis">Inactif</span>
                            @endif
                            
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Désactiver cet utilisateur ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-toggle-on"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                Aucun utilisateur.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">{{ $users->links() }}</div>
        </div>
    <div class="empty d-none" data-empty><i class="bi bi-inbox"></i><p class="fw-semibold mb-1">Aucun résultat</p><p class="text-muted mb-0">Modifiez ou effacez vos filtres pour afficher des éléments.</p></div>
    <div class="card-footer bg-white d-flex flex-wrap gap-2 justify-content-between align-items-center"><small class="text-muted" data-count></small><nav aria-label="Pagination"><ul class="pagination pagination-sm mb-0" data-pager></ul></nav></div></div>
@endsection