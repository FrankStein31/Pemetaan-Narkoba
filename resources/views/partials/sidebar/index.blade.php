@if(auth()->check())
    @if(auth()->user()->is_admin == 1)
        <!-- Menu untuk Admin -->
        <li class="menu-header">Navigasi Utama</li>
<li class="menu-item {{ Request::is('admin/dashboard*') ? 'active' : '' }}">
  <a class="menu-link cursor-pointer" onclick="window.location.href='/admin/dashboard'">
    <i class="menu-icon tf-icons bx bx-desktop"></i>
    <div>Dashboard</div>
  </a>
</li>
<li class="menu-item {{ Request::is('maps*') ? 'active open' : '' }}">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
      <i class="menu-icon tf-icons bx bx-map"></i>
      <div>Peta</div>
    </a>
    <ul class="menu-sub">
      <li class="menu-item {{ Request::routeIs('maps.index') ? 'active' : '' }}">
        <a href="{{ route('maps.index') }}" class="menu-link">
          <div>Kerawanan</div>
        </a>
      </li>
      <li class="menu-item {{ Request::routeIs('maps-sosialisasi.index') ? 'active' : '' }}">
        <a href="{{ route('maps-sosialisasi.index') }}" class="menu-link">
          <div>Sosialisasi</div>
        </a>
      </li>
      <li class="menu-item {{ Request::routeIs('maps-jenis.index') ? 'active' : '' }}">
        <a href="{{ route('maps-jenis.index') }}" class="menu-link">
          <div>Jenis Narkoba</div>
        </a>
      </li>
    </ul>
  </li>

{{-- <li class="menu-item {{ Request::routeIs('maps.index') ? 'active' : '' }}">
    <a class="menu-link cursor-pointer" href="{{ route('maps.index') }}">
      <i class="menu-icon tf-icons bx bx-map"></i>
      <div>Peta</div>
    </a>
  </li> --}}
  <li class="menu-header">Data masyarakat</li>
<li class="menu-item {{ Request::is('admin/pasien*') ? 'active' : '' }}">
  <a class="menu-link cursor-pointer" onclick="window.location.href='/admin/pasien'">
    <i class="menu-icon tf-icons bx bx-group"></i>
    <div>Data Pengadu</div>
  </a>
</li>
<li class="menu-item {{ Request::is('admin/warga*') ? 'active' : '' }}">
  <a class="menu-link cursor-pointer" onclick="window.location.href='/admin/warga'">
    <i class="menu-icon tf-icons bx bx-group"></i>
    <div>Data Warga</div>
  </a>
</li>
<li class="menu-item {{ Request::is('warga-positif*') ? 'active' : '' }}">
    <a class="menu-link cursor-pointer" onclick="window.location.href='/warga-positif'">
      <i class="menu-icon tf-icons bx bx-group"></i>
      <div>Data Pasien Positif</div>
    </a>
  </li>
<li class="menu-header">Layanan</li>
<li class="menu-item {{ Request::routeIs('sosialisasi.index') ? 'active' : '' }} ">
  <a class="menu-link cursor-pointer" href="{{ route('sosialisasi.index') }}">
    <i class="menu-icon tf-icons bx bx-street-view"></i>
    <div>Sosialisasi</div>
  </a>
</li>
<li class="menu-item {{ Request::is('admin/antrian*') ? 'active' : '' }}">
  <a class="menu-link cursor-pointer" onclick="window.location.href='/admin/antrian'">
    <i class="menu-icon tf-icons bx bx-message-alt-error"></i>
    <div>Pendaftaran Aduan</div>
  </a>
</li>
<li class="menu-item {{ Request::routeIs('pengaduan.index') ? 'active' : '' }}">
  <a class="menu-link" href="{{ route('pengaduan.index') }}">
    <i class="menu-icon tf-icons bx bx-message-dots"></i>
    <div>Laporan Pengaduan</div>
  </a>
</li>

<li class="menu-item {{ Request::routeIs('messages.index') ? 'active' : '' }}">
  <a class="menu-link cursor-pointer" href="{{ route('messages.index') }}">
    <i class="menu-icon tf-icons bx bx-support"></i>
    <div>Kritik & Saran</div>
  </a>
</li>
<li class="menu-header">Pengaturan</li>
<li class="menu-item {{ Request::is('admin/pengaturan*') ? 'active' : '' }}">
  <a class="menu-link cursor-pointer" onclick="window.location.href='/admin/pengaturan'">
    <i class="menu-icon tf-icons bx bx-cog"></i>
    <div>Pengaturan</div>
  </a>
</li>

@elseif(auth()->user()->is_admin == 2)
<li class="menu-header">Navigasi Utama</li>
<li class="menu-item {{ Request::is('masyarakat/dashboard*') ? 'active' : '' }}">
  <a class="menu-link cursor-pointer" onclick="window.location.href='/masyarakat/dashboard'">
    <i class="menu-icon tf-icons bx bx-desktop"></i>
    <div>Dashboard</div>
  </a>
</li>
<li class="menu-item {{ Request::routeIs('maps.index') ? 'active' : '' }}">
    <a class="menu-link cursor-pointer" href="{{ route('maps.index') }}">
      <i class="menu-icon tf-icons bx bx-map"></i>
      <div>Peta</div>
    </a>
  </li>
  <li class="menu-header">Layanan</li>
  <li class="menu-item {{ Request::routeIs('messages.index') ? 'active' : '' }}">
    <a class="menu-link cursor-pointer" href="{{ route('messages.index') }}">
      <i class="menu-icon tf-icons bx bx-support"></i>
      <div>Kritik & Saran</div>
    </a>
  </li>
  <li class="menu-header">Pengaturan</li>
<li class="menu-item {{ Request::is('admin/pengaturan*') ? 'active' : '' }}">
  <a class="menu-link cursor-pointer" onclick="window.location.href='/admin/pengaturan'">
    <i class="menu-icon tf-icons bx bx-cog"></i>
    <div>Pengaturan</div>
  </a>
</li>


@else
<li class="menu-header">Navigasi Utama</li>

<li class="menu-item {{ Request::is('masyarakat/dashboard*') ? 'active' : '' }}">
    <a class="menu-link cursor-pointer" onclick="window.location.href='/masyarakat/dashboard'">
      <i class="menu-icon tf-icons bx bx-desktop"></i>
      <div>Dashboard</div>
    </a>
  </li>
  <li class="menu-item {{ Request::routeIs('maps.index') ? 'active' : '' }}">
    <a class="menu-link cursor-pointer" href="{{ route('maps.index') }}">
      <i class="menu-icon tf-icons bx bx-map"></i>
      <div>Peta</div>
    </a>
  </li>

  <li class="menu-header">Layanan</li>
<li class="menu-item {{ Request::routeIs('pengaduan.tambah') ? 'active' : '' }}">
    <a class="menu-link" href="{{ route('pengaduan.tambah') }}" >
      <i class="menu-icon tf-icons bx bx-edit"></i>
      <div>Pengaduan</div>
    </a>
  </li>
  <li class="menu-item {{ Request::routeIs('messages.indextambah') ? 'active' : '' }}">
    <a class="menu-link cursor-pointer" href="{{ route('messages.indextambah') }}">
      <i class="menu-icon tf-icons bx bx-support"></i>
      <div>Kritik & Saran</div>
    </a>
  </li>

  <li class="menu-header">Pengaturan</li>
  <li class="menu-item {{ Request::is('admin/pengaturan*') ? 'active' : '' }}">
    <a class="menu-link cursor-pointer" onclick="window.location.href='/admin/pengaturan'">
      <i class="menu-icon tf-icons bx bx-cog"></i>
      <div>Pengaturan</div>
    </a>
  </li>
  @endif
  @endif