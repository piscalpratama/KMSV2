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
                        <li class="breadcrumb-item">Kombinasi</li>
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
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Daftar Hadits Bab <?=$bab_name->bab_name?></h5>
                            <p class="card-text">
                              <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                  <thead>
                                  <tr>
                                    <th>Action</th>
                                    <th>No.</th>
                                    <th>Judul Hadits</th>
                                    <th>Isi /Pembahasan Hadits</th>
                                    <th>Arab / Link</th>
                                    <th>Bab</th>
                                    <th>Kitab</th>
                                    <th>Keterangan</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no=1; foreach($tblMHadits as $a): ?>
                                      <tr>
                                        <td align="center">
                                          <a class="btn btn-primary btn-xs" target="_blank" href="<?=base_url('Admin/Master/Hadits/Detail/'.$a->id_master_hadits)?>"><i class="fa fa-paste"></i></a>
                                        </td>
                                        <td><?=$no++?></td>
                                        <td><?=$a->hadits_name?></td>
                                        <td><?=substr($a->hadits_content,0,100)?>...<a target="_blank" href="<?=base_url('Admin/Master/Hadits/Detail/'.$a->id_master_hadits)?>">Detail</a></td>
                                        <td><?=mb_substr($a->hadits_arab,0,100,'utf-8')?>...<a target="_blank" href="<?=base_url('Admin/Master/Hadits/Detail/'.$a->id_master_hadits)?>">Detail</a></td>
                                        <td><?=$a->bab_name?></td>
                                        <td><?=$a->kitab_name?></td>
                                        <td>
                                          <?php if($a->keterangan == 'fixed'): ?>
                                            <div class="badge badge-primary">Fixed</div>
                                          <?php elseif($a->keterangan == 'summarizing'): ?>
                                            <div class="badge badge-warning">Summarizing</div>
                                          <?php endif; ?>
                                        </td>
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
