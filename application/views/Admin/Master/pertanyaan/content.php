<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"> Master Pertanyaan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item active">Pertanyaan</li>
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
                            <h5 class="card-title">Pilih Bab</h5>
                            <p class="card-text">
                                <?=form_open('Admin/Master/Pertanyaan/')?>
                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Bab :</label>
                                    <select name="id_master_bab" class="form-control" required="">
                                        <?php foreach($tblMBab as $a): ?>
                                        <option value="<?=$a->id_master_bab?>" <?=($id_master_bab == $a->id_master_bab) ? 'selected' : ''?>><?=$a->bab_name?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                                <?=form_close()?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <?php if($data_kosong == FALSE): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">List Pertanyaan</h5>
                                <div class="float-right">
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambah_master_pertanyaan"><i class="fas fa-plus"></i></button>
                                </div>
                                <p class="card-text">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>No.</th>
                                                    <th>Nama Pertanyaan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($tblMPertanyaan)): ?>
                                                    <?php $no=1; foreach($tblMPertanyaan as $a): ?>
                                                    <tr>
                                                        <td align="center">
                                                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#list_pilihan<?=$a->id_master_pertanyaan?>"><i class="fas fa-bars"></i></button>
                                                            <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#edit_master_pertanyaan<?=$a->id_master_pertanyaan?>"><i class="fas fa-edit"></i></button>
                                                            <a class="btn btn-danger btn-xs" href="<?=base_url('Admin/Master/Pertanyaan/Delete/'.$a->id_master_pertanyaan)?>" onclick="return confirm('Apakah anda yakin ?')"><i class="fas fa-trash"></i></a>
                                                        </td>
                                                        <td><?=$no++?></td>
                                                        <td><?=$a->pertanyaan?></td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan='3'>Data Kosong</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>