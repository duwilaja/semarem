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

    public function set_activity($petugas_id='',$activity='')
    {
        $bool = false;
        if ($petugas_id != '' && $activity != '') {
            $q = $this->db->update('petugas',['activity' => $activity],['id' => $petugas_id]);
            if ($this->db->affected_rows() > 0) {
                $bool = true;
            }
        }
        return $bool;
    }
    
    public function in($obj='')
    {
        $q = [];
        $msg = 'Object or Array is null';
        $status = 0 ;
        $id = 0;

        if ($obj != '') {
            $q = $this->db->insert($this->t, $obj);
            $id = $this->db->insert_id();
            if ($this->db->affected_rows() > 0) {
                $msg = "Success insert data";
                $status = 1;
            }else{
                $msg = "Failed insert data";
            }
        }

        return [$msg,$status,$id];
        
    }

    public function up($obj='',$where='')
    {
        $q = [];
        $msg = 'Object or Array is null';
        $status = 0 ;

        if ($obj != '' || $where != '') {
            $q = $this->db->update($this->t, $obj,$where);
            if ($this->db->affected_rows() > 0) {
                $msg = "Success update data";
                $status = 1;
            }else{
                $msg = "Failed update data";
            }
        }

        return [$msg,$status];
        
    }

}