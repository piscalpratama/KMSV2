<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
    	<?php $this->load->view('layout/notification'); ?>
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Hadits (Kombinasi)</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Hadits</li>
                        <li class="breadcrumb-item active">Kombinasi</li>
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
                            <h5 class="card-title">Data Bab</h5>
                            <div class="float-right">
                              <a class="btn btn-primary btn-sm" href="<?=base_url('Admin/Master/Hadits/Knowledge')?>" target="_blank"><i class="fas fa-plus"></i> Add Knowledge</a>
                            </div>
                            <p class="card-text">
                              <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                  <thead>
                                  <tr>
                                    <th>Action</th>
                                    <th>No.</th>
                                    <th>Nama Bab</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no=1; foreach($tblMBab as $a): ?>
                                      <tr>
                                        <td align="center">
                                          <a class="btn btn-primary btn-xs" target="_blank" href="<?=base_url('Admin/Master/Hadits/DetailKombinasi/'.$a->id_master_bab)?>"><i class="fa fa-paste"></i></a>
                                        </td>
                                        <td><?=$no++?></td>
                                        <td><?=$a->bab_name?></td>
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
