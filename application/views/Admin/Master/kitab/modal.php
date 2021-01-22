<div class="modal fade" id="tambah_master_kitab">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Kitab</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?=form_open('Admin/Master/Kitab/Create')?>
      <div class="modal-body">
				<div class="form-group">
					<label for="recipient-name" class="control-label">Nama Kitab :</label>
					<input type="text" name="kitab_name" class="form-control" placeholder="Nama Kitab" required="">
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

<?php foreach($tblMKitab as $a): ?>
<div class="modal fade" id="edit_master_kitab<?=$a->id_master_kitab?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Master Kitab</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?=form_open('Admin/Master/Kitab/Update/'.$a->id_master_kitab)?>
      <div class="modal-body">
        <div class="form-group">
					<label for="recipient-name" class="control-label">Nama Kitab :</label>
					<input type="text" name="kitab_name" class="form-control" placeholder="Nama Kitab" value="<?=$a->kitab_name?>" required="">
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
