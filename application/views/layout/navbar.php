<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
    <a href="<?=base_url()?>Dashboard" class="navbar-brand">
        <img src="<?=base_url()?>assets/img/logo_uin.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">KMS</span>
    </a>
    
    <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="<?=base_url('Dashboard')?>" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    Internalisasi <i class="right fas fa-angle-down"></i>
                </a>
                <div class="dropdown-menu">
                    <a href="<?=base_url('Hadits')?>" class="nav-link">Belajar</a>
                    <a href="<?=base_url('Tes')?>" class="nav-link">Evaluasi</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="<?=base_url('Profil')?>" class="nav-link">Profil</a>
            </li>
        </ul>
    </div>

    <!-- Right navbar links -->
    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <!-- <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
                class="fas fa-th-large"></i></a>
        </li> -->
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <?=$this->session->userdata('nama');?> <i class="right fas fa-angle-down"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="row" style="padding: 20px">
                    <div class="col-md-3">
                        <img class="img-circle elevation-2" src="<?=$this->session->userdata('foto')?>" width="80" height="80" alt="User Avatar">
                    </div>
                    <div class="col-md-2">&nbsp;</div>
                    <div class="col-md-7">
                        <h5 class="widget-user-username"><?=$this->session->userdata('nama');?></h3>
                        <h6 class="widget-user-desc">Mahasiswa</h5>
                    </div>
                </div>
                <a href="<?=base_url('Auth/Logout')?>" class="dropdown-item text-center">
                    <i class="fas fa-sign-in-alt"></i> Logout
                </a>
            </div>
        </li>
    </ul>
    </div>
</nav>