<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_lokasi extends CI_Controller {
	
	public function __construct()
    {
		parent::__construct();
		$this->load->model('MLokasi','ml');
	}

    private function token()
    {
        $token = @getallheaders()['Token'];

        if (!$token) {
            # jika array kosong, dia akan melempar objek Exception baru
            throw new Exception('Header Token tidak terdeteksi');
        }

        return $token;
    }

    private function header($method="POST")
    {
        header("Content-Type: application/json; charset=UTF-8");
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: ".$method);
        header("Access-Control-Allow-Headers: Content-Type, Token");

        return true;
    }

    private function cek_token()
    {
        $bool = false;
        $q = $this->db->get_where('token', ['token' => $this->token(),'aktif' => 1]);
        if ($q->num_rows() > 0) 
            $bool = true;

        return $bool;
    }

    public function get()
    {
        $this->header();
        $id = $this->input->get('id');
        $priority = $this->input->get('priority');
        if ($id != '') {
            $q = $this->ml->get([['p.id','lat','lng','nama_petugas','hp','activity','nama_instansi','unit','p.instansi_id','p.unit_id'],['p.aktif' => 1,'p.id' => $id]])->result();
        }else{
            $q = $this->ml->get([['p.id','lat','lng','nama_petugas','hp','activity','nama_instansi','unit'],['p.aktif' => 1]])->result();
        }

        echo json_encode($q);
    }

    public function get_priority()
    {
        $this->header();
        $lokasi = [];
        $lokasi_pengaduan = false;
        $id = $this->input->get('id');
        
        if ($this->input->get('lokasi_pengaduan') != '') {
            $lokasi_pengaduan = explode(',',$this->input->get('lokasi_pengaduan'));
        }

        if ($id != '') {
            $lokasi = $this->ml->get([['id','nama_lokasi','lat','lng','kategori_static','deskripsi'],['priority' => 1,'id' => $id]])->result();
        }else{
            $q = $this->ml->get([['id','nama_lokasi','lat','lng','kategori_static','deskripsi'],['priority' => 1]])->result();
            foreach ($q as $v => $k) {
                $lokasi[$v] = $k;
                if ($lokasi_pengaduan) {
                    $lokasi[$v]->jarak = getDistanceFromLatLngInKm($k->lat,$k->lng,$lokasi_pengaduan[0],$lokasi_pengaduan[1]); 
                }else{
                    $lokasi[$v]->jarak = 0;
                }
            }
        }

        echo json_encode($lokasi);
    }
}
