<div class="modal fade" id="update_profil">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Profil</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?=form_open_multipart('Profil/Update/'.$tblKUsers->id_users)?>
      <div class="modal-body">
        <div class="form-group">
            <label for="recipient-name" class="control-label"><?php lang('nama')?> :</label>
            <input type="text" name="nama" class="form-control" required="" value="<?=$tblKUsers->nama?>">
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label"><?php lang('text_tmpt_lahir')?> :</label>
            <input type="text" name="tempat_lahir" class="form-control" required="" value="<?=$tblKProfil->tempat_lahir?>">
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label"><?php lang('text_tgl_lahir')?> :</label>
            <input type="date" name="tgl_lahir" class="form-control" required="" value="<?=$tblKProfil->tgl_lahir?>">
        </div>
        <div class="form-group">
          <label for="recipient-name" class="control-label"><?php lang('text_gender')?> :</label>
          <div class="row">
            <div class="input-group mb-3 col-md-6">
              <div class="input-group-prepend">
                <span class="input-group-text"><input type="radio" name="jenis_kelamin" class="forn-control" value="L"></span>
              </div>
              <input type="text" class="form-control" aria-label="False" value="Laki-Laki" readonly>
            </div>
            <div class="input-group mb-3 col-md-6">
              <div class="input-group-prepend">
                <span class="input-group-text"><input type="radio" name="jenis_kelamin" class="forn-control" value="P" checked></span>
              </div>
              <input type="text" class="form-control" aria-label="False" value="Perempuan" readonly>
            </div>
          </div>
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label"><?php lang('text_foto')?> :</label>
            <input type="file" name="foto" class="form-control" placeholder="Foto">
            <div class="badge badge-warning"><?php lang('info_upload')?></div>
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label"><?php lang('text_telp')?> :</label>
            <input type="text" name="no_telp" class="form-control" required="" value="<?=$tblKProfil->no_telp?>">
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label"><?php lang('text_alamat')?> :</label>
            <textarea name="alamat" class="form-control" required=""><?=$tblKProfil->alamat?></textarea>
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Username :</label>
            <input type="text" name="username" class="form-control" placeholder="Username" required="" value="<?=$tblKUsers->username?>">
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Password :</label>
            <input type="password" name="password" class="form-control" placeholder="Password">
            <div class="badge badge-warning"><?php lang('info_password')?></div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><?php lang('text_close')?></button>
        <button type="submit" class="btn btn-primary btn-sm"><?php lang('text_simpan')?></button>
      </div>
			<?=form_close()?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="view_foto">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Foto</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php if($tblKProfil->foto != '-'): ?>
            <img class="img-fluid" src="<?=base_url('uploads/foto/'.$tblKProfil->foto)?>" alt="User">
        <?php else: ?>
            <img class="img-fluid" src="<?=base_url('assets/img/user.png')?>" alt="User">
        <?php endif; ?>
      </div>
      <div class="modal-footer text-right">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>