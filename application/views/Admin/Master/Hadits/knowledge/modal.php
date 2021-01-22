<!-- Modal -->
<div class="modal fade" id="search_summarizing" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Search Summarizing</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#search_mashara"><i class="fas fa-search"></i> Mashara</button>
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#search_other1"><i class="fas fa-search"></i> Other 1</button>
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#search_other2"><i class="fas fa-search"></i> Other 2</button>
      </div>
      <div class="modal-footer float-right">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="search_mashara" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Mashara</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?=form_open('Admin/Master/Hadits/ResultSummarizing')?>
      <div class="modal-body">
        <input type="hidden" name="forum" value="mashara">
        <div class="form-group">
            <input type="text" name="web_link" class="form-control" placeholder="URL">
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary btn-sm">Cari</button>
      </div>
      <?=form_close()?>
    </div>
  </div>
</div>

<div class="modal fade" id="search_other1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Other 1</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?=form_open('Admin/Master/Hadits/ResultSummarizing')?>
      <div class="modal-body">
        <input type="hidden" name="forum" value="other1">
        <div class="form-group">
            <input type="text" name="web_link" class="form-control" placeholder="URL">
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary btn-sm">Cari</button>
      </div>
      <?=form_close()?>
    </div>
  </div>
</div>

<div class="modal fade" id="search_other2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Other 2</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?=form_open('Admin/Master/Hadits/ResultSummarizing')?>
      <div class="modal-body">
        <input type="hidden" name="forum" value="other2">
        <div class="form-group">
            <input type="text" name="web_link" class="form-control" placeholder="URL">
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary btn-sm">Cari</button>
      </div>
      <?=form_close()?>
    </div>
  </div>
</div>

<div class="modal fade" id="tambah_hadits">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Hadits</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?=form_open('Admin/Master/Hadits/Create/')?>
      <div class="modal-body">
        <input type="hidden" name="id_master_jenis" value="999">
        <div class="form-group">
            <label for="recipient-name" class="control-label">Judul :</label>
            <input type="text" class="form-control" name="hadits_name">
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Bab :</label>
            <select name="id_master_bab" class="form-control" required="">
                <?php foreach($tblMBab as $a): ?>
                  <option value="<?=$a->id_master_bab?>"><?=$a->bab_name?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Kitab :</label>
            <select name="id_master_kitab" class="form-control" required="">
                <?php foreach($tblMKitab as $a): ?>
                  <option value="<?=$a->id_master_kitab?>"><?=$a->kitab_name?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Isi Hadits :</label>
            <textarea class="form-control" style="height: 400px" name="hadits_content"></textarea>
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Arab :</label>
            <textarea class="form-control" style="height: 400px" name="hadits_arab"></textarea>
        </div>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Keterangan :</label>
            <select name="keterangan" class="form-control" required="">
                <option value="fixed">Fixed</option>
                <option value="summarizing">Summarizing</option>
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