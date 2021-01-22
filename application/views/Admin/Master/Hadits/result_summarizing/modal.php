<!-- Modal -->
<div class="modal fade" id="tambah_knowledge" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export Data Daftar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?=form_open('Admin/Master/Hadits/Create')?>
      <input type="hidden" name="id_master_kitab" value="99">
      <input type="hidden" name="keterangan" value="summarizing">
      <input type="hidden" name="id_master_jenis" value="999">
      <div class="modal-body">
        <div class="form-group">
            <label for="pertanyaan">Pertanyaan</label>
            <input type="text" name="hadits_name" class="form-control" id="pertanyaan"  value="<?=$data_summarizing->judul?>" readonly>
        </div>
            
        <div class="form-group">
            <label for="url">URL</label>
            <input type="url" name="hadits_arab" class="form-control" id="url" value="<?=$data_summarizing->url?>" readonly>
        </div>

        <div class="form-group">
            <label for="keyword">Keyword</label>
            <input type="text" name="keyword" class="form-control" id="keyword" value="<?=$data_summarizing->keyword?>" readonly>
        </div>
            
        <div class="form-group mb-3">
            <label>Hasil Ringkasan</label>
            <textarea class="form-control textarea" rows="3" name="hadits_content" id="ringkasan" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" readonly><?=$data_summarizing->ringkasan?></textarea>
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Bab :</label>
            <select name="id_master_bab" class="form-control" required="">
                <?php foreach($tblMBab as $a): ?>
                  <option value=<?=$a->id_master_bab?>><?=$a->bab_name?></option>
                <?php endforeach; ?>
            </select>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Apakah anda yakin akan menambahkan hadits kedalam bab tersebut?')">Simpan</button>
      </div>
      <?=form_close()?>
    </div>
  </div>
</div>