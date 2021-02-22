<div class="modal fade" id="tambah_master_pertanyaan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Pertanyaan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?=form_open('Admin/Master/Pertanyaan/Create/')?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="recipient-name" class="control-label">Pertanyaan :</label>
                    <input type="text" name="pertanyaan" class="form-control" placeholder="Pertanyaan" required="">
                </div>
                <input type="hidden" name="id_master_bab" value="<?=$id_master_bab?>" required="">
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </div>
            <?=form_close()?>
        </div>
    <!-- /.modal-content -->
    </div>
  <!-- /.modal-dialog -->
</div>

<?php if(!empty($tblMPertanyaan)): ?>
    <?php foreach($tblMPertanyaan as $a): ?>
        <div class="modal fade" id="edit_master_pertanyaan<?=$a->id_master_pertanyaan?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Pertanyaan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?=form_open('Admin/Master/Pertanyaan/Update/'.$a->id_master_pertanyaan)?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Pertanyaan :</label>
                            <input type="text" name="pertanyaan" class="form-control" value="<?=$a->pertanyaan?>" placeholder="Pertanyaan" required="">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                    <?=form_close()?>
                </div>
            <!-- /.modal-content -->
            </div>
        <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="list_pilihan<?=$a->id_master_pertanyaan?>">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">List Pilihan</h4>
                        <?php if($a->level != 0): ?>
                        <div class="float-right">
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambah_master_pilihan<?=$a->id_master_pertanyaan?>"><i class="fas fa-plus"></i></button>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>No.</th>
                                        <th>Pilihan</th>
                                        <th>Jawaban</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach($tblMPilihan[$a->id_master_pertanyaan] as $b): ?>
                                    <tr>
                                        <td align="center">
                                            <?php if($a->level != 0): ?>
                                                <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#edit_master_pilihan<?=$b->id_master_pilihan?>"><i class="fas fa-edit"></i></button>
                                                <a class="btn btn-danger btn-xs" href="<?=base_url('Admin/Master/Pilihan/Delete/'.$b->id_master_pilihan)?>" onclick="return confirm('Apakah anda yakin ?')"><i class="fas fa-trash"></i></a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?=$no++?></td>
                                        <td><?=$b->pilihan?></td>
                                        <td><?=$b->nilai?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
                    </div>
                    <?=form_close()?>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        
        <?php foreach($tblMPilihan[$a->id_master_pertanyaan] as $b): ?>
        <div class="modal fade" id="edit_master_pilihan<?=$b->id_master_pilihan?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Pilihan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?=form_open('Admin/Master/Pilihan/Update/'.$b->id_master_pilihan)?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Pilihan :</label>
                            <input type="text" name="pilihan" class="form-control" value="<?=$b->pilihan?>" placeholder="Pilihan" required="">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Jawaban :</label>
                            <select name="nilai" class="form-control" required="">
                                <option value="0" <?=($b->nilai == '0') ? 'selected' : ''?>>Salah</option>
                                <option value="1" <?=($b->nilai == '1') ? 'selected' : ''?>>Benar</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                    <?=form_close()?>
                </div>
            <!-- /.modal-content -->
            </div>
        <!-- /.modal-dialog -->
        </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php if(!empty($tblMPertanyaan)): ?>
    <?php foreach($tblMPertanyaan as $a): ?>
        <div class="modal fade" id="tambah_master_pilihan<?=$a->id_master_pertanyaan?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Pilihan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?=form_open('Admin/Master/Pilihan/Create/')?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Pilihan :</label>
                            <input type="text" name="pilihan" class="form-control" placeholder="Pilihan" required="">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Jawaban :</label>
                            <select name="nilai" class="form-control" required="">
                                <option value="0">Salah</option>
                                <option value="1">Benar</option>
                            </select>
                        </div>
                        <input type="hidden" name="id_master_pertanyaan" value="<?=$a->id_master_pertanyaan?>" required="">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                    <?=form_close()?>
                </div>
            <!-- /.modal-content -->
            </div>
        <!-- /.modal-dialog -->
        </div>
    <?php endforeach; ?>
<?php endif; ?>