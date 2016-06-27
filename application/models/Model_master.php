<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_master extends CI_Model {

    function __construct() {
    parent::__construct();
        $this->initialize_database();
    }
    
    
    public function initialize_database(){
        $this->load->dbforge();
        
        //create database
        //$this->dbforge->create_database('spl_vssc', TRUE);
        
        //create user table
        if(!$this->db->table_exists('users')){
            $this->dbforge->add_field(array(
                                            'user_id' => array(
                                                                'type' => 'INT',
                                                                'auto_increment' => TRUE
                                                                    ),
                                            'user_name' => array(
                                                                'type' => 'VARCHAR',
                                                                'constraint' => '20'
                                                                    ),
                                            'name' => array(
                                                                'type' => 'VARCHAR',
                                                                'constraint' => '20'
                                                                ),
                                            'email_id' => array(
                                                                'type' => 'VARCHAR',
                                                                'constraint' => '20'
                                                                ),
                                            'password' => array(
                                                                'type' => 'VARCHAR',
                                                                'constraint' => '200'
                                                                    ),
                                            'user_type' => array(
                                                                'type' => 'VARCHAR',
                                                                'constraint' => '20'
                                                                    ),
                                            'last_active_date' => array(
                                                                        'type' => 'DATE',
                                                                            ),
                                            'join_date' => array(
                                                                'type' => 'DATE'
                                                                    )
                                                ));
            $this->dbforge->add_key('user_id', TRUE);
            $this->dbforge->create_table('users', TRUE);
        }
        
            //insert default admin
            $this->db->where('user_name', 'admin');
            $this->db->where('password', do_hash('password'));
            $query = $this->db->get('users');
            if($query->num_rows() == 0){
                $this->db->insert('users', array(
                                            'user_name' => 'admin',
                                            'name' => 'Admin',
                                            'email_id' => "",
                                            'password' => do_hash('password'),
                                            'user_type' => 'admin', 
                                            'last_active_date' => date("Y-m-d"),
                                            'join_date' => date("Y-m-d")
                                                ));
            }
        

            
            //create user_privilege table
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
            
        
        //calendar events
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
        
        //bom_list
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
        
        //bom_status
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
        
        //siv_status
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
        
        //em_master_table
        if(!$this->db->table_exists('em_master_table')){                //create em_master_table if not exists
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
            $this->dbforge->create_table('em_master_table',TRUE);
        }
        
        //fm_master_table
        if(!$this->db->table_exists('fm_master_table')){                //create em_master_table if not exists
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
            $this->dbforge->create_table('fm_master_table',TRUE);
        }
        
        //message table
        if(!$this->db->table_exists('message_details')){
            $this->dbforge->add_field(array(
                                        'msg_no' => array(
                                                            'type' => 'INT',
                                                            'auto_increment' => TRUE
                                                            ),
                                        'sender_name' => array(
                                                            'type' => 'VARCHAR',
                                                            'constraint' => '50'
                                                            ),
                                        'receiver_name' => array(
                                                            'type' => 'VARCHAR',
                                                            'constraint' => '50'                
                                                            ),
                                        'message' => array(
                                                                'type' => 'VARCHAR',
                                                                'constraint' => '200'
                                                                  ),
                                        'date' => array(
                                                            'type' => 'DATE',
                                                        
                                                        ),
                                        'time' => array(
                                                                  'type' => 'TIME',
                                                                  
                                                                    ),
                                        'status' => array(
                                                              'type' => 'VARCHAR',
                                                              'constraint' => '20',
                                                              'default' => 'unseen'
                                                                    )
                                        
                                        ));
            $this->dbforge->add_key('msg_no',TRUE);
            $this->dbforge->create_table('message_details',TRUE);    
        }
        
        //rescreens
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
            
    }      //main function
        
        
        
        
        
}   //model








