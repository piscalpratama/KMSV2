<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"> <?php lang('text_hadits')?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><?php lang('text_hadits')?></li>
                        <li class="breadcrumb-item"><?php lang('text_daftar')?></li>
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
                            <?=form_open('Hadits/Filter')?>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label"><?php lang('text_bab')?> :</label>
                                        <?php $tblMBab = json_decode($tblMBab); ?>
                                        <select name="id_master_bab" class="form-control">
                                            <option value="semua"><?php lang('text_semua')?></option>
                                            <?php foreach($tblMBab as $a): ?>
                                                <option value="<?=$a->id_master_bab?>" <?=($this->session->userdata('id_master_bab') == $a->id_master_bab) ? 'selected' : ''?>><?=$a->bab_name?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label"><?php lang('text_kitab')?> :</label>
                                        <?php $tblMKitab = json_decode($tblMKitab); ?>
                                        <select name="id_master_kitab" class="form-control">
                                            <option value="semua"><?php lang('text_semua')?></option>
                                            <?php foreach($tblMKitab as $a): ?>
                                                <option value="<?=$a->id_master_kitab?>" <?=($this->session->userdata('id_master_kitab') == $a->id_master_kitab) ? 'selected' : ''?>><?=$a->kitab_name?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-block">Filter</button>
                                    </div>
                                </div>
                            </div>
                            <?=form_close()?>
                            <p class="card-text">
                                <?php $viewMHadits = json_decode($viewMHadits); ?>
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th class="width: 10%">Judul Hadits</th>
                                                <th>Isi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1; foreach($viewMHadits as $a): ?>
                                            <tr>
                                                <td><?=$no++?></td>
                                                <td><a href="<?=base_url('Hadits/Detail/'.$a->id_master_hadits)?>" style="color: #000"><strong><?=$a->hadits_name?></strong><a></td>
                                                <td><?=substr($a->hadits_content, 0, 200)?>...<a href="<?=base_url('Hadits/Detail/'.$a->id_master_hadits)?>"><?php lang('text_selengkapnya')?></a></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
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