<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"> Detail Peserta Belajar</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Knowledge</li>
                        <li class="breadcrumb-item">Users</li>
                        <li class="breadcrumb-item active">Detail</li>
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
                <div class="col-md-12">
                    <?php $this->load->view('layout/notification'); ?>
                    <div class="card">
                        <div class="card-header">
                            Data Peserta
                            <div class="float-right">
                                <a class="btn btn-warning btn-sm" href="#" data-toggle="modal" data-target="#update"><i class="fas fa-edit"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <tr>
                                    <th>Nama</th>
                                    <td><?=$tblKUsers->nama?></td>
                                </tr>
                                <tr>
                                    <th>username</th>
                                    <td><?=$tblKUsers->username?></td>
                                </tr>
                                <tr>
                                    <th>level</th>
                                    <td><?=$tblKUsers->level?></td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td><?=$tblKUsers->alamat?></td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>
                                        <?php if($tblKUsers->jenis_kelamin == 'L'): ?>
                                            Laki-Laki
                                        <?php elseif($tblKUsers->jenis_kelamin == 'P'): ?>
                                            Perempuan
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>No Telp</th>
                                    <td><?=$tblKUsers->no_telp?></td>
                                </tr>
                                <tr>
                                    <th>Tempat Lahir</th>
                                    <td><?=$tblKUsers->tempat_lahir?></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir</th>
                                    <td><?=$tblKUsers->tgl_lahir?></td>
                                </tr>
                                <tr>
                                    <th>Foto</th>
                                    <td><?=$tblKUsers->foto?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>