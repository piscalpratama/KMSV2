<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Setting Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Setting</li>
                        <li class="breadcrumb-item">Users</li>
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
                            <h5 class="card-title">Setting Users</h5>
                            <div class="float-right">
                              <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambah_setting_users"><i class="fas fa-plus"></i></button>
                            </div>
                            <?php $this->load->view('layout/notification'); ?>
                            <p class="card-text">
                              <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                  <thead>
                                  <tr>
                                    <th>Action</th>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Hak Akses</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no=1; foreach($tblSUsers as $a): ?>
                                      <tr>
                                        <td align="center">
                                          <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#edit_setting_users<?=$a->id_setting_users?>"><i class="fas fa-edit"></i></button>
                                          <a class="btn btn-danger btn-xs" href="<?=base_url('Admin/Settings/Users/Delete/'.$a->id_setting_users)?>" onclick="return confirm('Apakah anda yakin ?')"><i class="fas fa-trash"></i></a>
                                        </td>
                                        <td><?=$no++?></td>
                                        <td><?=$a->nama?></td>
                                        <td><?=$a->username?></td>
                                        <td><?=$a->hak_akses?></td>
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
