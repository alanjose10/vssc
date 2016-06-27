<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Assembled BOM Details
        <small><?php echo $bom_details['bom_no']."-".$bom_details['bom_name']."-".$bom_details['model_grade']."-".$bom_details['bom_model_no']; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Assembled Bom List</li>
        <li class="active">View Assembled BOM Details</li>
      </ol>
    </section>
    <div class="pad margin row no-print">
            <div class="col-xs-12">
                <div class="small-box <?php switch($bom_details['bom_status']){
                                                    case 'PENDING_APPROVAL' : echo "bg-yellow";
                                                                            break;
                                                    case 'APPROVED' : echo "bg-green";
                                                                            break;
                                                    case 'REJECTED' : echo "bg-red";
                                                                            break;
                                                    case 'DELIVERED' : echo "bg-agua";
                                                                            break;
                                                    }
                                    ?>">
                <div class="inner">
                    <div class="row">
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>BOM NO:</h4></span>
                            <span class="info-box-number"><?php echo $bom_details['bom_no']; ?></span>
                        </div>
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>BOM Name:</h4></span>
                            <span class="info-box-number"><?php echo $bom_details['bom_name']; ?></span>
                        </div>
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>Model:</h4></span> 
                            <span class="info-box-number"><?php echo $bom_details['model_grade']."-".$bom_details['bom_model_no']; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>Assembled By.</h4></span>
                            <span class="info-box-number"><?php echo $bom_details['assembled_by']; ?></span>
                        </div>
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>Assembled On:</h4></span> 
                            <span class="info-box-number"><?php echo $bom_details['date_of_assembly']; ?></span>
                        </div>
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>Status:</h4></span> 
                            <span class="info-box-number"><?php echo $bom_details['bom_status']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="icon">
                  <i class="fa fa-file-text-o"></i>
                </div>
              </div>       
            </div>
    </div>
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>Component No.</th>
                              <th>Component Type</th>
                              <th>Component Name</th>
                              <th>Required Quantity</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                               $i = 1;
                            foreach($components as $row) {
                                echo "<tr>";
                                echo "<td>".$i++."</td>";
                                echo "<td>".$row['component_type']."</td>";
                                echo "<td>".$row['component_name']."</td>";
                                echo "<td>".$row['required_quantity']."</td>";
                                echo "</tr>";
                            }
                            ?>

                            </tbody>
                          </table>
                    </div>
                    <div class="row no-print">
                    <div class="col-xs-4">
                      <a href="<?php echo base_url().'admin/print_assembled_bom/'.$bom_details['bom_no']; ?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                    </div>
                    <div class="col-xs-4">
                      <a href="<?php echo base_url().'admin/assembled_bom_save_as_excel/'.$bom_details['bom_no']; ?>" class="btn btn-default btn-primary"><i class="fa fa-file-excel-o"></i> Save As Excel</a>

                    </div>
                    <?php
                    if(strcmp($bom_details['bom_status'],'PENDING_APPROVAL') == 0){
                        echo "<div class=\"col-xs-4\">\n"; 
                        echo "<a href=\"".base_url().'admin/delete_assembled_bom/'.$bom_details['bom_no']."\" class=\"btn btn-danger pull-right\"><i class=\"fa fa-delete\"></i> Delete</a>\n"; 
                        echo "                    </div>\n";   
                    }    
                    ?>
                  </div>
                </div>
                
            </div>
          
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
  </div>