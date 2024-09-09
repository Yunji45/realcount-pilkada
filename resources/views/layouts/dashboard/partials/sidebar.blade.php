<div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
        <a href="index.html" class="logo">
            <img src="{{ asset('template/assets/img/logos.svg') }}" alt="navbar brand" class="navbar-brand"
                height="50" />
        </a>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
            </button>
        </div>
        <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
        </button>
    </div>
    <!-- End Logo Header -->
</div>
<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
        <ul class="nav nav-secondary">
            <li class="nav-item {{ Request::is('home') ? 'active' : '' }}">
                <a href="">
                    <i class="fas fa-home"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-section">
                <span class="sidebar-mini-icon">
                    <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section" style="color: black;font-weight:bold">Master Data</h4>
            </li>
            <li class="nav-item {{ Request::is('user*', 'role*', 'permission*') ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#user_management"
                    class="collapsed {{ Request::is('user*', 'role*', 'permission*') ? '' : 'collapsed' }}"
                    aria-expanded="{{ Request::is('user*', 'role*', 'permission*') ? 'true' : 'false' }}">
                    <i class="fas fa-users"></i>
                    <p>User Management</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse {{ Request::is('user*', 'role*', 'permission*') ? 'show' : '' }}"
                    id="user_management">
                    <ul class="nav nav-collapse">
                        <li class="{{ Request::is('user*') ? 'active' : '' }}">
                            <a href="{{ route('user.index') }}">
                                <span class="sub-item">All Users</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('user*') ? 'active' : '' }}">
                            <a href="{{ route('user.pending') }}">
                                <span class="sub-item">Users Pending</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('role*') ? 'active' : '' }}">
                            <a href="{{ route('role.index') }}">
                                <span class="sub-item">Roles</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('permission*') ? 'active' : '' }}">
                            <a href="{{ route('permission.index') }}">
                                <span class="sub-item">Permissions</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item {{ Request::is('partai*') ? 'active' : '' }}">
                <a href="{{ route('partai.index') }}">
                    <i class="fas fa-desktop"></i>
                    <p>Partai</p>
                </a>
            </li>
            <li class="nav-item {{ Request::is('election*') ? 'active' : '' }}">
                <a href="{{ route('election.index') }}">
                    <i class="fas fa-desktop"></i>
                    <p>Pemilu</p>
                </a>
            </li>
            <li class="nav-item {{ Request::is('candidate*') ? 'active' : '' }}">
                <a href="{{ route('candidate.index') }}">
                    <i class="fas fa-desktop"></i>
                    <p>Kandidat</p>
                </a>
            </li>
            <li class="nav-item {{ Request::is('tps*') ? 'active' : '' }}">
                <a href="{{ route('tps.index') }}">
                    <i class="fas fa-desktop"></i>
                    <p>TPS</p>
                </a>
            </li>
            <li class="nav-item {{ Request::is('vote*') ? 'active' : '' }}">
                <a href="{{ route('vote.index') }}">
                    <i class="fas fa-desktop"></i>
                    <p>Suara</p>
                </a>
            </li>
            <li class="nav-item {{ Request::is('agenda*') ? 'active' : '' }}">
                <a href="{{ route('agenda.index') }}">
                    <i class="fas fa-desktop"></i>
                    <p>Agenda</p>
                </a>
            </li>
            <li class="nav-item {{ Request::is('kegiatan*') ? 'active' : '' }}">
                <a href="{{ route('kegiatan.index') }}">
                    <i class="fas fa-desktop"></i>
                    <p>Kegiatan</p>
                </a>
            </li>
            <li class="nav-item {{ Request::is('articles*') ? 'active' : '' }}">
                <a href="{{ route('articles.index') }}">
                    <i class="fas fa-desktop"></i>
                    <p>Berita</p>
                </a>
            </li>
        </ul>
    </div>
</div>
