<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="<?=base_url()?>assets/img/logo_uin.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">AdminKMS</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?=base_url()?>assets/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?=$this->session->userdata('nama')?><br><?=$this->session->userdata('hak_akses')?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item has-treeview">
          <a href="<?=base_url()?>Admin/Dashboard" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item has-treeview">
          <a href="<?=base_url()?>Admin/Knowledge/Users" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Peserta Belajar
            </p>
          </a>
        </li>
        <li class="nav-item has-treeview">
          <a href="<?=base_url()?>Admin/Master/Hadits/Kombinasi" class="nav-link">
            <i class="nav-icon fas fa-folder"></i>
            <p>
              Hadits (Kombinasi)
            </p>
          </a>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-folder"></i>
            <p>
              Master
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?=base_url('Admin/Master/Kategori')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Kategori</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=base_url('Admin/Master/Bab')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Bab</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=base_url('Admin/Master/Pertanyaan')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Pertanyaan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=base_url('Admin/Master/Kitab')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Kitab</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=base_url('Admin/Master/Hadits')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Hadits (Externalisasi)</p>
              </a>
            </li>
          </ul>
        </li>
        <?php if($this->session->userdata('hak_akses') == 'ADMIN'): ?>
				<li class="nav-item has-treeview">
          <a href="<?=base_url()?>Admin/Settings/Setting" class="nav-link">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>
              Settings
            </p>
          </a>
        </li>
				<li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tools"></i>
            <p>
              Advanced Settings
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?=base_url('Admin/Settings/Users')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Users</p>
              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>
        <li class="nav-item has-treeview">
          <a href="<?=base_url()?>Admin/Auth/Logout" class="nav-link">
            <i class="nav-icon fa fa-sign-out-alt"></i>
            <p>
              Logout
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
