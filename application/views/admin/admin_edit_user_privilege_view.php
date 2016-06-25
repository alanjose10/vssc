 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        
      <h1>
        Edit User Privilege<small>Choose the privileges for the user.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>View User Privileges</li>
        <li class="active">Edit User Privilege</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Name: <?php echo $privilege['name']; ?></h3>
                        <h3 class="box-title pull-right">User ID: <?php echo $privilege['user_id']; ?></h3>
                    </div>
                        <form role="form-horizontal" action="<?php echo base_url().'admin/save_privilege'; ?>" method="post">
                        <div class="box-body no-padding">
                            <table class="table table-hover table-bordered">
                                <tr class="bg-red">
                                    <th>SIV Entry</th>
                                    <th>BOM Entry</th>
                                    <th>BOM Create</th>
                                    <th>Print Excel</th>
                                    <th>Re-screen</th>
                                    <th>Store Officer</th>
                                </tr>
                                <tr>
                                    
                                        <?php
                                            echo "<input type='hidden' name='user_id' value=\"".$privilege['user_id'];
                                            echo "\"/>";
                                            echo "<td>";
                                            switch ($privilege['siv_entry']){
                                                case 1: echo form_checkbox(array(
                                                                        "name" => "siv_entry",
                                                                        "defaultValue" => "yes",
                                                                        "value" => "yes",
                                                                        "checked" => TRUE,
                                                                        "class" => "minimal-red"
                                                                        ));
                                                            break;
                                                case 0: echo form_checkbox(array(
                                                                                "name" => "siv_entry",
                                                                                "defaultValue" => "no",
                                                                                "value" => "yes",
                                                                                "checked" => FALSE,
                                                                                "class" => "minimal-red"
                                                                                )); 
                                                            break;        
                                                }
                                                echo "</td>"; 
                                                echo "<td>";
                                                switch ($privilege['bom_entry']){
                                                    case 1: echo form_checkbox(array(
                                                                            "name" => "bom_entry",
                                                                            "defaultValue" => "yes",
                                                                            "value" => "yes",
                                                                            "checked" => TRUE,
                                                                            "class" => "minimal-red"
                                                                            ));
                                                                break;
                                                    case 0: echo form_checkbox(array(
                                                                                    "name" => "bom_entry",
                                                                                    "defaultValue" => "no",
                                                                                    "value" => "yes",
                                                                                    "checked" => FALSE,
                                                                                    "class" => "minimal-red"
                                                                                    )); 
                                                                break;        
                                                }
                                                echo "</td>"; 
                                                echo "<td>";
                                                switch ($privilege['bom_create']){
                                                    case 1: echo form_checkbox(array(
                                                                            "name" => "bom_create",
                                                                            "defaultValue" => "yes",
                                                                            "value" => "yes",
                                                                            "checked" => TRUE,
                                                                            "class" => "minimal-red"
                                                                            ));
                                                                break;
                                                    case 0: echo form_checkbox(array(
                                                                                    "name" => "bom_create",
                                                                                    "defaultValue" => "no",
                                                                                    "value" => "yes",
                                                                                    "checked" => FALSE,
                                                                                    "class" => "minimal-red"
                                                                                    )); 
                                                                break;        
                                                }
                                                echo "</td>"; 
                                                echo "<td>";
                                                switch ($privilege['print_excel']){
                                                    case 1: echo form_checkbox(array(
                                                                            "name" => "print_excel",
                                                                            "defaultValue" => "yes",
                                                                            "value" => "yes",
                                                                            "checked" => TRUE,
                                                                            "class" => "minimal-red"
                                                                            ));
                                                                break;
                                                    case 0: echo form_checkbox(array(
                                                                                    "name" => "print_excel",
                                                                                    "defaultValue" => "no",
                                                                                    "value" => "yes",
                                                                                    "checked" => FALSE,
                                                                                    "class" => "minimal-red"
                                                                                    )); 
                                                                break;        
                                                }
                                                echo "</td>"; 
                                                echo "<td>";
                                                switch ($privilege['rescreen']){
                                                    case 1: echo form_checkbox(array(
                                                                            "name" => "rescreen",
                                                                            "defaultValue" => "yes",
                                                                            "value" => "yes",
                                                                            "checked" => TRUE,
                                                                            "class" => "minimal-red"
                                                                            ));
                                                                break;
                                                    case 0: echo form_checkbox(array(
                                                                                    "name" => "rescreen",
                                                                                    "defaultValue" => "no",
                                                                                    "value" => "yes",
                                                                                    "checked" => FALSE,
                                                                                    "class" => "minimal-red"
                                                                                    )); 
                                                                break;        
                                                }
                                                echo "</td>"; 
                                                echo "<td>";
                                                switch ($privilege['store_officer']){
                                                    case 1: echo form_checkbox(array(
                                                                            "name" => "store_officer",
                                                                            "defaultValue" => "yes",
                                                                            "value" => "yes",
                                                                            "checked" => TRUE,
                                                                            "class" => "minimal-red"
                                                                            ));
                                                                break;
                                                    case 0: echo form_checkbox(array(
                                                                                    "name" => "store_officer",
                                                                                    "defaultValue" => "no",
                                                                                    "value" => "yes",
                                                                                    "checked" => FALSE,
                                                                                    "class" => "minimal-red"
                                                                                    )); 
                                                                break;        
                                                }
                                                echo "</td>"; 
                                        ?>
                                    
                                    
                                </tr>
   
                            </table>
                        </div>
                            <div class="box-footer">
                                <div class="row">
                                <div class="col-xs-2 col-xs-offset-5">
                                    <button type="submit pull-middle" class="btn btn-default">Save</button>
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
 







