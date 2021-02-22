<div class="modal fade" id="update">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Hadits</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?=form_open('Admin/Master/Hadits/Update/'.$tblMHadits->id_master_hadits)?>
      <div class="modal-body">
        <div class="form-group">
            <label for="recipient-name" class="control-label">Judul :</label>
            <input type="text" class="form-control" name="hadits_name" value="<?=$tblMHadits->hadits_name?>">
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Bab :</label>
            <select name="id_master_bab" class="form-control" required="">
                <?php foreach($tblMBab as $a): ?>
                  <option value="<?=$a->id_master_bab?>" <?=($tblMHadits->id_master_bab == $a->id_master_bab)?'selected':'' ?>><?=$a->bab_name?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Kitab :</label>
            <select name="id_master_kitab" class="form-control" required="">
                <?php foreach($tblMKitab as $a): ?>
                  <option value="<?=$a->id_master_kitab?>" <?=($tblMHadits->id_master_kitab == $a->id_master_kitab)?'selected':'' ?>><?=$a->kitab_name?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Isi Hadits :</label>
            <textarea class="form-control" style="height: 400px" name="hadits_content"><?=$tblMHadits->hadits_content?></textarea>
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Arab :</label>
            <textarea class="form-control" style="height: 400px" name="hadits_arab"><?=$tblMHadits->hadits_arab?></textarea>
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Keterangan :</label>
            <select name="keterangan" class="form-control" required="">
                <option value="fixed" <?=($tblMHadits->keterangan == 'fixed')?'selected':'' ?>>Fixed</option>
                <option value="summarizing" <?=($tblMHadits->keterangan == 'summarizing')?'selected':'' ?>>Summarizing</option>
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

<?php foreach($tblKExpert as $a): ?>
  <div class="modal fade" id="update-pendapat<?=$a->id_knowledge_expert?>">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Pendapat</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <?=form_open('Admin/Knowledge/Expert/Update/'.$tblMHadits->id_master_hadits.'/'.$a->id_knowledge_expert)?>
        <div class="modal-body">
          <div class="form-group">
              <label for="recipient-name" class="control-label">Pendapat :</label>
              <textarea class="form-control" style="height: 150px" name="pendapat"><?=$a->knowledge?></textarea>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary btn-sm">Update</button>
        </div>
        <?=form_close()?>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<?php endforeach; ?>