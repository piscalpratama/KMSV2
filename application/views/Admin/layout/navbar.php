
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?=base_url('Admin/Dashboard')?>" class="nav-link">Dashboard</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Messages Dropdown Menu -->
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <?=$this->session->userdata('nama');?> <i class="right fas fa-angle-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="row" style="padding: 20px">
                <div class="col-md-3">
                    <img class="img-circle elevation-2" src="<?=base_url()?>assets/img/user2-160x160.jpg" width="80" height="80" alt="User Avatar">
                </div>
                <div class="col-md-2">&nbsp;</div>
                <div class="col-md-7">
                    <h5 class="widget-user-username"><?=$this->session->userdata('nama');?></h3>
                    <h6 class="widget-user-desc"><?=$this->session->userdata('level');?></h5>
                </div>
            </div>
            <a href="<?=base_url('Admin/Auth/Logout')?>" class="dropdown-item text-center">
                <i class="fas fa-sign-in-alt"></i> Logout
            </a>
        </div>
    </li>
  </ul>
</nav>
