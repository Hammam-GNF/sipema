<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="{{ route('petugas.dashboard') }}" class="simple-text logo-mini">
            <div class="logo-image-small">
                <img src="../assets/img/logo-small.png">
            </div>
        </a>
        <a href="{{ route('petugas.dashboard') }}" class="simple-text logo-normal">
            SIPEMA
        </a>
    </div>
    <!-- Menu List -->
    <div class="sidebar-wrapper">
        <ul class="nav overflow-hidden">
            <li class="{{ Route::currentRouteName() == 'petugas.dashboard' ? 'active' : '' }}">
                <a href="{{ route('petugas.dashboard') }}">
                    <i class="bi bi-house-door"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="{{ Route::currentRouteName() == 'petugas.pengaduan.index' ? 'active' : '' }}">
                <a href="{{ route('petugas.pengaduan.index') }}">
                    <i class="nc-icon nc-tile-56"></i>
                    <p>Data Pengaduan</p>
                </a>
            </li>
            <li class="{{ Route::currentRouteName() == 'petugas.notifikasi.index' ? 'active' : '' }}">
                <a href="{{ route('petugas.notifikasi.index') }}">
                    <i class="bi bi-chat-dots"></i> 
                    <p>Pesan</p>
                </a>
            </li>
        </ul>
    </div>
</div>