<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="{{ route('home') }}">
        <img src="/logo.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">{{ config('app.name') }}</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('home') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Facturation</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="{{ route('invoices') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-file-alt text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Factures</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Gestion des services</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('services.game') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-server text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Services Game</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Support</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('tickets') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-support text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Tickets</span>
          </a>
        </li>
        @if(Auth::user()->role == 'admin')
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Administration</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-user text-danger text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1 text-red">Administration</span>
          </a>
        </li>
        @endif
      </ul>
    </div>
    <div class="sidenav-footer mx-3 ">
      @if(View::hasSection('sidebar.ticket'))
        @yield('sidebar.ticket')
      @else
      <div class="card card-plain shadow-none" id="sidenavCard">
        <img class="w-50 mx-auto" src="/assets/img/illustrations/icon-documentation.svg" alt="sidebar_illustration">
        <div class="card-body text-center p-3 w-100 pt-0">
          <div class="docs-info">
            <h6 class="mb-0">Besoin d'aide ?</h6>
            <p class="text-xs font-weight-bold mb-0">Contactez-nous</p>
          </div>
        </div>
      </div>
      <a href="mailto:contact@swizcloud.fr" target="_blank" class="btn btn-dark btn-sm w-100 mb-3">Envoyer un mail</a>
      <a class="btn btn-primary btn-sm mb-0 w-100" href="{{ route('ticket.new') }}">Ouvrir une demande</a>
      @endif
    </div>
  </aside>