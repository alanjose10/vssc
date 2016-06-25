<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin|Print</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
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

                        <div class="col-xs-6">
                            BOM Name: <?php echo $bom_details['bom_name']; ?>
                        </div>
                        <div class="col-xs-6">
                           BOM No: <?php echo $bom_details['bom_no']; ?>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-xs-6">
                           Created By: <?php echo $bom_details['created_by']; ?>
                        </div>
                        <div class="col-xs-6">
                            Created On: <?php echo $bom_details['date_of_creation']; ?>
                        </div><br>

                    <!-- /.col -->
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
              <th>Quantity Required</th>
            </tr>
            </thead>
            <tbody>
                
            <?php
            foreach($component_details as $row) {
                echo "<tr>";
                echo "<td>".$row['component_id']."</td>";
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

  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
