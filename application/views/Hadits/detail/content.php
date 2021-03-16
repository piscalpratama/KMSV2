<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"> <?php lang('text_detail')?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><?php lang('text_hadits')?></li>
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
                            Data <?php lang('text_hadits')?>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <tr>
                                    <th><?php lang('text_hadits')?></th>
                                    <td><?=$tblMHadits->hadits_name?></td>
                                </tr>
                                <tr>
                                    <th><?php lang('text_bab')?></th>
                                    <td><?=$tblMHadits->bab_name?></td>
                                </tr>
                                <tr>
                                    <th><?php lang('text_kitab')?></th>
                                    <td><?=$tblMHadits->kitab_name?></td>
                                </tr>
                                <tr>
                                    <th><?php lang('text_isi')?></th>
                                    <td><pre style="white-space:pre-wrap;"><?=$tblMHadits->hadits_content?></pre></td>
                                </tr>
                                <tr>
                                    <th><?php lang('text_arab')?></th>
                                    <td><pre style="white-space:pre-wrap;"><?=$tblMHadits->hadits_arab?></pre></td>
                                </tr>
                                <tr>
                                    <th><?php lang('text_keterangan')?></th>
                                    <td>
                                        <?php if($tblMHadits->keterangan == 'fixed'): ?>
                                            <div class="badge badge-primary">Kitab 9 Imam</div>
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
                                <?php lang('text_ahli')?>
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