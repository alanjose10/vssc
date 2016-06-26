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
            <form method="post" action="<?php echo base_url().'user/confirm_delivery/'; ?>">
                <input type='hidden' name='bom_no' value="<?php echo $bom_details['bom_no']; ?>"/>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead class="bg-gray">
                            <tr>
                              <th>Component No.</th>
                              <th>Component Type</th>
                              <th>Component Name</th>
                              <th>Required Quantity</th>
                            <?php
                            if($bom_details['bom_status'] == 'APPROVED'){
                                echo "<th>Issued Quantity</th>";
                            }
                                echo "<th>Delivered Quantity</th>";
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
                                echo "<td style=\"width:150px\">";
                                echo "<div class=\"form-group\">";
                                
                                echo form_input(array(
                                                            "type" => "number",
                                                            "class" => "form-control",
                                                            "style" => "width:150px",
                                                            "id" => "delivered_quantity",
                                                            "name" => "delivered_quantity[]",
                                                            "placeholder" => $row['issued_quantity'],
                                                            "value" => $row['issued_quantity'],
                                                            "min" => "0",
                                                            "max" => $row['issued_quantity']
                                                            ));
                                
                                echo "</div>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                            
                            </tbody>
                          </table>
                    </div>
                    <div class="row no-print">
                    <div class="row no-print"> 
                    <div class="col-xs-3 col-xs-offset-4"> 
                    <button type="submit" name="submit" value="submit" class="btn btn-success"><i class="fa fa-check"></i> CONFIRM DELIVERY</button> 
                    </div> 
                    </div>
                  </div>
                
          </form>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
  </div>