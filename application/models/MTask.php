<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class MTask extends CI_Model{
    
    function __construct() {
      
    }
    
    public function task_assign($arr=[])
    {
       if (!empty($arr)){
            if (!empty($arr[0]) && $arr[0] != '') 
                $this->db->select($arr[0]);
        
            if (!empty($arr[1])) 
                $this->db->where($arr[1]);
        }
        
       $this->db->join('pengaduan p', 'p.id = ta.pengaduan_id', 'inner');   
       $q = $this->db->get('task_assign ta');
       return $q; 
    }

}