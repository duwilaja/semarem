<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MUsers','mu');        
        $this->load->model('MPetugas','mp');        
    }
    

	public function index()
	{
		$this->load->view('welcome_message');
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

    // Login Petugas
	public function auth_petugas()
    {        
        $this->header();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $data = [];
            $status = false;
            $statusCode = 200;
            $msg = "Gagal login ke aplikasi";

            if (empty($this->input->post())) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {   
                  if ($this->cek_token()) {
                   
                    $arr = [
                        "u.petugas_id,p.unit_id,p.instansi_id,nama_instansi,unit,nama_petugas,activity,hp",
                        [
                            'p.aktif' => 1,
                            'u.username' => $this->input->post('username'),
                            'u.password' => md5($this->input->post('password'))
                        ]
                    ];

                     $q = $this->mu->join_petugas($arr);
                     if($q->num_rows() > 0){
                         $data = $q->row();
                         $msg = "Berhasil login ke aplikasi";
                         $status = true; 
                     }
                  }
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

    public function profile_petugas($petugas_id='')
    {        
        $this->header();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $data = [];
            $status = false;
            $statusCode = 200;
            $msg = "Gagal mendapatkan data profile petugas";

            if (empty($petugas_id)) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {   
                  if ($this->cek_token()) {
                     $q = $this->mp->get([
                         'p.id,p.instansi_id,unit_id,nama_petugas,nama_instansi,unit,activity',
                         ['p.id' => $petugas_id]
                     ]);
                     if($q->num_rows() > 0){
                         $data = $q->row();
                         $data->activity_name = setActivityPetugas($data->activity);
                         $msg = "Berhasil mengambil data petugas";
                         $status = true; 
                     }
                  }
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
}
