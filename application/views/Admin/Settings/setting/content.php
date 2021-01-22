<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
    	<?php $this->load->view('layout/notification'); ?>
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Setting KMS</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Setting</li>
                        <li class="breadcrumb-item">KMS</li>
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
                            <h5 class="card-title">Setting KMS</h5>
                            <!-- <div class="float-right">
                              <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambah_setting_ict"><i class="fas fa-plus"></i></button>
                            </div> -->
                            <p class="card-text">
                              <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                  <thead>
                                  <tr>
                                    <th>Action</th>
                                    <th>No.</th>
                                    <th>Nama Setting</th>
                                    <th>Setting</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no=1; foreach($tblISetting as $a): ?>
                                      <tr>
                                        <td align="center">
                                          <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#edit_setting_ict<?=$a->id_setting?>"><i class="fas fa-edit"></i></button>
                                          <a class="btn btn-danger btn-xs" href="<?=base_url('Admin/Settings/Setting/Delete/'.$a->id_setting)?>" onclick="return confirm('Apakah anda yakin ?')"><i class="fas fa-trash"></i></a>
                                        </td>
                                        <td><?=$no++?></td>
                                        <td><?=$a->nama_setting?></td>
                                        <td><?=$a->setting?></td>
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
