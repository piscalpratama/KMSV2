<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"> Detail Hadits</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Hadits</li>
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
        <?php $this->load->view('layout/notification'); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            Data Hadits
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <tr>
                                    <th>Judul Hadits</th>
                                    <td><?=$tblMHadits->hadits_name?></td>
                                </tr>
                                <tr>
                                    <th>Bab</th>
                                    <td><?=$tblMHadits->bab_name?></td>
                                </tr>
                                <tr>
                                    <th>Kitab</th>
                                    <td><?=$tblMHadits->kitab_name?></td>
                                </tr>
                                <tr>
                                    <th>Isi / Pembahasan Hadits</th>
                                    <td><pre style="white-space:pre-wrap;"><?=$tblMHadits->hadits_content?></pre></td>
                                </tr>
                                <tr>
                                    <th>Arab / Link</th>
                                    <td><pre style="white-space:pre-wrap;"><?=$tblMHadits->hadits_arab?></pre></td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td>
                                        <?php if($tblMHadits->keterangan == 'fixed'): ?>
                                            <div class="badge badge-primary">fixed</div>
                                        <?php elseif($tblMHadits->keterangan == 'summarizing'): ?>
                                            <div class="badge badge-warning">summarizing</div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <?php if($tblKExpert != null): ?>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                Pendapat Ahli
                            </div>
                            <div class="card-body">
                                <?php foreach($tblKExpert as $a): ?>
                                    <div class="card">
                                        <div class="card-header">
                                            <?=$a->nama_users?>
                                            <div class="float-right">
                                                <?=$a->updated_date?>
                                                <?php if($a->updated_by == $this->session->userdata('id_setting_users')): ?>
                                                    <a class="btn btn-warning btn-xs" href="#" data-toggle="modal" data-target="#update-pendapat<?=$a->id_knowledge_expert?>"><i class="fas fa-edit"></i></a>
                                                    <a class="btn btn-danger btn-xs" href="<?=base_url('Admin/Knowledge/Expert/Delete/'.$tblMHadits->id_master_hadits.'/'.$a->id_knowledge_expert)?>" onclick="return confirm('Apakah anda yakin ?')"><i class="fas fa-trash"></i></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p><?=$a->knowledge?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>