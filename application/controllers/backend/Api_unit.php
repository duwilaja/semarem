<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_unit extends CI_Controller {
	
	public function __construct()
    {
		parent::__construct();
		$this->load->model('MUnit','mun');
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
        $id = $this->input->get("id");
        $instansi_id = $this->input->get("instansi_id");
        $where = ['instansi_id' => $instansi_id];
        if ($id != '') {
            $q = $this->mun->get($id)->result();
        }else if($instansi_id != ''){
            $q = $this->mun->get('',$where)->result();
        }else{
            $q = $this->mun->get()->result();
        }

        echo json_encode($q);
    }

    public function in()
    {
        $this->header();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $data = [];
            $status = false;
            $statusCode = 200;
            $msg = "Gagal menambah data unit";

            if (empty($this->input->post())) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {
                    // if ($this->cek_token()) {   
                        $unit = $this->input->post('unit');
                        $instansi_id = $this->input->post('instansi_id');
                        $obj = [
                            'unit' => $unit,
                            'instansi_id' => $instansi_id
                        ];
                        $q = $this->mun->in($obj);
                        if($q){
                            $data = $obj;
                            $msg = "Berhasil menambah data unit";
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
            $msg = "Gagal mengubah data unit";

            if (empty($this->input->post())) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {
                    // if ($this->cek_token()) {  
                        $id = $this->input->post('id'); 
                        $unit = $this->input->post('unit');
                        $instansi_id = $this->input->post('instansi_id');
                        $obj = [
                            'unit' => $unit,
                            'instansi_id' => $instansi_id
                        ];
                        $up = $this->mun->up($obj,['id' => $id]);
                        if($up){
                            $data = $obj;
                            $msg = "Berhasil mengubah data unit";
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
            $msg = "Gagal menghapus data unit";

            if (empty($this->input->post())) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {
                    // if ($this->cek_token()) {  
                        $id = $this->input->post('id');
                        $del = $this->mun->del(['id' => $id]);
                        if($del){
                            // $data = $obj;
                            $msg = "Berhasil menghapus data unit";
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
        echo $this->mun->dt();
    }
}
