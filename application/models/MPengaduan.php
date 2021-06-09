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

    public function peng_kategori($select='',$id='')
    {
        $q = [];
        if ($id != '') {
            if($select != ''){
                $this->db->select($select);
                $q = $this->db->get_where('peng_kategori',['id' => $id]);
            }
        }

        return $q;
    }

    public function insert_pengaduan()
    {
        date_default_timezone_set("Asia/Jakarta");
        $data = array(
            'kategori_peng_id' => $this->input->post('kasus'),
            'nama_pelapor' => $this->input->post('pelapor'),
            'telp' => $this->input->post('nohp'),
            'keterangan' => $this->input->post('ket'),
            'lat' => $this->input->post('lat'),
            'lng' => $this->input->post('lng'),
            'alamat' => $this->input->post('alamat'),
            'ctddate' => date('Y-m-d'),
            'ctdtime' => date('H:i:s'),
            'ctdby' => $this->session->userdata('id'),
            'status' => 0
        );
        $this->db->insert('pengaduan',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

}