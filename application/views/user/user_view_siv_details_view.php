<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        SIV Details
        <small>#<?php echo $siv_details['siv_no']; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Issued SIVs</li>
        <li class="active">View SIV Details</li>
      </ol>
    </section>
    <div class="pad margin row no-print">
            <div class="col-xs-12">
                <div class="small-box <?php switch($siv_details['siv_status']){
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
                            <span class="info-box-text"><h4>SIV NO:</h4></span>
                            <span class="info-box-number"><?php echo $siv_details['siv_no']; ?></span>
                        </div>
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>SIV Grade:</h4></span>
                            <span class="info-box-number"><?php echo $siv_details['siv_grade']; ?></span>
                        </div>
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>Date Of Issue:</h4></span> 
                            <span class="info-box-number"><?php echo $siv_details['date_of_issue']; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>No Of Components:</h4></span>
                            <span class="info-box-number"><?php echo $siv_details['no_of_components']; ?></span>
                        </div>
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>SIV Status:</h4></span> 
                            <span class="info-box-number"><?php echo $siv_details['siv_status']; ?></span>
                        </div>
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>Entered By:</h4></span> 
                            <span class="info-box-number"><?php echo $siv_details['entered_by']; ?></span>
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

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-bordered table-striped table-hover">
            <thead class="bg-gray">
            <tr>
              <th>Component Type</th>
              <th>Component Name</th>
              <th>Date Of Expiry</th>
               <th>Quantity</th> 
            </tr>
            </thead>
            <tbody>
                
            <?php
            foreach($component_details as $row) {
                echo "<tr>";
                echo "<td>".$row['component_type']."</td>";
                echo "<td>".$row['component_name']."</td>";
                echo "<td>".$row['date_of_expiry']."</td>";
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
          <a href=\"".base_url().'user/print_siv/'.$siv_details['siv_no']."\" target=\"_blank\" class=\"btn btn-default\"><i class=\"fa fa-print\"></i> Print</a>
        </div>";
              
              echo "<div class=\"col-xs-4\">
          <a href=\"".base_url()."user/siv_save_as_excel/".$siv_details['siv_no']."\" class=\"btn btn-default btn-primary\"><i class=\"fa fa-file-excel-o\"></i> Save As Excel</a>";
            
        echo "</div>";
          }
          ?>
          

        
        <?php
            if(strcmp($siv_details['siv_status'],'PENDING_APPROVAL') == 0){
                echo "<div class=\"col-xs-4\">\n"; 
                echo "<a href=\"".base_url().'user/delete_issued_siv/'.$siv_details['siv_no']."\" class=\"btn btn-danger pull-right\"><i class=\"fa fa-delete\"></i> Delete</a>\n"; 
                echo "                    </div>\n";   
            }    
        ?>
      </div>
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
  </div>