<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        BOM Details
        <small>#<?php echo $bom_details['bom_no']; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Examples</a></li>
        <li>Bom List</li>
        <li class="active">View BOM Details</li>
      </ol>
    </section>
    <div class="pad margin row no-print">
            <div class="col-xs-12">
                <div class="small-box bg-blue">
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
                            <span class="info-box-text"><h4>Model Grade:</h4></span> 
                            <span class="info-box-number"><?php echo $bom_details['model_type']; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>Uploaded By:</h4></span>
                            <span class="info-box-number"><?php echo $bom_details['created_by']; ?></span>
                        </div>
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>Uploaded Date:</h4></span> 
                            <span class="info-box-number"><?php echo $bom_details['date_of_creation']; ?></span>
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
      <!-- title row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <thead class="bg-gray">
            <tr>
              <th>Component No.</th>
              <th>Component Type</th>
              <th>Component Name</th>
              <th>Quantity Required</th>
            </tr>
            </thead>
            <tbody>
                
            <?php
                $i = 1;
            foreach($component_details as $row) {
                echo "<tr>";
                echo "<td>".$i++."</td>";
                echo "<td>".$row['component_type']."</td>";
                echo "<td>".$row['component_name']."</td>";
                echo "<td>".$row['component_quantity']."</td>";
                echo "</tr>";
            }
            ?>
            
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
       
          
          <?php
   
              if($this->session->userdata('print_excel') == 1){

                  echo "<div class=\"col-xs-4\">
              <a href=\"".base_url().'user/print_bom/'.$bom_details['bom_no']."\" target=\"_blank\" class=\"btn btn-default\"><i class=\"fa fa-print\"></i> Print</a>
            </div>";

                 
              }
          
            
              ?>
          <div class="col-xs-2">
          <a href="<?php echo base_url().'user/delete_uploaded_bom/'.$bom_details['bom_no']; ?>" class="btn btn-danger pull-right"><i class="fa fa-delete"></i> Delete</a>
        </div>
          
      </div>
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
  </div>