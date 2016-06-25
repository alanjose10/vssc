<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        BOM Entry
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Examples</a></li>
        <li>Bom List</li>
        <li class="active">Enter BOM</li>
      </ol>
    </section>
    <div class="pad margin row no-print">
            <div class="col-xs-12">
                <div class="small-box bg-green">
                <div class="inner">
                    <div class="row">
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>BOM NO:</h4></span>
                            <span class="info-box-number"><?php echo $bom_details['bom_no']; ?></span>
                        </div>
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>BOM Name:</h4></span>
                            <span class="info-box-number"><?php echo $bom_details['bom_name']; ?></span>
                        </div>
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>Model Grade:</h4></span> 
                            <span class="info-box-number"><?php echo $bom_details['model_type']; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>Uploaded By:</h4></span>
                            <span class="info-box-number"><?php echo $bom_details['created_by']; ?></span>
                        </div>
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>Uploaded Date:</h4></span> 
                            <span class="info-box-number"><?php echo $bom_details['date_of_creation']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="icon">
                  <i class="fa fa-file-text-o"></i>
                </div>
              </div>       
            </div>
    </div>
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
        <div class="pad margin row invoice-info">
            <h4 class="page-header">
                  <div class="row">

                        <div class="col-xs-6">
                            BOM Name: <?php echo $bom_details['bom_name']; ?>
                        </div>
                        <div class="col-xs-6">
                           BOM No: <?php echo $bom_details['bom_no']; ?>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-xs-6">
                           Created By: <?php echo $bom_details['created_by']; ?>
                        </div>
                        <div class="col-xs-6">
                            Created On: <?php echo $bom_details['date_of_creation']; ?>
                        </div><br>

                    <!-- /.col -->
                  </div>
            </h4>
        </div>
        <form role="form-inline" method="post" action="<?php echo base_url().'user/store_new_bom'; ?>">
      <!-- info row -->
      <div class="row">
        <div class="col-xs-3 col-xs-offset-4">

        <div class="form-group">
                                <label for="date_assemble"> Date of Assembling</label>
                                <input type="date" class="form-control" id="siv_no" name="date_assemble"  placeholder="Enter Date of Assembling">
                            </div>
                          </div>
                        </div>
       
        
      
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Component No.</th>
              <th>Component Type</th>
              <th>Component Name</th>
              <th>Quantity Assembled</th>
             
            </tr>
            </thead>
            <tbody>
             

              
                 <?php $bom_entry_num='1';?>
              
             <?php foreach($component_details as $row): ?>
                <tr>
                <input type='hidden' name='component_type[]' value="<?php echo $row['component_type']; ?>"/> 
                <input type='hidden' name='component_name[]' value="<?php echo $row['component_name']; ?>"/>
                <td><?php echo $row['component_id'] ?></td>
                <td><?php echo $row['component_type'] ?></td>
                <td><?php echo $row['component_name'] ?></td>
                <td><input type="number" name='quantity[]' id="quantity" ></td>

                 
                
                
                    <?php $bom_entry_num=$bom_entry_num+1; ?>


                    </tr>
                     <?php endforeach; ?>   
                     <input type='hidden' name='bom_entry_num' value="<?php echo $bom_entry_num; ?>"/>
                     <input type='hidden' name='bom_name' value="<?php echo $bom_details['bom_name']; ?>"/>
                

 </table>

                      <div class="box-footer">
                            <div class="row">
                                <div class="col-xs-2 col-xs-offset-5">
                                    <button type="submit" class="btn btn-flat bg-blue btn-lg" name="submit" value="submit">Submit</button>
                                    <br>
                                </div>
                            </div>
                        </div>
            
            </form>
            </tbody>
         
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
     
    <!-- /.content -->
    <div class="clearfix"></div>
  </div>