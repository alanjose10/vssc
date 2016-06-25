 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add New SIV<small>Please enter new SIV details.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Add SIV details</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Enter New SIV Details</h3>
                    </div>
                    <form role="form-horizontal" method="post" action="<?php echo base_url().'user/new_siv'; ?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="siv_no"> SIV Number</label>
                                <input type="number" class="form-control" id="siv_no" name="siv_no"  placeholder="Enter SIV No:">
                            </div>
                            <div class="form-group">
                                <label class="control-lable" for="siv_grade">SIV Components Grade</label>
                                <select aria-hidden="true" class="form-control select2" id="siv_grade" name="siv_grade" style="width: 100%;">
                                <option selected="selected">Choose the grade</option>
                                <option value="EM">Engineering Grade</option>
                                <option value="FM">Flight Grade</option>
                                </select>
                            </div>
                            <div class="form-group">
                            <label>Date Of Issue:</label>

                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" class="form-control" id="date_of_issue" name="date_of_issue" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                            </div>
                            </div>
                            <div class="form-group">
                                <label for="no_comp"> Number Of Components</label>
                                <input type="number" class="form-control" id="no_of_components" name="no_of_components" placeholder="Enter No. of Components">
                            </div>
                         </div>
                        <div class="row">
                            <div class="col-xs-2 col-xs-offset-5">
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-flat bg-blue btn-lg" name="submit" value="submit">Next<i class="glyphicon glyphicon-triangle-right"></i></button>
                                    <br><p>
                                   
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
