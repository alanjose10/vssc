 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Create New BOM<small>Please enter new BOM details.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Create BOM</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Enter New BOM Details</h3>
                    </div>
                    <?php echo form_open_multipart('user/create_bom_user'); ?>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="bom_name"> BOM Name (Please do not use spaces)</label>
                                <input type="text" class="form-control" id="bom_name" name="bom_name" placeholder="BOM Name:">
                            </div>
                            <div class="form-group">
                                <label class="control-lable" for="grade">BOM Model</label>
                                <select aria-hidden="true" class="form-control select2" name="model_type" style="width: 100%;">
                                <option selected="selected">Choose the model type</option>
                                <option value="EM">Engineering Model</option>
                                <option value="FM">Flight Model</option>
                                </select>
                            </div>  
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">            <!--upload excel!-->
                                <label class="control-lable" for="bom_excel">Select Spreadsheet</label>
                                <input id="bom_excel" name="bom_excel" type="file" class="file-loading" accept="application/msexcel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                                <script>
                                $(document).on('ready', function() {
                                    $("#bom_excel").fileinput({
                                                                browseClass: "btn btn-primary",
                                                                showCaption: false,
                                                                
                                                                });
                                });
                                </script>
                                
                                </div>
                                <a title="Click to download" href="<?php echo base_url(); ?>admin/download_bom_template">
                                <div class="btn btn-primary btn-flat pull-right">
                                    <i class="fa fa-download"></i> Download BOM Template
                                </div>
                                </a>
                            </div>
                        </div>
                            
                         </div>
                        <div class="row">
                            <div class="col-xs-3 col-xs-offset-5">
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-flat btn-primary btn-lg" value="submit">Create</button>
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

