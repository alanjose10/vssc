


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Approved Re-Screens
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().'user/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Approved Re-Screens</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">   
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Approved Re-Screens</h3>
                    </div>
                    <div class="box-body no-padding table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="bg-gray">
                            <tr>
                                <th>Re-Screen ID.</th>
                                <th>Grade</th>
                                <th>Component Type</th>
                                <th>Component Name</th>
                                <th>Date Of Expiry</th>
                                <th>Component Quantity</th>
                                <th>Assigned User</th>
                                <th>Rescreen Status</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                foreach($rescreens as $row){
                                    echo "<tr id=\"row\" href=\"#\">";
                                    echo "<td>".$row['rescreen_id']."</td>\n";
                                    echo "<td>".$row['grade']."</td>\n";
                                    echo "<td>".$row['component_type']."</td>\n";
                                    echo "<td>".$row['component_name']."</td>\n";
                                    echo "<td>".$row['date_of_expiry']."</td>\n";
                                    echo "<td>".$row['component_quantity']."</td>\n";
                                    echo "<td>".$row['assigned_user']."</td>\n";
                                    echo "<td><span class=\"label label-success\">".$row['rescreen_status']."</span></td>\n";
                                    /*
                                    switch ($row['bom_status']){
                                        case 'PENDING_RESCREEN' :echo "<td><span class=\"label label-warning\">".$row['rescreen_status']."</span></td>\n";
                                                                break;
                                        case 'RESCREEN_COMPLETE' :echo "<td><span class=\"label label-danger\">".$row['rescreen_status']."</span></td>\n";
                                                                break;
                                        case 'RESCREEN_CANCELLED' :echo "<td><span class=\"label label-success\">".$row['rescreen_status']."</span></td>\n";
                                                                break;
                                    }
                                    */
                                    echo "\n</tr>";
                                }
                                
                                ?>
                                </tbody>
                            
                        </table>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
