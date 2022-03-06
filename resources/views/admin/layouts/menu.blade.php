<li class="nav-item">
    <a class="nav-link" href="{{ route('admin') }}">
        <i class="fa fa-fw fa-home"></i>
        <p>Accueil</p>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.users') }}">
        <i class="fa fa-fw fa-users"></i>
        <p>Utilisateurs</p>
    </a>
</li>
<li class="nav-header">FACTURATION</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.invoices') }}">
        <i class="fa fa-fw fa-file-alt"></i>
        <p>Factures</p>
    </a>
</li>
<li class="nav-header">TICKET</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.tickets') }}">
        <i class="fa fa-fw fa-support"></i>
        <p>Tickets</p>
    </a>
</li>
<li class="nav-header">Pterodactyl</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.pterodactyl.nodes') }}">
        <i class="fa fa-fw fa-server"></i>
        <p>Nodes</p>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.pterodactyl.products') }}">
        <i class="fa fa-fw fa-database"></i>
        <p>Produits</p>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.pterodactyl.services') }}">
        <i class="fa fa-fw fa-cubes"></i>
        <p>Services</p>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.pterodactyl.logs') }}">
        <i class="fa fa-fw fa-newspaper"></i>
        <p>Logs</p>
    </a>
</li>