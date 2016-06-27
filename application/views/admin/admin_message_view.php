<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard </a></li>
        <li class="active">Messages</li>
      </ol>
      <br>
    </section>
    <!-- Main content -->
    <section class="content">
            <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-danger ">
                            <div class="panel-heading bg-purple">
                                <div class="row">
                                    <div class="col-xs-5 col-xs-offset-4">
                                    <h1>Messages</h1>
                                    </div>    
                                    <div class="col-xs-3">
                                        <form role="form-horizontal" action="<?php echo base_url().'admin/message'; ?>" method="post">
                                            <div class="box-footer">
                                               <div class="input-group">
                                                    <select class="form-control select2" id="receiver_name" name="receiver_name" style="width: 100%;"  >
                                                        <option selected="selected" value="">ENTER USER TO PING..</option>   
                                                        <?php
                                                            foreach($user_names as $row)   {
                                                            echo "<option value=\"".$row['user_name']."\">".$row['user_name']."</option>\n"; 
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="input-group-btn">
                                                        <button type="submit" class="btn btn-info"><i class="fa fa-hand-o-up"></i></button>
                                                    </div>
                                                </div>        
                                            </div>
                                        </form>      
                                    </div>
                                </div> 
                            </div>  
                            <div class="row">
                                <div class="col-xs-10">
                                    <div class="panel-body transparent">
                                      <div class="col-xs-12">
                                          <div class="row">
                                              <div class="box-body">
                                                  <div class="form-group">
                                                      <div id="compose-textarea" class="form-control"  style="overflow: scroll; height: 500px" >
                                                          <?php
                                                            foreach($message_details as $row)   {
                                                                
                                                            print "<div class=\"col-xs-1 \">\n";
                                                            print "<div class=\"nonborderbox\">\n";
                                                            print "<div class=\"box-body\">\n";
                                                            print "<div class=\"col-xs-12 \"> \n";
                                                            print "<p bg-red>\n";
                                                            
                                                                    echo "<option value=\"".$row['sender_name']."\">".$row['sender_name'].":"."</option>\n"; 
                                                                
                                                            print "</p>\n";
                                                            print "</div>\n";
                                                            print "</div>\n";
                                                            print "</div>\n";
                                                            print "</div>\n";
                                                            print "\n";
                                                                
                                                            print "<div class=\"col-xs-8 \">\n";
                                                            print "<div class=\"nonborderbox\">\n";
                                                            print "<div class=\"box-body \">\n";
                                                            print "<div class=\"col-xs-12 \"> \n";
                                                            
                                                            print "<p style = \"overflow: hidden; white-space: nowrap; text-overflow: ellipsis;\">\n";
                                                                //print "<p>\n";
                                                                    echo "<option value=\"".$row['message']."\">".$row['message']."</option>\n"; 
                                                                
                                                            print "</p>\n";
                                                            print "</div>\n";
                                                            print "</div>\n";
                                                            print "</div>\n";
                                                            print "</div>\n";
                                                            print "\n";
                                                          
                                                            print "<div class=\"col-xs-1 \">\n";
                                                            print "<div class=\"nonborderbox\">\n";
                                                            print "<div class=\"box-body \">\n";
                                                            print "<div class=\"col-xs-12 \">    \n";
                                                            print "<p>\n";
                                                            
                                                            echo "<option value=\"".$row['time']."\">".$row['time']."</option>\n"; 
                                                                
                                                            print "</p>\n";
                                                            print "</div>\n";
                                                            print "</div>\n";
                                                            print "</div>\n";
                                                            print "</div>";
                                                            
                                                            print "<div class=\"col-xs-1 \">\n";
                                                            print "<div class=\"nonborderbox\">\n";
                                                            print "<div class=\"box-body \">\n";
                                                            print "<div class=\"col-xs-12 \">    \n";
                                                            print "<p>\n";
                                                            
                                                            echo "<option value=\"".$row['date']."\">".$row['date']."</option>\n"; 
                                                                
                                                            print "</p>\n";
                                                            print "</div>\n";
                                                            print "</div>\n";
                                                            print "</div>\n";
                                                            print "</div>";    
                                                                
                                                            print "<div class=\"col-xs-1 \">\n";
                                                            print "<div class=\"nonborderbox\">\n";
                                                            print "<div class=\"box-body \">\n";
                                                            print "<div class=\"col-xs-12 \">    \n";
                                                            //print "<p>\n";
                                                            //echo "<option value=\"".$row['status']."\">".$row['status']."</option>\n";             
                                                            //print "</p>\n";
                                                            //print "<div class=\"input-group-btn \">\n";    
                                                            //print "<button type=\"button\" class=\"btn btn-info\">\n";
                                                            //print "<i class=\"fa fa-hand-o-up\">\n";
                                                            //print "</i>\n";
                                                            //print "</button>\n";
                                                            //print "</div>\n";
                                                            if($row['status']=="unseen") {    
                                                            print "<div class=\"input-group-btn\">\n";
                                                            print "<button type=\"button\" class=\"btn btn-info \" ><i class=\"fa fa-circle-o\" ></i></button>\n";
                                                            print "</div>";    
                                                            } 
                                                            else {
                                                            print "<div class=\"input-group-btn\">\n";
                                                            print "<button type=\"button\" class=\"btn btn-info bg-green\"><i class=\"fa fa-check\"></i></button>\n";
                                                            print "</div>";
                                                            } 
                                                            print "</div>\n";
                                                            print "</div>\n";
                                                            print "</div>\n";
                                                            print "</div>";
                                                          }
                                                          ?>
                                                      </div>  
                                                  </div>
                                                </div>
                                          </div>
                                       </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <form role="form-horizontal" action="<?php echo base_url().'admin/add_message'; ?>" method="post">
                                                <div class="box-footer">
                                                  <input type='hidden' name='receiver_name' value="<?php if(isset($receiver_name)){echo $receiver_name; }?>"/>
                                                  <div class="input-group">
                                                    <input name="message" id="message" class="form-control" placeholder="Type message (max.110 letters) ..." autofocus>
                                                    <div class="input-group-btn">
                                                      <button type="submit" class="btn btn-success"><i class="fa fa-envelope-o"></i></button>
                                                    </div>
                                                  </div>
                                                </div>
                                            </form>      
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-2 ">
                            <div class="panel-body transparent">
                                <?php
                                foreach($user_names as $row)   {
                                                                
                                                print "<div class=\"row\">\n";
                                                print "<a href=\"".base_url()."admin/message/".$row['user_name']."\">";
                                                print "<div class=\"box\">\n";
                                                print "<div class=\"box-header with-border\">\n";
                                                print "<div class=\"col-xs-4\">\n";
                                                print "<div class=\"image\">\n";
                                                print "<img src=\"".base_url()."assets/dist/img/".$row['user_name'].".jpg\" class=\"img-circle\" alt=\"User Image\" style=\"height: 80px\">\n";
                                                
                                                print "</div>\n";
                                                print "</div>\n";
                                                print "<div class=\"col-xs-8  \">\n";
                                                print "<div class=\"nonborderbox\">\n";
                                                print "<div class=\"box-body \">\n";
                                                print "<div class=\"col-xs-12 \">    \n";
                                                print "<p class=\"text-center\" style=\"color:purple;\">\n";
                                                    echo "<option value=\"".$row['user_name']."\">".$row['name']."</option>\n"; 
                                                print "</p>\n";
                                                print "</div>\n";
                                                print "</div>\n";
                                                print "</div>\n";
                                                print "</div>\n";
                                                print "</div>\n";
                                                print "</div>\n";
                                                print "</a>\n";
                                                print "</div>";
                                            }
                                ?>
                            </div>
                            </div>
                        </div>  
                    </div>
                </div>  
            </div>    
            <!-- /.row -->
    </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
 
 