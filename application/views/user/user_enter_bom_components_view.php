<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        BOM Entry
        
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Dashboard</li>
        <li>Choose BOM</li>
        <li class="active">Enter Components</li>
      </ol>
    </section>
    <div class="pad margin row no-print">
            <div class="col-xs-12">
                <div class="small-box bg-blue">
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
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <form role="form-horizontal" method="post" action="<?php echo base_url().'user/store_entered_bom'; ?>">
                <input type='hidden' name='bom_name' value="<?php echo $bom_details['bom_name']; ?>"/>
                <input type='hidden' name='model_grade' value="<?php echo $bom_details['model_type']; ?>"/>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Enter BOM Details</h3>
                    </div>
                    
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                    <label for="siv_no"> Model Number</label>
                                    <input type="number" class="form-control" id="bom_model_no" name="bom_model_no"  placeholder="Enter Model No.">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                    <label>Date Of Entry:</label>
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                      </div>
                                      <input type="text" class="form-control" id="date_of_assembly" name="date_of_assembly" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                         </div>
                        
                    
                </div>
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 table-responsive">
                                <table class="table table-hover table-bordered table-striped">
                                    <thead>
                                    <tr>
                                      <th>Component No.</th>
                                      <th>Component Type</th>
                                      <th>Component Name</th>
                                      
                                      <th>Required Quantity</th>
                                    </tr>
                                    </thead>
                                    <?php
                                        echo "<tbody>";
                                    //print_r($components);
                                        $i=1;
                                    foreach($components as $row){
                                        echo "<tr>";
                                        echo "<td>".$i++."</td>";
                                        echo "<td>".$row['component_type']."</td>";
                                        echo form_hidden('component_type[]', $row['component_type']);
                                        echo "<td>".$row['component_name']."</td>";
                                        echo form_hidden('component_name[]',$row['component_name']);
                                        echo "<td>";
                                        echo "<div class=\"form-group\">";
                                        echo form_input(array(
                                                            "type" => "number",
                                                            "class" => "form-control",
                                                            "id" => "required_quantity",
                                                            "name" => "required_quantity[]",
                                                            "placeholder" => $row['component_quantity'],
                                                            "value" => $row['component_quantity'],
                                                            "max" => $row['component_quantity'],
                                                            "min" => 0
                                                            ));
                                        echo "</div>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                    echo form_hidden('no_of_components', $i-1);
                                    ?>
                                </table>
                            </div>
                        
                        </div>
                    </div>
                    
                    <div class="row">
                            <div class="col-xs-2 col-xs-offset-5">
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-flat bg-blue btn-lg" name="submit" value="submit">Submit<i class="glyphicon glyphicon-triangle-right"></i></button>
                                    <br><p>
                                   
                                    </p>
                                </div>
                            </div>
                        </div>
                </div>
            </form>
            </div> 
        </div>
        

    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
  </div>