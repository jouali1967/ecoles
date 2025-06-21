<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>AdminLTE v4 | Dashboard</title>
  <!--begin::Primary Meta Tags-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="title" content="AdminLTE v4 | Dashboard" />
  <meta name="author" content="ColorlibHQ" />
  <meta name="description"
    content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS." />
  <meta name="keywords"
    content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard" />
  <!--end::Primary Meta Tags-->
  <!--begin::Fonts-->
  {{--
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous" /> --}}
  <!--end::Third Party Plugin(Bootstrap Icons)-->
  <!--begin::Required Plugin(AdminLTE)-->
  <link rel="stylesheet" href="{{ asset('assets/bootstrap-icons/bootstrap-icons.min.css') }}" />
  {{-- <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script> --}}
  <link rel="stylesheet" href="{{ asset('dist/datepicker/flatpickr.min.css') }}">
  {{--
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css"> --}}
  <link rel="stylesheet" href="{{ asset('dist/datepicker/monthSelectStyle.css') }}">
  <link href="{{ asset('dist/css/select2.min.css') }}" rel="stylesheet" />

  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}" />
  <!--end::Required Plugin(AdminLTE)-->
  @livewireStyles
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <!--begin::App Wrapper-->
  <div class="app-wrapper">
    <!--begin::Header-->
    <nav class="app-header navbar navbar-expand bg-body">
      <!--begin::Container-->
      <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
              <i class="bi bi-list"></i>
            </a>
          </li>
        </ul>
        <!--end::Start Navbar Links-->
        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
          <!--begin::User Menu Simple-->
          <li class="nav-item d-flex align-items-center gap-3">
            <div class="d-flex align-items-center">
              <img src="{{ asset('dist/assets/img/user2-160x160.jpg') }}" class="rounded-circle shadow me-2"
                style="width: 32px; height: 32px;" alt="User Image" />
              <span class="d-none d-md-inline text-dark">{{ Auth::user()->name }}</span>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
              @csrf
              <button type="submit" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-sign-out-alt me-2"></i>
                <span class="d-none d-md-inline">Déconnexion</span>
              </button>
            </form>
          </li>
          <!--end::User Menu Simple-->
        </ul>
        <!--end::End Navbar Links-->
      </div>
      <!--end::Container-->
    </nav>
    <!--end::Header-->
    <!--begin::Sidebar-->
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
      <!--begin::Sidebar Brand-->
      <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="#" class="brand-link">
          <!--begin::Brand Image-->
          <img src="{{ asset('dist/assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image opacity-75 shadow" />
          <!--end::Brand Image-->
          <!--begin::Brand Text-->
          <span class="brand-text fw-light">Etudiants</span>
          <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
      </div>
      <!--end::Sidebar Brand-->
      <!--begin::Sidebar Wrapper-->
      <div class="sidebar-wrapper">
        <nav class="mt-2">
          <!--begin::Sidebar Menu-->
          <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
            <li class="nav-item {{ request()->routeIs('classes.*') ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ request()->routeIs('classes.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-speedometer"></i>
                <p>
                  Classes
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a wire:navigate href="{{ route('classes.maj') }}"
                    class="nav-link {{ request()->routeIs('classes.maj') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-circle"></i>
                    <p>Ajouter Classe</p>
                  </a>
                </li>
            </li>
          </ul>
          </li>
          <li class="nav-item {{ request()->routeIs('matieres.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('matieres.*') ? 'active' : '' }}">
              <i class="nav-icon bi bi-box-seam-fill"></i>
              <p>
                Matieres
                <i class="nav-arrow bi bi-chevron-right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a wire:navigate href="{{ route('matieres.maj') }}"
                  class="nav-link {{ request()->routeIs('matieres.maj') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Liste Matiere</p>
                </a>
              </li>
              <li class="nav-item">
                <a wire:navigate href="{{ route('classes-matieres.create') }}"
                  class="nav-link {{ request()->routeIs('classes-matieres.create') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Classes_Matiers</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ request()->routeIs('etudiants.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('etudiants.*') ? 'active' : '' }}">
              <i class="nav-icon bi bi-box-seam-fill"></i>
              <p>
                Etudiants
                <i class="nav-arrow bi bi-chevron-right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a wire:navigate href="{{route('etudiants.create') }}"
                  class="nav-link {{ request()->routeIs('etudiants.create') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Ajouter Etudiant</p>
                </a>
              </li>
              <li class="nav-item">
                <a wire:navigate href="{{ route('etudiants.index') }}"
                  class="nav-link {{ request()->routeIs('etudiants.index') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Liste Etudiant</p>
                </a>
              </li>
              <li class="nav-item">
                <a wire:navigate href="{{ route('etudiants.create.insc') }}"
                  class="nav-link {{ request()->routeIs('etudiants.create.insc') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Nouvelle Inscription</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ request()->routeIs('notes.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('notes.*') ? 'active' : '' }}">
              <i class="nav-icon bi bi-box-seam-fill"></i>
              <p>
                Gestions Notes
                <i class="nav-arrow bi bi-chevron-right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a wire:navigate href="{{ route('notes.saisie') }}"
                  class="nav-link {{ request()->routeIs('notes.create') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Notes Etudiant</p>
                </a>
              </li>
              {{-- <li class="nav-item">
                <a wire:navigate href="{{ route('notes.index') }}"
                  class="nav-link {{ request()->routeIs('notes.index') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Lise Notes Etudiant</p>
                </a>
              </li> --}}
              <li class="nav-item">
                <a wire:navigate href="{{route('notes.suivi-notes') }}"
                  class="nav-link {{ request()->routeIs('notes.suivi-notes') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Suivi Notes Etudiant</p>
                </a>
              </li>
            </ul>
          </li>
          {{-- <li class="nav-item {{ request()->routeIs('parents.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('parents.*') ? 'active' : '' }}">
              <i class="nav-icon bi bi-box-seam-fill"></i>
              <p>
                Informations Parents
                <i class="nav-arrow bi bi-chevron-right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a wire:navigate href="{{ route('parents.create') }}"
                  class="nav-link {{ request()->routeIs('parents.create') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Ajouter Parents</p>
                </a>
              </li>
              <li class="nav-item">
                <a wire:navigate href="{{ route('parents.index') }}"
                  class="nav-link {{ request()->routeIs('parents.index') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Liste Parents</p>
                </a>
              </li>
            </ul>
          </li> --}}

          </ul>
          <!--end::Sidebar Menu-->
        </nav>
      </div>
      <!--end::Sidebar Wrapper-->
    </aside>
    <!--end::Sidebar-->
    <!--begin::App Main-->
    <main class="app-main">
      <div class="app-content">
        {{ $slot }}
      </div>
      <!--end::App Content-->
    </main>
    <!--end::App Main-->
    <!--begin::Footer-->
    <footer class="app-footer">
      <!--begin::To the end-->
      <div class="float-end d-none d-sm-inline">Anything you want</div>
      <!--end::To the end-->
      <!--begin::Copyright-->
      <strong>
        Copyright &copy; 2025-2026&nbsp;
        <a href="#" class="text-decoration-none">Gestions Des Employés</a>.
      </strong>
      All rights reserved.
      <!--end::Copyright-->
    </footer>
    <!--end::Footer-->
  </div>
  <!--end::App Wrapper-->
  <!--begin::Script-->
  <!--begin::Third Party Plugin(OverlayScrollbars)-->
  <script src="{{ asset('dist/js/jquery.js') }}"></script>
  <script src="{{ asset('dist/js/bootstrap.bundle.min.js') }}"> </script>
  <script src="{{ asset('assets/fontawesome/fontaesome6-3-0.js') }}" crossorigin="anonymous"></script>
  <script src="{{ asset('dist/datepicker/flatpickr.min.js') }}"></script>
  <script src="{{ asset('dist/datepicker/l10n/fr.js') }}"></script>
  <script src="{{ asset('dist/js/monthSelectIndex.js') }}"></script>
  <script src="{{ asset('dist/js/select2.min.js') }}"></script>
  <script src="{{ asset('dist/js/adminlte.js') }}"></script>

  @livewireScripts {{-- Laissez Livewire Scripts en dernier --}}
</body>

</html>

</body>

</html>