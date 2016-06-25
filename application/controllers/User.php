<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
    
    function __construct() {
    parent::__construct();
        $this->page_data = array();
        $this->load->model("model_user");
    }
    
    public function index(){
            $this->login();
    }
    
    public function login() {
        if($this->session->userdata('user_status')){
            $this->dashboard();
        }
        else{
            $this->load->view('login');
        }
    }

    
    public function login_validation() {
            if($this->input->post()){             
                $this->load->library('form_validation');
                $this->form_validation->set_rules('username', 'Username', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required');   
                if($this->form_validation->run() == FALSE){
                    $this->load->view("login");
                }
                else{
                    $this->load->model("model_user");
                    if($this->model_user->login()){
                        $this->model_user->update_userdata();
                        $this->model_user->get_user_privileges();
                        $this->dashboard();
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
            $userdata = $this->session->all_userdata();
            $this->model_user->update_userdata();
            $this->session->sess_destroy();
            $userdata = $this->session->all_userdata();
            redirect("user/login");
        }
    
    
    public function print_error($message){
        $this->page_data["err_msg"] = $message;
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('fail_alert_view',$this->page_data,TRUE);
        $this->load->view('user/user_main_view',$this->page_data);
    }
    
    public function print_success($message){
        $this->page_data["err_msg"] = $message;
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('success_alert_view',$this->page_data,TRUE);
        $this->load->view('user/user_main_view',$this->page_data);
    }
    
    public function dashboard() {
        $this->model_user->get_user_privileges();
        if($this->session->userdata('user_status')){
            if(isset($this->page_data['page_content'])){
                unset($this->page_data['page_content']);
            }
            //$this->page_data["page_content"] = $this->load->view('user/ul_user_enter_bom_view',$this->page_data,TRUE);
            $this->page_data["page_content"] = $this->load->view('user/user_dashboard_view',$this->page_data,TRUE);
            $this->load->view('user/user_main_view',$this->page_data);
            //print_r($this->page_data); 
        }
        else {
            $this->login();
        }
    }

    
    
    
    
    
    
    //**********SIV************
    
    
    
    
    
    
    
    
public function new_siv() {
    if(!$this->session->userdata('user_status')){
        $this->login();
    }
        if($this->input->post('submit')){
            $this->form_validation->set_rules('siv_no', 'SIV No', 'required');
            $this->form_validation->set_rules('siv_grade', 'Grade', 'required');
            $this->form_validation->set_rules('date_of_issue', 'Date of Issue', 'required');
            $this->form_validation->set_rules('no_of_components', 'No Of Components', 'required');
            if($this->form_validation->run() == FALSE){                 //load the view again
                    $this->print_error("Error! All fields are required. Please try again.");
                }
                
             else {
                if($this->model_user->check_unique_siv($this->input->post('siv_no'))){
                    $siv_data = array(
                                    'siv_no' => $this->input->post('siv_no'),
                                    'siv_grade' => $this->input->post('siv_grade'),
                                    'date_of_issue' => $this->input->post('date_of_issue'),
                                    'no_of_components' => $this->input->post('no_of_components'),
                                    'entered_by' => $this->session->userdata('user_name')
                                    );
                
                    $this->page_data['siv_data'] = $siv_data;
                    $components = $this->model_user->get_all_component_names();
                    $types = $this->model_user->get_all_component_types();
                    $this->page_data['components'] = $components;
                    $this->page_data['types'] = $types;
                    if(isset($this->page_data['page_content'])){
                        unset($this->page_data['page_content']);
                    }
                    $this->page_data["page_content"] = $this->load->view('user/user_new_siv_2',$this->page_data,TRUE);
                    $this->load->view('user/user_main_view',$this->page_data);
                }
                 else{
                     $this->print_error("Error! SIV No. ".$this->input->post('siv_no')." already exists.");
                 }
                } 
            }
    else {
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('user/user_new_siv_1',$this->page_data,TRUE);
        $this->load->view('user/user_main_view',$this->page_data);
    }
            
        
    }
    
    
    public function new_siv_components() {
        if(!$this->session->userdata('user_status')){
            $this->login();
        }
        if($this->input->post('submit')){
            //print_r($this->input->post());
            $siv_data = array();                //store siv data
            $component_details = array();       //store component data
            $component_type = $this->input->post('component_type');
            $component_name = $this->input->post('component_name');
            $this->model_user->update_datalist($component_type, $component_name);
            $date_of_expiry = array();
            //$date_of_expiry = $this->input->post('date_of_expiry');
            $date_of_expiry = $this->input->post('date_of_expiry');
            //print_r($date_of_expiry);
            for($i = 0; $i< $this->input->post('no_of_components'); $i++) {
                $date_of_expiry[$i] = preg_replace("!([0123][0-9])/([0-9]{2})/([0-9]{4})!", "$3-$2-$1", $date_of_expiry[$i]);
            }
            //print_r($date_of_expiry);
            $component_quantity = $this->input->post('component_quantity');
            $siv_data['siv_no'] = $this->input->post('siv_no');
            $siv_data['siv_grade'] = $this->input->post('siv_grade');
            $siv_data['date_of_issue'] = $this->input->post('date_of_issue');
            $siv_data['no_of_components'] = $this->input->post('no_of_components');
            $siv_data['entered_by'] = $this->session->userdata('user_name');
            //echo $siv_no;
            //echo $no_of_components;
            //print_r($component_type);
            //print_r($component_name);
            //print_r($date_of_expiry);
            //print_r($component_quantity);
            

            for($i = 0; $i < $siv_data['no_of_components']; $i++){
                //echo $i;
                $component_details[$i] = array(
                                                'component_type' => $component_type[$i],
                                                'component_name' => $component_name[$i],
                                                'date_of_expiry' => $date_of_expiry[$i],
                                                'component_quantity' => $component_quantity[$i]
                                                );
            }
            //print_r($component_details);
            if($this->model_user->enter_new_siv($siv_data, $component_details)){
                
                //siv components entered to db
                $title = "SIV_".$siv_data['siv_no'];
                $this->insert_into_calendar($title, date("Y-m-d") , 'siv_entered');
                //$this->print_success("SIV Successfully Entered.");
                redirect('user/print_success/SIV Successfully Entered.');
            }
            
            else{
                //siv component add error
                $this->print_error("Error while entering the SIV. Please try again.");
            }

            
        }
    }
    
    public function view_issued_siv_list(){
        if(!$this->session->userdata('user_status')){
            $this->login();
        }
        $this->page_data['issued_siv'] = $this->model_user->get_issued_siv();
        //print_r($this->page_data['issued_siv']);
        //$this->get_session_details();
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('user/user_issued_siv_list_view',$this->page_data,TRUE);
        $this->load->view('user/user_main_view',$this->page_data);
    }
    
    public function view_full_siv($siv_no) {
        if(!$this->session->userdata('user_status')){
            $this->login();
        }
        $siv_details = $this->model_user->get_siv_by_siv_no($siv_no);
        $siv_table_name = $siv_details['table_name'];
        //echo $siv_table_name;
        $component_details = $this->model_user->get_components_of_siv($siv_table_name);
        //print_r($component_details);
        $this->page_data['siv_details'] = $siv_details;
        $this->page_data['component_details'] = $component_details;
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('user/user_view_siv_details_view',$this->page_data,TRUE);
        $this->load->view('user/user_main_view',$this->page_data);
        
    }
    
    
    public function print_siv($siv_no) {
        if(!$this->session->userdata('user_status')){
            $this->login();
        }
        $siv_details = $this->model_user->get_siv_by_siv_no($siv_no);
        $siv_table_name = $siv_details['table_name'];
        $component_details = $this->model_user->get_components_of_siv($siv_table_name);
        $this->page_data['siv_details'] = $siv_details;
        $this->page_data['component_details'] = $component_details;
        $this->load->view('user/user_print_siv_view',$this->page_data);
        
    }
    
    public function delete_issued_siv($siv_no){
        if(!$this->session->userdata('user_status')){
            $this->login();
        }
        $siv_details = $this->model_user->get_siv_by_siv_no($siv_no);
        $siv_table_name = $siv_details['table_name'];
            if($this->model_user->delete_issued_siv($siv_no, $siv_table_name)){
                $this->print_success("SIV Successfully Deleted.");
            }
            else {
                $this->print_error("SIV Delete Failed!");
            }
    }
    
    public function siv_save_as_excel($siv_no){
        if(!$this->session->userdata('user_status')){
            $this->login();
        }
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel = new phpexcel();
        $siv_details = $this->model_user->get_siv_by_siv_no($siv_no);
        $siv_table_name = $siv_details['table_name'];      //eg: siv_#123_em_2011-11-11_1_alanjose
        //echo $siv_table_name;
        //print_r($siv_details);
        $components = $this->model_user->get_components_of_siv($siv_table_name);
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
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //**********BOM************
    
    
    
    
    public function choose_bom_for_entry() {                              //<!--Made by Pooch-->  
        if(!$this->session->userdata('user_status')){
            $this->login();
        }
        $this->page_data['uploaded_boms'] = $this->model_user->get_uploaded_boms();
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('user/user_choose_uploaded_bom_view',$this->page_data,TRUE);
        $this->load->view('user/user_main_view',$this->page_data);
    }
    
    public function enter_bom_details($bom_no) {                        //<!--Made by Pooch-->
        if(!$this->session->userdata('user_status')){
            $this->login();
        }
        $bom_details = $this->model_user->get_bom_by_bom_no($bom_no);
        $table_name = strtolower("BOM_".$bom_details['bom_name']."_".$bom_details['model_type']);
        $this->page_data['components'] = $this->model_user->get_components_of_bom($table_name);
        $this->page_data['bom_details'] = $bom_details;
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('user/user_enter_bom_components_view',$this->page_data,TRUE);
        $this->load->view('user/user_main_view',$this->page_data);
    }
    
    public function store_entered_bom(){
        if(!$this->session->userdata('user_status')){
            $this->login();
        }
        if($this->input->post()){
            $this->form_validation->set_rules('bom_name', 'BOM No', 'required');
            $this->form_validation->set_rules('model_grade', 'Grade', 'required');
            $this->form_validation->set_rules('bom_model_no', 'BOM Model No', 'required');
            $this->form_validation->set_rules('date_of_assembly', 'Date Of Assembly', 'required');
            $this->form_validation->set_rules('no_of_components', 'No Of Components', 'required');
            if($this->form_validation->run() == FALSE){                 
                    $this->print_error("Error! All fields are required. Please try again.");
                }
            else{
                //print_r($this->input->post());
                $bom_details = array(
                                    "bom_name" => $this->input->post('bom_name'),
                                    "model_grade" => $this->input->post('model_grade'),
                                    "bom_model_no" => $this->input->post('bom_model_no'),
                                    "date_of_assembly" => $this->input->post('date_of_assembly'),
                                    "no_of_components" => $this->input->post('no_of_components'),
                                    );
                $component_type = $this->input->post('component_type');
                $component_name = $this->input->post('component_name');
                $required_quantity = $this->input->post('required_quantity');
                for($i = 0; $i < $bom_details['no_of_components']; $i++){
                    //echo $i;
                    $component_details[$i] = array(
                                                    'component_type' => $component_type[$i],
                                                    'component_name' => $component_name[$i],
                                                    'required_quantity' => $required_quantity[$i]
                                                    );
                }
                //print_r($component_details);
                if($this->model_user->enter_new_bom($bom_details, $component_details)){
                    $title = "BOM_".$bom_details['bom_name']."-".$bom_details['model_grade']."-".$bom_details['bom_model_no'];
                    $this->insert_into_calendar($title, date("Y-m-d") , 'bom_entered');
                    $this->print_success("BOM Entered Successfully.");
                }
                else {
                    $this->print_error("Error! Please check and try again.");
                }
            }
            
            
            
        }
    }
    
    public function view_assembled_bom_list(){
        if(!$this->session->userdata('user_status')){
            $this->login();
        }
        $this->page_data['assembled_bom'] = $this->model_user->get_assembled_bom();
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('user/user_assembled_bom_list_view',$this->page_data,TRUE);
        $this->load->view('user/user_main_view',$this->page_data);
    }
    

    
    
    
    public function view_assembled_bom_full($bom_no){
        if(!$this->session->userdata('user_status')){
            $this->login();
        }
        $bom_details = $this->model_user->get_assembled_bom_details($bom_no);
        $components = $this->model_user->get_assembled_bom_components($bom_details['table_name']);
        //print_r($bom_details);
        //print_r($components);
        $bom_details['date_of_assembly'] = preg_replace("!([0-9]{4})-([0-9]{2})-([0123][0-9])!", "$3/$2/$1", $bom_details['date_of_assembly']);         //yyyy-mm-dd -> dd/mm/yyyy
        $this->page_data['bom_details'] = $bom_details;
        $this->page_data['components'] = $components;
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('user/user_view_assembled_bom_details_view',$this->page_data,TRUE);
        $this->load->view('user/user_main_view',$this->page_data);
    }
    
    public function print_assembled_bom($bom_no){
        if(!$this->session->userdata('user_status')){
            $this->login();
        }
        $bom_details = $this->model_user->get_assembled_bom_details($bom_no);
        $components = $this->model_user->get_assembled_bom_components($bom_details['table_name']);
        //print_r($components);
        $bom_details['date_of_assembly'] = preg_replace("!([0-9]{4})-([0-9]{2})-([0123][0-9])!", "$3/$2/$1", $bom_details['date_of_assembly']);         //yyyy-mm-dd -> dd/mm/yyyy
        $this->page_data['bom_details'] = $bom_details;
        $this->page_data['components'] = $components;
        $this->load->view('user/user_print_assembled_bom_view',$this->page_data);
    }
    
    public function delete_assembled_bom($bom_no){    
        if(!$this->session->userdata('user_status')){
            $this->login();
        }
            if($this->model_user->delete_assembled_bom($bom_no)){
                $this->print_success("BOM Successfully Deleted.");
            }
            else {
                $this->print_error("BOM Delete Failed!");
            }
    }
    
    public function assembled_bom_save_as_excel($bom_no){           //not working!
        if(!$this->session->userdata('user_status')){
            $this->login();
        }
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel = new phpexcel();
        $bom_details = $this->model_user->get_assembled_bom_details($bom_no);
        print_r($bom_details);
        $table_name = $bom_details['table_name'];
        echo $table_name;
        $components = $this->model_user->get_assembled_bom_components($table_name);
        $file_name = $table_name.".xlsx";
        //print_r($components);
        //echo $file_name;
        $objPHPExcel->getProperties()->setCreator($this->session->userdata('name')); //author the excel file
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $table_name);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "component_no");
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 2, "component_type"); //insert column headings
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, "component_name");
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 2, "required_quantity");
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
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $r, $row['required_quantity']);
            $r++;
        }
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=".$file_name);
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }
    
    
    
    
    
    
    
    
    public function create_bom_user() {                        
        if(!$this->session->userdata('user_status')){
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
            $this->page_data["page_content"] = $this->load->view('user/user_create_bom_view',$this->page_data,TRUE);
            $this->load->view('user/user_main_view',$this->page_data);
            
        }
    }
    
    public function read_bom_excel($bom_details) {
        if(!$this->session->userdata('user_status')){
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
        if($this->model_user->create_bom($bom_details, $file_data_new, $table_name)){
            //$this->get_session_details();
            $this->insert_into_calendar($table_name, date("Y-m-d") , 'bom_created');
            $this->print_success("BOM Successfully Created.");
        }
        else{
            //$this->get_session_details();
            $this->print_error("Error! BOM Already Exists. Delete existing BOM and try again.");
        }
    }
    
    public function download_bom_template(){
        if(!$this->session->userdata('user_status')){
            $this->login();
        }
        $this->load->helper('download');
        $data = file_get_contents("./downloads/bom_template.xlsx");
        $name = 'bom_template.xlsx';
        force_download($name, $data);
    }
    
    public function view_uploaded_bom_list(){
        if(!$this->session->userdata('user_status')){
            $this->login();
        }
        $this->page_data['uploaded_boms'] = $this->model_user->get_uploaded_boms();

        //$this->get_session_details();
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('user/user_uploaded_bom_list_view',$this->page_data,TRUE);
        $this->load->view('user/user_main_view',$this->page_data);
    }
    
    public function view_full_bom($bom_no) {
        if(!$this->session->userdata('user_status')){
            $this->login();
        }
        $bom_details = $this->model_user->get_bom_by_bom_no($bom_no);
        $bom_table_name = strtolower("bom_".$bom_details['bom_name']."_".$bom_details['model_type']);
        $component_details = $this->model_user->get_components_of_bom($bom_table_name);
        //print_r($component_details);
        //print_r($bom_details);
        $this->page_data['bom_details'] = $bom_details;
        $this->page_data['component_details'] = $component_details;
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('user/user_view_bom_details_view',$this->page_data,TRUE);
        $this->load->view('user/user_main_view',$this->page_data);
        
    }
    
    public function print_bom($bom_no) {    
        if(!$this->session->userdata('user_status')){
            $this->login();
        }
        $bom_details = $this->model_user->get_bom_by_bom_no($bom_no);
        $bom_table_name = strtolower("bom_".$bom_details['bom_name']."_".$bom_details['model_type']);
        $component_details = $this->model_user->get_components_of_bom($bom_table_name);
        $bom_details['date_of_creation'] = preg_replace("!([0-9]{4})-([0-9]{2})-([0123][0-9])!", "$3/$2/$1", $bom_details['date_of_creation']);         //yyyy-mm-dd -> dd/mm/yyyy
        //print_r($bom_details);
        $this->page_data['bom_details'] = $bom_details;
        $this->page_data['component_details'] = $component_details;
        $this->load->view('user/user_print_bom_view',$this->page_data);
        
    }
    
    public function delete_uploaded_bom($bom_no){    
        if(!$this->session->userdata('user_status')){
            $this->login();
        }
            if($this->model_user->delete_uploaded_bom($bom_no)){
                $this->print_success("BOM Successfully Deleted.");
            }
            else {
                $this->print_error("BOM Delete Failed!");
            }
    }
    
    
    
    
    
    
    
    
    //*******************CALENDAR************
    
    
    public function calendar(){
        if(!$this->session->userdata('user_status')){
            $this->login();
        }
        //$this->page_data['users'] = $this->model_user->get_users('user');
        $this->load->view('user/user_calendar_view',$this->page_data);
    }
    
    public function calendar_get_events() {
        if(!$this->session->userdata('user_status')){
            $this->login();
        }

        $events = $this->model_user->get_calendar_events();
        echo json_encode($events);
    }
    
    public function insert_into_calendar($title, $start, $type){
        if(!$this->session->userdata('user_status')){
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
            case 'rescreen_submitted' : $color = 'rgb(114,175,210)'; 
                                break;
            case 'rescreen_completed' : $color = 'rgb(0,31,63)'; 
                                break;
        }
        
        $this->model_user->insert_event($title, $start, $color);
    }
    

}