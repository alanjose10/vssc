 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        View All Uploads
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Dashboard</li>
        <li class="active">View All Uploads</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">

        <div class="row">
            <?php
            
            foreach($uploads as $file){
                
                echo "<div class=\"col-md-4 col-sm-8 col-xs-12\">";
                echo "<div class=\"box-info info-box bg-aqua\">";
                echo "<a href=\"".base_url()."admin/view_all_uploads/".$file."\">";
                echo "<div class=\"box-tools pull-right\">";
                echo "<button type=\"button\" class=\"btn btn-box-tool\" ><i class=\"fa fa-times\"></i></button>";
                echo "</div>";
                echo "</a>";
                echo "<span class=\"info-box-icon\"><i class=\"fa fa-file-excel-o\"></i></span>";
                echo "<div class=\"info-box-content\">";
                echo "<span class=\"info-box-text\">".$file."</span>";
                echo "</div>";
                echo "</div>";
                echo "</div>";

            }
            ?>
  
                  

        </div>
      
        
      
      
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
