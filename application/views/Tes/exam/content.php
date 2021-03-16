<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"> <?php lang('text_pertanyaan')?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><?php lang('text_tes')?></li>
                        <li class="breadcrumb-item active">Exam</li>
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
                            <?php foreach($tblMPertanyaan as $a): ?>
                                <h5 class="card-title"><?=$num.'. '.$a->pertanyaan?></h5>
                                <div class="float-right">
                                    <?php if($this->uri->segment(3) == $total_row-1): ?>
                                        <a onclick="return confirm('Apakah anda yakin akan menyelesaikan tes ?')" href="<?=base_url('Tes/SubmitTes')?>" class="btn btn-primary btn-block"><?php lang('text_selesaikan')?></a>
                                    <?php endif; ?>
                                </div>
                                <p class="card-text">
                                    <?php $no=1; foreach($tblMPilihan[$a->id_master_pertanyaan] as $b): ?>
                                        <?php
                                            $rules = array(
                                                'select'    => null,
                                                'where'     => array(
                                                    'id_master_pilihan' => $b->id_master_pilihan,
                                                    'created_by' => $this->session->userdata('id_users'),
                                                ),
                                                'or_where'  => null,
                                                'order'     => null,
                                                'limit'     => null,
                                                'pagging'   => null,
                                            );
                                            $tblHJawaban = $this->Tbl_histori_jawaban->where($rules)->num_rows();
                                        ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pilihan" id="pilihan<?=$no?>" value="<?=$b->id_master_pilihan?>" <?=($tblHJawaban>0) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="pilihan<?=$no?>">
                                                <?=$b->pilihan?>
                                            </label>
                                        </div>
                                    <?php $no++; endforeach; ?>
                                </p>
                            <?php endforeach; ?>
                        </div>
                        <nav aria-label="Page navigation">
                            <?=$this->pagination->create_links(); ?>
                        </nav>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>