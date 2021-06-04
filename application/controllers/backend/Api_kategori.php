<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_kategori extends CI_Controller {
	
	public function __construct()
    {
		parent::__construct();
		$this->load->model('MKategori','mk');
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
        $q = $this->mk->get()->result();

        echo json_encode($q);
    }

    public function in()
    {
        $this->header();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $data = [];
            $status = false;
            $statusCode = 200;
            $msg = "Gagal menambah data kategori";

            if (empty($this->input->post())) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {
                    // if ($this->cek_token()) {   
                        $peng_kategori = $this->input->post('peng_kategori');
                        $obj = [
                            'peng_kategori' => $peng_kategori
                        ];
                        $q = $this->mk->in($obj);
                        if($q){
                            $data = $obj;
                            $msg = "Berhasil menambah data kategori";
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

    public function up()
    {
        $this->header();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $data = [];
            $status = false;
            $statusCode = 200;
            $msg = "Gagal mengubah data kategori";

            if (empty($this->input->post())) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {
                    // if ($this->cek_token()) {  
                        $id = $this->input->post('id'); 
                        $peng_kategori = $this->input->post('peng_kategori');
                        $obj = [
                            'peng_kategori' => $peng_kategori
                        ];
                        $up = $this->mk->up($obj,['id' => $id]);
                        if($up){
                            $data = $obj;
                            $msg = "Berhasil mengubah data kategori";
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

    public function del()
    {
        $this->header();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $data = [];
            $status = false;
            $statusCode = 200;
            $msg = "Gagal menghapus data kategori";

            if (empty($this->input->post())) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {
                    // if ($this->cek_token()) {  
                        $id = $this->input->post('id');
                        $del = $this->mk->del(['id' => $id]);
                        if($del){
                            // $data = $obj;
                            $msg = "Berhasil menghapus data kategori";
                            $status = true; 
                        }
                    // }
                } catch (Exception $error) {
                    $statusCode = 417;
                    $msg = $error->getMessage();
                }
            }

            $arr = [
                // 'data' => $data,
                'msg' => $msg,
                'statusCode' => $statusCode,
                'status' => $status
            ];
            
            echo json_encode($arr);
        }
    }

    public function dt()
    {
        echo $this->mk->dt();
    }
}
