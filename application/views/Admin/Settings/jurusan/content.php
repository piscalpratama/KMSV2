<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
    	<?php $this->load->view('layout/notification'); ?>
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Setting Jurusan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Setting</li>
                        <li class="breadcrumb-item">Jurusan</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Setting Jurusan</h5>
                            <div class="float-right">
                              <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambah_setting_jurusan"><i class="fas fa-plus"></i></button>
                            </div>
                            <p class="card-text">
                              <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                  <thead>
                                  <tr>
                                    <th>Action</th>
                                    <th>Kode Jurusan</th>
                                    <th>Jurusan</th>
                                    <th>Fakultas</th>
                                    <th>Status</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no=1; foreach($tblSJurusan as $a): ?>
                                      <tr>
                                        <td align="center">
                                          <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#edit_setting_jurusan<?=$a->kode_jurusan?>"><i class="fas fa-edit"></i></button>
                                          <a class="btn btn-danger btn-xs" href="<?=base_url('Admin/Settings/Jurusan/Delete/'.$a->kode_jurusan)?>" onclick="return confirm('Apakah anda yakin ?')"><i class="fas fa-trash"></i></a>
                                        </td>
                                        <td><?=$a->kode_jurusan?></td>
                                        <td><?=$a->jurusan?></td>
                                        <td><?=$a->id_fakultas?></td>
                                        <td><?=$a->status?></td>
                                      </tr>
                                    <?php endforeach; ?>
                                  </tbody>
                                </table>
                              </div>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
