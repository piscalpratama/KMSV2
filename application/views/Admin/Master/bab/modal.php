<div class="modal fade" id="tambah_master_bab">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Bab</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?=form_open('Admin/Master/Bab/Create')?>
      <div class="modal-body">
				<div class="form-group">
					<label for="recipient-name" class="control-label">Nama Bab :</label>
					<input type="text" name="bab_name" class="form-control" placeholder="Nama Bab" required="">
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Parent Bab :</label>
            <select name="parent_id" class="form-control select2" required="" style="width: 100%">
                <option value="0">BAB AWAL</option>
                <?php foreach($tblMBab as $a): ?>
                  <option value="<?=$a->id_master_bab?>"><?=$a->bab_name?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Kategori :</label>
            <select name="id_master_kategori" class="form-control" required="">
                <?php foreach($tblMKategori as $a): ?>
                  <option value="<?=$a->id_master_kategori?>"><?=$a->kategori_name?></option>
                <?php endforeach; ?>
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

<?php foreach($tblMBab as $a): ?>
<div class="modal fade" id="edit_master_bab<?=$a->id_master_bab?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Master Bab</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?=form_open('Admin/Master/Bab/Update/'.$a->id_master_bab)?>
      <div class="modal-body">
        <div class="form-group">
					<label for="recipient-name" class="control-label">Nama Bab :</label>
					<input type="text" name="bab_name" class="form-control" placeholder="Nama Bab" value="<?=$a->bab_name?>" required="">
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Parent Bab :</label>
            <select name="parent_id" class="form-control select2" required="" style="width: 100%">
                <option value="0">BAB AWAL</option>
                <?php foreach($tblMBab as $b): ?>
                  <option value="<?=$b->id_master_bab?>" <?=($b->id_master_bab == $a->parent_id)?'selected':'' ?>><?=$b->bab_name?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Kategori :</label>
            <select name="id_master_kategori" class="form-control" required="">
                <?php foreach($tblMKategori as $b): ?>
                  <option value="<?=$a->id_master_kategori?>" <?=($a->id_master_kategori == $b->id_master_kategori)?'selected':'' ?>><?=$a->kategori_name?></option>
                <?php endforeach; ?>
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
