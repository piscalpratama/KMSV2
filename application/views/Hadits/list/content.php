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
                                        <label for="recipient-name" class="control-label"><?php lang('text_bab')?> <?=$this->session->userdata('id_master_bab')?> :</label>
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
                                        <label for="recipient-name" class="control-label"><?php lang('text_kitab')?> <?=$this->session->userdata('id_master_kitab')?> :</label>
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
                            <?=form_open('Hadits/Search')?>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label"><?php lang('text_keyword')?> :</label>
                                        <input type="text" name="keyword" class="form-control" value="<?=(!empty($this->session->userdata('keyword'))) ? $this->session->userdata('keyword') : ''?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-block">Search</button>
                                    </div>
                                </div>
                            </div>
                            <p class="card-text">
                                <center>
                                <div class="card-columns">
                                <?php foreach($viewMHadits as $a): ?>
                                    <div class="card" style="width: 80%;">
                                        <div class="card-body">
                                            <h5 class="card-title text-justify"><a href="<?=base_url('Hadits/Detail/'.$a->id_master_hadits)?>" style="color: #000"><strong><?=$a->hadits_name?></strong><a></h5>
                                            <p class="card-text text-justify"><?=substr($a->hadits_content, 0, 100)?>...<a href="<?=base_url('Hadits/Detail/'.$a->id_master_hadits)?>"><?php lang('text_selengkapnya')?></a></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                </div>
                                </center>
                                <nav aria-label="Page navigation">
                                    <?=$this->pagination->create_links(); ?>
                                </nav>
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