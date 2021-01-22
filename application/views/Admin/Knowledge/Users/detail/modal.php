<div class="modal fade" id="update">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Users</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?=form_open('Admin/Knowledge/Users/Update/'.$tblKUsers->id_users)?>
      <div class="modal-body">
        <div class="form-group">
            <label for="recipient-name" class="control-label">Nama :</label>
            <input type="text" class="form-control" name="nama" value="<?=$tblKUsers->nama?>">
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Tempat Lahir :</label>
            <input type="text" class="form-control" name="tempat_lahir" value="<?=$tblKUsers->tempat_lahir?>">
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Tanggal Lahir :</label>
            <input type="date" class="form-control" name="tgl_lahir" value="<?=$tblKUsers->tgl_lahir?>">
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Alamat :</label>
            <textarea class="form-control" style="height: 200px" name="alamat"><?=$tblKUsers->alamat?></textarea>
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Jenis Kelamin :</label>
            <select name="jenis_kelamin" class="form-control" required="">
                <option value="L" <?=($tblKUsers->jenis_kelamin == 'L')?'selected':'' ?>>Laki-Laki</option>
                <option value="P" <?=($tblKUsers->jenis_kelamin == 'P')?'selected':'' ?>>Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">No. Telp :</label>
            <input type="text" class="form-control" name="no_telp" value="<?=$tblKUsers->no_telp?>">
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Username :</label>
            <input type="text" class="form-control" name="username" value="<?=$tblKUsers->username?>">
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Password :</label>
            <input type="text" class="form-control" name="password">
            <div class="badge badge-warning">Kosongkan jika tidak ingin merubah password.</div>
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