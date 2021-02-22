<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"> Profil</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Profil</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
        <?php $this->load->view('layout/notification'); ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Knowledge:</h5>
                            <p class="card-text">
                                <div class="frem">
                                    <div id="my_dataviz"></div>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Histori Belajar:</h5>
                            <p class="card-text">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Hadits</th>
                                                <th>Jumlah Baca</th>
                                                <th>Tanggal Baca Terakhir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1; foreach($tblHBelajar as $a): ?>
                                                <tr>
                                                    <td><?=$no++?></td>
                                                    <td><?=$a->hadits_name?></td>
                                                    <td><?=$a->count?></td>
                                                    <td><?=$a->updated_date?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card card-widget widget-user-2">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-secondary">
                            <div class="widget-user-image">
                                <?php if($tblKProfil->foto != '-'): ?>
                                    <img class="img-circle elevation-2" src="<?=base_url('uploads/foto/'.$tblKProfil->foto)?>" data-toggle="modal" data-target="#view_foto" alt="User Avatar">
                                <?php else: ?>
                                    <img class="img-circle elevation-2" src="<?=base_url('assets/img/user.png')?>" data-toggle="modal" data-target="#view_foto" alt="User Avatar">
                                <?php endif; ?>
                            </div>
                            <!-- /.widget-user-image -->
                            <button class="btn btn-warning btn-sm float-right" style="margin-top: 20px" data-toggle="modal" data-target="#update"><i class="fas fa-edit"></i></button>
                            <h3 class="widget-user-username"><?=$tblKUsers->nama?></h3>
                            <h5 class="widget-user-desc">Level <?=$tblKProfil->level?></h5>
                        </div>
                        <div class="card-body">
                            <ul class="nav flex-column">
                                <li class="nav-item p-0">
                                    <table class="table">
                                        <tr>
                                            <th>Username</th>
                                            <td class="text-right"><?=$tblKUsers->username?></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Lahir</th>
                                            <td class="text-right"><?=$tblKProfil->tgl_lahir?></td>
                                        </tr>
                                        <tr>
                                            <th>Tempat Lahir</th>
                                            <td class="text-right"><?=$tblKProfil->tempat_lahir?></td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Kelamin</th>
                                            <td class="text-right"><?=$tblKProfil->jenis_kelamin?></td>
                                        </tr>
                                        <tr>
                                            <th>No. Telp</th>
                                            <td class="text-right"><?=$tblKProfil->no_telp?></td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td class="text-right"><?=$tblKProfil->alamat?></td>
                                        </tr>
                                    </table>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Statistik Tes Terakhir:</h5>
                            <p class="card-text">
                                <div id="container">
                                    <canvas id="pie-chart"></canvas>
                                </div>
                            </p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Saran Belajar:</h5>
                            <p class="card-text">
                                <?php if(count($rekomendasi_tidakpaham) == 0 && count($rekomendasi_kurangpaham) == 0): ?>
                                    anda tidak mengalami kendala belajar<br>
                                    Silahkan lakukan tes atau lanjutkan ke level tes selanjutnya.<br>
                                <?php else: ?>
                                    anda mengalami kendala belajar pada bab
                                    <?php foreach($rekomendasi_tidakpaham as $a){ echo $a['bab_name'].','; }?>
                                    <?php foreach($rekomendasi_kurangpaham as $a){ echo $a['bab_name'].','; }?>.
                                    Sedangkan pada bab 
                                    <?php foreach($rekomendasi_paham as $a){ echo $a['bab_name'].','; }?>
                                    <?php foreach($rekomendasi_sangatpaham as $a){ echo $a['bab_name'].','; }?>.
                                    peserta belajar sudah dianggap paham.
                                    <?php if(count($rekomendasi_tidakpaham) == 0 && count($rekomendasi_kurangpaham) == 0): ?>
                                    <?php else: ?>
                                        Maka anda dapat memprioritaskan bab 
                                        <?php foreach($rekomendasi_tidakpaham as $a){ echo $a['bab_name'].','; }?>
                                        <?php foreach($rekomendasi_kurangpaham as $a){ echo $a['bab_name'].','; }?>
                                        untuk dipelajari kembali.<br><br>
                                    <?php endif; ?>
                                    <?php if(count($rekomendasi_tidakpaham) == 0 && count($rekomendasi_kurangpaham) == 0): ?>
                                        Anda belum memahami bab yang telah disediakan, silahkan pelajari dan lakukan tes ulang untuk dapat melanjutkan ke bab selanjutnya.
                                    <?php else: ?>
                                        Anda dapat melanjutkan ke materi selanjutnya :<br>
                                        <?php foreach($rekomendasi_selanjutnya1 as $a): ?>
                                            <li><?=$a?></li>
                                        <?php endforeach ?>
                                        <?php foreach($rekomendasi_selanjutnya2 as $a): ?>
                                            <li><?=$a?></li>
                                        <?php endforeach ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>