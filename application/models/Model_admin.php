<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_admin extends CI_Model {
    
    
    
    
    public function login() {
         $query = $this->db->get_where('users',array(
                                                "user_name" => $this->input->post('username'),
                                                "password" => do_hash($this->input->post('password')),
                                                "user_type" => "admin"
                                                ));
        if($query->num_rows() == 1){
            $row = $query->row();
            $data = array("user_status" => true, 
                         "user_id" => $row->user_id, 
                         "user_name" => $row->user_name,
                         "name" => $row->name,
                        "user_type" => $row->user_type,
                        "last_active_date" => $row->last_active_date,
                         );
            $this->session->set_userdata($data);
            return true;
            }
        return false;               
    }
    
    public function update_userdata() {
        $this->db->where('user_id',$this->session->userdata('user_id'));
        if($query = $this->db->update('users',array(
                                                'last_active_date' => date("Y-m-d")
                                                    ))){
            return true;
        }
        return false;
        
    }
    
    public function get_users($type) {
        $this->db->select('user_id, user_name, name, last_active_date, join_date');
        $query = $this->db->get_where('users', array(
                                                    "user_type" => $type,
                                                    ));
        return $query->result_array();
    }
    
    public function add_user() {
        $this->load->dbforge();
        if($this->db->insert('users', array(
                                        "user_name" => $this->input->post('username'),
                                        "name" => $this->input->post('name'),
                                        "email_id" => $this->input->post('email_id'),
                                        "password" => do_hash($this->input->post('password_1')),
                                        "user_type" => 'user',
                                        "last_active_date" => date("Y-m-d"),
                                        "join_date" => date("Y-m-d")
                                        ))){
            
            
                $this->db->select('user_id');
                $this->db->from('users');
                $this->db->where('user_name', $this->input->post('username')); 
                $this->db->where('name', $this->input->post('name')); 
                $query = $this->db->get();
                $temp = $query->row_array();
                //print_r($temp);
                if(!$this->db->table_exists('user_privileges')){
                    $fields = array(
                            'user_id' => array(
                                                    'type' => 'INT',
                                                    'auto_increment' => TRUE
                                                    ),
                            'name' => array(
                                                        'type' => 'VARCHAR',
                                                        'constraint' => '20',
                                                        
                                                        ),
                            'siv_entry' => array(
                                                        'type' => 'TINYINT',
                                                        'default' => 0
                                                        
                                                        ),
                            'bom_entry' => array(
                                                        'type' => 'TINYINT',
                                                        'default' => 0
                                                        ),
                            'bom_create' => array(
                                                        'type' => 'TINYINT',
                                                        'default' => 0
                                                        ),
                            'print_excel' => array(
                                                        'type' => 'TINYINT',
                                                        'default' => 0
                                                        ),
                            'rescreen' => array(
                                                        'type' => 'TINYINT',
                                                        'default' => 0
                                                        ),
                            'store_officer' => array(
                                                        'type' => 'TINYINT',
                                                        'default' => 0
                                                        )
                                    );
                    $this->dbforge->add_field($fields);
                    $this->dbforge->add_key('user_id',TRUE);
                    $this->dbforge->create_table('user_privileges',TRUE);
                }
                $this->db->insert('user_privileges', array(
                                                            "user_id" => $temp["user_id"],
                                                            "name" => $this->input->post('name'),
                                                            "siv_entry" => 0,
                                                            "bom_entry" => 0,
                                                            "bom_create" => 0,
                                                            "print_excel" => 0,
                                                            "rescreen" =>0,
                                                            "store_officer" =>0
                                                            ));
                
            return true;
            }
        return false;
    }
    public function remove_user($user_id){
        $this->db->where('user_id', $user_id);
        if($this->db->delete('users')){
            $this->db->where('user_id', $user_id);
            if($this->db->delete('user_privileges')){
                return true;
            }
        }
        return false;
    }
    
    public function remove_verifier($user_id){
        $this->db->where('user_id', $user_id);
        if($this->db->delete('users')){
            return true;
        }
        return false;
    }
    
    
    public function get_user_privileges(){
        $query = $this->db->get('user_privileges');
        return $query->result_array();
    }
    
    public function get_privilege($user_id){
        $query = $this->db->get_where('user_privileges', array(
                                                    "user_id" => $user_id
                                                    ));
        if($query->num_rows() == 1){
            $row = $query->row_array();
        }
        return $row;
    }
    
    public function update_privilege($user_id, $new_priv){
        $this->db->where('user_id',$user_id);
        $query = $this->db->update('user_privileges',$new_priv);
        if($query){
                    return true;
        }
        else{
            return false;
        }
    }
    
    public function add_verifier() {
        if($this->db->insert('users', array(
                                        "user_name" => $this->input->post('username'),
                                        "name" => $this->input->post('name'),
                                        "email_id" => $this->input->post('email_id'),
                                        "password" => do_hash($this->input->post('password_1')),
                                        "user_type" => 'verifier',
                                        "last_active_date" => date("Y-m-d"),
                                        "join_date" => date("Y-m-d")
                                        ))){
            return true;
            }
        return false;
    }
    
    
    
    //***************Master Inventory***************
    
    public function get_master_inventory_fields($type){
        switch($type){
            case 'em': $table_name = "em_master_table";
                        break;
            case 'fm': $table_name = "fm_master_table";
                        break;
        }
        $fields = $this->db->list_fields($table_name);
        ksort($fields);
        /*
        echo "<pre>";
        print_r($fields);
        echo "</pre>";
        */
        $new_fields = array(
                            0 => 'component_type',
                            1 => 'component_name',
                            2 => 'total'
                                );
        $len = sizeof($fields);
        for($i = 3 ; $i < $len ; $i++){
            $new_fields[] = $fields[$i];
        }

        return $new_fields;
    }
    
    public function get_master_inventory($type){
        switch($type){
            case 'em': $table_name = "em_master_table";
                        break;
            case 'fm': $table_name = "fm_master_table";
                        break;
        }
        $this->db->where('total !=', 0);
        $query = $this->db->get($table_name);
        $result = $query->result_array();
        return $result;
    }
    
    public function delete_component_from_master($type, $component_type, $component_name){
        switch($type){
            case 'em': $table_name = "em_master_table";
                        break;
            case 'fm': $table_name = "fm_master_table";
                        break;
        }
        $this->db->where('component_type', $component_type);
        $this->db->where('component_name', $component_name);
        if($this->db->delete($table_name)){
            return true;
        }
            return false;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //*****************SIV***********************
    
    public function get_issued_siv(){
        $query = $this->db->get('siv_status');
        
        return $query->result_array();
    }
    
    public function get_issued_siv_by_type($type){
        $this->db->where('siv_status', $type);
        $query = $this->db->get('siv_status');
        
        return $query->result_array();
    }
    
    public function get_siv_by_siv_no ($siv_no) {
        $query = $this->db->get_where('siv_status',array(
                                            'siv_no' => $siv_no
                                                ));
            $result = $query->row_array();
            return $result;
        
    }
    
    public function get_components_of_siv($siv_table_name)  {
        $this->db->select('component_type, component_name, date_of_expiry, component_quantity');
        $query = $this->db->get($siv_table_name);
        //print_r($query->result_array());
        return $query->result_array();
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //****************BOM******************
    
    
    
    
    public function create_bom($bom_details, $file_data, $table_name){
        $this->load->dbforge();
        if(!$this->db->table_exists('bom_list')){
            $this->dbforge->add_field(array(
                                        'bom_no' => array(
                                                            'type' => 'INT',
                                                            'auto_increment' => TRUE
                                                            ),
                                        'bom_name' => array(
                                                            'type' => 'VARCHAR',
                                                            'constraint' => '50'
                                                            ),
                                        'model_type' => array(
                                                            'type' => 'VARCHAR',
                                                            'constraint' => '50'
                                                            ),
                                        'date_of_creation' => array(
                                                            'type' => 'DATE',
                                                            
                                                            ),
                                        'created_by' => array(
                                                            'type' => 'VARCHAR',
                                                            'constraint' => '50'
                                                            )
                                            ));
            $this->dbforge->add_key('bom_no',TRUE);
            $this->dbforge->create_table('bom_list',TRUE);    
        }
        $table_name = strtolower($table_name);
        if($this->db->table_exists($table_name)){
            //echo "3";
            return false;
        }
        else{
            $fields = array(
                            'component_id' => array(
                                                    'type' => 'INT',
                                                    'auto_increment' => TRUE
                                                    ),
                            'component_type' => array(
                                                        'type' => 'VARCHAR',
                                                        'constraint' => '20',
                                                        
                                                        ),
                            'component_name' => array(
                                                        'type' => 'VARCHAR',
                                                        'constraint' => '100'
                                                        
                                                        ),
                            'component_quantity' => array(
                                                        'type' => 'INT',
                                                        'default' => 0
                                                        )
                            );
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('component_id',TRUE);
            if($this->dbforge->create_table($table_name,TRUE)){
                //$this->db->set($file_data);
                //print_r($file_data);
                if($this->db->insert_batch($table_name,$file_data)){
                    if($this->db->insert('bom_list',$bom_details)) {
                        //echo "1";
                        return true;
                    } 
                }
            }

              //echo "2";
                return false;
            
        }
     
        
    }
    
    public function get_uploaded_boms(){
        $query = $this->db->get('bom_list');
        return $query->result_array();
    }
    
    public function get_components_of_uploaded_bom($bom_table_name) {
        $query = $this->db->get($bom_table_name);
        //print_r($query->result_array());
        $results = $query->result_array();
       // print_r ($results);
        return $results;
    }
    
    public function get_bom_by_bom_no ($bom_no) {
        $query = $this->db->get_where('bom_list',array(
                                            'bom_no' => $bom_no
                                                ));
        $result = $query->row_array();
        return $result;
    }
    
    public function get_assembled_bom_by_bom_no ($bom_no) {
        $query = $this->db->get_where('bom_status',array(
                                            'bom_no' => $bom_no
                                                ));
        $result = $query->row_array();
        return $result;
    }
    
    
    
    public function get_components_of_bom($bom_table_name)  {                                   //save as excel for rejected and pending
        $this->db->select('component_type, component_name, required_quantity');
        $this->db->where('required_quantity !=', 0);
        $query = $this->db->get($bom_table_name);
        //print_r($query->result_array());
        $results = $query->result_array();
       // print_r ($results);
        return $results;
    }
    
    public function get_components_of_bom_approved($bom_table_name)  {                          //save as excel for approved new
        $this->db->select('component_type, component_name, required_quantity, issued_quantity');
        $this->db->where('required_quantity !=', 0);
        $query = $this->db->get($bom_table_name);
        //print_r($query->result_array());
        $results = $query->result_array();
       // print_r ($results);
        return $results;
    
    }
    
    public function delete_uploaded_bom($bom_no){
        $this->load->dbforge();
        $this->db->select('bom_name, model_type');
        $this->db->where('bom_no',$bom_no);
        $query = $this->db->get('bom_list');
        $result = $query->row_array();
        //print_r($result);
        $table_name = strtolower("bom_".$result['bom_name']."_".$result['model_type']);
        //echo $table_name;
        if($this->db->delete('bom_list',array(
                                            'bom_no' => $bom_no
                                            ))){
            if($this->dbforge->drop_table($table_name)){
                return true;
            }
        }
    return false;
    }
    
    public function get_assembled_bom(){
        $query = $this->db->get('bom_status');
        return $query->result_array();
    }
    
    public function get_assembled_bom_by_type($type){
        $this->db->where('bom_status', $type);
        $query = $this->db->get('bom_status');
        return $query->result_array();
    }
    
    public function get_assembled_bom_details($bom_no){
        $query = $this->db->get_where('bom_status', array(
                                                            'bom_no' => $bom_no
                                                            ));
        $result = $query->row_array();
        return $result;
    }
    
    public function get_assembled_bom_components($table_name) {
        $query = $this->db->get($table_name);
        //print_r($query->result_array());
        return $query->result_array();
    }
    
    public function delete_assembled_bom($bom_no){
        $this->load->dbforge();
        $this->db->select('table_name');
        $this->db->where('bom_no',$bom_no);
        $query = $this->db->get('bom_status');
        $result = $query->row_array();
        //print_r($result);
        $table_name = $result['table_name'];
        //echo $table_name;
        if($this->db->delete('bom_status',array(
                                            'bom_no' => $bom_no
                                            ))){
            if($this->dbforge->drop_table($table_name)){
                return true;
            }
        }
    return false;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //************CALENDAR************
    
    
    public function insert_dropped_calendar_event($event_data) {
        if(!$this->db->table_exists('calendar_events')){
            $this->load->dbforge();
                    $fields = array(
                            'event_id' => array(
                                                    'type' => 'INT',
                                                    'auto_increment' => TRUE
                                                    ),
                            'user' => array(
                                                    'type' => 'VARCHAR',
                                                    'constraint' => '20',
                                                    'default' => 'general'
                                                    ),
                            'title' => array(
                                                        'type' => 'VARCHAR',
                                                        'constraint' => '50',
                                                        
                                                        ),
                            'start' => array(
                                                        'type' => 'DATE',
                                                        
                                                        ),
                            'color' => array(
                                                        'type' => 'VARCHAR',
                                                        'constraint' => '50',
                                                        )
                            
                                    );
                    $this->dbforge->add_field($fields);
                    $this->dbforge->add_key('event_id',TRUE);
                    $this->dbforge->create_table('calendar_events',TRUE);
                }
        $this->db->insert('calendar_events', array(
                                                    "user" => $event_data["user"],
                                                    "title" => $event_data["title"],
                                                    "start" => $event_data["start"],
                                                    "color" => $event_data["color"]
                                                    ));
 
    }
    
    public function get_calendar_events() {
        $this->db->select('user, title, start, color');
        $query = $this->db->get('calendar_events');
        $result = $query->result();
        return $result;
    }
    
    public function insert_event($title, $start, $color) {
        if(!$this->db->table_exists('calendar_events')){
            $this->load->dbforge();
                    $fields = array(
                            'event_id' => array(
                                                    'type' => 'INT',
                                                    'auto_increment' => TRUE
                                                    ),
                            'user' => array(
                                                    'type' => 'VARCHAR',
                                                    'constraint' => '20',
                                                    'default' => 'general'
                                                    ),
                            'title' => array(
                                                        'type' => 'VARCHAR',
                                                        'constraint' => '50',
                                                        
                                                        ),
                            'start' => array(
                                                        'type' => 'DATE',
                                                        
                                                        ),
                            'color' => array(
                                                        'type' => 'VARCHAR',
                                                        'constraint' => '50',
                                                        )
                            
                                    );
                    $this->dbforge->add_field($fields);
                    $this->dbforge->add_key('event_id',TRUE);
                    $this->dbforge->create_table('calendar_events',TRUE);
                }
        $this->db->insert('calendar_events', array(
                                                    "title" => $title,
                                                    "start" => $start,
                                                    "color" => $color
                                                    ));
        
        
        
    }
    
    
    
    //*********************MESSAGES********************
    
    
    public function get_message_by_sender_name_receiver_name ($sender_name, $receiver_name) {              //message new
        
        $this->db->order_by('msg_no', 'DESC');
        $this->db->select('sender_name, receiver_name, message, date, time, status');
        $this->db->where("(sender_name = '$sender_name' AND receiver_name = '$receiver_name')
                    OR (sender_name = '$receiver_name' AND receiver_name = '$sender_name')");
                               
        $query = $this->db->get('message_details');
        $result = $query->result_array();
         $row_count = $query->num_rows();
        //if($sender_name == array_column[$result, 'receiver_name'])
        for($x=0; $x<$row_count; $x++) {
            if($sender_name == $result[$x]['receiver_name']) {
        $this->db->where("(sender_name = '$receiver_name' AND receiver_name = '$sender_name')");
        $this->db->update('message_details', array(
                                            'status' => 'seen'
                                            ));
                        
            }
        }
        //print_r($result);
        return $result;
         
      }
   
    public function get_all_user_names(){                                                       //message new
        $sender_name = $this->session->userdata('user_name');
        //$this->db->select('user_name');
        $this->db->distinct('user_name');
        $this->db->where("(user_name != '$sender_name')");
        $query = $this->db->get('users');
        $result = $query->result_array();
        //print_r($result);
        return $result;  
    }
    
    public function insert_message($sender_name, $receiver_name, $message){                         //message new

        date_default_timezone_set('asia/kolkata');
        //$date = date('m/d/Y h:i:s a', time());
        //date_default_timezone_set("America/New_York");
        $time=date("h:i:sa");
        $date = date("Y/m/d");
        $this->db->set('sender_name', $sender_name);
        $this->db->set('receiver_name', $receiver_name);
        $this->db->set('message', $message);
        //echo ($message);
        $this->db->set('time', $time);
        $this->db->set('date', $date);
        $this->db->set('status', "unseen");
        $this->db->insert('message_details');
        
        
    }
    
    public function get_message_count(){
        $sender_name = $this->session->userdata('user_name');
        $this->db->order_by('msg_no', 'DESC');
        $this->db->distinct();
        $this->db->select('sender_name');//, message, date, time, status
        $this->db->where("(receiver_name = '$sender_name' AND status = 'unseen')");
        $query = $this->db->get('message_details');
        $row_count = $query->num_rows();
        $result = $row_count;
        
        //$result['count'] = $row_count; 
        //$row_count = $query->num_rows();
        //print_r($result);
        return $result;
        
    }
    
    public function get_message_notification_details(){
        $sender_name = $this->session->userdata('user_name');
        $this->db->order_by('msg_no', 'DESC');
        $this->db->distinct();
        $this->db->select('sender_name');//, message, date, time, status
        $this->db->where("(receiver_name = '$sender_name' AND status = 'unseen')");
        $query = $this->db->get('message_details');
        //$row_count = $query->num_rows();
        $result = $query->result_array();
        
       // $result['count'] = $row_count; 
        //$row_count = $query->num_rows();
        //print_r($result);
        return $result;
        
    }
    
    
    
    //************DASHBOARD****************
    
    public function get_no_of_siv($type){
        $this->db->where('siv_status', $type);
        $query = $this->db->get('siv_status');
        $result = $query->num_rows();
        return $result;
    }
    
    public function get_no_of_bom($type){
        $this->db->where('bom_status', $type);
        $query = $this->db->get('bom_status');
        $result = $query->num_rows();
        return $result;
    }
    
    public function get_no_of_uploaded_bom(){
        $query = $this->db->get('bom_list');
        $result = $query->num_rows();
        return $result;
    }
    
    public function get_no_of_calendar_events(){
        $this->db->where('user', 'general');
        $query = $this->db->get('calendar_events');
        $result = $query->num_rows();
        return $result;
    }
    
    public function get_no_of_components_to_expire_in_3($type){
        switch($type){
            case 'em': $table_name = "em_master_table";
                        break;
            case 'fm': $table_name = "fm_master_table";
                        break;
        }
        $fields = $this->db->list_fields($table_name);
        sort($fields);
        $len = sizeof($fields);
        for($i = 0; $i < $len-3; $i++){
            $dates[] = $fields[$i];
        }
        $query = $this->db->get($table_name);
        $result = $query->result_array();
        $count = 0;
        $three_months = date('Y-m-d', time() + (86400 * 90));
        foreach($result as $row){
            foreach($dates as $date){
                if(($date < $three_months) && $row[$date] > 0){
                    //echo $date;
                    $count++;
                }
            }
        
        }
        return $count;
    }
    
    
    
    
    
    
    
}