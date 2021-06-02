<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class MPetugas extends CI_Model{
    
    private $t = 'petugas';
    public $see = '*';

    function __construct() {
      
    }
    
    public function get($arr=[])
    {
       if (!empty($arr)){
            if (!empty($arr[0]) && $arr[0] != '') 
                $this->db->select($arr[0]);
        
            if (!empty($arr[1])) 
                $this->db->where($arr[1]);
        }
        
       $this->db->join('instansi i', 'i.id = p.instansi_id', 'inner');
       $this->db->join('unit unt', 'unt.id = p.unit_id', 'inner');
       $q = $this->db->get('petugas p');
       return $q; 
    }

}