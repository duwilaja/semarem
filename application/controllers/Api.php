<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MUsers','mu');        
        $this->load->model('MPetugas','mp');
        $this->load->model('MPengaduan','mpeng');  
        $this->load->model('MTask','mt');        
    }
    

	public function index()
	{
		$this->load->view('welcome_message');
	}

    private function upload($path,$files,$types="jpg|png|jpeg")
    {
        $config = array(
            'upload_path'   => $path,
            'allowed_types' => $types,
            'encrypt_name'  => true,
            'max_size'      => 0,
            'max_width'     => 0,
            'max_height'    => 0,                   
        );

        $this->load->library('upload', $config);

        $images = array();

        foreach ($files['name'] as $key => $image) {
            $_FILES['images[]']['name']= $files['name'][$key];
            $_FILES['images[]']['type']= $files['type'][$key];
            $_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
            $_FILES['images[]']['error']= $files['error'][$key];
            $_FILES['images[]']['size']= $files['size'][$key];

            $this->upload->initialize($config);

            if ($this->upload->do_upload('images[]')) {
                $images[] = $this->upload->data('file_name');
            } else {
                return false;
            }
        }

        return $images;
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

    // Profile Petugas
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

    // Set Activity Petugas
    public function set_activity_petugas()
    {        
        $this->header();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $data = [];
            $status = false;
            $statusCode = 200;
            $msg = "Gagal mengubah activity petugas";

            if (empty($this->input->post())) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {   
                  if ($this->cek_token()) {
                     $q = $this->mp->set_activity($this->input->post('petugas_id'), $this->input->post('activity'));
                     if($q){
                         $msg = "Berhasil mengubah activity petugas";
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

    // Mengambil data task petugas
    public function task_petugas($petugas_id='')
    {        
        $this->header();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $data = [];
            $status = false;
            $statusCode = 200;
            $msg = "Gagal mengambil data task petugas";

            if (empty($petugas_id)) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {   
                  if ($this->cek_token()) {
                    $q = $this->mt->task_assign([
                        'ta.id,ta.task_id,ta.pengaduan_id,ta.petugas_id,p.judul,p.alamat,p.ctddate,p.ctdtime,ta.pengaduan_id,ta.status',
                        ['ta.petugas_id' => $petugas_id]
                    ]);
                    if($q->num_rows() > 0){
                        foreach ($q->result() as $k => $v) {
                            $data[$k] = $v;
                            $data[$k]->tanggal = tgl_indo($v->ctddate);
                            $data[$k]->status_name = setStatusPengaduan($v->status);
                            $data[$k]->img = $this->mpeng->peng_img_peng_id('id,img',$pengaduan_id=$v->pengaduan_id)->result();
                        }
                        $msg = "Berhasil mengambil data task petugas";
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

    // Mengambil detail task petugas
    public function detail_task_petugas($petugas_id='',$task_id='')
    {        
        $this->header();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $data = [];
            $status = false;
            $statusCode = 200;
            $msg = "Gagal mengambil detail task";

            if (empty($petugas_id)) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {   
                  if ($this->cek_token()) {
                    $q = $this->mt->task_assign([
                        'ta.id as task_assign_id,ta.task_id,ta.task_kategori_id,p.judul,p.alamat,p.ctddate,p.ctdtime,ta.pengaduan_id,ta.status',
                        ['ta.petugas_id' => $petugas_id,'ta.id' => $task_id]
                    ]);
                    if($q->num_rows() > 0){
                        $data = $q->row();
                        $data->task_kategori = $this->mt->task_kategori('task_kategori',$data->task_kategori_id,true);
                        $data->tanggal = tgl_indo($data->ctddate);
                        $data->status = setStatusPengaduan($data->status);
                        $data->img = $this->mpeng->peng_img_peng_id('id,img',$pengaduan_id=$data->pengaduan_id)->result();

                        $msg = "Berhasil mengambil detail task";
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

    // Set Status Task
    public function set_status_task()
    {        
        $this->header();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $data = [];
            $status = false;
            $statusCode = 200;
            $msg = "Gagal mengubah status task";

            if (empty($this->input->post())) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {   
                  if ($this->cek_token()) {
                     $q = $this->mt->set_status_task_assign($this->input->post('task_assign_id'), $this->input->post('status'),$this->input->post('lat'),$this->input->post('lng'));
                     if($q){
                         $msg = "Berhasil mengubah status task";
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

    // Form Task Done
    public function form_task_done()
    {      
        $this->header();
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $status = false;
            $statusCode = 200;
            $msg = "Gagal update task";
            if (empty($this->input->post())) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {   
                  if ($this->cek_token()) {
                     $q = $this->mt->form_task_done([
                        'petugas_id' => $this->input->post('petugas_id'),
                        'lat' => $this->input->post('lat'),
                        'lng' => $this->input->post('lng'),
                        'penyebab' => $this->input->post('penyebab'),
                        'tindakan' => $this->input->post('tindakan'),
                        'keterangan' => $this->input->post('keterangan'),
                        'task_assign_id' => $this->input->post('task_assign_id')
                     ]);
                     if($q){
                        $arr = [];
                        $msg = "Berhasil update task";
                        $status = true; 
                        
                        $task_done_id = $this->db->insert_id();
                        $file = $this->upload('./my/img_done/',$_FILES['img']);
                        $q = $this->mt->set_status_task_assign($this->input->post('task_assign_id'), 4,$this->input->post('lat'),$this->input->post('lng'));

                        // Insert gambar 
                        if ($file) {
                            foreach ($file as $v) {
                                $obj = [
                                    'task_done_id' => $task_done_id,
                                    'img' => $v,
                                    'path' => 'my/img_done/',
                                    'full_file' => 'my/img_done/'.$v,
                                    'ctddate' => date('Y-m-d'),
                                    'ctdtime' => date('H:i:s')
                                ];
                                array_push($arr,$obj);
                            }
                            
                            $this->mt->in_batch_task_img($obj);
                        }
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

    // Mengambil data task berdasarkan status
    public function task_petugas_by_status()
    {        
        $this->header();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $data = [];
            $status = false;
            $statusCode = 200;
            $msg = "Gagal mengambil data task petugas by status";

            if (empty($this->input->post('petugas_id'))) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {   
                  if ($this->cek_token()) {
                    $q = $this->mt->task_assign([
                        'ta.id,ta.task_id,ta.pengaduan_id,ta.petugas_id,p.judul,p.alamat,p.ctddate,p.ctdtime,ta.pengaduan_id,ta.status',
                        ['ta.petugas_id' => $this->input->post('petugas_id'),'ta.status' => $this->input->post('status')]
                    ]);
                    if($q->num_rows() > 0){
                        foreach ($q->result() as $k => $v) {
                            $data[$k] = $v;
                            $data[$k]->tanggal = tgl_indo($v->ctddate);
                            $data[$k]->status_name = setStatusPengaduan($v->status);
                            $data[$k]->img = $this->mpeng->peng_img_peng_id('id,img',$pengaduan_id=$v->pengaduan_id)->result();
                        }
                        $msg = "Berhasil mengambil data task petugas by status";
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

    // Mengambil data task history petugas
    public function task_history_petugas()
    {        
        $this->header();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $data = [];
            $status = false;
            $statusCode = 200;
            $msg = "Gagal mengambil data task history petugas";

            if (empty($this->input->post('petugas_id'))) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {   
                  if ($this->cek_token()) {
                    $q = $this->mt->task_assign([
                        'ta.id,ta.task_id,ta.pengaduan_id,ta.petugas_id,p.judul,p.alamat,p.ctddate,p.ctdtime,ta.pengaduan_id,ta.status',
                        ['ta.petugas_id' => $this->input->post('petugas_id')],
                        ['ta.status' => ['4','5']]
                    ]);
                    if($q->num_rows() > 0){
                        foreach ($q->result() as $k => $v) {
                            $data[$k] = $v;
                            $data[$k]->tanggal = tgl_indo($v->ctddate);
                            $data[$k]->status_name = setStatusPengaduan($v->status);
                            $data[$k]->img = $this->mpeng->peng_img_peng_id('id,img',$pengaduan_id=$v->pengaduan_id)->result();
                        }
                        $msg = "Berhasil mengambil data task petugas by status";
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
