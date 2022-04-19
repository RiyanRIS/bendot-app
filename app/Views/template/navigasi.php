  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= site_url() ?>" class="brand-link">
      <img src="<?= base_url() ?>/assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><?= (session()->get("user_role") == "Admin" ? "Admin" : "Bendahara") ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= base_url() ?>/assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?= site_url("profil") ?>" class="d-block"><?= @session()->get("user_nama") ?: "Gamabunta" ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <?php if(session()->get("user_role") == "Admin"){ ?>
            <li class="nav-item">
              <a href="<?= site_url("anggota") ?>" class="nav-link <?= nav_oto($nav_apa, "anggota") ?> ">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Anggota
                </p>
              </a>
            </li>
          <?php } ?>
          <?php if(session()->get("user_role") == "Bendahara"){ ?>
          <li class="nav-item">
            <a href="<?= site_url("himpunan") ?>" class="nav-link <?= nav_oto($nav_apa, "himpunan") ?> ">
              <i class="nav-icon fas fa-book"></i>
              <p>Kas Himpunan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= site_url("bulanan") ?>" class="nav-link <?= nav_oto($nav_apa, "bulanan") ?> ">
              <i class="nav-icon fas fa-columns"></i>
              <p>Kas Bulanan</p>
            </a>
          </li>
          <?php } ?>
          <li class="nav-item">
            <a href="<?= site_url("logout") ?>" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Logout</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>