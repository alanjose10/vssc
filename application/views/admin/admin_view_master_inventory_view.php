<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Inventory - <?php 
                                switch($type){
                                    case 'em': echo "Engineering Grade";
                                                break;
                                    case 'fm': echo "Flight Grade";
                                                break;
                                }
                                ?>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Master Inventory - <?php 
                                switch($type){
                                    case 'em': echo "Engineering Grade";
                                                break;
                                    case 'fm': echo "Flight Grade";
                                                break;
                                }
                                ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="invoice">

      <div class="row">
        <div class="col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead class="bg-gray">
                            <tr>
                                <th>Sl No.</th>
                                <?php
                                foreach($table_fields as $field){
                                    echo "<th>".$field."</th>";
                                }
                                ?>
                                <th>Edit</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                                $date = date('Y-m-d', time() + (86400 * 90));
                               $i = 1;
                            foreach($components as $row) {
                                echo "<tr>";
                                echo "<td>".$i++."</td>";
                                foreach($table_fields as $field){
                                    if(($field < $date) && $row[$field] > 0){
                                        echo "<td><span class=\"badge bg-yellow\">".$row[$field]."</span></td>";
                                    }
                                    else{
                                        echo "<td>".$row[$field]."</td>";
                                    }
                                    
                                }
                                echo "<td><a class=\"text-danger\" href = \"".base_url().'admin/delete_from_master_inventory/'.$type."/".$row['component_type']."/".$row['component_name']."\" onclick=\"return confirm('Are you sure you want to delete this item?')\"><i class=\"glyphicon glyphicon-trash\"></i></a></td>";
                                echo "</tr>";
                            }
                            ?>
                                
                                
                            </tbody>
                          </table>
                    </div>
        </div>
        <!-- /.col -->
      </div><br><br>
        <div class="row no-print">

                    <div class="col-xs-3 col-xs-offset-1">
                      <a href="<?php echo base_url().'admin/print_master_inventory/'.$type; ?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                    </div>
                    <div class="col-xs-3 col-xs-offset-1">
                      <a href="<?php echo base_url().'admin/master_inventory_save_as_excel/'.$type; ?>" class="btn btn-default btn-primary"><i class="fa fa-file-excel-o"></i> Save As Excel</a>
                    </div>
        </div>        
        
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
  </div>