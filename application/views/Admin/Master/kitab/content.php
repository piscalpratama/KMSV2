<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
    	<?php $this->load->view('layout/notification'); ?>
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Master Kitab</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Master</li>
                        <li class="breadcrumb-item">Kitab</li>
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
                            <h5 class="card-title">Master Kitab</h5>
                            <div class="float-right">
                              <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambah_master_kitab"><i class="fas fa-plus"></i></button>
                            </div>
                            <p class="card-text">
                              <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                  <thead>
                                  <tr>
                                    <th>Action</th>
                                    <th>No.</th>
                                    <th>Nama Kitab</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no=1; foreach($tblMKitab as $a): ?>
                                      <tr>
                                        <td align="center">
                                          <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#edit_master_kitab<?=$a->id_master_kitab?>"><i class="fas fa-edit"></i></button>
                                          <a class="btn btn-danger btn-xs" href="<?=base_url('Admin/Master/Kitab/Delete/'.$a->id_master_kitab)?>" onclick="return confirm('Apakah anda yakin ?')"><i class="fas fa-trash"></i></a>
                                        </td>
                                        <td><?=$no++?></td>
                                        <td><?=$a->kitab_name?></td>
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
