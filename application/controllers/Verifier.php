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
                $this->form_validation->set_rules('username', 'Username', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required'); 
                if($this->form_validation->run() == FALSE){
                    $this->load->view("login");
                }
                else{
                    if($this->model_verifier->login()){                        
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
        $this->load->view('verifier/verifier_main_view',$this->page_data);
    }
    
    public function print_success($message){
        $this->page_data["err_msg"] = $message;
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('success_alert_view',$this->page_data,TRUE);
        $this->load->view('verifier/verifier_main_view',$this->page_data);
    }
    
    public function dashboard() {
        $this->page_data["pending_approval_siv_no"] = $this->model_verifier->get_no_of_siv('PENDING_APPROVAL');
        $this->page_data["approved_siv_no"] = $this->model_verifier->get_no_of_bom('APPROVED');
        $this->page_data["rejected_siv_no"] = $this->model_verifier->get_no_of_bom('REJECTED');
        $this->page_data["pending_approval_bom_no"] = $this->model_verifier->get_no_of_bom('PENDING_APPROVAL');
        $this->page_data["approved_bom_no"] = $this->model_verifier->get_no_of_bom('APPROVED');
        $this->page_data["rejected_bom_no"] = $this->model_verifier->get_no_of_bom('REJECTED');
        $this->page_data["no_of_uploaded_boms"] = $this->model_verifier->get_no_of_uploaded_bom();
        $this->page_data["no_of_calendar_events"] = $this->model_verifier->get_no_of_calendar_events();
        $this->page_data["no_of_eg_to_expire"] = $this->model_verifier->get_no_of_components_to_expire_in_3('em');
        $this->page_data["no_of_fg_to_expire"] = $this->model_verifier->get_no_of_components_to_expire_in_3('fm');
        
        if($this->session->userdata('user_status')){
            if(isset($this->page_data['page_content'])){
                unset($this->page_data['page_content']);
            }
            $this->page_data["page_content"] = $this->load->view('verifier/verifier_dashboard_view.php',$this->page_data,TRUE);
            $this->load->view('verifier/verifier_main_view',$this->page_data);
            //print_r($this->page_data);   
        }
        else {
            $this->login();
        }
    }
    
    
    
    
    //**************SIV***************
    
    
    
    
    public function view_siv_list($type) {
        if(!$this->session->userdata('user_status')){
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
        $this->load->view('verifier/verifier_main_view',$this->page_data);
    }
    
    public function view_full_siv($siv_no) {
        if(!$this->session->userdata('user_status')){
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
        $this->load->view('verifier/verifier_main_view',$this->page_data);
        
    }
    
    public function approve_siv($siv_no){
        if(!$this->session->userdata('user_status')){
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
                $this->print_success("SIV Approved Successfully.");
            }
        }
        else{
            $this->print_error("Failed to Approve SIV.");
        }
    }
    
    public function reject_siv($siv_no){
        if(!$this->session->userdata('user_status')){
        $this->login();
        }
        if($this->model_verifier->change_siv_status($siv_no, 'REJECTED')){
                $this->insert_into_calendar("SIV_".$siv_no, date("Y-m-d") , 'siv_rejected');
                $this->print_success("SIV Rejected.");
            }
        else{
            $this->print_success("Failed to Reject SIV.");
        }
    
    }
    
    public function print_siv($siv_no){
        if(!$this->session->userdata('user_status')){
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

    
    
    
    
    
    
    
    
    
    //**************BOM***************
    
    
    
    
    
    public function view_assembled_bom_list($type){
        if(!$this->session->userdata('user_status')){
        $this->login();
        }
        $this->page_data['type'] = $type;
        $this->page_data['assembled_bom'] = $this->model_verifier->get_assembled_bom($type);
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        $this->page_data["page_content"] = $this->load->view('verifier/verifier_assembled_bom_list_view',$this->page_data,TRUE);
        $this->load->view('verifier/verifier_main_view',$this->page_data);
    }
    
    public function view_assembled_bom_full($bom_no){
        if(!$this->session->userdata('user_status')){
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
        $this->load->view('verifier/verifier_main_view',$this->page_data);
    }
    
    
    
    public function approve_bom($bom_no){
        if(!$this->session->userdata('user_status')){
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
                $this->print_success("BOM Approved Successfully.");
            }
        }
        else{
            $this->print_error("Failed to Approve BOM.");
        }
    }
    
    
    public function reject_bom($bom_no){
        if(!$this->session->userdata('user_status')){
        $this->login();
        }
        if($this->model_verifier->change_bom_status($bom_no, 'REJECTED')){
                $this->insert_into_calendar("BOM_".$bom_no, date("Y-m-d") , 'bom_rejected');
                $this->print_success("BOM Rejected.");
            }
        else{
            $this->print_success("Failed to Reject BOM.");
        }
    
    }
    
    
    public function print_assembled_bom($bom_no){
        if(!$this->session->userdata('user_status')){
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
    
    
    
    
    
    
    
    
    
    
    
    //************RESCREEN****************
    
    
    
    public function pending_rescreen() {
        if(!$this->session->userdata('user_status')){
        $this->login();
        }
        //$this->get_session_details();
        if(isset($this->page_data['page_content'])){
            unset($this->page_data['page_content']);
        }
        //$this->page_data["page_content"] = $this->load->view('verifier/verifier_dashboard_view',$this->page_data,TRUE);
        $this->page_data["page_content"] = $this->load->view('verifier/verifier_pending_rescreen_list_view',$this->page_data,TRUE);
        $this->load->view('verifier/verifier_main_view',$this->page_data);
        //print_r($this->page_data);           
    }
    
    
    
    
    
    
    
        //*******************CALENDAR************
    
    
    public function calendar(){
        if(!$this->session->userdata('user_status')){
        $this->login();
        }
        //$this->page_data['users'] = $this->model_verifier->get_users('user');
        $this->load->view('verifier/verifier_calendar_view',$this->page_data);
    }
    
    public function calendar_get_events() {
        if(!$this->session->userdata('user_status')){
        $this->login();
        }
        $events = $this->model_verifier->get_calendar_events();
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
        
        $this->model_verifier->insert_event($title, $start, $color);
    }
    
    
    
    
    
    
    
}