<?php

class Task_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database(); /*Load catalogo base datos*/
    }

//public function vistaregiones(){
    public function save_task($data = array())
    {
        return $this->db->insert("ta_journal", $data);
    }

}
