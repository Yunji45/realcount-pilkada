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
            {{-- Super Admin --}}
            @role('Super Admin')
                <li class="nav-item {{ Request::is('superadmin/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('superadmin.dashboard') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: currentColor;">
                            <path
                                d="M24,19V4c0-1.654-1.346-3-3-3H3C1.346,1,0,2.346,0,4v15H11v2H6v2h12v-2h-5v-2h11ZM16,5h5v2h-5v-2Zm0,4h5v2h-5v-2Zm0,4h5v2h-5v-2Zm-8,2c-2.761,0-5-2.239-5-5,0-2.419,1.718-4.436,4-4.899v5.313l3.754,3.754c-.79,.523-1.736,.832-2.754,.832Zm4.168-2.246l-3.168-3.168V5.101c2.282,.463,4,2.48,4,4.899,0,1.019-.308,1.964-.832,2.754Z" />
                        </svg>
                        <p style="margin-left:16px">Dashboard</p>
                    </a>
                </li>
            @endrole

            {{-- Admin --}}
            @role('Admin')
                <li class="nav-item {{ Request::is('admin/dashboard/perorangan*', 'admin/dashboard/partai*', 'admin/dashboard/peta*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#adminDashboard"
                        class="{{ Request::is('admin/dashboard/perorangan*', 'admin/dashboard/partai*', 'admin/dashboard/peta*') ? '' : 'collapsed' }}"
                        aria-expanded="{{ Request::is('admin/dashboard/perorangan*', 'admin/dashboard/partai*', 'admin/dashboard/peta*') ? 'true' : 'false' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: currentColor;">
                            <path
                                d="M24,19V4c0-1.654-1.346-3-3-3H3C1.346,1,0,2.346,0,4v15H11v2H6v2h12v-2h-5v-2h11ZM16,5h5v2h-5v-2Zm0,4h5v2h-5v-2Zm0,4h5v2h-5v-2Zm-8,2c-2.761,0-5-2.239-5-5,0-2.419,1.718-4.436,4-4.899v5.313l3.754,3.754c-.79,.523-1.736,.832-2.754,.832Zm4.168-2.246l-3.168-3.168V5.101c2.282,.463,4,2.48,4,4.899,0,1.019-.308,1.964-.832,2.754Z" />
                        </svg>
                        <p style="margin-left:16px">Dashboard</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ Request::is('admin/dashboard/perorangan*', 'admin/dashboard/partai*', 'admin/dashboard/peta*') ? 'show' : '' }}"
                        id="adminDashboard">
                        <ul class="nav nav-collapse">
                            <li class="{{ Request::is('admin/dashboard/perorangan*') ? 'active' : '' }}">
                                <a href="{{ route('admin.dashboard.perorangan') }}">
                                    <span class="sub-item">Perorangan</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('admin/dashboard/partai*') ? 'active' : '' }}">
                                <a href="{{ route('admin.dashboard.partai') }}">
                                    <span class="sub-item">Partai</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('admin/dashboard/peta*') ? 'active' : '' }}">
                                <a href="{{ route('admin.dashboard.peta') }}">
                                    <span class="sub-item">Peta</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endrole

            @role('Relawan RDW')
                <li class="nav-item {{ Request::is('relawan/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('relawan.dashboard') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: currentColor;">
                            <path
                                d="M24,19V4c0-1.654-1.346-3-3-3H3C1.346,1,0,2.346,0,4v15H11v2H6v2h12v-2h-5v-2h11ZM16,5h5v2h-5v-2Zm0,4h5v2h-5v-2Zm0,4h5v2h-5v-2Zm-8,2c-2.761,0-5-2.239-5-5,0-2.419,1.718-4.436,4-4.899v5.313l3.754,3.754c-.79,.523-1.736,.832-2.754,.832Zm4.168-2.246l-3.168-3.168V5.101c2.282,.463,4,2.48,4,4.899,0,1.019-.308,1.964-.832,2.754Z" />
                        </svg>
                        <p style="margin-left:16px">Dashboard</p>
                    </a>
                </li>
            @endrole
            @role('Saksi')
                <li class="nav-item {{ Request::is('saksi/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('saksi.dashboard') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: currentColor;">
                            <path
                                d="M24,19V4c0-1.654-1.346-3-3-3H3C1.346,1,0,2.346,0,4v15H11v2H6v2h12v-2h-5v-2h11ZM16,5h5v2h-5v-2Zm0,4h5v2h-5v-2Zm0,4h5v2h-5v-2Zm-8,2c-2.761,0-5-2.239-5-5,0-2.419,1.718-4.436,4-4.899v5.313l3.754,3.754c-.79,.523-1.736,.832-2.754,.832Zm4.168-2.246l-3.168-3.168V5.101c2.282,.463,4,2.48,4,4.899,0,1.019-.308,1.964-.832,2.754Z" />
                        </svg>
                        <p style="margin-left:16px">Dashboard</p>
                    </a>
                </li>
            @endrole
            @role('Koordinator')
                <li class="nav-item {{ Request::is('koordinator/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('koordinator.dashboard') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: currentColor;">
                            <path
                                d="M24,19V4c0-1.654-1.346-3-3-3H3C1.346,1,0,2.346,0,4v15H11v2H6v2h12v-2h-5v-2h11ZM16,5h5v2h-5v-2Zm0,4h5v2h-5v-2Zm0,4h5v2h-5v-2Zm-8,2c-2.761,0-5-2.239-5-5,0-2.419,1.718-4.436,4-4.899v5.313l3.754,3.754c-.79,.523-1.736,.832-2.754,.832Zm4.168-2.246l-3.168-3.168V5.101c2.282,.463,4,2.48,4,4.899,0,1.019-.308,1.964-.832,2.754Z" />
                        </svg>
                        <p style="margin-left:16px">Dashboard</p>
                    </a>
                </li>
            @endrole
            @role('Pimpinan')
                <li class="nav-item {{ Request::is('pimpinan/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('pimpinan.dashboard') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: currentColor;">
                            <path
                                d="M24,19V4c0-1.654-1.346-3-3-3H3C1.346,1,0,2.346,0,4v15H11v2H6v2h12v-2h-5v-2h11ZM16,5h5v2h-5v-2Zm0,4h5v2h-5v-2Zm0,4h5v2h-5v-2Zm-8,2c-2.761,0-5-2.239-5-5,0-2.419,1.718-4.436,4-4.899v5.313l3.754,3.754c-.79,.523-1.736,.832-2.754,.832Zm4.168-2.246l-3.168-3.168V5.101c2.282,.463,4,2.48,4,4.899,0,1.019-.308,1.964-.832,2.754Z" />
                        </svg>
                        <p style="margin-left:16px">Dashboard</p>
                    </a>
                </li>
            @endrole
            @role('Pemilih')
                <li class="nav-item {{ Request::is('pemilih/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('pemilih.dashboard') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: currentColor;">
                            <path
                                d="M24,19V4c0-1.654-1.346-3-3-3H3C1.346,1,0,2.346,0,4v15H11v2H6v2h12v-2h-5v-2h11ZM16,5h5v2h-5v-2Zm0,4h5v2h-5v-2Zm0,4h5v2h-5v-2Zm-8,2c-2.761,0-5-2.239-5-5,0-2.419,1.718-4.436,4-4.899v5.313l3.754,3.754c-.79,.523-1.736,.832-2.754,.832Zm4.168-2.246l-3.168-3.168V5.101c2.282,.463,4,2.48,4,4.899,0,1.019-.308,1.964-.832,2.754Z" />
                        </svg>
                        <p style="margin-left:16px">Dashboard</p>
                    </a>
                </li>
            @endrole
            @role('Simpatisan')
                <li class="nav-item {{ Request::is('simpatisan/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('simpatisan.dashboard') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: currentColor;">
                            <path
                                d="M24,19V4c0-1.654-1.346-3-3-3H3C1.346,1,0,2.346,0,4v15H11v2H6v2h12v-2h-5v-2h11ZM16,5h5v2h-5v-2Zm0,4h5v2h-5v-2Zm0,4h5v2h-5v-2Zm-8,2c-2.761,0-5-2.239-5-5,0-2.419,1.718-4.436,4-4.899v5.313l3.754,3.754c-.79,.523-1.736,.832-2.754,.832Zm4.168-2.246l-3.168-3.168V5.101c2.282,.463,4,2.48,4,4.899,0,1.019-.308,1.964-.832,2.754Z" />
                        </svg>
                        <p style="margin-left:16px">Dashboard</p>
                    </a>
                </li>
            @endrole
            @role('Lain-lain')
                <li class="nav-item {{ Request::is('lain-lain/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('lain-lain.dashboard') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: currentColor;">
                            <path
                                d="M24,19V4c0-1.654-1.346-3-3-3H3C1.346,1,0,2.346,0,4v15H11v2H6v2h12v-2h-5v-2h11ZM16,5h5v2h-5v-2Zm0,4h5v2h-5v-2Zm0,4h5v2h-5v-2Zm-8,2c-2.761,0-5-2.239-5-5,0-2.419,1.718-4.436,4-4.899v5.313l3.754,3.754c-.79,.523-1.736,.832-2.754,.832Zm4.168-2.246l-3.168-3.168V5.101c2.282,.463,4,2.48,4,4.899,0,1.019-.308,1.964-.832,2.754Z" />
                        </svg>
                        <p style="margin-left:16px">Dashboard</p>
                    </a>
                </li>
            @endrole

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
                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24"
                        width="24" height="24">
                        <path
                            d="M12,17a4,4,0,1,1,4-4A4,4,0,0,1,12,17Zm6,4a3,3,0,0,0-3-3H9a3,3,0,0,0-3,3v3H18ZM18,8a4,4,0,1,1,4-4A4,4,0,0,1,18,8ZM6,8a4,4,0,1,1,4-4A4,4,0,0,1,6,8Zm0,5A5.968,5.968,0,0,1,7.537,9H3a3,3,0,0,0-3,3v3H6.349A5.971,5.971,0,0,1,6,13Zm11.651,2H24V12a3,3,0,0,0-3-3H16.463a5.952,5.952,0,0,1,1.188,6Z" />
                    </svg>
                    <p style="margin-left:16px">User Management</p>
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
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                        style="fill: currentColor;">
                        <path
                            d="m19,2C19,.895,19.895,0,21,0s2,.895,2,2-.895,2-2,2-2-.895-2-2ZM3,4c1.105,0,2-.895,2-2S4.105,0,3,0,1,.895,1,2s.895,2,2,2Zm20.341,4c.454,0,.76-.444.628-.878-.376-1.228-1.518-2.122-2.869-2.122h-1.169c.041.328.069.661.069,1,0,.692-.097,1.36-.262,2h3.603ZM4.069,5h-1.154C1.533,5,.368,5.935.021,7.208c-.11.403.229.792.647.792h3.594c-.165-.64-.262-1.308-.262-2,0-.339.028-.672.069-1Zm18.931,18.407v.593H6.538l-1.821-1.628c-.917-.858-.96-2.307-.098-3.23.861-.922,2.313-.97,3.235-.109.034.032,1.069.898,2.145,1.784v-9.817c0-1.215,1.083-2.176,2.336-1.973.983.16,1.664,1.083,1.664,2.08v5.355l5.829,2.292c1.913.752,3.171,2.598,3.171,4.653ZM12,0c-3.309,0-6,2.691-6,6,0,1.796.8,3.401,2.054,4.501.124-.984.588-1.897,1.355-2.548.896-.761,2.078-1.088,3.248-.899,1.709.278,3.033,1.711,3.289,3.447,1.254-1.1,2.054-2.705,2.054-4.5,0-3.309-2.691-6-6-6Zm0,6c-1.105,0-2-.895-2-2s.895-2,2-2,2,.895,2,2-.895,2-2,2Z" />
                    </svg>
                    <p style="margin-left:16px">Partai</p>
                </a>
            </li>

            <li class="nav-item {{ Request::is('election*') ? 'active' : '' }}">
                <a href="{{ route('election.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24"
                        width="24" height="24">
                        <path
                            d="m12,10c2.757,0,5-2.243,5-5S14.757,0,12,0s-5,2.243-5,5,2.243,5,5,5Zm2.413,1.38c2.639.839,4.689,3.011,5.352,5.724.111.454-.232.896-.7.896h-5.352l-1.116-3.897,1.816-2.723Zm-10.179,5.724c.663-2.713,2.713-4.885,5.352-5.724l1.816,2.723-1.116,3.897h-5.352c-.468,0-.81-.442-.7-.896Zm19.766,3.896c0,.552-.448,1-1,1h-1v1c0,.552-.448,1-1,1H3c-.552,0-1-.448-1-1v-1h-1c-.552,0-1-.448-1-1s.448-1,1-1h22c.552,0,1,.448,1,1Z" />
                    </svg>

                    <p style="margin-left: 16px">Pemilu</p>
                </a>
            </li>
            <li class="nav-item {{ Request::is('candidate*') ? 'active' : '' }}">
                <a href="{{ route('candidate.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24"
                        width="24" height="24">
                        <path
                            d="m18.5,16c-2.206,0-4-1.794-4-4s1.794-4,4-4,4,1.794,4,4-1.794,4-4,4Zm-6.5-8c-2.206,0-4-1.794-4-4S9.794,0,12,0s4,1.794,4,4-1.794,4-4,4Zm-6.5,8c-2.206,0-4-1.794-4-4s1.794-4,4-4,4,1.794,4,4-1.794,4-4,4Zm5.5,8v-3c0-1.629-1.3-2.947-2.918-2.992l-2.582,2.992-2.621-2.988c-1.6.065-2.879,1.372-2.879,2.988v3m24,0v-3c0-1.629-1.3-2.947-2.918-2.992l-2.582,2.992-2.621-2.988c-1.6.065-2.879,1.372-2.879,2.988v3" />
                    </svg>

                    <p style="margin-left: 16px">Kandidat</p>
                </a>
            </li>
            <li class="nav-item {{ Request::is('tps*') ? 'active' : '' }}">
                <a href="{{ route('tps.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24"
                        width="24" height="24">
                        <path
                            d="M23.576,6.429l-1.91-3.171L12,.036,2.334,3.258,.442,6.397c-.475,.792-.563,1.742-.243,2.607,.31,.839,.964,1.488,1.8,1.793l-.008,9.844,10,3.333,10-3.333,.008-9.844c.846-.296,1.507-.946,1.819-1.788,.317-.857,.229-1.797-.242-2.582Zm-5.737-2.338l-5.831,1.946-5.833-1.951,5.825-1.942,5.839,1.946ZM2.156,7.428l1.292-2.145,7.048,2.357-1.529,2.549c-.239,.398-.735,.581-1.173,.434l-5.081-1.693c-.297-.099-.53-.324-.639-.618-.108-.293-.079-.616,.082-.883Zm1.843,4.038l3.163,1.054c1.343,.448,2.792-.088,3.521-1.302l.316-.526-.005,10.843-7-2.333,.006-7.735Zm8.994,10.068l.005-10.849,.319,.532c.556,.928,1.532,1.459,2.561,1.459,.319,0,.643-.051,.96-.157l3.161-1.053-.006,7.734-7,2.333Zm8.95-13.216c-.105,.285-.331,.503-.619,.599l-5.118,1.706c-.438,.147-.934-.035-1.173-.434l-1.526-2.543,7.051-2.353,1.305,2.167c.156,.26,.186,.573,.08,.858Z" />
                    </svg>
                    <p style="margin-left:16px">TPS</p>
                </a>
            </li>
            <li class="nav-item {{ Request::is('vote*') ? 'active' : '' }}">
                <a href="{{ route('vote.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24"
                        width="24" height="24">
                        <path
                            d="M23.577,10.352l-2.133-3.554-9.444,3.148L2.556,6.798,.442,10.319c-.475,.791-.563,1.741-.243,2.606,.31,.839,.963,1.488,1.801,1.793v5.934l10,3.333,10-3.333v-5.933c.846-.296,1.507-.946,1.818-1.788,.316-.856,.229-1.797-.241-2.58Zm-21.42,.997l1.287-2.146,7.057,2.353-1.533,2.555c-.243,.406-.729,.583-1.174,.435l-5.081-1.693c-.297-.1-.529-.325-.638-.618-.109-.294-.079-.616,.082-.884Zm1.843,4.038l3.161,1.054c.317,.106,.642,.157,.96,.157,1.029,0,2.005-.531,2.562-1.459l.317-.529v6.936l-7-2.334v-3.825Zm9,6.159v-6.936l.317,.529c.557,.928,1.533,1.459,2.562,1.459,.318,0,.642-.051,.96-.157l3.161-1.053v3.825l-7,2.334Zm8.942-9.307c-.105,.285-.331,.504-.619,.601l-5.117,1.705c-.45,.147-.931-.028-1.174-.435l-1.533-2.555,7.057-2.353,1.307,2.179c.156,.26,.186,.572,.08,.857ZM7.163,6.226l-2.121-.707L10.525,.036l2.749,2.749,1.199-1.199,4.071,4.071-2.121,.707-1.95-1.95-3.187,3.187-2.121-.707,2.694-2.694-1.335-1.335-3.362,3.362Z" />
                    </svg>
                    <p style="margin-left:16px">Suara</p>
                </a>
            </li>
            <li class="nav-item {{ Request::is('agenda*') ? 'active' : '' }}">
                <a href="{{ route('agenda.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24"
                        width="24" height="24">
                        <path
                            d="M20,0H3V3H1v2H3v2H1v2H3v2H1v2H3v2H1v2H3v2H1v2H3v3H20c1.65,0,3-1.35,3-3V3c0-1.65-1.35-3-3-3ZM5,2h3V22h-3V2ZM21,21c0,.55-.45,1-1,1H10V2h10c.55,0,1,.45,1,1V21Z" />
                    </svg>
                    <p style="margin-left:16px">Agenda</p>
                </a>
            </li>
            <li class="nav-item {{ Request::is('kegiatan*') ? 'active' : '' }}">
                <a href="{{ route('kegiatan.index') }}">

                    <svg id="Layer_1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                        data-name="Layer 1"width="24" height="24">
                        <path
                            d="m21 4h-6v-1a3 3 0 0 0 -6 0v1h-6a3 3 0 0 0 -3 3v17h24v-17a3 3 0 0 0 -3-3zm-10-1a1 1 0 0 1 2 0v3h-2zm11 19h-20v-15a1 1 0 0 1 1-1h6v2h6v-2h6a1 1 0 0 1 1 1zm-18-2h7v-10h-7zm2-8h3v6h-3zm7 2h7v2h-7zm0-4h7v2h-7zm0 8h5v2h-5z" />
                    </svg>
                    <p style="margin-left:16px">Kegiatan</p>
                </a>
            </li>

            <li class="nav-item {{ Request::is('articles*', 'category_articles*') ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#berita"
                    class="collapsed {{ Request::is('articles*', 'category_articles*') ? '' : 'collapsed' }}"
                    aria-expanded="{{ Request::is('articles*', 'category_articles*') ? 'true' : 'false' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24"
                        width="24" height="24">
                        <path
                            d="m21,0h-13c-1.654,0-3,1.346-3,3v3H0v14.5c0,1.93,1.57,3.5,3.5,3.5h17c1.93,0,3.5-1.57,3.5-3.5V3c0-1.654-1.346-3-3-3ZM5,20.5c0,.827-.673,1.5-1.5,1.5s-1.5-.673-1.5-1.5v-12.5h3v12.5Zm17,0c0,.827-.673,1.5-1.5,1.5H6.662c.216-.455.338-.963.338-1.5V3c0-.551.449-1,1-1h13c.551,0,1,.449,1,1v17.5Zm-7-14.5h5v2h-5v-2Zm-6,4h11v2h-11v-2Zm0,4h11v2h-11v-2Zm0,4h11v2h-11v-2Zm4-10h-4v-4h4v4Z" />
                    </svg>

                    <p style="margin-left: 16px">Berita</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse {{ Request::is('articles*', 'category_articles*') ? 'show' : '' }}"
                    id="berita">
                    <ul class="nav nav-collapse">
                        <li class="{{ Request::is('articles*') ? 'active' : '' }}">
                            <a href="{{ route('articles.index') }}">
                                <span class="sub-item">Berita</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('category_articles*') ? 'active' : '' }}">
                            <a href="{{ route('category_articles.index') }}">
                                <span class="sub-item">Kategori Artikel</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
