<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Peserta Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Knowledge</li>
                        <li class="breadcrumb-item">Users</li>
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
    	            <?php $this->load->view('layout/notification'); ?>  
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Peserta Belajar</h5>
                            <p class="card-text">
                              <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered table-striped">
                                  <thead>
                                  <tr>
                                    <th>Action</th>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Foto</th>
                                    <th>Level</th>
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
