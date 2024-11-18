<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('/index.php'); ?>">
    <div class="sidebar-brand-icon">
      <img src="<?= base_url('/assets/img/logo.png'); ?>" alt="logo masjid" width="50" class="rounded-circle" />
    </div>
    <div class="sidebar-brand-text mx-3">
      LBC
    </div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item <?= ($act == 'home') ? 'active' : ''; ?>">
    <a class="nav-link" href="<?= base_url('/index.php'); ?>">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item <?= ($act == 'kategori') ? 'active' : ''; ?>">
    <a class="nav-link" href="<?= base_url('/kategori.php'); ?>">
      <i class="fas fa-fw fa-list"></i>
      <span>Kategori</span>
    </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Nav Item - kas masuk -->
  <li class="nav-item  <?= ($act == 'masuk') ? 'active' : ''; ?>">
    <a class="nav-link" href="<?= base_url('/masuk.php'); ?>">
      <i class="fas fa-fw fa-download"></i>
      <span>Kas Masuk</span>
    </a>
  </li>
  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Nav Item - kas keluar -->
  <li class="nav-item  <?= ($act == 'keluar') ? 'active' : ''; ?>">
    <a class="nav-link" href="<?= base_url('/keluar.php'); ?>">
      <i class="fas fa-fw fa-upload"></i>
      <span>Kas Keluar</span>
    </a>
  </li>
  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Nav Item - rekapitulasi -->
  <li class="nav-item  <?= ($act == 'rekap') ? 'active' : ''; ?>">
    <a class="nav-link" href="<?= base_url('/rekapitulasi.php'); ?>">
      <i class="fas fa-fw fa-list"></i>
      <span>Rekapitulasi</span>
    </a>
  </li>
  <!-- Divider -->
  <hr class="sidebar-divider">
  
  <?php if(getLevel() == "admin") : ?>
  <!-- Nav Item - User -->
  <li class="nav-item  <?= ($act == 'user') ? 'active' : ''; ?>">
    <a class="nav-link" href="<?= base_url('/user.php'); ?>">
      <i class="fas fa-fw fa-users"></i>
      <span>User</span>
    </a>
  </li>
  <!-- Divider -->
  <hr class="sidebar-divider">
  <?php endif; ?>

  <!-- Nav Item - my profile -->
  <li class="nav-item  <?= ($act == 'profile') ? 'active' : ''; ?>">
    <a class="nav-link" href="<?= base_url('/profile.php'); ?>">
      <i class="fas fa-fw fa-user"></i>
      <span>My Profile</span>
    </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>