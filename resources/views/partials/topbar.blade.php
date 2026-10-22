<header class="topbar">
    <button
        class="btn btn-light"
        id="sidebarToggle" type="button"
        aria-label="Afficher ou masquer le menu"
        aria-controls="sidebar"
        aria-expanded="true">
        <i class="bi bi-list fs-5" aria-hidden="true"></i>
    </button>
    <nav aria-label="Fil d'Ariane" class="d-none d-sm-block">
        <ol class="breadcrumb mb-0">
            @yield('breadcrumbs')
        </ol>
    </nav>
    <form
        class="ms-auto d-none d-md-block topbar-search"
        data-global-search data-action="#" role="search">
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
                <i class="bi bi-search" aria-hidden="true"></i>
            </span>
            <input
                type="search"
                class="form-control bg-light border-start-0"
                placeholder="Rechercher une archive…"
                aria-label="Rechercher une archive">
        </div>
    </form>
    <div
        class="d-flex align-items-center gap-1 gap-sm-2 ms-auto ms-md-0">
        <div class="dropdown">
            <button
                class="btn btn-light position-relative"
                data-bs-toggle="dropdown" aria-expanded="false"
                aria-label="Notifications (3)">
                <i class="bi bi-bell" aria-hidden="true"></i>
                <span class="notif-dot"></span>
            </button>
            <div
                class="dropdown-menu
                dropdown-menu-end p-0 notif-menu">
                <div
                    class="px-3 py-2 fw-semibold border-bottom">Notifications
                </div>
                <a class="dropdown-item py-2" href="#">
                    <i class="bi bi-hourglass-split text-warning me-2"></i>
                    4 archives en attente de validation
                </a>
                <a class="dropdown-item py-2" href="#">
                    <i class="bi bi-calendar-x text-danger me-2"></i>
                    2 documents arrivent à expiration
                </a>
                <a class="dropdown-item py-2" href="#">
                    <i class="bi bi-shield-check text-success me-2"></i>
                    Journal d'audit mis à jour
                </a>
            </div>
        </div>
        <span
            class="badge text-bg-light border d-none d-sm-inline"
            title="Langue de l'interface">
            <i class="bi bi-translate" aria-hidden="true"></i>
            FR
        </span>
        <div class="dropdown">
            <button
                class="btn btn-light d-flex align-items-center gap-2 px-2"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                aria-label="Menu du profil">
                <span class="avatar">{{ auth()->user()->department->code }}</span>
                <span class="d-none d-lg-inline text-start lh-sm">
                    {{auth()->user()->name}}<br>
                    <small class="text-muted">{{ auth()->user()->role }}</small>
                </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="#" data-demo>
                        <i class="bi bi-person me-2"></i>
                        Mon profil
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#" data-demo>
                        <i class="bi bi-gear me-2"></i>
                        Paramètres du compte
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item" href="#">
                            <i class="bi bi-box-arrow-left me-2"></i>
                            Déconnexion
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
