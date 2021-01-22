<div class="modal fade" id="tambah_master_kategori">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Kategori</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?=form_open('Admin/Master/Kategori/Create')?>
      <div class="modal-body">
				<div class="form-group">
					<label for="recipient-name" class="control-label">Nama Kategori :</label>
					<input type="text" name="kategori_name" class="form-control" placeholder="Nama Kategori" required="">
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

<?php foreach($tblMKategori as $a): ?>
<div class="modal fade" id="edit_master_kategori<?=$a->id_master_kategori?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Master Kategori</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?=form_open('Admin/Master/Kategori/Update/'.$a->id_master_kategori)?>
      <div class="modal-body">
        <div class="form-group">
					<label for="recipient-name" class="control-label">Nama Kategori :</label>
					<input type="text" name="kategori_name" class="form-control" placeholder="Nama Kategori" value="<?=$a->kategori_name?>" required="">
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
