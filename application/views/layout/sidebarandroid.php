  <!-- Page Wrapper -->
  <div id="wrapper">

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar"  >

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <img src="<?= base_url('assets/img/hasbi.png')?>" alt="" width="60"> 
        <div class="sidebar-brand-text mx-3" style="color:black">Snacksnake</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0" style="border:3px solid black;">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?= base_url('android')?>" style="color:black">
            <i class="fas fa-fw fa-table"></i>
            <span>Menu Utama</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item active">
        <a class="nav-link" href="<?= base_url('android/cart')?>" style="color:black">
            <i class="fas fa-fw fa-pen"></i>
            <span>Keranjang</span></a>
    </li>
    <li class="nav-item active">
        <a class="nav-link" href="<?= base_url('android/pesanan')?>" style="color:black">
            <i class="fas fa-fw fa-list"></i>
            <span>Pesanan Kamu</span></a>
    </li>

  
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>



</ul>