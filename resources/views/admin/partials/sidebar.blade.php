<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="{{ route('admin.dashboard') }}" class="simple-text logo-mini">
            <div class="logo-image-small">
                <img src="../assets/img/logo-small.png">
            </div>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="simple-text logo-normal">
            SIPEMA
        </a>
    </div>
    <!-- Menu List -->
    <div class="sidebar-wrapper">
        <ul class="nav overflow-hidden">
            <li class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="nc-icon nc-bank"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="{{ Route::currentRouteName() == 'petugas.index' ? 'active' : '' }}">
                <a href="{{ route('petugas.index') }}">
                    <i class="nc-icon nc-single-02"></i>
                    <p>Data Petugas</p>
                </a>
            </li>
            <li class="{{ Route::currentRouteName() == 'user.index' ? 'active' : '' }}">
                <a href="{{ route('user.index') }}">
                    <i class="nc-icon nc-single-02"></i>
                    <p>Data Pengguna</p>
                </a>
            </li>
            <!-- Pengaduan with Submenu -->
            <li class="nav-item {{ in_array(Route::currentRouteName(), ['pengaduan.index', 'pengaduan.detail.index', 'tindakLanjut.index']) ? 'active' : '' }}">
                <a data-toggle="collapse" href="#pengaduanSubmenu" aria-expanded="false" class="nav-link">
                    <i class="bi bi-bandaid"></i>
                    <p>Pengaduan</p>
                    <b class="caret"></b>
                </a>
                <div class="collapse {{ in_array(Route::currentRouteName(), ['pengaduan.index', 'pengaduan.detail.index', 'tindakLanjut.index']) ? 'show' : '' }}" id="pengaduanSubmenu">
                    <ul class="nav pl-3">
                        <li class="{{ Route::currentRouteName() == 'pengaduan.index' ? 'active' : '' }}">
                            <a href="{{ route('pengaduan.index') }}">
                                <i class="nc-icon nc-tile-56"></i>
                                <p>Data</p>
                            </a>
                        </li>
                        <li class="{{ Route::currentRouteName() == 'tindakLanjut.index' ? 'active' : '' }}">
                            <a href="{{ route('tindakLanjut.index') }}">
                                <i class="bi bi-check-circle"></i>
                                <p>Tindak Lanjut</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="{{ Route::currentRouteName() == 'laporan.index' ? 'active' : '' }}">
                <a href="{{ route('laporan.index') }}">
                    <i class="bi bi-clipboard-data"></i>
                    <p>Laporan</p>
                </a>
            </li>
        </ul>
    </div>
</div>