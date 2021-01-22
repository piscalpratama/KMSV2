<div class="modal fade" id="tambah_setting_ict">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Setting</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?=form_open('Admin/Settings/Setting/Create')?>
      <div class="modal-body">
				<div class="form-group">
					<label for="recipient-name" class="control-label">Nama Setting :</label>
					<input type="text" name="nama_setting" class="form-control" placeholder="Nama Setting" required="">
				</div>
				<div class="form-group">
					<label for="recipient-name" class="control-label">Setting :</label>
					<input type="text" name="setting" class="form-control" placeholder="Setting" required="">
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

<?php foreach($tblISetting as $a): ?>
<div class="modal fade" id="edit_setting_ict<?=$a->id_setting?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Setting</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?=form_open('Admin/Settings/Setting/Update/'.$a->id_setting)?>
      <div class="modal-body">
        <div class="form-group">
					<label for="recipient-name" class="control-label">Setting :</label>
					<input type="text" name="setting" class="form-control" placeholder="Setting" value="<?=$a->setting?>" required="">
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
