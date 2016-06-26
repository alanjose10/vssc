<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Components To Re-Screen
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">To Re-Screen</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="invoice">

      <div class="row">
        <div class="col-xs-12">
            <form method="post" action="<?php echo base_url()."verifier/assign_rescreen/"; ?>">   
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead class="bg-gray">
                            <tr>
                            <th>Sl No.</th>
                              <th>Component Grade</th>
                              <th>Component Type</th>
                              <th>Component Name</th>
                              <th>Date Of Expiry</th>
                                <th>Component Quantity</th>
                            </tr>
                            </thead>
                            <tbody>
                            
                             
                            <?php
                               $i = 1;
                            foreach($rescreen_components as $row) {
                                echo "<tr>";
                                
                                echo "<td>".($i++)."</td>";
                                echo "<td>".$row['grade']."</td>";
                                echo "<input type=\"hidden\" name=\"grade[]\" value=\"".$row['grade']."\"/>";
                                echo "<td>".$row['component_type']."</td>";
                                echo "<input type=\"hidden\" name=\"component_type[]\" value=\"".$row['component_type']."\"/>";
                                 echo "<td>".$row['component_name']."</td>";
                                echo "<input type=\"hidden\" name=\"component_name[]\" value=\"".$row['component_name']."\"/>";
                                 echo "<td>".$row['date_of_expiry']."</td>";
                                echo "<input type=\"hidden\" name=\"date_of_expiry[]\" value=\"".$row['date_of_expiry']."\"/>";
                                echo "<td>".$row['component_quantity']."</td>";
                                echo "<input type=\"hidden\" name=\"component_quantity[]\" value=\"".$row['component_quantity']."\"/>";
                               
                                
                                
                                echo "</tr>";
                            }
                            ?>
                            
                          </table>
                    </div>
                <div class="row">
                    <div class="col-xs-2 col-xs-offset-1">
                            <div class="form-group">
                                <input type="number" class="form-control" id="sl_no" name="sl_no"  placeholder="Enter Sl No.">
                            </div>
                        </div>
                    <div class="col-xs-2 col-xs-offset-1">
                        <div class="form-group">
                            <select id="user" name="assigned_user" class="form-control select2" placeholder="Event Title">";
                                <option selected="selected" value="" disabled>Choose user</option>
                                <?php
                                foreach($users as $row)   {
                                    echo "<option value=\"".$row['user_name']."\">".$row['name']."</option>\n"; 
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-2 col-xs-offset-2">
                        <div class="form-group">
                            <button type="submit" name="submit" value="submit" class="btn btn-primary center-block">Assign Re-Screen</button>
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