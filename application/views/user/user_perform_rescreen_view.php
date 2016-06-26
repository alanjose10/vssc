 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        
      <h1>
        Perform Re-Screen<small>Please enter new expiry date.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li>Pending Re-Screens</li>
        <li class="active">Perform Re-Screen</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Enter New User Details</h3>
                    </div>
                    <form role="form-horizontal" action="<?php echo base_url().'user/confirm_rescreen'; ?>" method="post">
                        <input type="hidden" name="rescreen_id" value="<?php echo $rescreen_data['rescreen_id']; ?>"/>
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
                                    <div class="form-group">
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                      </div>
                                      <input type="text" class="form-control" id="date_of_expiry" name="date_of_expiry" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2 col-xs-offset-5">
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-success" name="submit" value="submit">Confirm Rescreen</button>
                                    <br><p>
                                   
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 