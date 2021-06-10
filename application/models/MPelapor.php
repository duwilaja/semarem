<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class MPelapor extends CI_Model{
    
    function __construct() {
      
    }
    
    public function pelapor_id($select='',$id='')
    {
        $q = [];
        if ($id != '') {
            if($select != ''){
                $this->db->select($select);
                $q = $this->db->get_where('pelapor',['id' => $id]);
            }
        }

        return $q;
    }

    public function pelapor_where($select='',$where='')
    {
        $q = [];
        if (isset($where)) {
            if($select != ''){
                $this->db->select($select);
                $q = $this->db->get_where('pelapor',$where);
            }
        }

        return $q;
    }

    public function in($arr=[])
    {
        $bool = false;
        if (!empty($arr)) {
            $arr['ctddate'] = date('Y-m-d');
            $arr['ctdtime'] = date('H:i:s');
            $q = $this->db->insert('pelapor',$arr);
            if ($this->db->affected_rows() > 0) {
                $bool = true;
            }
        }
        return $bool;
    }


}