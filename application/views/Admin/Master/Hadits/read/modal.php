<!-- Modal -->
<div class="modal fade" id="exportexcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export Data Daftar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?=form_open('Admin/Daftar/ExportExcel/')?>
      <div class="modal-body">
        <div class="form-group">
            <label for="recipient-name" class="control-label">Fakultas :</label>
            <select name="fakultas" class="form-control" required="">
                <option value="-">Semua</option>
                <?php foreach($tblSFakultas as $a): ?>
                  <option value=<?=$a->id_fakultas?>><?=$a->fakultas?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Status :</label>
            <select name="status" class="form-control" required="">
                <option value="1">Mengajukan</option>
                <option value="2">Lolos</option>
            </select>
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Tahun :</label>
            <select name="tahun" class="form-control" required="">
                <?php foreach($tahun as $a): ?>
                  <option value=<?=$a->tahun?>><?=$a->tahun?></option>
                <?php endforeach; ?>
            </select>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary btn-sm">Export</button>
      </div>
      <?=form_close()?>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="importexcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Import Data Daftar (Status)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?=form_open_multipart('Admin/Daftar/ImportExcel/')?>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
                <label for="recipient-name" class="control-label">File :</label>
                <input type="file" name="file_import" class="form-control" required="">
            </div>
            <button type="submit" class="btn btn-primary btn-sm float-right">Import</button>
          </div>
          <div class="col-md-6">
            <p>Tatacara import data daftar : (Only Windows)</p>
            <ol>
                <li>Download template daftar yang sudah disediakan.</li>
                <li>Isi kolom pada tabel sesuai nama kolomnya.</li>
                <li>Pilih jalur masuk dan pilih file yang ingin di upload.</li>
                <li>klik import.</li>
            </ol>
            <a href="<?=base_url('file/template_daftar_status.xlsx')?>" class="btn btn-default btn-flat btn-sm" target="_blank">Download Template</a>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm float-right" data-dismiss="modal">Tutup</button>
      </div>
      <?=form_close()?>
    </div>
  </div>
</div>