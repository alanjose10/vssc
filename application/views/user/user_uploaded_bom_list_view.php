 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        BOM List
        <small>List of uploaded BOMs.</small>
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Dashboard</li>
        <li class="active">BOM List</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
            
        <?php
            //print_r($uploaded_boms);
            foreach($uploaded_boms as $row){
                echo "<div class=\"row\">";
                echo "<div class=\"col-xs-12\">";
                echo "<div class=\"small-box bg-blue\">";
                echo "<div class=\"inner\">";
                echo "<div class=\"row\">";
                echo "<div class=\"col-xs-4\">";
                echo "<span class=\"info-box-text\"><h4>BOM NO:</h4></span>";
                echo "<span class=\"info-box-number\">".$row['bom_no']."</span>";
                echo "</div>";
                echo "<div class=\"col-xs-4\">";
                echo "<span class=\"info-box-text\"><h4>BOM Name:</h4></span>";
                echo "<span class=\"info-box-number\">".$row['bom_name']."</span>";
                echo "</div>";
                echo "<div class=\"col-xs-4\">";
                echo "<span class=\"info-box-text\"><h4>Model Grade:</h4></span> ";
                echo "<span class=\"info-box-number\">".$row['model_type']."</span>";
                echo "</div>";
                echo "</div>";
                echo "<div class=\"row\">";
                echo "<div class=\"col-xs-4\">";
                echo "<span class=\"info-box-text\"><h4>Uploaded By:</h4></span>";
                echo "<span class=\"info-box-number\">".$row['created_by']."</span>";
                echo "</div>";
                echo "<div class=\"col-xs-4\">";
                echo "<span class=\"info-box-text\"><h4>Uploaded On:</h4></span> ";
                echo "<span class=\"info-box-number\">".$row['date_of_creation']."</span>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "<div class=\"icon\">";
                echo "<i class=\"fa fa-file-text-o\"></i>";
                echo "</div>";
                echo "<a href=\"".base_url()."user/view_full_bom/".$row['bom_no']."\" class=\"small-box-footer\">";
                echo "View BOM <i class=\"fa fa-arrow-circle-right\"></i>";
                echo "</a>";
                echo " </div>  ";
                echo "</div>";
                echo "</div>";
                
            }
        
        
        ?>        
        
<!--
        <div class="row">
            <div class="col-xs-12">
                <div class="small-box bg-red">
                <div class="inner">
                    <div class="row">
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>BOM ID:</h4></span>
                            <span class="info-box-number">7896</span>
                        </div>
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>BOM Name:</h4></span>
                            <span class="info-box-number">Chace-2</span>
                        </div>
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>Model Grade:</h4></span> 
                            <span class="info-box-number">Engineering Model</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>Uploaded By:</h4></span>
                            <span class="info-box-number"> Athil K Abbas</span>
                        </div>
                        <div class="col-xs-4">
                            <span class="info-box-text"><h4>Uploaded Date:</h4></span> 
                            <span class="info-box-number">04/10/2014</span>
                        </div>
                    </div>
                </div>
                <div class="icon">
                  <i class="fa fa-file-text-o"></i>
                </div>
                <a href="#" class="small-box-footer">
                  View BOM <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>       
            </div>
        </div>

      -->
      
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
