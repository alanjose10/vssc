<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    
    function __construct() {
    parent::__construct();
        $this->page_data = array();
        $this->load->model("model_admin");
    }
    
    
    public function index(){
            redirect("admin/login");
    }
    
    public function login() {
        if(($this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
           redirect('admin/dashboard');
        }
        else{
            $this->load->view('login');
        }
    }
    
    public function login_validation(){
        if(($this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
            redirect('admin/dashboard');
        }
        
        if($this->input->post()){
                //$this->load->library('form_validation');
                $this->form_validation->set_rules('username', 'Username', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required'); 
                if($this->form_validation->run() == FALSE){
                    $this->load->view("login");
                }
                else{
                    if($this->model_admin->login()){
                        redirect('admin/dashboard');
                    }
                    else{
                        $data = array(
                            'err_msg' => "Incorrect Username or Password"
                        );
                        $this->load->view('login',$data);
                    }
                }
            }
    }
    
    public function logout(){
        //$userdata = $this->session->all_userdata();
        //print_r($userdata);
        $this->model_admin->update_userdata();
        $this->session->sess_destroy();
        redirect("admin/login");
    }
    
    /*
    public function get_session_details() {         //to get admin session data
        $this->page_data["ses_user_id"] = $this->session->userdata('user_id');
        $this->page_data["ses_user_name"] = $this->session->userdata('user_name');
        $this->page_data["ses_name"] = $this->session->userdata('name');
        $this->page_data["last_active_date"] = $this->session->userdata('last_active_date');
        $this->page_data["last_active_time"] = $this->session->userdata('last_active_time');
    }
    */
    
    public function print_error($message){
        $this->page_data["err_msg"] = $message;
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('fail_alert_view',$this->page_data,TRUE);
        $notification_details = $this->model_admin->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;         $message_count = $this->model_admin->get_message_count();         $this->page_data['message_count'] = $message_count;         $this->load->view('admin/admin_main_view',$this->page_data);
    }
    
    public function print_success($message){
        $this->page_data["err_msg"] = $message;
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('success_alert_view',$this->page_data,TRUE);
        $notification_details = $this->model_admin->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;         $message_count = $this->model_admin->get_message_count();         $this->page_data['message_count'] = $message_count;         $this->load->view('admin/admin_main_view',$this->page_data);
    }
    
    public function dashboard() {
        $this->page_data["message"] = $this->model_admin->get_message_count();
        $this->page_data["pending_approval_siv_no"] = $this->model_admin->get_no_of_siv('PENDING_APPROVAL');
        $this->page_data["approved_siv_no"] = $this->model_admin->get_no_of_siv('APPROVED');
        $this->page_data["rejected_siv_no"] = $this->model_admin->get_no_of_siv('REJECTED');
        $this->page_data["pending_approval_bom_no"] = $this->model_admin->get_no_of_bom('PENDING_APPROVAL');
        $this->page_data["approved_bom_no"] = $this->model_admin->get_no_of_bom('APPROVED');
        $this->page_data["rejected_bom_no"] = $this->model_admin->get_no_of_bom('REJECTED');
        $this->page_data["no_of_uploaded_boms"] = $this->model_admin->get_no_of_uploaded_bom();
        $this->page_data["no_of_calendar_events"] = $this->model_admin->get_no_of_calendar_events();
        $this->page_data["no_of_eg_to_expire"] = $this->model_admin->get_no_of_components_to_expire_in_3('em');
        $this->page_data["no_of_fg_to_expire"] = $this->model_admin->get_no_of_components_to_expire_in_3('fm');
        
        if(($this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
            //$this->get_session_details();
            if(isset($this->page_data['page_content'])){
                unset($this->page_data['page_content']);
            }
            $this->page_data["page_content"] = $this->load->view('admin/admin_dashboard_view',$this->page_data,TRUE);
            $notification_details = $this->model_admin->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;         $message_count = $this->model_admin->get_message_count();         $this->page_data['message_count'] = $message_count;         $this->load->view('admin/admin_main_view',$this->page_data);
            //print_r($this->page_data);           
        }
        else{
            redirect("admin/login");
        }
    }
    public function view_users() {
        //$this->get_session_details();
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["view_users"] = $this->model_admin->get_users('user');
        //print_r($this->page_data["view_users"]);
        $this->page_data["page_content"] = $this->load->view('admin/admin_view_users_view.php',$this->page_data,TRUE);
        $notification_details = $this->model_admin->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;         $message_count = $this->model_admin->get_message_count();         $this->page_data['message_count'] = $message_count;         $this->load->view('admin/admin_main_view',$this->page_data);
    }
    
    public function add_user() {
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        if($this->input->post()){
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email_id', 'Email ID', 'required');
            $this->form_validation->set_rules('password_1', 'Password', 'required');
            $this->form_validation->set_rules('password_2', 'Password', 'required');
            if($this->form_validation->run() == FALSE){                 //load the view again
                    //$this->get_session_details();
                    $this->print_error("Error! All fields are required. Please try again.");
                    
                }
                else{
                    if($this->input->post('password_1') != $this->input->post('password_2')){
                        //$this->get_session_details();
                        $this->print_error("Error! Passwords do not match. Please try again.");
                    }
                    else {
                        if($this->model_admin->add_user('user')){
                           // $this->get_session_details();
                            //$this->print_success("User successfully added.");
                            redirect('admin/print_success/User_successfully_added.');
                            
                            //added successfully
                        }
                        else {
                            //$this->get_session_details();
                            //$this->print_error("Error while adding the user! Please try again.");
                            redirect('admin/print_error/Error_while_adding_the_user!_Please_try_again.');
                        }
                    }
                } 
            }
        else {
            //$this->get_session_details();
            if(isset($this->page_data['page_content'])){
                unset($this->page_data['page_content']);
            }
            $this->page_data["page_content"] = $this->load->view('admin/admin_add_user_view.php',$this->page_data,TRUE);
            $notification_details = $this->model_admin->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;         $message_count = $this->model_admin->get_message_count();         $this->page_data['message_count'] = $message_count;         $this->load->view('admin/admin_main_view',$this->page_data);
        }
    }
    
    public function remove_user($user_id){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        if($this->model_admin->remove_user($user_id)){
            //$this->print_success("User Removed Successfully.");
            redirect('admin/print_success/User_Removed_Successfully.');
        }
        else{
            //$this->print_error("Error!. Failed to Remove User.");
            redirect('admin/print_error/Error!._Failed_to_Remove User.');
        }
    }
    
    public function view_user_privileges() {
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        if($this->input->post()){
            //print($this->input->post('user_id'));
            $privileges = $this->model_admin->get_privilege($this->input->post('user_id'));
            //print_r($privileges);
            $this->page_data['privilege'] = $privileges;
            //$this->get_session_details();
            if(isset($this->page_data['page_content'])){
                unset($this->page_data['page_content']);
            }
            $this->page_data["page_content"] = $this->load->view('admin/admin_edit_user_privilege_view',$this->page_data,TRUE);
            $notification_details = $this->model_admin->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;         $message_count = $this->model_admin->get_message_count();         $this->page_data['message_count'] = $message_count;         $this->load->view('admin/admin_main_view',$this->page_data);
        }
        else {
           $this->page_data["user_privileges"] = $this->model_admin->get_user_privileges(); 
            //print_r($this->page_data["user_privileges"]);

           // $this->get_session_details();
            if(isset($this->page_data['page_content'])){
                unset($this->page_data['page_content']);
            }
            $this->page_data["page_content"] = $this->load->view('admin/admin_view_user_privileges_view',$this->page_data,TRUE);
            $notification_details = $this->model_admin->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;         $message_count = $this->model_admin->get_message_count();         $this->page_data['message_count'] = $message_count;         $this->load->view('admin/admin_main_view',$this->page_data); 
        }
        
    }
    
    public function save_privilege() {
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        if($this->input->post()){
            //print_r($this->input->post());
            $user_id = $this->input->post('user_id');
            if($this->input->post('siv_entry') == 'yes'){
                $new_priv['siv_entry'] = 1;
            }
            else{
                $new_priv['siv_entry'] = 0;
            }
            if($this->input->post('bom_entry') == 'yes'){
                $new_priv['bom_entry'] = 1;
            }
            else{
                $new_priv['bom_entry'] = 0;
            }
            if($this->input->post('bom_create') == 'yes'){
                $new_priv['bom_create'] = 1;
            }
            else{
                $new_priv['bom_create'] = 0;
            }
            if($this->input->post('print_excel') == 'yes'){
                $new_priv['print_excel'] = 1;
            }
            else{
                $new_priv['print_excel'] = 0;
            }
            if($this->input->post('rescreen') == 'yes'){
                $new_priv['rescreen'] = 1;
            }
            else{
                $new_priv['rescreen'] = 0;
            }
            if($this->input->post('store_officer') == 'yes'){
                $new_priv['store_officer'] = 1;
            }
            else{
                $new_priv['store_officer'] = 0;
            }
            //print_r($new_priv);
            //echo $user_id;
            if($this->model_admin->update_privilege($user_id, $new_priv)){
                //$this->get_session_details();
                //$this->print_success("User Privilege Successfully Updated.");
                redirect('admin/print_success/User_Privilege_Successfully_Updated.');
            }
            else {
                //$this->get_session_details();
                $this->print_error("Error while updating user privilege! Please try again.");
                redirect('admin/print_error/Error_while_updating_user_privilege!_Please_try_again.');
            }
            
        }
        
        
    }
    
    public function add_verifier() {
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
            if($this->input->post()){
                $this->form_validation->set_rules('name', 'Name', 'required');
                $this->form_validation->set_rules('email_id', 'Email ID', 'required');
                $this->form_validation->set_rules('password_1', 'Password', 'required');
                $this->form_validation->set_rules('password_2', 'Password', 'required');
                if($this->form_validation->run() == FALSE){                 //load the view again
                       // $this->get_session_details();
                        $this->print_error("Error! All fields are required. Please try again.");
                    }
                    else{
                        if($this->input->post('password_1') != $this->input->post('password_2')){
                            //$this->get_session_details();
                            $this->print_error("Error! Passwords do not match. Please try again.");
                        }
                        else {
                            if($this->model_admin->add_verifier()){
                                //$this->get_session_details();
                                //$this->print_success("Verifier successfully added.");
                                redirect('admin/print_success/Verifier_Successfully_Added.');

                                //added successfully
                            }
                            else {
                                //$this->print_error("Error while adding the Verifier! Please try again.");
                                redirect('admin/print_error/Error_while_adding_the_Verifier!_Please_try_again.');
                            }
                        }
                    } 
                }
            else {
                //$this->get_session_details();
                if(isset($this->page_data['page_content'])){
                    unset($this->page_data['page_content']);
                }
                $this->page_data["page_content"] = $this->load->view('admin/admin_add_verifier_view.php',$this->page_data,TRUE);
                $notification_details = $this->model_admin->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;         $message_count = $this->model_admin->get_message_count();         $this->page_data['message_count'] = $message_count;         $this->load->view('admin/admin_main_view',$this->page_data);
            }
        }
    
    public function remove_verifier($user_id){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        if($this->model_admin->remove_verifier($user_id)){
            //$this->print_success("Verifier Removed Successfully.");
            redirect('admin/print_success/Verifier_Removed_Successfully.');
        }
        else{
            $this->print_error("Error!. Failed to Remove Verifier.");
        }
    }
    
    
    public function view_verifiers() {
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        //$this->get_session_details();
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["view_verifier"] = $this->model_admin->get_users('verifier');
        //print_r($this->page_data["view_users"]);
        $this->page_data["page_content"] = $this->load->view('admin/admin_view_verifiers_view.php',$this->page_data,TRUE);
        $notification_details = $this->model_admin->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;         $message_count = $this->model_admin->get_message_count();         $this->page_data['message_count'] = $message_count;         $this->load->view('admin/admin_main_view',$this->page_data);
    }
    
    
    //***********Master Inventory****************
    
    
    
    public function view_master_inventory($type){
        $this->page_data['table_fields'] = $this->model_admin->get_master_inventory_fields($type);
        /*
        echo "<pre>";
        print_r($this->page_data['table_fields']);
        echo "</pre>";
        */
        $this->page_data['components'] = $this->model_admin->get_master_inventory($type);
        $this->page_data['type'] = $type;
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('admin/admin_view_master_inventory_view',$this->page_data,TRUE);
        $notification_details = $this->model_admin->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;         $message_count = $this->model_admin->get_message_count();         $this->page_data['message_count'] = $message_count;         $this->load->view('admin/admin_main_view',$this->page_data);
        
    }
    
    public function delete_from_master_inventory($type, $component_type, $component_name){
        if($this->model_admin->delete_component_from_master($type, $component_type, $component_name)){
            //$this->print_success("Component Deleted Successfully.");  
            redirect('admin/print_success/Component_Deleted_Successfully.');
        }
        else{
            $this->print_error("Error!. Failed to Delete Component.");
        }
    }
    
    public function print_master_inventory($type){
        $this->page_data['type'] = $type;
        $this->page_data['table_fields'] = $this->model_admin->get_master_inventory_fields($type);
        $this->page_data['components'] = $this->model_admin->get_master_inventory($type);
        $this->page_data['type'] = $type;
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->load->view('admin/admin_print_master_inventory', $this->page_data);
    }
    
    
    public function master_inventory_save_as_excel($type){              //MASTER INVENTORY SAVE AS EXCEL EM AND FM new
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel = new phpexcel();
        $master_inventory_table_name =  strtolower("master_inventory_".$type."_grade");       //eg:  master_inventory_em_grade   
        $file_name = $master_inventory_table_name.".xlsx";
        $components = $this->model_admin->get_master_inventory($type);
        //print_r($components);
        $objPHPExcel->getProperties()->setCreator($this->session->userdata('name')); //author the excel file
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $master_inventory_table_name);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "sl_no"); //insert column headings
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 2, "component_type");
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, "component_name");
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 2, "total");
        
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true); //auto width
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
        
        
        $objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray(array(
                                                                        "font" => array(
                                                                                        "bold" => true
                                                                                        ), 
                                                                        "alignment" => array(
                                                                                            "horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                                                                                            ),
                                                                        "fill" => array(
                                                                                        "type" => PHPExcel_Style_Fill::FILL_SOLID,
                                                                                        "startcolor" => array(
                                                                                                                "rgb" => "3C8DBC"
                                                                                                                )
                                                                                        ),
                                                                        "borders" => array(
                                                                                            "allborders" => array(
                                                                                                                    "style" => PHPExcel_Style_Border::BORDER_THIN
                                                                                                                    )
                                                                                            )
                                                                        ));
        $objPHPExcel->getActiveSheet()->getStyle("A2:D2")->applyFromArray(array(
                                                                        "font" => array(
                                                                                        "bold" => true
                                                                                        ), 
                                                                        "alignment" => array(
                                                                                            "horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                                                                                            ),
                                                                        "fill" => array(
                                                                                        "type" => PHPExcel_Style_Fill::FILL_SOLID,
                                                                                        "startcolor" => array(
                                                                                                                "rgb" => "00A65A"
                                                                                                                )
                                                                                        ),
                                                                        "borders" => array(
                                                                                            "allborders" => array(
                                                                                                                    "style" => PHPExcel_Style_Border::BORDER_THIN
                                                                                                                    )
                                                                                            )
                                                                        ));
        $r = 3;
        $i = 1;
        foreach($components as $row){
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $r, $i++);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $r, $row['component_type']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $r, $row['component_name']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $r, $row['total']);
            $r++;
        }
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=".$file_name);
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        
    }

    
    
    
    
    //****************SIV************
    
    
    public function view_issued_siv_list(){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        $this->page_data['issued_siv'] = $this->model_admin->get_issued_siv();
        //print_r($this->page_data['issued_siv']);
        //$this->get_session_details();
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('admin/admin_issued_siv_list_view',$this->page_data,TRUE);
        $notification_details = $this->model_admin->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;         $message_count = $this->model_admin->get_message_count();         $this->page_data['message_count'] = $message_count;         $this->load->view('admin/admin_main_view',$this->page_data);
    }
    
    public function view_siv_list($type) {
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        //echo $type;
        $this->page_data['type'] = $type;
        $this->page_data['issued_siv'] = $this->model_admin->get_issued_siv_by_type($type);
        //print_r($this->page_data['siv']);
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('admin/admin_issued_siv_list_view',$this->page_data,TRUE);
        $notification_details = $this->model_admin->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;         $message_count = $this->model_admin->get_message_count();         $this->page_data['message_count'] = $message_count;         $this->load->view('admin/admin_main_view',$this->page_data);
    }
    
    public function view_full_siv($siv_no) {
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        $siv_details = $this->model_admin->get_siv_by_siv_no($siv_no);
        $siv_table_name = strtolower("siv_#".$siv_details['siv_no']."_".$siv_details['siv_grade']."_".$siv_details['date_of_issue']."_".$siv_details['no_of_components']."_".$siv_details['entered_by']);  //eg: siv_#123_em_2011-11-11_1_alanjose
        //echo $siv_table_name;
        $component_details = $this->model_admin->get_components_of_siv($siv_table_name);
        //print_r($component_details);
        //print_r($bom_details);
        $siv_details['date_of_issue'] = preg_replace("!([0-9]{4})-([0-9]{2})-([0123][0-9])!", "$3/$2/$1", $siv_details['date_of_issue']);         //yyyy-mm-dd -> dd/mm/yyyy
        $this->page_data['siv_details'] = $siv_details;
        $this->page_data['component_details'] = $component_details;
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('admin/admin_view_siv_details_view',$this->page_data,TRUE);
        $notification_details = $this->model_admin->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;         $message_count = $this->model_admin->get_message_count();         $this->page_data['message_count'] = $message_count;         $this->load->view('admin/admin_main_view',$this->page_data);
        
    }
    
    public function print_siv($siv_no) {
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        $siv_details = $this->model_admin->get_siv_by_siv_no($siv_no);
        $siv_table_name = strtolower("siv_#".$siv_details['siv_no']."_".$siv_details['siv_grade']."_".$siv_details['date_of_issue']."_".$siv_details['no_of_components']."_".$siv_details['entered_by']);       //eg: siv_#123_em_2011-11-11_1_alanjose
        echo $siv_table_name;
        $component_details = $this->model_admin->get_components_of_siv($siv_table_name);
        $this->page_data['siv_details'] = $siv_details;
        $this->page_data['component_details'] = $component_details;
        $this->load->view('admin/admin_print_siv_view',$this->page_data);
        
    }
    
    public function siv_save_as_excel($siv_no){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel = new phpexcel();
        $siv_details = $this->model_admin->get_siv_by_siv_no($siv_no);
        $siv_table_name = strtolower("siv_#".$siv_details['siv_no']."_".$siv_details['siv_grade']."_".$siv_details['date_of_issue']."_".$siv_details['no_of_components']."_".$siv_details['entered_by']);       //eg: siv_#123_em_2011-11-11_1_alanjose
        //echo $siv_table_name;
        //print_r($siv_details);
        $components = $this->model_admin->get_components_of_siv($siv_table_name);
        $file_name = $siv_table_name.".xlsx";
        //print_r($components);
        $objPHPExcel->getProperties()->setCreator($this->session->userdata('name')); //author the excel file
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $siv_table_name);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "component_type"); //insert column headings
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 2, "component_name");
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, "date_of_expiry");
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 2, "component_quantity");
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true); //auto width
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray(array(
                                                                        "font" => array(
                                                                                        "bold" => true
                                                                                        ), 
                                                                        "alignment" => array(
                                                                                            "horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                                                                                            ),
                                                                        "fill" => array(
                                                                                        "type" => PHPExcel_Style_Fill::FILL_SOLID,
                                                                                        "startcolor" => array(
                                                                                                                "rgb" => "3C8DBC"
                                                                                                                )
                                                                                        ),
                                                                        "borders" => array(
                                                                                            "allborders" => array(
                                                                                                                    "style" => PHPExcel_Style_Border::BORDER_THIN
                                                                                                                    )
                                                                                            )
                                                                        ));
        $objPHPExcel->getActiveSheet()->getStyle("A2:D2")->applyFromArray(array(
                                                                        "font" => array(
                                                                                        "bold" => true
                                                                                        ), 
                                                                        "alignment" => array(
                                                                                            "horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                                                                                            ),
                                                                        "fill" => array(
                                                                                        "type" => PHPExcel_Style_Fill::FILL_SOLID,
                                                                                        "startcolor" => array(
                                                                                                                "rgb" => "00A65A"
                                                                                                                )
                                                                                        ),
                                                                        "borders" => array(
                                                                                            "allborders" => array(
                                                                                                                    "style" => PHPExcel_Style_Border::BORDER_THIN
                                                                                                                    )
                                                                                            )
                                                                        ));
        $r = 3;
        foreach($components as $row){
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $r, $row['component_type']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $r, $row['component_name']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $r, $row['date_of_expiry']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $r, $row['component_quantity']);
            $r++;
        }
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=".$file_name);
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    //**************BOM********************
    
    
    
    public function create_bom_admin() {         
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        if($this->input->post()) {
            $this->form_validation->set_rules('bom_name', 'BOM Name', 'required');
            $this->form_validation->set_rules('model_type', 'Model Type', 'required');
            //$this->form_validation->set_rules('bom_excel', 'BOM Excel', 'required');
            if($this->form_validation->run() == FALSE){                 //load the view again
                    //$this->get_session_details();
                    $this->print_error("Error! All fields are required. Please try again.");
                }
            else{
                $data['bom_name'] = $this->input->post('bom_name');
                $data['model_type'] = $this->input->post('model_type');
                $file_name = "BOM_".$data['bom_name']."_".$data['model_type'];
                //echo $file_name;
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = '*';
                $config['file_name'] = $file_name;
                $this->load->library('upload', $config);
                if($this->upload->do_upload('bom_excel')){
                    $this->read_bom_excel($data);
                }
                else {
                    //$this->get_session_details();
                    $this->print_error("Error! Upload Failed. Please try again.");
                }  
            }

            }
        else {
            //$this->get_session_details();
            if(isset($this->page_data['page_content'])){
                unset($this->page_data['page_content']);
            }
            $this->page_data["page_content"] = $this->load->view('admin/admin_create_bom_view',$this->page_data,TRUE);
            $notification_details = $this->model_admin->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;         $message_count = $this->model_admin->get_message_count();         $this->page_data['message_count'] = $message_count;         $this->load->view('admin/admin_main_view',$this->page_data);
            
        }
    }
    
    public function read_bom_excel($bom_details) {
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        $file = "./uploads/BOM_".$bom_details['bom_name']."_".$bom_details['model_type'].".xlsx";
        $bom_details['created_by'] = $this->session->userdata('user_name');
        $bom_details['date_of_creation'] = date("Y-m-d");
        //print_r($bom_details);
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/IOFactory');
        //echo $file;
        $objPHPExcel = IOFactory::load($file);
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        $highestColumm = $objPHPExcel->getActiveSheet()->getHighestColumn();
        $highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();
        //echo $highestColumm;
        //echo $highestRow;
        foreach ($cell_collection as $cell) {
            $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
            if ($row == 1) {
                continue;
                //$header[$row][$column] = $data_value;
            }       
            else {
                $arr_data[$row][$column] = $data_value;
            }   
        }
        $file_data = $arr_data;
        //print_r($file_data);
        foreach($file_data as $row){
            $new_row['component_type'] = $row['A'];
            $new_row['component_name'] = $row['B'];
            $new_row['component_quantity'] = $row['C'];
            //$new_row['component_unit'] = $row['D'];
            $file_data_new[] = $new_row;
        }
        unset($file_data);
        //print_r($file_data_new);
        
        $table_name = "BOM_".$bom_details['bom_name']."_".$bom_details['model_type'];
        if($this->model_admin->create_bom($bom_details, $file_data_new, $table_name)){
            //$this->get_session_details();
            $this->insert_into_calendar($table_name, date("Y-m-d") , 'bom_created');
            //$this->print_success("BOM Successfully Created.");
            redirect('admin/print_success/BOM_Successfully_Created.');
        }
        else{
            //$this->get_session_details();
            $this->print_error("Error! BOM Already Exists. Delete existing BOM and try again.");
        }
    }
    
    public function download_bom_template(){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        $this->load->helper('download');
        $data = file_get_contents("./downloads/bom_template.xlsx");
        $name = 'bom_template.xlsx';
        force_download($name, $data);
    }
    
    
    public function view_uploaded_bom_list(){
        $this->page_data['uploaded_boms'] = $this->model_admin->get_uploaded_boms();
        
        
        
        //$this->get_session_details();
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('admin/admin_uploaded_bom_list_view',$this->page_data,TRUE);
        $notification_details = $this->model_admin->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;         $message_count = $this->model_admin->get_message_count();         $this->page_data['message_count'] = $message_count;         $this->load->view('admin/admin_main_view',$this->page_data);
    }
    
    public function view_all_uploads($file_to_delete = null){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        if(isset($file_to_delete)){
            $this->load->helper('file');
            $file_to_delete_path = "./uploads/".$file_to_delete;
            //echo $file_to_delete_path;
            if(file_exists($file_to_delete_path)){
                if(unlink($file_to_delete_path)) {
                    $this->view_all_uploads();
                } 
            }
                 
        }
        $this->load->helper('directory');
        $map = directory_map('./uploads/');
        //print_r($map);
        $this->page_data['uploads'] = $map;
        //$this->get_session_details();
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('admin/admin_view_all_uploads_view',$this->page_data,TRUE);
        $notification_details = $this->model_admin->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;         $message_count = $this->model_admin->get_message_count();         $this->page_data['message_count'] = $message_count;         $this->load->view('admin/admin_main_view',$this->page_data);
    }
    
    public function download_uploaded_file($file_name){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        $this->load->helper('download');
        $data = file_get_contents("./uploads/".$file_name);
        force_download($file_name, $data);
    }
    
    public function view_full_bom($bom_no) {
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        $bom_details = $this->model_admin->get_bom_by_bom_no($bom_no);
        $bom_table_name = strtolower("bom_".$bom_details['bom_name']."_".$bom_details['model_type']);
        $component_details = $this->model_admin->get_components_of_uploaded_bom($bom_table_name);
        //print_r($component_details);
        //print_r($bom_details);
        $this->page_data['bom_details'] = $bom_details;
        $this->page_data['component_details'] = $component_details;
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('admin/admin_view_bom_details_view',$this->page_data,TRUE);
        $notification_details = $this->model_admin->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;         $message_count = $this->model_admin->get_message_count();         $this->page_data['message_count'] = $message_count;         $this->load->view('admin/admin_main_view',$this->page_data);
        
    }
    
    public function print_bom($bom_no) {
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        $bom_details = $this->model_admin->get_bom_by_bom_no($bom_no);
        $bom_table_name = strtolower("bom_".$bom_details['bom_name']."_".$bom_details['model_type']);
        $component_details = $this->model_admin->get_components_of_uploaded_bom($bom_table_name);
        $this->page_data['bom_details'] = $bom_details;
        $this->page_data['component_details'] = $component_details;
        $this->load->view('admin/admin_print_bom_view',$this->page_data);
        
    }
    
    public function delete_uploaded_bom($bom_no){    
            if($this->model_admin->delete_uploaded_bom($bom_no)){
                //$this->print_success("BOM Successfully Deleted.");
                redirect('admin/print_success/BOM_Successfully_Deleted.');
            }
            else {
                $this->print_error("BOM Delete Failed!");
            }
    }
    
    
    public function view_assembled_bom_list(){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        $this->page_data['assembled_bom'] = $this->model_admin->get_assembled_bom();
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('admin/admin_assembled_bom_list_view',$this->page_data,TRUE);
        $notification_details = $this->model_admin->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;         $message_count = $this->model_admin->get_message_count();         $this->page_data['message_count'] = $message_count;         $this->load->view('admin/admin_main_view',$this->page_data);
    }
    
    public function view_assembled_bom_list_by_type($type){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        $this->page_data['type'] = $type;
        $this->page_data['assembled_bom'] = $this->model_admin->get_assembled_bom_by_type($type);
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('admin/admin_assembled_bom_list_view',$this->page_data,TRUE);
        $notification_details = $this->model_admin->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;         $message_count = $this->model_admin->get_message_count();         $this->page_data['message_count'] = $message_count;         $this->load->view('admin/admin_main_view',$this->page_data);
    }
    
    public function view_assembled_bom_full($bom_no){
        $bom_details = $this->model_admin->get_assembled_bom_details($bom_no);
        $components = $this->model_admin->get_assembled_bom_components($bom_details['table_name']);
        //print_r($bom_details);
        //print_r($components);
        $bom_details['date_of_assembly'] = preg_replace("!([0-9]{4})-([0-9]{2})-([0123][0-9])!", "$3/$2/$1", $bom_details['date_of_assembly']);         //yyyy-mm-dd -> dd/mm/yyyy
        $this->page_data['bom_details'] = $bom_details;
        $this->page_data['components'] = $components;
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('admin/admin_view_assembled_bom_details_view',$this->page_data,TRUE);
        $notification_details = $this->model_admin->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;         $message_count = $this->model_admin->get_message_count();         $this->page_data['message_count'] = $message_count;         $this->load->view('admin/admin_main_view',$this->page_data);
    }
    
    public function print_assembled_bom($bom_no){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        $bom_details = $this->model_admin->get_assembled_bom_details($bom_no);
        $components = $this->model_admin->get_assembled_bom_components($bom_details['table_name']);
        //print_r($components);
        $bom_details['date_of_assembly'] = preg_replace("!([0-9]{4})-([0-9]{2})-([0123][0-9])!", "$3/$2/$1", $bom_details['date_of_assembly']);         //yyyy-mm-dd -> dd/mm/yyyy
        $this->page_data['bom_details'] = $bom_details;
        $this->page_data['components'] = $components;
        $this->load->view('admin/admin_print_assembled_bom_view',$this->page_data);
    }
    
    public function delete_assembled_bom($bom_no){    
            if($this->model_admin->delete_assembled_bom($bom_no)){
                //$this->print_success("BOM Successfully Deleted.");
                redirect('admin/print_success/BOM_Successfully_Deleted.');
            }
            else {
                $this->print_error("BOM Delete Failed!");
            }
    }
    
    
    public function assembled_bom_save_as_excel($bom_no) {     //save as excel for approved, rejected and pending
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        $bom_details = $this->model_admin->get_bom_by_bom_no($bom_no);
        if($bom_details['bom_status'] == "APPROVED") {
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel = new phpexcel();
        $bom_details = $this->model_admin->get_assembled_bom_details($bom_no);
        $bom_table_name =  strtolower($bom_details['bom_name']."_".$bom_details['model_grade']."_".$bom_details['bom_model_no']."_".$bom_details['date_of_assembly']."_".$bom_details['no_of_components']);       //eg:  athil_em_431_2031-12-23_5   
        //'component_type, component_name, required_quantity'
        //echo $bom_table_name;
        //print_r($bom_details);
        $components = $this->model_admin->get_components_of_bom_approved($bom_table_name);
        $file_name = $bom_table_name.".xlsx";
        //print_r($components);
        $objPHPExcel->getProperties()->setCreator($this->session->userdata('name')); //author the excel file
        $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $bom_table_name);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "component_no"); //insert column headings
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 2, "component_type");
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, "component_name");
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 2, "required_quantity");
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 2, "issued_quantity");
        
        
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true); //auto width
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
        
        
        $objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray(array(
                                                                        "font" => array(
                                                                                        "bold" => true
                                                                                        ), 
                                                                        "alignment" => array(
                                                                                            "horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                                                                                            ),
                                                                        "fill" => array(
                                                                                        "type" => PHPExcel_Style_Fill::FILL_SOLID,
                                                                                        "startcolor" => array(
                                                                                                                "rgb" => "3C8DBC"
                                                                                                                )
                                                                                        ),
                                                                        "borders" => array(
                                                                                            "allborders" => array(
                                                                                                                    "style" => PHPExcel_Style_Border::BORDER_THIN
                                                                                                                    )
                                                                                            )
                                                                        ));
        $objPHPExcel->getActiveSheet()->getStyle("A2:E2")->applyFromArray(array(
                                                                        "font" => array(
                                                                                        "bold" => true
                                                                                        ), 
                                                                        "alignment" => array(
                                                                                            "horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                                                                                            ),
                                                                        "fill" => array(
                                                                                        "type" => PHPExcel_Style_Fill::FILL_SOLID,
                                                                                        "startcolor" => array(
                                                                                                                "rgb" => "00A65A"
                                                                                                                )
                                                                                        ),
                                                                        "borders" => array(
                                                                                            "allborders" => array(
                                                                                                                    "style" => PHPExcel_Style_Border::BORDER_THIN
                                                                                                                    )
                                                                                            )
                                                                        ));
        $r = 3;
        $i = 1;
        foreach($components as $row){
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $r, $i++);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $r, $row['component_type']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $r, $row['component_name']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $r, $row['required_quantity']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $r, $row['issued_quantity']);
            $r++;
        }
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=".$file_name);
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        
        }
        
        else {
            
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel = new phpexcel();
        $bom_details = $this->model_admin->get_assembled_bom_details($bom_no);
        $bom_table_name =  strtolower($bom_details['bom_name']."_".$bom_details['model_grade']."_".$bom_details['bom_model_no']."_".$bom_details['date_of_assembly']."_".$bom_details['no_of_components']);       //eg:  athil_em_431_2031-12-23_5   
        //'component_type, component_name, required_quantity'
        //echo $bom_table_name;
        //print_r($bom_details);
        $components = $this->model_admin->get_components_of_bom($bom_table_name);
        $file_name = $bom_table_name.".xlsx";
        //print_r($components);
        $objPHPExcel->getProperties()->setCreator($this->session->userdata('name')); //author the excel file
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $bom_table_name);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "component_no"); //insert column headings
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 2, "component_type");
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, "component_name");
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 2, "required_quantity");
        /*if($bom_details['bom_status'] == "APPROVED") {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 2, "issued_quantity");
        }*/
        
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true); //auto width
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
        /*if($bom_details['bom_status'] == "APPROVED") {
            $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
        }*/
        
        $objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray(array(
                                                                        "font" => array(
                                                                                        "bold" => true
                                                                                        ), 
                                                                        "alignment" => array(
                                                                                            "horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                                                                                            ),
                                                                        "fill" => array(
                                                                                        "type" => PHPExcel_Style_Fill::FILL_SOLID,
                                                                                        "startcolor" => array(
                                                                                                                "rgb" => "3C8DBC"
                                                                                                                )
                                                                                        ),
                                                                        "borders" => array(
                                                                                            "allborders" => array(
                                                                                                                    "style" => PHPExcel_Style_Border::BORDER_THIN
                                                                                                                    )
                                                                                            )
                                                                        ));
        $objPHPExcel->getActiveSheet()->getStyle("A2:D2")->applyFromArray(array(
                                                                        "font" => array(
                                                                                        "bold" => true
                                                                                        ), 
                                                                        "alignment" => array(
                                                                                            "horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                                                                                            ),
                                                                        "fill" => array(
                                                                                        "type" => PHPExcel_Style_Fill::FILL_SOLID,
                                                                                        "startcolor" => array(
                                                                                                                "rgb" => "00A65A"
                                                                                                                )
                                                                                        ),
                                                                        "borders" => array(
                                                                                            "allborders" => array(
                                                                                                                    "style" => PHPExcel_Style_Border::BORDER_THIN
                                                                                                                    )
                                                                                            )
                                                                        ));
        $r = 3;
        $i = 1;
        foreach($components as $row){
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $r, $i++);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $r, $row['component_type']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $r, $row['component_name']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $r, $row['required_quantity']);
         /*   if($bom_details['bom_status'] == "APPROVED") {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $r, $row['issued_quantity']);
            }
           */ 
            $r++;
        }
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=".$file_name);
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }
        
}
    
    
    
    
    
    
    //*******************CALENDAR*******************
    
    
    
    
    
    
    public function calendar(){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        if($this->session->userdata('user_status')){
            $this->page_data['users'] = $this->model_admin->get_users('user');
            $this->page_data["page_content"] = $this->load->view('fail_alert_view',$this->page_data,TRUE);
        $notification_details = $this->model_admin->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;         $message_count = $this->model_admin->get_message_count();         $this->page_data['message_count'] = $message_count;
            $this->load->view('admin/admin_calendar_view',$this->page_data);
            //print_r($this->page_data);           
        }
        else{
            $this->login();
        }
        
    }
    
    public function calendar_add_dropped_event()  {
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
       $event_data = $this->input->post('event_data');
        $event_data = json_decode($event_data,true);
        print_r($event_data);
        $this->model_admin->insert_dropped_calendar_event($event_data);
    }
    
    public function calendar_get_events() {
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        $events = $this->model_admin->get_calendar_events();
        echo json_encode($events);
    }
    
    public function insert_into_calendar($title, $start, $type){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'admin')){
        $this->login();
        }
        switch($type) {
            case 'siv_entered' : $color = 'rgb(0,192,239)'; 
                                break;
            case 'siv_approved' : $color = 'rgb(0,166,90)'; 
                                break;
            case 'siv_rejected' : $color = 'rgb(221,75,57)'; 
                                break;
            case 'bom_created' : $color = 'rgb(17,17,17)'; 
                                break;
            case 'bom_entered' : $color = 'rgb(0,115,183)'; 
                                break;
            case 'bom_approved' : $color = 'rgb(1,255,112)'; 
                                break;
            case 'bom_rejected' : $color = 'rgb(96,92,168)'; 
                                break;
            case 'rescreen_pending' : $color = 'rgb(114,175,210)'; 
                                break;
            case 'rescreen_completed' : $color = 'rgb(0,31,63)'; 
                                break;
            case 'rescreen_approved' : $color = 'rgb(210,214,222)';
                                break;
        }
        
        $this->model_admin->insert_event($title, $start, $color);
    }
    
    
    
    
    
    
    
    //*************MESSAGES*****************
    
    
    
    public function message($receiver_name = null) {                        //new
        $users = $this->model_admin->get_all_user_names();
        $this->page_data['user_names'] = $users;
        
       
       if($this->input->post()) { 
        $receiver_name = $this->input->post('receiver_name');
        $sender_name = $this->session->userdata('user_name');
        $message_details = $this->model_admin->get_message_by_sender_name_receiver_name($sender_name, $receiver_name);
        $this->page_data['message_details'] = $message_details;
        
       }
       
        else {
        
        if($receiver_name != null) {    
        $sender_name = $this->session->userdata('user_name');
        $message_details = $this->model_admin->get_message_by_sender_name_receiver_name($sender_name, $receiver_name);
        $this->page_data['message_details'] = $message_details;
           
       }
        
        else if($receiver_name == null) {
        $users = $this->model_admin->get_all_user_names();
        $receiver_name = $users['0']['user_name'];     
        $sender_name = $this->session->userdata('user_name');
        $message_details = $this->model_admin->get_message_by_sender_name_receiver_name($sender_name, $receiver_name);
        $this->page_data['message_details'] = $message_details;
       
       }
        
           
            
       }
        $this->page_data['receiver_name'] = $receiver_name;
    
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        
        $this->page_data["page_content"] = $this->load->view('admin/admin_message_view',$this->page_data,TRUE);
        $notification_details = $this->model_admin->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;         $message_count = $this->model_admin->get_message_count();         $this->page_data['message_count'] = $message_count;         $this->load->view('admin/admin_main_view',$this->page_data);
                 
    }
     

        
    public function add_message() {                                                         //new
        $message = $this->input->post('message');
        $receiver_name = $this->input->post('receiver_name');
        $sender_name = $this->session->userdata('user_name');
        $this->model_admin->insert_message($sender_name, $receiver_name, $message);
        $this->message($receiver_name);
        }
    
    
    

    
    
    
    

}