<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>User|Home</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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
    <style>
        #row {
        cursor: pointer;
    }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini"> <!--red theme for admin -->
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">       <!--link to dashboard!! -->
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>U</b>P</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>User</b>Page</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
           <li class="dropdown messages-menu">                       <!-- Messages -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success"><?=$message_count?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <?=$message_count?> messages</li> 
                <li>    
                <ul class="menu">
                <?php
                foreach($notification_details as $row)   {
                print "<li><!-- start message -->\n";
                print "<a href=\"#\">\n";
                print "<div class=\"pull-left\">\n";
                print "<img src=\"".base_url()."assets/dist/img/user_m.jpg\" class=\"img-circle\" alt=\"Sender Image\" style=\"height: 20px\">\n";
                print "</div>\n";
                print "<h4>\n";
                    echo "<option value=\"".$row['sender_name']."\">".$row['sender_name']."</option>\n";
                print "<small><i class=\"fa fa-clock-o\"></i>\n";
                    //echo "<option value=\"".$row['time']."\">".$row['time']."</option>\n";
                print "</small>\n";
                print "</h4>\n";
                print "<p>\n";
                    //echo "<option value=\"".$row['message']."\">".$row['message']."</option>\n";
                print "</p>\n";

                print "</a>\n";
                print "</li>";
                }
                ?>
                </ul>
                </li>
                <li class="footer"><a href="<?php echo base_url().'user/message'; ?>">See All Messages</a></li>
            </ul>
          </li>
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url();?>assets/dist/img/user_m.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $this->session->userdata('name'); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url();?>assets/dist/img/user_m.jpg" class="img-circle" alt="User Image">

                <p>
                  <?php echo $this->session->userdata('name'); ?>
                  <small>User</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="row">
                    <div class="col-xs-offset-4">
                        <a href="<?php echo base_url().'user/logout'; ?>" class="btn btn-default btn-flat bg-blue">Sign out</a>
                    </div>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
<!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url();?>assets/dist/img/user_m.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $this->session->userdata('name'); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview">
          <a href="<?php echo base_url().'user/dashboard'; ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
    <?php    /* //store_officer
          if($this->session->userdata('store_officer') == 1){
              echo "<!--";
          } */
          ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-shopping-cart"></i>
            <span>SIV</span>
            <i class="fa fa-angle-right pull-right"></i>
          </a>
          <ul class="treeview-menu">
              <?php     //siv_entry
              if($this->session->userdata('siv_entry') == 1){
                  echo "<li><a href=\"".base_url()."user/new_siv\"><i class=\"fa fa-circle-o\"></i> New SIV</a></li>\n";
              }
              ?>
            <li><a href="<?php echo base_url().'user/view_issued_siv_list'; ?>"><i class="fa fa-circle-o"></i> Issued SIVs</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-file-text"></i>
            <span>BOM</span>
            <i class="fa fa-angle-right pull-right"></i>
          </a>
          <ul class="treeview-menu">
          <?php     //bom_entry
          if($this->session->userdata('bom_entry') == 1){
              echo "<li><a href=\"".base_url()."user/choose_bom_for_entry\"><i class=\"fa fa-circle-o\"></i>Enter BOM</a></li>\n";
          }
            ?>
        <li><a href="<?php echo base_url().'user/view_assembled_bom_list'; ?>"><i class="fa fa-circle-o"></i>Issued BOMs</a></li>
        <li><a href="<?php echo base_url().'user/view_uploaded_bom_list'; ?>"><i class="fa fa-circle-o"></i>View Uploaded BOMs </a></li>  
            <?php     //bom_create
          if($this->session->userdata('bom_create') == 1){
              echo "<li><a href=\"".base_url()."user/create_bom_user\"><i class=\"fa fa-circle-o\"></i>Create BOM</a></li>\n";
          }        
            ?>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-refresh"></i>
            <i class="pull-right fa fa-angle-right"></i>
            <span>Re-Screen</span>
          </a>
            <ul class="treeview-menu">
                <?php
                if($this->session->userdata('rescreen') == 1){
                    echo "<li><a href=\"".base_url()."user/get_rescreens_for_user\"><i class=\"fa fa-circle-o\"></i>Pending Re-Screens</a></li>";
                }
                ?>
                
                <li><a href="<?php echo base_url().'user/get_completed_rescreens'; ?>"><i class="fa fa-circle-o"></i>Completed Re-Screens</a></li>
            </ul>
        </li>
        <li>
          <a href="<?php echo base_url().'user/calendar'; ?>">
            <i class="fa fa-calendar"></i> <span>Calendar</span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url().'user/message'; ?>">
            <i class="fa fa-envelope"></i> <span>Messages</span>
          </a>
        </li>
    <?php   /*  //store_officer
      if($this->session->userdata('store_officer') == 1){
          echo "-->";
          echo "<li class=\"treeview\">
          <a href=\"#\">
            <i class=\"fa fa-briefcase\"></i>
            <span>Store Officer #</span>
            <i class=\"fa fa-angle-right pull-right\"></i>
          </a>
          <ul class=\"treeview-menu\">
            <li><a href=\"".base_url()."user/store_officer_approved_boms_list\"><i class=\"fa fa-circle-o\"></i> Approved BOMs</a></li>
          </ul>
          <ul class=\"treeview-menu\">
            <li><a href=\"".base_url()."user/store_officer_approved_boms_list\"><i class=\"fa fa-circle-o\"></i> Delivered BOMs</a></li>
          </ul>
        </li>";
          
          
      }      */
      ?>
          
    </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
 <?=$page_content?>
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; 2014-2015 <a href="#">Lol</a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.0 -->
<script src="<?php echo base_url();?>assets/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url();?>assets/plugins/select2/select2.full.min.js"></script>
<!-- InputMask -->
<script src="<?php echo base_url();?>assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo base_url();?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url();?>assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="<?php echo base_url();?>assets/dist/js/moment.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo base_url();?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- bootstrap color picker -->
<script src="<?php echo base_url();?>assets/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="<?php echo base_url();?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="<?php echo base_url();?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="<?php echo base_url();?>assets/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url();?>assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>assets/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url();?>assets/dist/js/demo.js"></script>
    
<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
    //Money Euro
    $("[data-mask]").inputmask();

    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
    //Date range as a button
    $('#daterange-btn').daterangepicker(
        {
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function (start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    );

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
  });
</script>
<script>                //to click table row
    $(document).ready(function(){
        $('table #row').click(function(){
            window.location = $(this).attr('href');
            return false;
        });
    });
</script>    
</body>
</html>
