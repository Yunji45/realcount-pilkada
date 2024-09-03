<div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
        <a href="index.html" class="logo">
            <img src="{{ asset('template/assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand"
                height="20" />
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
            <li class="nav-item active">
                <a data-bs-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                    <i class="fas fa-home"></i>
                    <p>Dashboard</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="dashboard">
                    <ul class="nav nav-collapse">
                        <li>
                            <a href="../demo1/index.html">
                                <span class="sub-item">Dashboard 1</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-section">
                <span class="sidebar-mini-icon">
                    <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Master Data</h4>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#user_management" class="collapsed" aria-expanded="false">
                    <i class="fas fa-home"></i>
                    <p>User Management</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="user_management">
                    <ul class="nav nav-collapse">
                        <li>
                            <a href="{{ route('user.index') }}">
                                <span class="sub-item">Users</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('role.index') }}">
                                <span class="sub-item">Roles</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('permission.index') }}">
                                <span class="sub-item">Permissions</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a href="widgets.html">
                    <i class="fas fa-desktop"></i>
                    <p>Widgets</p>
                    <span class="badge badge-success">4</span>
                </a>
            </li>
        </ul>
    </div>
</div>
