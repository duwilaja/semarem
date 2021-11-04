<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_petugas extends CI_Controller {
	
	public function __construct()
    {
		parent::__construct();
		$this->load->model('MPetugas','mp');
		$this->load->model('MUsers','mu');
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
        $petugas = [];
        $lokasi_pengaduan = false;
        $id = $this->input->get('id');

        if ($this->input->get('lokasi_pengaduan') != '') {
            $lokasi_pengaduan = explode(',',$this->input->get('lokasi_pengaduan'));
        }

        if ($id != '') {
            $petugas = $this->mp->get([['p.id','lat','lng','nama_petugas','hp','activity','nama_instansi','unit','p.instansi_id','p.unit_id','backoff'],['p.aktif' => 1,'p.id' => $id]])->result();
        }else{
            $q = $this->mp->get([['p.id','lat','lng','nama_petugas','hp','activity','nama_instansi','unit'],['p.aktif' => 1]])->result();
            foreach ($q as $v => $k) {
                $petugas[$v] = $k;
                if ($lokasi_pengaduan) {
                    $petugas[$v]->jarak = getDistanceFromLatLngInKm($k->lat,$k->lng,$lokasi_pengaduan[0],$lokasi_pengaduan[1]); 
                }else{
                    $petugas[$v]->jarak = 0;
                }
            }
        }
        
        echo json_encode($petugas);
    }

    public function in()
    {
        $this->header();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $data = [];
            $status = false;
            $statusCode = 200;
            $msg = "Gagal menambah data petugas";

            if (empty($this->input->post())) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {
                    // if ($this->cek_token()) {   
                        $nama_petugas = $this->input->post('nama_petugas');
                        $hp = $this->input->post('hp');
                        $instansi_id = $this->input->post('instansi_id');
                        $unit_id = $this->input->post('unit_id');
                        $username = $this->input->post('username');
                        $password = $this->input->post('password');
                        $email = $this->input->post('email');

                        $obj = [
                            'nama_petugas' => $nama_petugas,
                            'hp' => $hp,
                            'aktif' => 1,
                            'instansi_id' => $instansi_id,
                            'unit_id' => $unit_id,
                            'activity' => 0,
                            'ctdby' => @$this->session->userdata('id')
                            // 'ctdby' => 0
                        ];

                        $cek_usr = $this->mu->get('','',['username' => $username]);
                        if ($cek_usr->num_rows() == 0) { 
                            $cek_email = $this->mu->get('','',['email' => $email]);
                            if ($cek_email->num_rows() == 0) { 
                                $in = $this->mp->in($obj);
                                $petugas_id = $this->db->insert_id();
                                $v2 = [
                                    'username' => $username,
                                    'password' => md5($password),
                                    'email' => $email,
                                    'petugas_id' => $petugas_id,
                                    'ctddate' => date('Y-m-d'),
                                    'ctdtime' => date('H:i:s'),
                                    'ctdBy' => @$this->session->userdata('id')
                                ];
                        
                                $this->db->insert('users',$v2);

                                if($in){
                                    $data = $obj;
                                    $msg = "Berhasil menambah data petugas";
                                    $status = true; 
                                }
                            } else {
                                $msg = "Gagal menambah data petugas, Email sudah digunakan";
                                $status = false; 
                            }
                        } else {
                            $msg = "Gagal menambah data petugas, Username sudah digunakan";
                            $status = false; 
                        }
                    // }
                } catch (Exception $error) {
                    $statusCode = 417;
                    $msg = $error->getMessage();
                }
            }

            $arr = [
                'data' => $data,
                'msg' => $msg,
                'statusCode' => $statusCode,
                'status' => $status
            ];
            
            echo json_encode($arr);
        }
    }

    // Untuk edit petugas
    public function up()
    {
        $this->header();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $data = [];
            $status = false;
            $statusCode = 200;
            $msg = "Gagal mengubah data petugas";

            if (empty($this->input->post())) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {
                    // if ($this->cek_token()) {  
                        $id = $this->input->post('id');
                        $nama_petugas = $this->input->post('nama_petugas');
                        $hp = $this->input->post('hp');
                        $instansi_id = $this->input->post('instansi_id');
                        $unit_id = $this->input->post('unit_id');
                        // status activity petugas
                        $activity = $this->input->post('activity');
						$backoff = $this->input->post('backoff');

                        $obj = [
                            'nama_petugas' => $nama_petugas,
                            'hp' => $hp,
                            'instansi_id' => $instansi_id,
                            'unit_id' => $unit_id,
                            'activity' => $activity,
							'backoff' => $backoff
                        ];
                        $up = $this->mp->up($obj,['id' => $id]);
                        if($up){
                            $data = $obj;
                            $msg = "Berhasil mengubah data petugas";
                            $status = true; 
                        }
                    // }
                } catch (Exception $error) {
                    $statusCode = 417;
                    $msg = $error->getMessage();
                }
            }

            $arr = [
                'data' => $data,
                'msg' => $msg,
                'statusCode' => $statusCode,
                'status' => $status
            ];
            
            echo json_encode($arr);
        }
	}

    public function non()
    {
        $this->header();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $data = [];
            $status = false;
            $statusCode = 200;
            $msg = "Gagal menghapus data petugas";

            if (empty($this->input->post())) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {
                    // if ($this->cek_token()) {  
                        $id = $this->input->post('id');
                        $obj = [
                            'aktif' => 0
                        ];
                        $up = $this->mp->up($obj,['id' => $id]);
                        if($up){
                            $msg = "Berhasil menghapus data petugas";
                            $status = true; 
                        }
                    // }
                } catch (Exception $error) {
                    $statusCode = 417;
                    $msg = $error->getMessage();
                }
            }

            $arr = [
                'msg' => $msg,
                'statusCode' => $statusCode,
                'status' => $status
            ];
            
            echo json_encode($arr);
        }
    }

    public function dt()
    {
        echo $this->mp->dt();
    }

    public function tes($us)
    {
        echo $this->mu->get('','',['username' => $us])->num_rows();
    }
}
