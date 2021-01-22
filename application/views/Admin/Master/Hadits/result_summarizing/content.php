<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"> Result Summarizing</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Knowledge</li>
                        <li class="breadcrumb-item active">Tambah</li>
                        <li class="breadcrumb-item active">Summarizing</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Result</h5>
                            <p class="card-text">
                            <div class="form-group">
                                <label for="pertanyaan">Pertanyaan</label>
                                <input type="text" name="pertanyaan" class="form-control" id="pertanyaan"  value="<?=$data_summarizing->judul?>" readonly>
                            </div>
                            
                            <div class="form-group">
                                <label for="url">URL</label>
                                <input type="url" name="url" class="form-control" id="url" value="<?=$data_summarizing->url?>" readonly>
                            </div>
                
                            <div class="form-group">
                                <label for="keyword">Keyword</label>
                                <input type="text" name="keyword" class="form-control" id="keyword" value="<?=$data_summarizing->keyword?>" readonly>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label>Hasil Ringkasan</label>
                                <textarea class="form-control textarea" rows="3" name="ringkasan" id="ringkasan" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" readonly><?=$data_summarizing->ringkasan?></textarea>
                            </div>
                            <button data-toggle="modal" data-target="#tambah_knowledge" class="btn btn-primary">Simpan Hasil</button>&nbsp;<button data-toggle="collapse" href="#collapseExample" class="btn btn-warning">Lihat Proses</button>
                            <div class="collapse" id="collapseExample">
                                <table class="table">
                                    <tr>
                                        <th>Jumlah Karakter Plain Text</th>
                                        <td>&nbsp;:&nbsp;</td>
                                        <td><?=$data_summarizing->len_raw?></td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah Karakter Textrank</th>
                                        <td>&nbsp;:&nbsp;</td>
                                        <td><?=$data_summarizing->len_text?></td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah Kalimat</th>
                                        <td>&nbsp;:&nbsp;</td>
                                        <td><?=$data_summarizing->len_kalimat?></td>
                                    </tr>
                                    <tr>
                                        <th>Presentase Reduce Kalimat</th>
                                        <td>&nbsp;:&nbsp;</td>
                                        <td><?=$data_summarizing->presentase?> %</td>
                                    </tr>
                                </table>
                                <div class="row">
                                    <!-- Left col -->
                                    <div class="col-md-12">
                                    <!-- MAP & BOX PANE -->
                                    <div class="card">
                                        <div class="card-header">
                                        <h3 class="card-title">Data Plain</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                        <p><?=$data_summarizing->raw_text?></p>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                    
                                
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- End Row Hasil -->
                                
                                <!-- Row Stem -->
                                <div class="row">
                                    <!-- Left col -->
                                    <div class="col-md-12">
                                    <!-- MAP & BOX PANE -->
                                    <div class="card">
                                        <div class="card-header">
                                        <h3 class="card-title">Stemming</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                        <p><?=$data_summarizing->ringkasan?></p>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- End Row Stem -->
                                
                                <div class="row">
                                <!-- Left col -->
                                <div class="col-md-12">
                                    <!-- MAP & BOX PANE -->
                                    
                                    <!-- /.card -->
                                    <div class="row">
                                    
                                    <!-- /.col -->
                                
                                    <div class="col-md-6">
                                        <!-- DIRECT CHAT -->
                                        <div class="card direct-chat direct-chat-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">Hasil Ektraksi</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            
                                            <p><?php var_dump($data_summarizing->text) ?></p>
                                            
                                        </div>
                                        <!-- /.card-body -->
                                        
                                        </div>
                                        <!--/.direct-chat -->
                                
                                        <!-- DIRECT CHAT -->
                                        <div class="card direct-chat direct-chat-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">Hasil Stopword</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            
                                            <p><?php var_dump($data_summarizing->new_sentence) ?></p>
                                            
                                        </div>
                                        <!-- /.card-body -->
                                        
                                        </div>
                                        <!--/.direct-chat -->
                                    </div>
                                    <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                
                                </div>
                                <!-- /.col -->
                                </div>
                            </div>
                            </p>
                        </div>
                    </div>
                </div>
            </div>  
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>