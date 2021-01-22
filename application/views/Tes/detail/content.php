<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"> Detail</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Tes</li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
        <?php $this->load->view('layout/notification'); ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Histori Jawaban</h5>
                            <p class="card-text">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Jawaban</th>
                                        <th>Nilai</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($tblHJawaban as $a): ?>
                                            <tr>
                                                <td><?=$no++?></td>
                                                <td><?=$a->pilihan?></td>
                                                <td><?=$a->nilai?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    </table>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Histori Rekomendasi:</h5>
                            <p class="card-text">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Bab</th>
                                        <th>Hasil</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($tblHRekomendasi as $a): ?>
                                            <tr>
                                                <td><?=$no++?></td>
                                                <td><?=$a->bab_name?></td>
                                                <td>
                                                <?php
                                                    if($a->score < 25):
                                                        echo "Tidak Paham";
                                                    elseif($a->score > 25 and $a->score <= 50):
                                                        echo "Kurang Paham";
                                                    elseif($a->score > 50 and $a->score <= 75):
                                                        echo "Paham";
                                                    else:
                                                        echo "Sangat Paham";
                                                    endif;
                                                ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    </table>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>