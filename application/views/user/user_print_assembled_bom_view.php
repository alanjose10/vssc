<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>User|Print</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">-->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/fonts/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/daterangepicker/daterangepicker-bs3.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/datepicker/datepicker3.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/iCheck/all.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/colorpicker/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/select2/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/skins/_all-skins.min.css">
  <![endif]-->
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="pad margin row invoice-info">
            <h4 class="page-header">
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
            </h4>
        </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-bordered">
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
      <!-- /.col -->
    </div>
    <!-- /.row -->

  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
