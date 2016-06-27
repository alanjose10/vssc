<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>VSSC | Log In</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/fonts/font-awesome/css/font-awesome.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
      <div class="row">
        <div class="col-xs-12">
            <a href="#"><b>SPL</b><span>VSSC</span></a>
          </div>
      </div>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
      <div class="row">
          <div class="col-xs-11 col-xs-offset-1">
              <ul class="nav nav-tabs ">
                <li class="active"><a data-toggle="tab" href="#user">User</a></li>
                <li><a data-toggle="tab" href="#verifier">Verifier</a></li>
                <li><a data-toggle="tab" href="#admin">Admin</a></li>
            </ul>
          </div>
      </div><br><br>
      <div class="tab-content">
          <div class="tab-pane fade in active" id="user">
            <p class="login-box-msg">Please Sign In</p>
            <form action="<?php echo base_url().'user/login_validation'; ?>" method="post">
              <div class="form-group has-feedback">
                <input type="name" class="form-control" placeholder="Username (User)" name="username" id="username">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>
              <div class="row">
                
                <!-- /.col -->
                <div class="col-xs-4 col-xs-offset-4">
                  <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
                <div class="form-group">
                    <?php if(isset($err_msg)){ echo "<br><br>";} ?>             <!--not working??-->
                    <div class="col-xs-offset-2 col-xs-10">
                        <p><?php if(isset($err_msg)){echo $err_msg;}  ?></p>
                    </div>
                </div>
                <!-- /.col -->
              </div>
            </form>
          </div>
         <div class="tab-pane fade" id="verifier">
            <p class="login-box-msg">Please Sign In</p>

            <form action="<?php echo base_url().'verifier/login_validation'; ?>" method="post">
              <div class="form-group has-feedback">
                <input type="name" class="form-control" placeholder="Username (Verifier)" name="username" id="username">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>
              <div class="row">
                
                <!-- /.col -->
                <div class="col-xs-4 col-xs-offset-4">
                  <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
                <!-- /.col -->
              </div>
                <div class="form-group">
                    <?php if(isset($err_msg)){ echo "<br><br>";} ?>             <!--not working??-->
                    <div class="col-xs-offset-2 col-xs-10">
                        <p><?php if(isset($err_msg)){echo $err_msg;}  ?></p>
                    </div>
                </div>
            </form>
          </div>
             <div class="tab-pane fade" id="admin">
            <p class="login-box-msg">Please Sign In</p>

            <form action="<?php echo base_url().'admin/login_validation'; ?>" method="post">
              <div class="form-group has-feedback">
                <input type="name" class="form-control" placeholder="Username (Admin)" name="username" id="username">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>
              <div class="row">
               
                <!-- /.col -->
                <div class="col-xs-4 col-xs-offset-4">
                  <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
                <!-- /.col -->
              </div>
                <div class="form-group">
                    <?php if(isset($err_msg)){ echo "<br><br>";} ?>             <!--not working??-->
                    <div class="col-xs-offset-2 col-xs-10">
                        <p><?php if(isset($err_msg)){echo $err_msg;}  ?></p>
                    </div>
                </div>
            </form>
          </div>
      </div>
    <!-- /.social-auth-links -->     
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<!-- jQuery 2.2.0 -->
<script src="<?php echo base_url();?>assets/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url();?>assets/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
