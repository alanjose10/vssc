<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {
    
    function __construct() {
    parent::__construct();
        $this->load->model("model_master");
    }
    
    
    public function index() {
        //if($this->session->userdata("user_status")){                  //redirect aoutomatcally if already logged in
                                                                        //uncomment later                     
            //$this->switch_user();
            //}
        //else{
            $this->load->view('login');
        //}
    }

}



