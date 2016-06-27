<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verifier extends CI_Controller {
    
    
    function __construct() {
    parent::__construct();
        $this->page_data = array();
        $this->load->model("model_verifier");
        //$this->load->library('excel');                    
        //$this->page_data["page_content_1"] = "";
    }
    
    public function index(){
            redirect("verifier/login");
    }
    
    public function login() {
        if(($this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
           redirect('verifier/dashboard');
        }
        else{
            $this->load->view('login');
        }
    }
    
    
    public function login_validation() {
        if(($this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
            redirect('verifier/dashboard');
        }
            if($this->input->post()){             
                $this->form_validation->set_rules('username', 'Username', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required'); 
                if($this->form_validation->run() == FALSE){
                    $this->load->view("login");
                }
                else{
                    if($this->model_verifier->login()){
                        redirect('verifier/dashboard');
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
        $this->model_verifier->update_userdata();
        $this->session->sess_destroy();
        redirect("verifier/login");
    }
    
    public function print_error($message){
        $this->page_data["err_msg"] = $message;
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('fail_alert_view',$this->page_data,TRUE);
        $notification_details = $this->model_verifier->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;                  $message_count = $this->model_verifier->get_message_count();                  $this->page_data['message_count'] = $message_count;                  $this->load->view('verifier/verifier_main_view',$this->page_data);
    }
    
    public function print_success($message){
        $this->page_data["err_msg"] = $message;
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('success_alert_view',$this->page_data,TRUE);
        $notification_details = $this->model_verifier->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;                  $message_count = $this->model_verifier->get_message_count();                  $this->page_data['message_count'] = $message_count;                  $this->load->view('verifier/verifier_main_view',$this->page_data);
    }
    
    public function dashboard() {
        
        $this->page_data["message"] = $this->model_verifier->get_message_count();
        $this->page_data["pending_approval_siv_no"] = $this->model_verifier->get_no_of_siv('PENDING_APPROVAL');
        $this->page_data["approved_siv_no"] = $this->model_verifier->get_no_of_siv('APPROVED');
        $this->page_data["rejected_siv_no"] = $this->model_verifier->get_no_of_siv('REJECTED');
        $this->page_data["pending_approval_bom_no"] = $this->model_verifier->get_no_of_bom('PENDING_APPROVAL');
        $this->page_data["approved_bom_no"] = $this->model_verifier->get_no_of_bom('APPROVED');
        $this->page_data["rejected_bom_no"] = $this->model_verifier->get_no_of_bom('REJECTED');
        $this->page_data["no_of_uploaded_boms"] = $this->model_verifier->get_no_of_uploaded_bom();
        $this->page_data["no_of_calendar_events"] = $this->model_verifier->get_no_of_calendar_events();
        $this->page_data["no_of_eg_to_expire"] = $this->model_verifier->get_no_of_components_to_expire_in_3('em');
        $this->page_data["no_of_fg_to_expire"] = $this->model_verifier->get_no_of_components_to_expire_in_3('fm');
        
         if(($this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
            if(isset($this->page_data['page_content'])){
                unset($this->page_data['page_content']);
            }
            $this->page_data["page_content"] = $this->load->view('verifier/verifier_dashboard_view.php',$this->page_data,TRUE);
            $notification_details = $this->model_verifier->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;                  $message_count = $this->model_verifier->get_message_count();                  $this->page_data['message_count'] = $message_count;                  $this->load->view('verifier/verifier_main_view',$this->page_data);
            //print_r($this->page_data);   
        }
        else {
            redirect("verifier/login");
        }
    }
    
    
    
    
    //**************SIV***************
    
    
    
    
    public function view_siv_list($type) {
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
        $this->login();
        }
        //echo $type;
        $this->page_data['type'] = $type;
        $this->page_data['siv'] = $this->model_verifier->get_issued_siv($type);
        //print_r($this->page_data['siv']);
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('verifier/verifier_siv_list_view',$this->page_data,TRUE);
        $notification_details = $this->model_verifier->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;                  $message_count = $this->model_verifier->get_message_count();                  $this->page_data['message_count'] = $message_count;                  $this->load->view('verifier/verifier_main_view',$this->page_data);
    }
    
    public function view_full_siv($siv_no) {
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
        $this->login();
        }
        $siv_details = $this->model_verifier->get_siv_by_siv_no($siv_no);
        $siv_table_name = $siv_details['table_name'];
        //echo $siv_table_name;
        $component_details = $this->model_verifier->get_components_of_siv($siv_table_name);
        //print_r($component_details);
        $this->page_data['siv_details'] = $siv_details;
        $this->page_data['component_details'] = $component_details;
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('verifier/verifier_view_siv_details_view',$this->page_data,TRUE);
        $notification_details = $this->model_verifier->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;                  $message_count = $this->model_verifier->get_message_count();                  $this->page_data['message_count'] = $message_count;                  $this->load->view('verifier/verifier_main_view',$this->page_data);
        
    }
    
    public function approve_siv($siv_no){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
        $this->login();
        }
        $siv_details = $this->model_verifier->get_siv_by_siv_no($siv_no);
        $siv_table_name = $siv_details['table_name'];
        $component_details = $this->model_verifier->get_components_of_siv($siv_table_name);
        //print_r($siv_details);
        //print_r($siv_table_name);
        //print_r($component_details);
        if($this->model_verifier->insert_approved_siv($siv_details, $component_details)){
            if($this->model_verifier->change_siv_status($siv_no, 'APPROVED')){
                $this->insert_into_calendar("SIV_".$siv_no, date("Y-m-d") , 'siv_approved');
                redirect('verifier/print_success/SIV_Approved_Successfully.');
                //$this->print_success("SIV Approved Successfully.");
            }
        }
        else{
            $this->print_error("Failed to Approve SIV.");
        }
    }
    
    public function reject_siv($siv_no){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
        $this->login();
        }
        if($this->model_verifier->change_siv_status($siv_no, 'REJECTED')){
                $this->insert_into_calendar("SIV_".$siv_no, date("Y-m-d") , 'siv_rejected');
                //$this->print_success("SIV Rejected.");
                redirect('verifier/print_success/SIV_Rejected.');
            }
        else{
            $this->print_success("Failed to Reject SIV.");
        }
    
    }
    
    public function print_siv($siv_no){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
        $this->login();
        }
        $this->page_data['siv_details'] = $this->model_verifier->get_siv_by_siv_no($siv_no);
        $siv_table_name = $this->page_data['siv_details']['table_name'];
        $this->page_data['siv_details']['date_of_issue'] = preg_replace("!([0-9]{4})-([0-9]{2})-([0123][0-9])!", "$3/$2/$1", $this->page_data['siv_details']['date_of_issue']);         //yyyy-mm-dd -> dd/mm/yyyy
        $this->page_data['component_details'] = $this->model_verifier->get_components_of_siv($siv_table_name);
        //print_r($this->page_data['siv']);
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->load->view('verifier/verifier_print_siv_view',$this->page_data);
        
    }

    
    
    public function siv_save_as_excel($siv_no){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
            $this->login();
        }
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel = new phpexcel();
        $siv_details = $this->model_verifier->get_siv_by_siv_no($siv_no);
        $siv_table_name = $siv_details['table_name'];      //eg: siv_#123_em_2011-11-11_1_alanjose
        //echo $siv_table_name;
        //print_r($siv_details);
        $components = $this->model_verifier->get_components_of_siv($siv_table_name);
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
    
    
    
    
    
    
    //**************BOM***************
    
    
    
    
    
    public function view_assembled_bom_list($type){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
        $this->login();
        }
        $this->page_data['type'] = $type;
        $this->page_data['assembled_bom'] = $this->model_verifier->get_assembled_bom($type);
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('verifier/verifier_assembled_bom_list_view',$this->page_data,TRUE);
        $notification_details = $this->model_verifier->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;                  $message_count = $this->model_verifier->get_message_count();                  $this->page_data['message_count'] = $message_count;                  $this->load->view('verifier/verifier_main_view',$this->page_data);
    }
    
    public function view_assembled_bom_full($bom_no){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
        $this->login();
        }
        $bom_details = $this->model_verifier->get_assembled_bom_details($bom_no);
        $components = $this->model_verifier->get_assembled_bom_components($bom_details['table_name']);
        //print_r($bom_details);
        //print_r($components);
        $bom_details['date_of_assembly'] = preg_replace("!([0-9]{4})-([0-9]{2})-([0123][0-9])!", "$3/$2/$1", $bom_details['date_of_assembly']);         //yyyy-mm-dd -> dd/mm/yyyy
        $this->page_data['bom_details'] = $bom_details;
        $this->page_data['components'] = $components;
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('verifier/verifier_view_assembled_bom_details_view',$this->page_data,TRUE);
        $notification_details = $this->model_verifier->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;                  $message_count = $this->model_verifier->get_message_count();                  $this->page_data['message_count'] = $message_count;                  $this->load->view('verifier/verifier_main_view',$this->page_data);
    }
    
    
    
    public function approve_bom($bom_no){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
        $this->login();
        }
        $bom_details = $this->model_verifier->get_assembled_bom_details($bom_no);
        //print_r($bom_details);
        $bom_table_name = $bom_details['table_name'];
        $component_details = $this->model_verifier->get_assembled_bom_components($bom_table_name);
        //print_r($component_details);
        if($this->model_verifier->reserve_approved_bom($bom_details, $component_details)){
            if($this->model_verifier->change_bom_status($bom_no, 'APPROVED')){
                $this->insert_into_calendar("BOM_".$bom_no, date("Y-m-d") , 'bom_approved');
                //$this->print_success("BOM Approved Successfully.");
                redirect('verifier/print_success/BOM_Approved_Successfully.');
            }
        }
        else{
            $this->print_error("Failed to Approve BOM.");
        }
    }
    
    
    public function reject_bom($bom_no){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
        $this->login();
        }
        if($this->model_verifier->change_bom_status($bom_no, 'REJECTED')){
                $this->insert_into_calendar("BOM_".$bom_no, date("Y-m-d") , 'bom_rejected');
                redirect('verifier/print_success/BOM_Rejected.');
                //$this->print_success("BOM Rejected.");
            }
        else{
            $this->print_success("Failed to Reject BOM.");
        }
    
    }
    
    
    public function print_assembled_bom($bom_no){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
        $this->login();
        }
        $bom_details = $this->model_verifier->get_assembled_bom_details($bom_no);
        $components = $this->model_verifier->get_assembled_bom_components($bom_details['table_name']);
        //print_r($bom_details);
        //print_r($components);
        $bom_details['date_of_assembly'] = preg_replace("!([0-9]{4})-([0-9]{2})-([0123][0-9])!", "$3/$2/$1", $bom_details['date_of_assembly']);         //yyyy-mm-dd -> dd/mm/yyyy
        $this->page_data['bom_details'] = $bom_details;
        $this->page_data['components'] = $components;
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->load->view('verifier/verifier_print_assembled_bom',$this->page_data);
        
    }
    
    
    public function assembled_bom_save_as_excel($bom_no) {     //save as excel for approved, rejected and pending
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
        $this->login();
        }
        $bom_details = $this->model_verifier->get_bom_by_bom_no($bom_no);
        if($bom_details['bom_status'] == "APPROVED") {
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel = new phpexcel();
        $bom_details = $this->model_verifier->get_bom_by_bom_no($bom_no);
        $bom_table_name =  strtolower($bom_details['bom_name']."_".$bom_details['model_grade']."_".$bom_details['bom_model_no']."_".$bom_details['date_of_assembly']."_".$bom_details['no_of_components']);       //eg:  athil_em_431_2031-12-23_5   
        //'component_type, component_name, required_quantity'
        //echo $bom_table_name;
        //print_r($bom_details);
        $components = $this->model_verifier->get_components_of_bom_approved($bom_table_name);
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
        $bom_details = $this->model_verifier->get_bom_by_bom_no($bom_no);
        $bom_table_name =  strtolower($bom_details['bom_name']."_".$bom_details['model_grade']."_".$bom_details['bom_model_no']."_".$bom_details['date_of_assembly']."_".$bom_details['no_of_components']);       //eg:  athil_em_431_2031-12-23_5   
        //'component_type, component_name, required_quantity'
        //echo $bom_table_name;
        //print_r($bom_details);
        $components = $this->model_verifier->get_components_of_bom($bom_table_name);
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
    
    
    
    public function delete_assembled_bom($bom_no){    
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
            $this->login();
        }
            if($this->model_verifier->delete_assembled_bom($bom_no)){
                redirect('verifier/print_success/BOM_Successfully_Deleted.');
            }
            else {
                $this->print_error("BOM Delete Failed!");
            }
    }
    
    
    
    
    
    
    
    //************RESCREEN****************
    
    public function get_components_for_rescreen($type){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
        $this->login();
        }
        $this->page_data['rescreen_components'] = $this->model_verifier->get_components_for_rescreen($type);
        $this->page_data['users'] = $this->model_verifier->get_users('user');
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('verifier/verifier_to_rescreen_list_view',$this->page_data,TRUE);
        $notification_details = $this->model_verifier->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;                  $message_count = $this->model_verifier->get_message_count();                  $this->page_data['message_count'] = $message_count;                  $this->load->view('verifier/verifier_main_view',$this->page_data);
    }
    
    public function assign_rescreen(){
        $data = $this->input->post();

        $sl_no = $this->input->post('sl_no');
        $sl_no = $sl_no - 1;
        $rescreen_array = array(
                                'grade' => $data['grade'][$sl_no],
                                'component_type' => $data['component_type'][$sl_no],
                                'component_name' => $data['component_name'][$sl_no],
                                'date_of_expiry' => $data['date_of_expiry'][$sl_no],
                                'component_quantity' => $data['component_quantity'][$sl_no],
                                'assigned_user' => $this->input->post('assigned_user')
                                    );
        
        

        
        if($this->model_verifier->send_for_rescreen($rescreen_array)){
            $this->insert_into_calendar("Re-Screen_Pending", date("Y-m-d") , 'rescreen_pending');
            redirect('verifier/print_success/Re-Screen_Assigned_Successfully');
        }
        else{
            $this->print_error("Error! Failed To Assign Re-Screen.");
        }
        
        
    }
    
    public function get_completed_rescreens(){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
        $this->login();
        }
        $this->page_data['rescreens'] = $this->model_verifier->get_rescreens('RESCREEN_OVER');
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('verifier/verifier_completed_rescreens_list_view',$this->page_data,TRUE);
        $notification_details = $this->model_verifier->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;                  $message_count = $this->model_verifier->get_message_count();                  $this->page_data['message_count'] = $message_count;                  $this->load->view('verifier/verifier_main_view',$this->page_data);
    }
    
    public function get_approved_rescreens(){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
        $this->login();
        }
        $this->page_data['rescreens'] = $this->model_verifier->get_rescreens('RESCREEN_APPROVED');
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('verifier/verifier_approved_rescreens_list_view',$this->page_data,TRUE);
        $notification_details = $this->model_verifier->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;                  $message_count = $this->model_verifier->get_message_count();                  $this->page_data['message_count'] = $message_count;                  $this->load->view('verifier/verifier_main_view',$this->page_data);
    }
    
    
    
    
    
    public function pending_rescreen() {
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
        $this->login();
        }
        //$this->get_session_details();
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        //$this->page_data["page_content"] = $this->load->view('verifier/verifier_dashboard_view',$this->page_data,TRUE);
        $this->page_data["page_content"] = $this->load->view('verifier/verifier_pending_rescreen_list_view',$this->page_data,TRUE);
        $notification_details = $this->model_verifier->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;                  $message_count = $this->model_verifier->get_message_count();                  $this->page_data['message_count'] = $message_count;                  $this->load->view('verifier/verifier_main_view',$this->page_data);
        //print_r($this->page_data);           
    }
    
    public function view_completed_rescreen($rescreen_id){
        $this->page_data['rescreen_data'] = $this->model_verifier->get_rescreen_data($rescreen_id); 
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('verifier/verifier_view_completed_rescreen',$this->page_data,TRUE);
        $notification_details = $this->model_verifier->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;                  $message_count = $this->model_verifier->get_message_count();                  $this->page_data['message_count'] = $message_count;                  $this->load->view('verifier/verifier_main_view',$this->page_data);
    }
    
    public function approve_rescreen($rescreen_id){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
        $this->login();
        }
        if($this->model_verifier->approve_rescreen($rescreen_id)){
            $this->insert_into_calendar("Re-Screen_Approved" , date("Y-m-d") , 'rescreen_approved');
            redirect('verifier/print_success/Re-Screen_Approved_Successfully');
        }
        else{
            $this->print_error("Error! Failed to Approve Re-Screen.");
        }
    }
    
    
    
    
    
    
    
        //*******************CALENDAR************
    
    
    public function calendar(){
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
        $this->login();
        }
        //$this->page_data['users'] = $this->model_verifier->get_users('user');
        $this->page_data["page_content"] = $this->load->view('verifier/verifier_message_view',$this->page_data,TRUE);
        $notification_details = $this->model_verifier->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;                  $message_count = $this->model_verifier->get_message_count();                  $this->page_data['message_count'] = $message_count;                  
        $this->load->view('verifier/verifier_calendar_view',$this->page_data);
    }
    
    public function calendar_get_events() {
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
        $this->login();
        }
        $events = $this->model_verifier->get_calendar_events();
        echo json_encode($events);
    }
    
    public function insert_into_calendar($title, $start, $type){        //add rescreen and etc
        if((!$this->session->userdata('user_status')) && ($this->session->userdata('user_type') == 'verifier')){
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
        
        $this->model_verifier->insert_event($title, $start, $color);
    }
    
    
    
    
    
    
    
     //*************MESSAGES*****************
    
    
    
    public function message($receiver_name = null) {                        //new
        $users = $this->model_verifier->get_all_user_names();
        $this->page_data['user_names'] = $users;
        
       
       if($this->input->post()) { 
        $receiver_name = $this->input->post('receiver_name');
        $sender_name = $this->session->userdata('user_name');
        $message_details = $this->model_verifier->get_message_by_sender_name_receiver_name($sender_name, $receiver_name);
        $this->page_data['message_details'] = $message_details;
        
       }
       
        else {
        
        if($receiver_name != null) {    
        $sender_name = $this->session->userdata('user_name');
        $message_details = $this->model_verifier->get_message_by_sender_name_receiver_name($sender_name, $receiver_name);
        $this->page_data['message_details'] = $message_details;
           
       }
        
        else if($receiver_name == null) {
        $users = $this->model_verifier->get_all_user_names();
        $receiver_name = $users['0']['user_name'];     
        $sender_name = $this->session->userdata('user_name');
        $message_details = $this->model_verifier->get_message_by_sender_name_receiver_name($sender_name, $receiver_name);
        $this->page_data['message_details'] = $message_details;
       
       }
        
           
            
       }
        $this->page_data['receiver_name'] = $receiver_name;
    
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        
        $this->page_data["page_content"] = $this->load->view('verifier/verifier_message_view',$this->page_data,TRUE);
        $notification_details = $this->model_verifier->get_message_notification_details();         $this->page_data['notification_details'] = $notification_details;                  $message_count = $this->model_verifier->get_message_count();                  $this->page_data['message_count'] = $message_count;                  $this->load->view('verifier/verifier_main_view',$this->page_data);
                 
    }
     

        
    public function add_message() {                                                         //new
        $message = $this->input->post('message');
        $receiver_name = $this->input->post('receiver_name');
        $sender_name = $this->session->userdata('user_name');
        $this->model_verifier->insert_message($sender_name, $receiver_name, $message);
        $this->message($receiver_name);
        }
    
    
    
    
    
    
    
}