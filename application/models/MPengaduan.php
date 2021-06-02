<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class MPengaduan extends CI_Model{
    
    function __construct() {
      
    }
    
    public function peng_img_peng_id($select='',$pengaduan_id='')
    {
        $q = [];
        if ($pengaduan_id != '') {
            if($select != ''){
                $this->db->select($select);
                $q = $this->db->get_where('peng_img',['pengaduan_id' => $pengaduan_id]);
            }
        }

        return $q;
    }

    public function peng_img_id($select='',$id='')
    {
        $q = [];
        if ($id != '') {
            if($select != ''){
                $this->db->select($select);
                $q = $this->db->get_where('peng_img',['id' => $id]);
            }
        }

        return $q;
    }

}