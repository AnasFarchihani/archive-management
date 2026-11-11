@extends('layouts.app')

@section('title', 'Corbeille')

@section('breadcrumbs')
<li class="breadcrumb-item">Accueil</li>
<li class="breadcrumb-item active" aria-current="page">Archives</li>
<li class="breadcrumb-item active" aria-current="page">Corbeille</li>
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
                <div class="mt-3">{{ $archives->links() }}</div>
            </div>
@endsection