<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        View All Users
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().'admin/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">View all users</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">   
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"> Users Details</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-hover table-striped table-bordered">
                            <tr class="bg-red">
                                <th>ID</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Last Active</th>
                                <th>Join Date</th>
                                <th>Remove User</th>
                            </tr>
                            <?php 
                            foreach ($view_users as $row){
                                echo "<tr >
                                        <td>".$row['user_id']."</td>
                                        <td>".$row['name']."</td>
                                        <td>".$row['user_name']."</td>
                                        <td>".$row['last_active_date']."</td>
                                        <td>".$row['join_date']."</td>
                                        <td ><a class=\"btn col-xs-offset-5 text-danger\" href=\"".base_url().'admin/remove_user/'.$row['user_id']."\" onclick=\"return confirm('Are you sure you want to delete this item?')\"><i class=\"glyphicon glyphicon-trash\"></i></a></td>
                                    </tr>";
                            }
                            ?>    
                        </table>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>