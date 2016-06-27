<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_verifier extends CI_Model {
    
    public function login() {
         $query = $this->db->get_where('users',array(
                                                "user_name" => $this->input->post('username'),
                                                "password" => do_hash($this->input->post('password')),
                                                "user_type" => "verifier"
                                                ));
        if($query->num_rows() == 1){
            $row = $query->row();
            $data = array("user_status" => true, 
                         "user_id" => $row->user_id, 
                         "user_name" => $row->user_name,
                         "name" => $row->name,
                        "user_type" => $row->user_type,
                        "last_active_date" => $row->last_active_date
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
    
    
    
    
    
    //*************SIV*******************
    
     public function get_issued_siv($type){
         if($type == 'ALL'){
             $query = $this->db->get('siv_status');
         }
         else{
             $query = $this->db->get_where('siv_status',array(
                                                'siv_status' => $type
                                                ));
         }
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
    
    
    
    public function insert_approved_siv($siv_details, $component_details){
        $this->load->dbforge();
        switch($siv_details['siv_grade']){
            case "EM" : $table_name = 'em_master_table';
                        break;
            case "FM" : $table_name = 'fm_master_table';
                        break;
        }
        if(!$this->db->table_exists($table_name)){                //create em_master_table if not exists
            $this->dbforge->add_field(array(
                                                'component_type' => array(
                                                                            'type' => 'VARCHAR',
                                                                            'constraint' => '50'
                                                                            
                                                                            ),
                                                'component_name' => array(
                                                                            'type' => 'VARCHAR',
                                                                            'constraint' => '100'
                                                                            
                                                                            ),
                                                'total' => array(
                                                                            'type' => 'INT',
                                                                            'default' => '0'
                                                                            )
                                                ));
            $this->dbforge->add_key('component_type',TRUE);
            $this->dbforge->add_key('component_name',TRUE);
            $this->dbforge->create_table($table_name,TRUE);
        }
        $dates = array_column($component_details, 'date_of_expiry');            //  }
        $dates = array_unique($dates);                                          //  }   get array of distinct dates
        $dates = array_values($dates);                                          //  }
        //print_r($dates);
        foreach($dates as $row){
            if(!$this->db->field_exists($row, $table_name)){
                $this->dbforge->add_column($table_name, array(
                                                                    $row => array(
                                                                                                    'type' =>'INT',
                                                                                                    'default' => '0'
                                                                                                    )
                                                                        ));
            }
        }
        foreach($component_details as $row) {
            $component_type = $row['component_type'];
            $component_name = $row['component_name'];
            $this->db->query("INSERT IGNORE INTO $table_name (component_type, component_name) VALUES ('$component_type', '$component_name')");
        }
        foreach($component_details as $row){
            $this->db->where('component_type', $row["component_type"]);
            $this->db->where('component_name', $row["component_name"]);
            $query = $this->db->get($table_name);
            $result = $query->row_array();
            $total = $result["total"] + $row["component_quantity"];
            $temp = $result[$row["date_of_expiry"]] + $row["component_quantity"];
            $this->db->set('total', $total);
            $this->db->set($row["date_of_expiry"], $temp);
            $this->db->where('component_type', $row["component_type"]);
            $this->db->where('component_name', $row["component_name"]);
            $this->db->update($table_name);
        }
        return true;
    }
    
    
    
    
    

    
    public function change_siv_status($siv_no, $new_status) {
        $this->db->set('siv_status', $new_status);
        $this->db->where('siv_no', $siv_no);
        if($this->db->update('siv_status')){
            return true;
        }
        else{
            return false;
        }
    }
    
    public function get_no_of_siv($type){
        $this->db->where('siv_status', $type);
        $query = $this->db->get('siv_status');
        $result = $query->num_rows();
        return $result;
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //^^^^^^^^^^^^^^^BOM*****************
    
    public function get_assembled_bom($type){
        if($type == 'ALL'){
            $query = $this->db->get('bom_status');
        }
        else{
            $query = $this->db->get_where('bom_status',array(
                                                'bom_status' => $type
                                                ));
        }
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
    
    public function get_bom_by_bom_no ($bom_no) {
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
    
    public function reserve_approved_bom($bom_details, $component_details)  {
        switch($bom_details['model_grade']){
            case 'EM': $table_name = 'em_master_table';
                        break;
            case 'FM': $table_name = 'fm_master_table';
                        break;
        }
        $new_row = array();             //new!!!!!!!!!!!!!!!!!!!
        //$back_track = array();  //store dates for backtracking components to respective dates
        $new_db = array();
        //$new_component_details = array();
        foreach($component_details as $row){
            $new_component_details_row = array(
                                                'component_type' => $row['component_type'],
                                                'component_name' => $row['component_name'],
                                                'required_quantity' => $row['required_quantity']
                                                    );
            //print_r($row);
            $req = $row['required_quantity'];
            $this->db->where('component_type', $row['component_type']);
            $this->db->where('component_name', $row['component_name']);
            $query = $this->db->get($table_name);
            if($query->num_rows() == 1){
                $result = $query->row_array();
                //print_r($result);
                $new_row = array(
                                            'component_type' => $result['component_type'],
                                            'component_name' => $result['component_name']
                                            );      //new array to be inserted to db
                /*
                $back_track_row = array(
                                        'component_type' => $result['component_type'],
                                        'component_name' => $result['component_name']
                                            );      // array for backtrack 
                                            */
                ksort($result); //keysort array
                $len = sizeof($result) - 3; //exclude 'type', 'name', 'total' fields
                $keys = array_keys($result);
                if($req <= $result['total']){   //required quantity or more is present in inventory
                    $new_component_details_row['issued_quantity'] = $req;    //required quantity is issued.
                    
                    $new_row['total'] = $result['total'] - $req;
                    
                    //print_r($keys);
                    for($i = 0 ; $i < $len ; $i++){
                        
                        if($req == 0){
                            $new_row[$keys[$i]] = $result[$keys[$i]];
                        }
                        else{
                            if(($req >= $result[$keys[$i]]) && ($req != 0)){
                                $new_row[$keys[$i]] = 0;
                                $req = $req - $result[$keys[$i]];
                                if($result[$keys[$i]] > 0){
                                    $new_component_details_row[$keys[$i]] = $result[$keys[$i]];    //back track to date
                                }
                            }
                            else if(($req < $result[$keys[$i]]) && ($req != 0)){
                                $new_row[$keys[$i]] = $result[$keys[$i]] - $req;
                                if($req > 0){
                                    $new_component_details_row[$keys[$i]] = $req;    //back track to date
                                }
                                $req = 0;
                            }
                        }
                        
                    }   //len loop end
                    //print_r($new_row);
                }
                else {
                    //req quantity is not there in inventory
                    $new_component_details_row['issued_quantity'] = $result['total'];
                    $new_row['total'] = 0;
                    for($i = 0 ; $i < $len ; $i++){
                        $new_row[$keys[$i]] = 0;
                        if($result[$keys[$i]] > 0){
                            $new_component_details_row[$keys[$i]] = $result[$keys[$i]];
                        }
                    }
                }
                
                $new_db[] = $new_row;       //store row of new db values
            }
            else{
                //component does not exist in inventory
                $new_component_details_row['issued_quantity'] = 0;        //0 quantity is issued.
            }
            $new_component_details[] = $new_component_details_row;
            
            //$back_track[] = $back_track_row;    //store each row to backtrack array
        }   //main loop
        /*
        print "<pre>";
        print_r($new_component_details);
        print "</pre>";
        
        print "<pre>";
        print_r($new_db);
        print "</pre>";
        */
        if($this->update_master($new_db, $table_name)){
            if($this->replace_table($bom_details, $new_component_details)){
                return true;
            }
        }
    }   //function end
    
    public function update_master($new_db, $table_name){
        /*
        print "<pre>";
        print_r($table_name);
        print "</pre>";
        
        print "<pre>";
        print_r($new_db);
        print "</pre>";
        */
        foreach($new_db as $row){
            $flag = 0;
            $this->db->where('component_type', $row['component_type']);
            $this->db->where('component_name', $row['component_name']);
            $this->db->update($table_name, $row);
        }
        return true;
    }
    
    public function replace_table($bom_details, $new_component_details){
        $dates = array();
        foreach($new_component_details as $row){
            $keys = array_keys($row);
            ksort($keys);
            //print "<pre>";
            //print_r($keys);
            //print "</pre>";
            $len = sizeof($keys);
            for($i = $len-1 ; $i > 3 ; $i--){
                $dates[] = $keys[$i];
            }
        }
        $dates = array_unique($dates);
        //print "<pre>";
        //print_r($dates);
        //print "</pre>";
        $this->load->dbforge();
        //echo $bom_details['table_name'];
        
        if($this->dbforge->drop_table($bom_details['table_name'])){
            $fields = array(
                            'component_type' => array(
                                                        'type' => 'VARCHAR',
                                                        'constraint' => '20'
                                                        ),
                            'component_name' => array(
                                                        'type' => 'VARCHAR',
                                                        'constraint' => '100'
                                                        
                                                        ),
                            'required_quantity' => array(
                                                        'type' => 'INT',
                                                        'default' => 0
                                                        ),
                            'issued_quantity' => array(
                                                        'type' => 'INT',
                                                        'default' => 0
                                                        )
                            );
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('component_type',TRUE); 
            $this->dbforge->add_key('component_name',TRUE); 
            if($this->dbforge->create_table($bom_details['table_name'],TRUE)){
                foreach($dates as $date){
                    if(!$this->db->field_exists($date, $bom_details['table_name'])){
                        $this->dbforge->add_column($bom_details['table_name'], array(
                                                                            $date => array(
                                                                                                            'type' =>'INT',
                                                                                                            'default' => '0'
                                                                                                            )
                                                                                ));
                    }
                }
                //$this->db->set($new_component_details);
                //var_dump($new_component_details);
                foreach($new_component_details as $row){
                    $this->db->insert($bom_details['table_name'], $row);
                }
                    
            }
            return true;
        }   //replaced table
        
        
        
    }
    
    public function change_bom_status($bom_no, $new_status) {
        $this->db->set('bom_status', $new_status);
        $this->db->where('bom_no', $bom_no);
        if($this->db->update('bom_status')){
            return true;
        }
        else{
            return false;
        }
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
    
    
    
    //**************CALENDAR******************
    
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
    
    public function get_calendar_events() {
        $this->db->select('user, title, start, color');
        $this->db->group_start();
        $this->db->where('user', "general");
        $this->db->or_where('user', $this->session->userdata('user_name'));
        $this->db->group_end();
        $query = $this->db->get('calendar_events');
        $result = $query->result();
        foreach($result as $event){
            $this->db->set('flag', 0);
            $this->db->where('event_id', $event['event_id']);
            $this->db->update('calendar_events');
        }
        return $result;
    }
    
    public function get_no_of_calendar_events(){
        $this->db->where('user', 'general');
        $this->db->or_where('user', $this->session->userdata('user_name'));
        $query = $this->db->get('calendar_events');
        $result = $query->num_rows();
        return $result;
    }
    
    
    
    
    
    //*************MASTER INVENTORY****************
    
    
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
    
    
    
    
    
    
    
    
    
    //******************RESCREEN******************
    
    
    public function get_components_for_rescreen($type){
        switch($type){
            case 'EM': $master_table_name = "em_master_table";
                        break;
            case 'FM': $master_table_name = "fm_master_table";
                        break;
        }
        $date = date('Y-m-d', time() + (86400 * 90));       //date after 3 months
        $query = $this->db->get($master_table_name);
        $result = $query->result_array();

        $rescreen_array = array();
        $fields = $this->db->list_fields($master_table_name);
        sort($fields);

        
        foreach($fields as $field){
            if($field < $date){
                $dates[] = $field;
            }
        }

        foreach($result as $row){
            foreach($dates as $date){
                if($row[$date] > 0){
                    $rescreen_array_row = array(
                                                'grade' => $type,
                                                'component_type' => $row['component_type'],
                                                'component_name' => $row['component_name'],
                                                'date_of_expiry' => $date,
                                                'component_quantity' => $row[$date]
                                                    );
                    $rescreen_array[] = $rescreen_array_row;
                }
            }
        }

        return $rescreen_array;
        
    }
    
    
    public function send_for_rescreen($rescreen_array){
        if(!$this->db->table_exists('rescreens')){
            $this->load->dbforge();
                    $fields = array(
                            'rescreen_id' => array(
                                                    'type' => 'INT',
                                                    'auto_increment' => TRUE
                                                    ),
                            'grade' => array(
                                                        'type' => 'VARCHAR',
                                                        'constraint' => '10'
                                                        
                                                        ),
                            'component_type' => array(
                                                        'type' => 'VARCHAR',
                                                        'constraint' => '20'
                                                        
                                                        ),
                            'component_name' => array(
                                                        'type' => 'VARCHAR',
                                                        'constraint' => '100',
                                                        ),
                            'date_of_expiry' => array(
                                                        'type' => 'DATE',
                                                        ),
                            'component_quantity' => array(
                                                        'type' => 'INT',
                                                        ),
                            'assigned_user' => array(
                                                        'type' => 'VARCHAR',
                                                        'constraint' => '20',
                                                        ),
                            'rescreen_status' => array(
                                                        'type' => 'VARCHAR',
                                                        'constraint' => '20',
                                                        'default' => 'PENDING_RESCREEN'
                                                        )
                                    );
                    $this->dbforge->add_field($fields);
                    $this->dbforge->add_key('rescreen_id',TRUE);
                    $this->dbforge->create_table('rescreens',TRUE);
                }
        switch($rescreen_array['grade']){
            case 'EM': $master_table_name = "em_master_table";
                        break;
            case 'FM': $master_table_name = "fm_master_table";
                        break;
        }
        
        $this->db->where('component_type', $rescreen_array['component_type']);
        $this->db->where('component_name', $rescreen_array['component_name']);
        $query = $this->db->get($master_table_name);
        $result = $query->row_array();

        $total = $result['total'] - $rescreen_array['component_quantity'];
        
        $this->db->set('total', $total);
        $this->db->set($rescreen_array['date_of_expiry'], 0);
        $this->db->where('component_type', $rescreen_array['component_type']);
        $this->db->where('component_name', $rescreen_array['component_name']);
        if($this->db->update($master_table_name)){      //update_master_db
            if($this->db->insert('rescreens', $rescreen_array)){        //insert into rescreens table
                return true;
            }
        }
    }
    
    public function get_rescreens($type){
        $this->db->where('rescreen_status', $type);
        $query = $this->db->get('rescreens');
        $result = $query->result_array();
        return $result;
    }
    
    public function get_rescreen_data($rescreen_id){
        $this->db->where('rescreen_id', $rescreen_id);
        $query = $this->db->get('rescreens');
        $result = $query->row_array();
        return $result;
    }
    
    public function approve_rescreen($rescreen_id){
        $rescreen_data = $this->get_rescreen_data($rescreen_id);
        switch($rescreen_data['grade']){
            case 'EM': $master_table_name = "em_master_table";
                        break;
            case 'FM': $master_table_name = "fm_master_table";
                        break;
        }
        
        if(!$this->db->field_exists($rescreen_data['date_of_expiry'], $master_table_name)){
            $this->load->dbforge();
            $this->dbforge->add_column($master_table_name, array(
                                                                $rescreen_data['date_of_expiry'] => array(
                                                                                                        'type' =>'INT',
                                                                                                        'default' => '0'
                                                                                                        )
                                                                    ));
        }
        
        $this->db->where('component_type', $rescreen_data['component_type']);
        $this->db->where('component_name', $rescreen_data['component_name']);
        $query = $this->db->get($master_table_name);
        $result = $query->row_array();
        $total = $result['total'] + $rescreen_data['component_quantity'];
        $date = $result[$rescreen_data['date_of_expiry']] + $rescreen_data['component_quantity'];
        $this->db->set('total', $total);
        $this->db->set($rescreen_data['date_of_expiry'], $date);
        $this->db->where('component_type', $rescreen_data['component_type']);
        $this->db->where('component_name', $rescreen_data['component_name']);
        if($this->db->update($master_table_name)){
            $this->db->set('rescreen_status', 'RESCREEN_APPROVED');
            $this->db->where('rescreen_id', $rescreen_id);
            if($this->db->update('rescreens')){
                return true;
            }
        }
        return false;
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
    
    
    
    
    
    
    
    
    
    
}