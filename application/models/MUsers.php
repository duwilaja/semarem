<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class MUsers extends CI_Model{
    
    private $t = 'ais_laka';
    public $see = '*';

    function __construct() {
      
    }
    
    public function get($select='',$id='',$where='',$groupby='')
    {
        if ($select == '') {
            $select = $this->see;
        } 
        $this->db->select($select);
        
        if ($groupby != '') {
            $this->db->group_by($groupby);
        }

        if($id != ''){
            $q = $this->db->get_where($this->t,['id' => $id]);
        }else if($where != ''){
            $this->db->where($where);
            $q = $this->db->get($this->t);
        }else{
            $q = $this->db->get($this->t);
        }
        return $q;
    }

    public function join_petugas($arr=[])
    {
       if (!empty($arr)){
            if (!empty($arr[0]) && $arr[0] != '') 
                $this->db->select($arr[0]);
        
            if (!empty($arr[1])) 
                $this->db->where($arr[1]);
        }
        
       $this->db->join('petugas p', 'p.id = u.petugas_id', 'inner');
       $this->db->join('instansi i', 'i.id = p.instansi_id', 'inner');
       $this->db->join('unit unt', 'unt.id = p.unit_id', 'inner');
       $q = $this->db->get('users u');
       return $q; 
    }

}