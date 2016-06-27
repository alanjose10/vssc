<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Assembled BOM Details
        <small><?php echo $bom_details['bom_no']."-".$bom_details['bom_name']."-".$bom_details['model_grade']."-".$bom_details['bom_model_no']; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>BOM-<?php echo $bom_details['bom_status']; ?></li>
        <li class="active">View BOM Details</li>
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
                                                    case 'DELIVERED' : echo "bg-aqua";
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
    <section class="invoice">

      <div class="row">
        <div class="col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>Component No.</th>
                              <th>Component Type</th>
                              <th>Component Name</th>
                              <th>Required Quantity</th>
                            <?php
                                if($bom_details['bom_status'] == 'APPROVED'){
                                    echo "<th>Issued Quantity</th>";
                                }
                                ?>
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
                                if($bom_details['bom_status'] == 'APPROVED'){
                                    echo "<td>";
                                    if($row['issued_quantity'] < $row['required_quantity']){
                                        echo "<span class=\"badge bg-red\">";
                                    }
                                    else{
                                        echo "<span class=\"badge bg-green \">";
                                    }
                                    echo $row['issued_quantity']."</span></td>"; 
                                    
                                }
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                          </table>
                    </div>
        </div>
        <!-- /.col -->
      </div>
        <div class="row no-print">
                    <div class="col-xs-3 col-xs-offset-1">
                      <a href="<?php echo base_url().'verifier/print_assembled_bom/'.$bom_details['bom_no']; ?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                    </div>
                    <div class="col-xs-3 col-xs-offset-1">
                      <a href="<?php echo base_url().'verifier/assembled_bom_save_as_excel/'.$bom_details['bom_no']; ?>" class="btn btn-default btn-primary"><i class="fa fa-file-excel-o"></i> Save As Excel</a>

                    </div>
                    <?php
                    if(strcmp($bom_details['bom_status'],'PENDING_APPROVAL') == 0){
                        echo "<div class=\"col-xs-3\">\n"; 
                        echo "<a href=\"".base_url().'verifier/delete_assembled_bom/'.$bom_details['bom_no']."\" class=\"btn btn-danger pull-right\"><i class=\"fa fa-delete\"></i> Delete</a>\n"; 
                        echo "                    </div>\n";   
                    }    
                    ?>
        </div>        
        <br><br>
        <?php
        if(strcmp($bom_details['bom_status'],'PENDING_APPROVAL') == 0){
            echo "<div class=\"row no-print\">\n"; 
            echo "            <div class=\"col-xs-4 col-xs-offset-2\">\n"; 
            echo "                <a href=\"".base_url().'verifier/approve_bom/'.$bom_details['bom_no']."\" class=\"btn btn-success\"><i class=\"fa fa-check\"></i> APPROVE</a>\n"; 
            echo "            </div>\n"; 
            echo "            <div class=\"col-xs-4 col-xs-offset-2\">\n"; 
            echo "                <a href=\"".base_url().'verifier/reject_bom/'.$bom_details['bom_no']."\" class=\"btn btn-danger\"><i class=\"fa fa-close\"></i> REJECT</a>\n"; 
            echo "            </div>\n"; 
            echo "        </div>\n";

        }
        ?>
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
  </div>