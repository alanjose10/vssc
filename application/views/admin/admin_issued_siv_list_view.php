<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Issued SIVs 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().'admin/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Issued SIVs</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">   
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                    </div>
                    <div class="box-body no-padding table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr class="bg-gray">
                                <th>SIV No.</th>
                                <th>SIV Grade</th>
                                <th>Date Of Issue</th>
                                <th>No. Of Components</th>
                                <th>Entered By</th>
                                <th>Status</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                foreach($issued_siv as $row){
                                    echo "<tr id=\"row\" href=\"".base_url().'admin/view_full_siv/'.$row['siv_no']."\">";
                                    echo "<td>".$row['siv_no']."</td>\n";
                                    echo "<td>".$row['siv_grade']."</td>\n";
                                    echo "<td>".$row['date_of_issue']."</td>\n";
                                    echo "<td>".$row['no_of_components']."</td>\n";
                                    echo "<td>".$row['entered_by']."</td>\n";
                                    switch ($row['siv_status']){
                                        case 'PENDING_APPROVAL' :echo "<td><span class=\"label label-warning\">".$row['siv_status']."</span></td>\n";
                                                                break;
                                        case 'REJECTED' :echo "<td><span class=\"label label-danger\">".$row['siv_status']."</span></td>\n";
                                                                break;
                                        case 'APPROVED' :echo "<td><span class=\"label label-success\">".$row['siv_status']."</span></td>\n";
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
<!-- /.content-wrapper -->
 
 