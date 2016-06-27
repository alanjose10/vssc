 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="<?php echo base_url().'admin/messages'; ?>">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Messages</span>
              <span class="info-box-number"><?php echo $message; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
            </a>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="<?php echo base_url().'admin/calendar'; ?>">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-calendar"></i></span>
              
            <div class="info-box-content">
              <span class="info-box-text">Calendar Events</span>
              <span class="info-box-number"><?php echo $no_of_calendar_events; ?></span>
            </div>
              
            <!-- /.info-box-content -->
          </div>
            </a>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-black"><i class="fa fa-gears"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">To Expiry Soon-</span>
                <span class="info-box-text">Engineering Grade</span>
              <span class="info-box-number"><?php echo $no_of_eg_to_expire; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-gears"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">To Expiry Soon-</span>
                <span class="info-box-text">Flight Grade</span>
              <span class="info-box-number"><?php echo $no_of_fg_to_expire; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
        
        <div class="row">       
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $pending_approval_siv_no; ?></h3>

              <p>SIVs - PENDING APPROVAL</p>
            </div>
            <div class="icon">
              <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="<?php echo base_url().'admin/view_siv_list/PENDING_APPROVAL'; ?>" class="small-box-footer">
              View SIVs <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $approved_siv_no; ?></h3>

              <p>SIVs - APPROVED</p>
            </div>
            <div class="icon">
              <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="<?php echo base_url().'admin/view_siv_list/APPROVED'; ?>" class="small-box-footer">
              View SIVs <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $rejected_siv_no; ?></h3>

              <p>SIVs - REJECTED</p>
            </div>
            <div class="icon">
              <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="<?php echo base_url().'admin/view_siv_list/REJECTED'; ?>" class="small-box-footer">
               View SIVs <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        
        <!-- ./col -->
      </div>
 
    <div class="row">       <!--boms-->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $pending_approval_bom_no; ?></h3>

              <p>BOMs - PENDING APPROVAL</p>
            </div>
            <div class="icon">
              <i class="fa fa-file-text-o"></i>
            </div>
            <a href="<?php echo base_url().'admin/view_assembled_bom_list_by_type/PENDING_APPROVAL'; ?>" class="small-box-footer">
              View BOMs <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $approved_bom_no; ?></h3>

              <p>BOMs - APPROVED</p>
            </div>
            <div class="icon">
              <i class="fa fa-file-text-o"></i>
            </div>
            <a href="<?php echo base_url().'admin/view_assembled_bom_list_by_type/APPROVED'; ?>" class="small-box-footer">
              View BOMs <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $rejected_bom_no; ?></h3>

              <p>BOMs - REJECTED</p>
            </div>
            <div class="icon">
              <i class="fa fa-file-text-o"></i>
            </div>
            <a href="<?php echo base_url().'admin/view_assembled_bom_list_by_type/REJECTED'; ?>" class="small-box-footer">
               View BOMs <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        
        <!-- ./col -->
      </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
