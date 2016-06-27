<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Verifier|Calendar</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
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
<!-- fullCalendar 2.2.5-->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/fullcalendar/fullcalendar.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/fullcalendar/fullcalendar.print.css" media="print">


  <![endif]-->
</head>
<body class="hold-transition skin-green sidebar-mini"> <!--red theme for admin -->
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">       <!--link to dashboard!! -->
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>V</b>P</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Verifier</b>Page</span>
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
                print "<img src=\"".base_url()."assets/dist/img/user_f.jpg\" class=\"img-circle\" alt=\"Sender Image\" style=\"height: 20px\">\n";
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
                <li class="footer"><a href="<?php echo base_url().'verifier/message'; ?>">See All Messages</a></li>
            </ul>
          </li><!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url();?>assets/dist/img/user_f.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $this->session->userdata('name'); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url();?>assets/dist/img/user_f.jpg" class="img-circle" alt="User Image">

                <p>
                  <?php echo $this->session->userdata('name'); ?>
                  <small>Verifier</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="row">
                    <div class="col-xs-offset-4">
                        <a href="<?php echo base_url().'verifier/logout'; ?>" class="btn btn-default btn-flat bg-green">Sign out</a>
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
          <img src="<?php echo base_url();?>assets/dist/img/user_f.jpg" class="img-circle" alt="User Image">
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
          <a href="<?php echo base_url().'verifier/dashboard'; ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-shopping-cart"></i>
            <span>SIV</span>
            <i class=" pull-right fa fa-angle-right"></i>
          </a>
            <ul class="treeview-menu">
                <li><a href="<?php echo base_url().'verifier/view_siv_list/PENDING_APPROVAL'; ?>"><i class="fa fa-circle-o"></i>Pending Approval</a></li>
                <li><a href="<?php echo base_url().'verifier/view_siv_list/APPROVED'; ?>"><i class="fa fa-circle-o"></i>Approved</a></li>
                <li><a href="<?php echo base_url().'verifier/view_siv_list/REJECTED'; ?>"><i class="fa fa-circle-o"></i>Rejected</a></li>
                <li><a href="<?php echo base_url().'verifier/view_siv_list/ALL'; ?>"><i class="fa fa-circle-o"></i>View All SIVs</a></li>
            </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-file-text"></i>
            <span>BOM</span>
            <i class=" pull-right fa fa-angle-right"></i>
          </a>
            <ul class="treeview-menu">
                <li><a href="<?php echo base_url().'verifier/view_assembled_bom_list/PENDING_APPROVAL'; ?>"><i class="fa fa-circle-o"></i>Pending Approval</a></li>
                <li><a href="<?php echo base_url().'verifier/view_assembled_bom_list/APPROVED'; ?>"><i class="fa fa-circle-o"></i>Approved</a></li>
                <li><a href="<?php echo base_url().'verifier/view_assembled_bom_list/REJECTED'; ?>"><i class="fa fa-circle-o"></i>Rejected</a></li>
                <li><a href="<?php echo base_url().'verifier/view_assembled_bom_list/ALL'; ?>"><i class="fa fa-circle-o"></i>View All BOMs</a></li>
            </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-refresh"></i>
            <i class="pull-right fa fa-angle-right"></i>
            <span>Re-Screen</span>
          </a>
            <ul class="treeview-menu">
                
                <li>
                  <a href="#"><i class="fa fa-circle-o"></i>To Re-screen<i class="fa fa-angle-right pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="<?php echo base_url().'verifier/get_components_for_rescreen/EM'; ?>"><i class="fa fa-circle-o"></i>Engineering Grade</a></li>
                    <li><a href="<?php echo base_url().'verifier/get_components_for_rescreen/FM'; ?>"><i class="fa fa-circle-o"></i>Flight Grade</a></li>
                  </ul>
                </li>
                <li><a href="<?php echo base_url().'verifier/get_completed_rescreens'; ?>"><i class="fa fa-circle-o"></i>Completed Re-Screens</a></li>
                <li><a href="<?php echo base_url().'verifier/get_approved_rescreens'; ?>"><i class="fa fa-circle-o"></i>Approved Re-Screens</a></li>
            </ul>
        </li>
        <li>
          <a href="<?php echo base_url().'verifier/calendar'; ?>">
            <i class="fa fa-calendar"></i> <span>Calendar</span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url().'verifier/message'; ?>">
            <i class="fa fa-envelope"></i> <span>Messages </span>
          </a>
        </li>
        </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Calendar
        <small>Assign Tasks</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Calendar</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <!-- /. box -->
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Color Code</h3>
            </div>
            <div class="box-body">
              <div class="btn-group" style="width: 100%; margin-bottom: 5px;">
                <!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
                <ul class="fc-color-picker" id="color-chooser">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 fc-color-picker">
                                <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
                                <code>Assigned Task</code>
                            </div>
                            <div class="col-xs-12 fc-color-picker">
                                <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
                                <code>SIV Entered</code>
                            </div>
                            <div class="col-xs-12 fc-color-picker">
                                <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
                                <code>SIV Approved</code>
                            </div>
                            <div class="col-xs-12 fc-color-picker">
                                <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
                                <code>SIV Rejected</code>
                            </div>
                            
                            <div class="col-xs-12 fc-color-picker">
                                <li><a class="text-black" href="#"><i class="fa fa-square"></i></a></li>
                                <code>BOM Created</code>
                            </div>
                            <div class="col-xs-12 fc-color-picker">
                                <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
                                <code>BOM Entered</code>
                            </div>
                            <div class="col-xs-12 fc-color-picker">
                                <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
                                <code>BOM Approved</code>
                            </div>
                            
                            <div class="col-xs-12 fc-color-picker">
                                <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
                                <code>BOM Rejected</code>
                            </div>
                            <div class="col-xs-12 fc-color-picker">
                                <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
                                <code>Re-Screen Pending</code>
                            </div>
                            <div class="col-xs-12 fc-color-picker">
                                <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
                                <code>Re-Screen Completed</code>
                            </div> 
                            <div class="col-xs-12 fc-color-picker">
                                <li><a class="text-gray" href="#"><i class="fa fa-square"></i></a></li>
                                <code>Re-Screen Approved</code>
                            </div> 
                        </div>
                    </div>
                    
                </ul>
              </div>
              <!-- /btn-group -->
             
              <!-- /input-group -->
            </div>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-success">
            <div class="box-body no-padding">
              <!-- THE CALENDAR -->
              <div id="calendar"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Lol</a>.</strong> All rights
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
<!-- fullCalendar 2.2.5 -->
<script src="<?php echo base_url();?>assets/plugins/fullcalendar/fullcalendar.min.js"></script>
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
<!-- jQuery UI 1.11.4 -->

<script src="<?php echo base_url();?>assets/dist/js/jquery-ui.min.js"></script>  


<!-- FullCalendar js -->
<script>
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        };

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject);

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex: 1070,
          revert: true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        });

      });
    }

    ini_events($('#external-events div.external-event'));

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date();
    var  d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear();
      
      // function to pass user_name to controller...not working!
      /*
    $('#user').select(function(){
        console.log("selected");
        jQuery.ajax({
                url: "<?php echo base_url(); ?>"+"admin/calendar_get_events",
                type: 'post',
                dataType: 'json',
                //data: {"lol"} ,
                success: function () {
                    console.log("ok");
                }
            });
    });
      */
      
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week: 'week',
        day: 'day'
      },
        
      events : "<?php echo base_url().'user/calendar_get_events'; ?>",
      editable: false,      //made to false
      droppable: false, // this allows things to be dropped onto the calendar !!!
      
    });


  });
</script>    

