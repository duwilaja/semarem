<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_task_kategori extends CI_Controller {
	
	public function __construct()
    {
		parent::__construct();
		$this->load->model('MTaskKategori','mtk');
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
        if ($id != '') {
            $q = $this->mtk->get($id)->result();
        }else{
            $q = $this->mtk->get()->result();
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
            $msg = "Gagal menambah data task kategori";

            if (empty($this->input->post())) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {
                    // if ($this->cek_token()) {   
                        $task_kategori = $this->input->post('task_kategori');
                        $obj = [
                            'task_kategori' => $task_kategori
                        ];
                        $q = $this->mtk->in($obj);
                        if($q){
                            $data = $obj;
                            $msg = "Berhasil menambah data task kategori";
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
            $msg = "Gagal mengubah data task kategori";

            if (empty($this->input->post())) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {
                    // if ($this->cek_token()) {  
                        $id = $this->input->post('id'); 
                        $task_kategori = $this->input->post('task_kategori');
                        $obj = [
                            'task_kategori' => $task_kategori
                        ];
                        $up = $this->mtk->up($obj,['id' => $id]);
                        if($up){
                            $data = $obj;
                            $msg = "Berhasil mengubah data task kategori";
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
            $msg = "Gagal menghapus data task kategori";

            if (empty($this->input->post())) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {
                    // if ($this->cek_token()) {  
                        $id = $this->input->post('id');
                        $del = $this->mtk->del(['id' => $id]);
                        if($del){
                            // $data = $obj;
                            $msg = "Berhasil menghapus data task kategori";
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
        echo $this->mtk->dt();
    }
}
