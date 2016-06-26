<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Approved BOMs
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().'user/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Store Officer</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">   
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">BOMs</h3>
                    </div>
                    <div class="box-body no-padding table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr class="bg-blue">
                                <th>Entry No.</th>
                                <th>BOM Name</th>
                                <th>BOM Model Grade</th>
                                <th>BOM Model No.</th>
                                <th>Date Of Assembling</th>
                                <th>Assembled By</th>
                                <th>BOM Status</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                foreach($assembled_bom as $row){
                                    echo "<tr id=\"row\" href=\"".base_url().'user/store_officer_approved_bom_detail_view/'.$row['bom_no']."\">";
                                    echo "<td>".$row['bom_no']."</td>\n";
                                    echo "<td>".$row['bom_name']."</td>\n";
                                    echo "<td>".$row['model_grade']."</td>\n";
                                    echo "<td>".$row['bom_model_no']."</td>\n";
                                    echo "<td>".$row['date_of_assembly']."</td>\n";
                                    echo "<td>".$row['assembled_by']."</td>\n";
                                    switch ($row['bom_status']){
                                        case 'PENDING_APPROVAL' :echo "<td><span class=\"label label-warning\">".$row['bom_status']."</span></td>\n";
                                                                break;
                                        case 'REJECTED' :echo "<td><span class=\"label label-danger\">".$row['bom_status']."</span></td>\n";
                                                                break;
                                        case 'APPROVED' :echo "<td><span class=\"label label-success\">".$row['bom_status']."</span></td>\n";
                                                                break;
                                    }
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
