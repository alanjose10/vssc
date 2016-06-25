 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        
      <h1>
        Add New User<small>Please enter new user details.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Add New User</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Enter New User Details</h3>
                    </div>
                    <form role="form-horizontal" action="<?php echo base_url().'admin/add_user'; ?>" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name"> Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                            </div>
                            <div class="form-group">
                                <label for="email_id"> Email ID</label>
                                <input type="email" class="form-control" id="email_id" name="email_id" placeholder="Email ID">
                            </div>
                            <div class="form-group">
                                <label for="user_name"> Username</label>
                                <input type="text" class="form-control" id="user_name" name="username" placeholder="Enter Username">
                            </div>
                            <div class="form-group">
                                <label for="password_1"> Password</label>
                                <input type="password" class="form-control" id="password_1" name="password_1" placeholder="Enter Password">
                            </div>
                            <div class="form-group">
                                <label for="password_2">Confirm Password</label>
                                <input type="password" class="form-control" id="password_2" name="password_2" placeholder="Confirm Password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2 col-xs-offset-5">
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-flat bg-red btn-lg" value="submit">Add User</button>
                                    <br><p>
                                    <?php       //not working?
                                    if(isset($password_err_msg)){
                                        echo $password_err_msg;
                                    }
                                    ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 