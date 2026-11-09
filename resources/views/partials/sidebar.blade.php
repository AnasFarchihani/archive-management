<aside
    class="sidebar"
    id="sidebar"
    aria-label="Navigation principale">
    <a class="sb-brand" href="{{ route('dashboard') }}">
        <img src="{{ asset('assets/img/logo.svg') }}" alt="" width="34" height="34">
        <span class="sb-text">Archives
            <small>Gestion documentaire</small>
        </span>
    </a>
    <nav class="sb-nav">
        @auth
            @if (auth()->user()->isAdmin())
            <div class="sb-group">Principal</div>
            <a
                class="sb-link active"
                aria-current="page"
                href="{{ route('dashboard') }}"
                data-label="Tableau de bord">
                <i class="bi bi-speedometer2" aria-hidden="true"></i>
                <span class="sb-text">Tableau de bord</span>
            </a>

            <div class="sb-group">Archives</div>
            <a
                class="sb-link"
                href="{{ route('archives.index') }}"
                data-label="Registre des archives">
                <i class="bi bi-archive" aria-hidden="true"></i>
                <span class="sb-text">Registre des archives</span>
            </a>
            <a
                class="sb-link"
                href="{{ route('archives.create') }}"
                data-label="Nouvelle archive">
                <i class="bi bi-plus-circle" aria-hidden="true"></i>
                <span class="sb-text">Nouvelle archive</span>
            </a>
            <a
                class="sb-link"
                href="{{ route('archives.trashed') }}"
                data-label="Corbeille">
                <i class="bi bi-trash3" aria-hidden="true"></i>
                <span class="sb-text">Corbeille</span>
            </a>

            <div class="sb-group">Administration</div>
            <a
                class="sb-link"
                href="{{ route('admin.users.index') }}"
                data-label="Utilisateurs">
                <i class="bi bi-people" aria-hidden="true"></i>
                <span class="sb-text">Utilisateurs</span>
            </a>
            <a
                class="sb-link"
                href="{{ route('admin.departments.index') }}"
                data-label="Départements">
                <i class="bi bi-diagram-3" aria-hidden="true"></i>
                <span class="sb-text">Départements</span>
            </a>
            <a
                class="sb-link"
                href="{{ route('admin.storage-locations.index') }}"
                data-label="Emplacements">
                <i class="bi bi-geo-alt" aria-hidden="true"></i>
                <span class="sb-text">Emplacements</span>
            </a>
            <a
                class="sb-link"
                href="#"
                data-label="Journal d'audit">
                <i class="bi bi-journal-text" aria-hidden="true"></i>
                <span class="sb-text">Journal d'audit</span>
            </a>

            @else
                <div class="sb-group">Principal</div>
                    <a
                        class="sb-link active"
                        aria-current="page"
                        href="#"
                        data-label="Tableau de bord">
                        <i class="bi bi-speedometer2" aria-hidden="true"></i>
                        <span class="sb-text">Tableau de bord</span>
                    </a>
                    <div class="sb-group">Archives</div>
                    <a
                        class="sb-link"
                        href="{{ route('archives.index') }}"
                        data-label="Registre des archives">
                        <i class="bi bi-archive" aria-hidden="true"></i>
                        <span class="sb-text">Registre des archives</span>
                    </a>
                    <a
                        class="sb-link"
                        href="{{ route('archives.create') }}"
                        data-label="Nouvelle archive">
                        <i class="bi bi-plus-circle" aria-hidden="true"></i>
                        <span class="sb-text">Nouvelle archive</span>
                    </a>
        @endif
        @endauth
    </nav>

    <div class="sb-foot">
        @auth
            <form method="POST" action="{{ route('logout') }}">
            @csrf
                <button
                    type="submit"
                    style="background: none;border:none"
                    class="sb-link">
                    <i class="bi bi-box-arrow-left" aria-hidden="true"></i>
                    <span class="sb-text">Déconnexion</span>
                </button>
            </form>
        @endauth
        
    </div>
</aside>
<div class="sb-overlay" id="sbOverlay"></div>