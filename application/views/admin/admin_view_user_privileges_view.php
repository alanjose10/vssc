 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        
      <h1>
        Edit User Privileges<small>Click edit to change the privileges.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>View User Privileges</li>
        
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">User Privileges</h3>
                    </div>
                        <div class="box-body no-padding">
                            <table class="table table-hover table-bordered">
                                <tr class="bg-red">
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>SIV Entry</th>
                                    <th>BOM Entry</th>
                                    <th>BOM Create</th>
                                    <th>Print Excel</th>
                                    <th>Re-screen</th>
                                    <th>Store Officer</th>
                                    <th>Edit</th>
                                </tr>
                                <?php
                                $i = 0;
                                
                                foreach($user_privileges as $row){
                                    
                                    echo form_open('admin/view_user_privileges', array(
                                                                                        "method" => 'post',
                                                                                        "class" =>'form-horizontal'
                                                                                        ));
                                    echo "<tr>";
                                    echo "<td>".$row["user_id"]."</td>";
                                    echo "<td>".$row["name"]."</td>";
                                    //echo "<td>";
                                    echo "<input type='hidden' name='user_id' value=\"".$row["user_id"]."\"/>";
                                    //echo "</td>";
                                   // echo "<td>";
                                    echo "<input type='hidden' name='name' value=\"".$row["name"]."\"/>";
                                    //echo "</td>";
                                    echo "<td>";
                                    switch ($row["siv_entry"]) {
                                        case 1: echo form_checkbox(array(
                                                                        "disabled" =>"",
                                                                        "name" => "siv_entry",
                                                                        "defaultValue" => "yes",
                                                                        "value" => "yes",
                                                                        "checked" => TRUE,
                                                                        "class" => "minimal-red"
                                                                        ));
                                                    break;
                                        case 0: echo form_checkbox(array(
                                                                        "disabled" =>"",
                                                                        "name" => "siv_entry",
                                                                        "defaultValue" => "no",
                                                                        "value" => "yes",
                                                                        "checked" => FALSE
                                                                        )); 
                                                    break;
                                    }
                                    //if(!isset(siv_entry[$i])){
                                    //    siv_entry[$i] = 0;
                                   // }
                                    echo "</td>";
                                    echo "<td>";
                                    switch ($row["bom_entry"]) {
                                        case 1: echo form_checkbox(array("disabled" =>"",
                                                                        "name" => "bom_entry",
                                                                        "defaultValue" => "yes",
                                                                        "value" => "yes",
                                                                        "checked" => TRUE,
                                                                         "class" => "minimal-red"
                                                                        )); 
                                                    break;
                                        case 0: echo form_checkbox(array("disabled" =>"",
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
                                    switch ($row["bom_create"]) {
                                        case 1: echo form_checkbox(array("disabled" =>"",
                                                                        "name" => "bom_create",
                                                                        "defaultValue" => "yes",
                                                                        "value" => "yes",
                                                                        "checked" => TRUE,
                                                                         "class" => "minimal-red"
                                                                        ));
                                                    break;
                                        case 0: echo form_checkbox(array("disabled" =>"",
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
                                    switch ($row["print_excel"]) {
                                        case 1: echo form_checkbox(array("disabled" =>"",
                                                                        "name" => "print_excel",
                                                                        "defaultValue" => "yes",
                                                                        "value" => "yes",
                                                                        "checked" => TRUE,
                                                                         "class" => "minimal-red"
                                                                        ));
                                                    break;
                                        case 0: echo form_checkbox(array("disabled" =>"",
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
                                    switch ($row["rescreen"]) {
                                        case 1: echo form_checkbox(array("disabled" =>"",
                                                                        "name" => "rescreen",
                                                                        "defaultValue" => "yes",
                                                                        "value" => "yes",
                                                                        "checked" => TRUE,
                                                                         "class" => "minimal-red"
                                                                        )); 
                                                    break;
                                        case 0: echo form_checkbox(array("disabled" =>"",
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
                                    switch ($row["store_officer"]) {
                                        case 1: echo form_checkbox(array("disabled" =>"",
                                                                        "name" => "store_officer",
                                                                        "defaultValue" => "yes",
                                                                        "value" => "yes",
                                                                        "checked" => TRUE,
                                                                         "class" => "minimal-red"
                                                                        )); 
                                                    break;
                                        case 0: echo form_checkbox(array("disabled" =>"",
                                                                        "name" => "store_officer",
                                                                        "defaultValue" => "no",
                                                                        "value" => "yes",
                                                                        "checked" => FALSE,
                                                                         "class" => "minimal-red"
                                                                        )); 
                                                    break;
                                    }
                                    echo "</td>";
                                    echo "<td>";
                                    echo form_submit(array(
                                                            "type" => 'submit',
                                                            "name" => 'submit',
                                                            "value" => "Edit"
                                                            ));
                                    echo "</td>";
                                    echo form_close();
                                    echo "</tr>";
                                    
                                }
                                
                                
                                
                                ?>
                                
                            </table>
                    </div>
                    
                </div>
            </div> 
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 







