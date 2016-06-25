 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        
      <h1>
        Add Component Details<small>Please enter details of the components in SIV.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Add SIV details</a></li>
        <li class="active">Add component details</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="small-box bg-blue">
                <div class="inner">
                    <div class="row">
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>SIV NO:</h4></span>
                            <span class="info-box-number"><?php echo $siv_data['siv_no']; ?></span>
                        </div>
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>SIV Grade:</h4></span>
                            <span class="info-box-number"><?php echo $siv_data['siv_grade']; ?></span>
                        </div>
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>Date Of Issue:</h4></span> 
                            <span class="info-box-number"><?php echo $siv_data['date_of_issue']; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>No Of Components:</h4></span>
                            <span class="info-box-number"><?php echo $siv_data['no_of_components']; ?></span>
                        </div>
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>Entered By:</h4></span> 
                            <span class="info-box-number"><?php echo $siv_data['entered_by']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="icon">
                  <i class="fa fa-shopping-cart"></i>
                </div>
              </div>       
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
            
            </div>
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Enter Components of SIV</h3>
                    </div>
                <form class="form" role="form" method="post" action="<?php echo base_url().'user/new_siv_components'; ?>"/>
                    <div class="box-body">
                        <input type='hidden' name='siv_no' value="<?php echo $siv_data['siv_no']; ?>"/>
                        <input type='hidden' name='siv_grade' value="<?php echo $siv_data['siv_grade']; ?>"/>
                        <input type='hidden' name='date_of_issue' value="<?php echo $siv_data['date_of_issue']; ?>"/>
                        <input type='hidden' name='no_of_components' value="<?php echo $siv_data['no_of_components']; ?>"/>
                        <input type='hidden' name='entered_by' value="<?php echo $siv_data['entered_by']; ?>"/>
                       <?php
                        //echo $no_of_components;
                        for($i = 0; $i < $siv_data['no_of_components']; $i++){
                            echo "<div class=\"row\">";
                            echo "<div class=\"col-xs-3\">";
                            echo "<div class=\"form-group\">";
                            echo "<lable for=\"component_type\">Component Type:\n"; 
                            echo "<input type=\"text\" name=\"component_type[]\" class=\"form-control\" list=\"component_type\">\n";
                            echo "<datalist id=\"component_type\">\n"; 
                            foreach($types as $row)   {
                                echo "<option value=\"".$row['component_type']."\">\n"; 
                            }
                            echo "</datalist>\n";
                            echo "</lable>\n";
                            echo "</div>";
                            echo "</div>";
                
                            echo "<div class=\"col-xs-3\">";
                            echo "<div class=\"form-group\">";
                            echo "<lable for=\"component_name\">Component Name:\n"; 
                            echo "<input type=\"text\" name=\"component_name[]\" class=\"form-control\" list=\"component_name\">\n";
                            echo "<datalist id=\"component_name\">\n"; 
                            foreach($components as $row)   {
                                echo "<option value=\"".$row['component_name']."\">\n"; 
                            }                       
                            echo "</datalist>\n";
                            echo "</lable>\n";
                            echo "</div>";
                            echo "</div>";
                            
                            echo "<div class=\"col-xs-3\">";
                            echo "<div class=\"form-group\">";
                            echo "<lable for=\"date_of_expiry\">Date Of Expiry:\n"; 
                            echo "<div class=\"input-group\">";
                            echo "<div class=\"input-group-addon\">";
                            echo "<i class=\"fa fa-calendar\"></i>";
                            echo "</div>";
                            echo form_input(array(
                                                "type" => "text",
                                                "class" => "form-control",
                                                "id" => "date_of_expiry",
                                                "name" => "date_of_expiry[]",
                                                "data-inputmask"=> "'alias': 'dd/mm/yyyy'",
                                                "data-mask"=> ""
                                                ));
                            echo "</div>";
                            echo "</lable>\n";
                            echo "</div>";
                            echo "</div>";
                            
                            echo "<div class=\"col-xs-3\">";
                            echo "<div class=\"form-group\">";
                            echo "<lable for=\"component_quantity\">Component Quantity:\n"; 
                            echo form_input(array(
                                                "type" => "number",
                                                "class" => "form-control",
                                                "id" => "component_quantity",
                                                "name" => "component_quantity[]",
                                                "placeholder" => "Enter quantity:"
                                                ));
                            echo "</lable>\n";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            
                            
                        }

                       

                        
                        
                       ?>
                      </div> 
                        
                    
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-xs-2 col-xs-offset-5">
                                    <button type="submit" class="btn btn-flat bg-blue btn-lg" name="submit" value="submit">Add SIV</button>
                                    <br>
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
