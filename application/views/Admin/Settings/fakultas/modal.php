<div class="modal fade" id="tambah_setting_fakultas">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Fakultas</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?=form_open('Admin/Settings/Fakultas/Create')?>
      <div class="modal-body">
				<div class="form-group">
					<label for="recipient-name" class="control-label">Fakultas :</label>
					<input type="text" name="fakultas" class="form-control" placeholder="Fakultas" required="">
				</div>
        <div class="form-group">
          <label for="recipient-name" class="control-label">Status :</label>
          <div class="row">
            <div class="input-group mb-3 col-md-6">
              <div class="input-group-prepend">
                <span class="input-group-text"><input type="radio" name="status" class="forn-control" value="0"></span>
              </div>
              <input type="text" class="form-control" aria-label="False" value="False" readonly>
            </div>
            <div class="input-group mb-3 col-md-6">
              <div class="input-group-prepend">
                <span class="input-group-text"><input type="radio" name="status" class="forn-control" value="1" checked></span>
              </div>
              <input type="text" class="form-control" aria-label="False" value="True" readonly>
            </div>
          </div>
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

<?php foreach($tblSFakultas as $a): ?>
<div class="modal fade" id="edit_setting_fakultas<?=$a->id_fakultas?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Fakultas</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?=form_open('Admin/Settings/Fakultas/Update/'.$a->id_fakultas)?>
      <div class="modal-body">
        <div class="form-group">
					<label for="recipient-name" class="control-label">Fakultas :</label>
					<input type="text" name="fakultas" class="form-control" placeholder="Fakultas" value="<?=$a->fakultas?>" required="">
				</div>
        <div class="form-group">
          <label for="recipient-name" class="control-label">Status :</label>
          <div class="row">
            <div class="input-group mb-3 col-md-6">
              <div class="input-group-prepend">
                <span class="input-group-text"><input type="radio" name="status" class="forn-control" value="0" <?php if ($a->status == "0"){echo 'checked';}?>></span>
              </div>
              <input type="text" class="form-control" aria-label="False" value="False" readonly>
            </div>
            <div class="input-group mb-3 col-md-6">
              <div class="input-group-prepend">
                <span class="input-group-text"><input type="radio" name="status" class="forn-control" value="1" <?php if ($a->status == "1"){echo 'checked';}?>></span>
              </div>
              <input type="text" class="form-control" aria-label="False" value="True" readonly>
            </div>
          </div>
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
