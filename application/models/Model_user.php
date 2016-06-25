<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_user extends CI_Model {
    
    public function login() {
        $query = $this->db->get_where('users',array(
                                                "user_name" => $this->input->post('username'),
                                                "password" => do_hash($this->input->post('password')),
                                                "user_type" => "user"
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
    
    public function get_user_privileges() {
        $this->db->select('siv_entry, bom_entry, bom_create, print_excel, rescreen, store_officer');
        $this->db->where('user_id',$this->session->userdata('user_id'));
        $query = $this->db->get('user_privileges');
        if($query->num_rows() == 1){
            $row = $query->row();
            $data = array(
                            'siv_entry' => $row->siv_entry,
                            'bom_entry' => $row->bom_entry,
                            'bom_create' => $row->bom_create,
                            'print_excel' => $row->print_excel,
                            'rescreen' => $row->rescreen,
                            'store_officer' => $row->store_officer
                            );
            $this->session->set_userdata($data);
        }
    }
    
    
    
    
    
    
    
    //****************SIV**********************
    
    
    
    
    
    
    
    
    
    
    public function get_all_component_names() {
        if(!$this->db->table_exists('component_names')){
            $this->load->dbforge();
            $this->dbforge->add_field(array(
                                                'component_name' => array(
                                                                            'type' => 'VARCHAR',
                                                                            'constraint' => '50'
                                                                            
                                                                            )
                                                ));
            $this->dbforge->add_key('component_name',TRUE);
            $this->dbforge->create_table('component_names',TRUE);
            $this->db->query('ALTER TABLE component_names ADD UNIQUE (component_name)');
        }
        $this->db->select('component_name');
        $this->db->distinct('component_name');
        $query = $this->db->get('component_names');
        $result = $query->result_array();
        //print_r($result);
        return $result;
    }
    
    public function get_all_component_types() {
        if(!$this->db->table_exists('component_types')){
            $this->load->dbforge();
            $this->dbforge->add_field(array(
                                                'component_type' => array(
                                                                            'type' => 'VARCHAR',
                                                                            'constraint' => '50'
                                                                            
                                                                            )
                                                ));
            $this->dbforge->add_key('component_type',TRUE);
            $this->dbforge->create_table('component_types',TRUE);
            $this->db->query('ALTER TABLE component_types ADD UNIQUE (component_type)');
        }
        $this->db->select('component_type');
        $this->db->distinct('component_type');
        $query = $this->db->get('component_types');
        $result = $query->result_array();
        //print_r($result);
        return $result;
    }
    
    
    public function enter_new_siv($siv_data, $component_details) {
        $this->load->dbforge();
        if(!$this->db->table_exists('siv_status')){
            $fields = array(
                            'siv_no' => array(
                                                    'type' => 'INT',
                                                    ),
                            'siv_grade' => array(
                                                        'type' => 'VARCHAR',
                                                        'constraint' => '20',
                                                        
                                                        ),
                            'date_of_issue' => array(
                                                        'type' => 'DATE',
                                                        
                                                        ),
                            'no_of_components' => array(
                                                        'type' => 'INT',
                                                        'default' => 0
                                                        ),
                            'siv_status' => array(
                                                        'type' => 'VARCHAR',
                                                        'constraint' => '20',
                                                        'default' => 'PENDING_APPROVAL'
                                                        ),
                            'entered_by' => array(
                                                        'type' => 'VARCHAR',
                                                        'constraint' => '30'
                                                        ),
                            'table_name' => array(
                                                        'type' => 'VARCHAR',
                                                        'constraint' => '50'
                                                        )
                            );
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('siv_no',TRUE);
            $this->dbforge->create_table('siv_status',TRUE);
        }
        $siv_data['date_of_issue'] = preg_replace("!([0123][0-9])/([0-9]{2})/([0-9]{4})!", "$3-$2-$1", $siv_data['date_of_issue']);
        // change date format from dd/mm/yyyy to yyyy-mm-dd
        $siv_data['table_name'] = strtolower("siv_#".$siv_data['siv_no']."_".$siv_data['siv_grade']."_".$siv_data['date_of_issue']."_".$siv_data['no_of_components']."_".$siv_data['entered_by']);
        if($this->db->insert('siv_status',$siv_data)){
                //crete table for the siv
                
                $fields = array(
                                    'component_type' => array(
                                                            'type' => 'VARCHAR',
                                                            'constraint' => '10'
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
                                                                'default' => 0
                                                                )
                            /*      'unit' => array(
                                                                'type' => 'INT',
                                                                )       */
                                    );

                // echo $table_name;
                $this->dbforge->add_field($fields);
                $this->dbforge->add_key('component_name',TRUE);
                $this->dbforge->add_key('date_of_expiry',TRUE);     //composite primary key
                $this->dbforge->create_table($siv_data['table_name'],TRUE);
                if($this->db->insert_batch($siv_data['table_name'], $component_details)){
                    return true;
                }
        }
    return false;  
    }
    
    
    public function get_issued_siv(){
        $query = $this->db->get_where('siv_status',array(
                                                'entered_by' => $this->session->userdata('user_name')
                                                ));
        
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
    
   public function delete_issued_siv($siv_no, $siv_table_name){
        $this->load->dbforge();
       $this->db->where('siv_no', $siv_no);
       //$this->db->where("('siv_status' LIKE 'INCOMPLETE') OR ('siv_status' LIKE 'PENDING APPROVAL')");
       $this->db->group_start();
       $this->db->or_where('siv_status', "INCOMPLETE");
       $this->db->or_where('siv_status', "PENDING_APPROVAL");
       $this->db->group_end();
        if($this->db->delete('siv_status')){
            if($this->dbforge->drop_table($siv_table_name)){
                return true;
            }
        }
       else {
           return false;
       }
    
    }
    
    public function update_datalist($component_type, $component_name){
        //print_r($component_type);
        //print_r($component_name);
        foreach($component_type as $row){
            //echo $row;
            $this->db->query("INSERT IGNORE INTO component_types (component_type) VALUES ('$row')");
        }
        foreach($component_name as $row){
            //echo $row;
            $this->db->query("INSERT IGNORE INTO component_names (component_name) VALUES ('$row')");
        }
        
    }
    
    
    public function check_unique_siv($siv_no)   {
        $this->db->where('siv_no', $siv_no);
        $query = $this->db->get('siv_status');
        if(!$query->num_rows()){
            return true;
        }
        else{
            return false;
        }
        
    }
   
    
    
    
    
    
    
    //**********BOM***************
    
    
    
    
    
    
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
    
    public function get_bom_by_bom_no ($bom_no) {
        $query = $this->db->get_where('bom_list',array(
                                            'bom_no' => $bom_no
                                                ));
        $result = $query->row_array();
        return $result;
    }
    
    public function get_components_of_bom($bom_table_name)  {
        $this->db->select('component_id, component_type, component_name, component_quantity');
        $this->db->where('component_quantity !=', 0);
        $query = $this->db->get($bom_table_name);
        //print_r($query->result_array());
        return $query->result_array();
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
    
    
    public function enter_new_bom($bom_details, $component_details) {
        $bom_details['date_of_assembly'] = preg_replace("!([0123][0-9])/([0-9]{2})/([0-9]{4})!", "$3-$2-$1", $bom_details['date_of_assembly']);
        $table_name = strtolower($bom_details['bom_name']."_".$bom_details['model_grade']."_".$bom_details['bom_model_no']."_".$bom_details['date_of_assembly']."_".$bom_details['no_of_components']);
        $bom_details['assembled_by'] = $this->session->userdata('user_name');
        $bom_details['table_name'] = $table_name;
        $bom_details['bom_status'] = 'PENDING_APPROVAL';
        //echo $table_name;
        //print_r($bom_details);
        $this->load->dbforge();
        if(!$this->db->table_exists('bom_status')){
            $this->dbforge->add_field(array(
                                        'bom_no' => array(
                                                            'type' => 'INT',
                                                            'auto_increment' => TRUE
                                                            ),
                                        'bom_name' => array(
                                                            'type' => 'VARCHAR',
                                                            'constraint' => '50'
                                                            ),
                                        'model_grade' => array(
                                                            'type' => 'VARCHAR',
                                                            'constraint' => '50'
                                                            ),
                                        'bom_model_no' => array(
                                                            'type' => 'VARCHAR',
                                                            'constraint' => '50'
                                                            ),
                                        'date_of_assembly' => array(
                                                            'type' => 'DATE',
                                                            
                                                            ),
                                        'assembled_by' => array(
                                                            'type' => 'VARCHAR',
                                                            'constraint' => '50'
                                                            ),
                                        'no_of_components' => array(
                                                            'type' => 'INT',
                                                            ),
                                        'table_name' => array(
                                                            'type' => 'VARCHAR',
                                                            'constraint' => '50'
                                                            ),
                                        'bom_status' => array(
                                                            'type' => 'VARCHAR',
                                                            'constraint' => '50',
                                                            'default' => 'INCOMPLETE'
                                                            )
                                            ));
            $this->dbforge->add_key('bom_no',TRUE);
            $this->dbforge->create_table('bom_status',TRUE);    
        }
        if(!$this->db->table_exists($table_name)){
            $fields = array(
                            'component_type' => array(
                                                        'type' => 'VARCHAR',
                                                        'constraint' => '20',
                                                        
                                                        ),
                            'component_name' => array(
                                                        'type' => 'VARCHAR',
                                                        'constraint' => '100'
                                                        
                                                        ),
                            'required_quantity' => array(
                                                        'type' => 'INT',
                                                        'default' => 0
                                                        )
                            );
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('component_type',TRUE); 
            $this->dbforge->add_key('component_name',TRUE); 
            if($this->dbforge->create_table($table_name,TRUE)){
                //$this->db->set($file_data);
                //print_r($file_data);
                if($this->db->insert_batch($table_name,$component_details)){
                    if($this->db->insert('bom_status',$bom_details)) {
                        //echo "1";
                        return true;
                    } 
                }
            }
        }
        else{
            return false;
        }
        
    }
    
    
    public function get_assembled_bom(){
        $query = $this->db->get_where('bom_status',array(
                                                'assembled_by' => $this->session->userdata('user_name')
                                                ));
        
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
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //************CALENDAR**************
    
    
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
        $this->db->or_where('user', "general");
        $this->db->or_where('user', $this->session->userdata('user_name'));
        $this->db->group_end();
        $query = $this->db->get('calendar_events');
        $result = $query->result();
        return $result;
    }
    
    
    
}