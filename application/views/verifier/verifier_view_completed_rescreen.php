 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        
      <h1>
        Completed Re-Screen<small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Completed Re-Screens</li>
          <li class="active">View Completed Re-Screen</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Re-Screen Details</h3>
                    </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <h4>Component Grade: </h4>
                                </div>
                                <div class="col-xs-6">
                                    <h4><?php echo $rescreen_data['grade']; ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <h4>Component Type: </h4>
                                </div>
                                <div class="col-xs-6">
                                    <h4><?php echo $rescreen_data['component_type']; ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <h4>Component Name:</h4>
                                </div>
                                <div class="col-xs-6">
                                    <h4><?php echo $rescreen_data['component_name']; ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <h4>Component Quantity: </h4>
                                </div>
                                <div class="col-xs-6">
                                    <h4><?php echo $rescreen_data['component_quantity']; ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <h4>New Date Of Expiry: </h4>
                                </div>
                                <div class="col-xs-3">
                                    <h4><?php echo $rescreen_data['date_of_expiry']; ?></h4>
                                </div>
                            </div>
                        </div><br><br>
                        <div class="row">
                            <div class="col-xs-3 col-xs-offset-5">
                                <div class="box-footer">
                                    <a href="<?php echo base_url().'verifier/approve_rescreen/'.$rescreen_data['rescreen_id']; ?>" class="btn btn-success">Approve Re-Screen</a>
                                    <br><p>
                                   
                                    </p>
                                </div>
                            </div>
                        </div>
                </div>
            </div> 
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 