<div class="modal fade" id="tambah_setting_users">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Users</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?=form_open('Admin/Settings/Users/Create')?>
      <div class="modal-body">
				<div class="form-group">
					<label for="recipient-name" class="control-label">Username :</label>
					<input type="text" name="username" class="form-control" placeholder="Username" required="">
				</div>
				<div class="form-group">
					<label for="recipient-name" class="control-label">Password :</label>
					<input type="password" name="password" class="form-control" placeholder="Password">
				</div>
				<div class="form-group">
					<label for="recipient-name" class="control-label">Nama :</label>
					<input type="text" name="nama" class="form-control" placeholder="Nama" required="">
				</div>
				<div class="form-group">
					<label for="recipient-name" class="control-label">Hak Akses :</label>
					<select name="hak_akses" id="hak_akses" class="form-control">
						<option value="ADMIN">ADMIN</option>
						<option value="EXPERT">EXPERT</option>
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

<?php foreach($tblSUsers as $a): ?>
<div class="modal fade" id="edit_setting_users<?=$a->id_setting_users?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Users</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?=form_open('Admin/Settings/Users/Update/'.$a->id_setting_users)?>
      <div class="modal-body">
        <?php $data = explode('@', $a->username); ?>
				<div class="form-group">
					<label for="recipient-name" class="control-label">Username :</label>
					<input type="text" name="username" class="form-control" placeholder="Username" required="" value="<?=$data[0]?>">
				</div>
				<div class="form-group">
					<label for="recipient-name" class="control-label">Password :</label>
					<input type="password" name="password" class="form-control" placeholder="Password">
          <span class="badge badge-warning">Isi jika ingin dirubah.</span>
				</div>
				<div class="form-group">
					<label for="recipient-name" class="control-label">Nama :</label>
					<input type="text" name="nama" class="form-control" placeholder="Nama" required="" value="<?=$a->nama?>">
				</div>
				<div class="form-group">
					<label for="recipient-name" class="control-label">Level :</label>
					<select name="hak_akses" id="hak_akses" class="form-control">
						<option value="ADMIN" <?php if($a->hak_akses=="ADMIN"){ echo 'selected'; } ?>>ADMIN</option>
						<option value="EXPERT" <?php if($a->hak_akses=="EXPERT"){ echo 'selected'; } ?>>EXPERT</option>
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
