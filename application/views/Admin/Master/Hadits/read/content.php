<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
    	<?php $this->load->view('layout/notification'); ?>
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Master Hadits</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Master</li>
                        <li class="breadcrumb-item">Hadits</li>
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
                            <h5 class="card-title">Data Hadits (Fixed)</h5>
                            <p class="card-text">
                              <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered table-striped">
                                  <thead>
                                  <tr>
                                    <th>Action</th>
                                    <th>No.</th>
                                    <th>Judul Hadits</th>
                                    <th>Isi Hadits</th>
                                    <th>Arab</th>
                                    <th>Bab</th>
                                    <th>Kitab</th>
                                    <th>Keterangan</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                    
                                  </tbody>
                                </table>
                              </div>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Data Hadits (Summarizing)</h5>
                            <p class="card-text">
                              <div class="table-responsive">
                                <table id="dataTable2" class="table table-bordered table-striped">
                                  <thead>
                                  <tr>
                                    <th>Action</th>
                                    <th>No.</th>
                                    <th>Judul Bahasan</th>
                                    <th>Pembahasan</th>
                                    <th>Link</th>
                                    <th>Bab</th>
                                    <th>Kitab</th>
                                    <th>Keterangan</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                    
                                  </tbody>
                                </table>
                              </div>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
