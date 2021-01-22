<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"> Tes</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Tes</li>
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
                            <h5 class="card-title">Histori Tes</h5>
                            <div class="float-right"><a href="<?=base_url('Tes/Confirm')?>" onclick="return confirm('Apakah anda yakin akan melakukan tes ?')" class="btn btn-primary">Lakukan Tes</a></div>
                            <p class="card-text">
                                <?php if(!empty($tblHTest)): ?>
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>No.</th>
                                        <th>Level</th>
                                        <th>Percobaan Ke-</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($tblHTest as $a): ?>
                                        <tr>
                                            <td align="center">
                                                <a class="btn btn-primary btn-xs" href="<?=base_url('Tes/Detail/'.$a->id_histori_tes)?>"><i class="fas fa-bars"> Detail</i></a>
                                            </td>
                                            <td><?=$no++?></td>
                                            <td><?=$a->level?></td>
                                            <td><?=$a->summit?></td>
                                            <td>
                                                <?php if($a->status == '0'): ?>
                                                    <div class="badge badge-warning">Sedang melakukan tes.</div>
                                                <?php else: ?>
                                                    <div class="badge badge-warning">Tes selesai.</div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    </table>
                                </div>
                                <?php else: ?>
                                    <div class="alert alert-warning">Anda belum melakukan tes.</div>
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