<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_pengaduan extends CI_Controller {
	
	public function __construct()
    {
		parent::__construct();
		$this->load->model('MPengaduan','mp');
        $this->load->model('MPelapor','mpel');
        $this->load->model('MKategori','mpengkateg');

	}

    private function upload($path,$files,$types="jpg|png|jpeg|svg")
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
        $token = @getallheaders()['token'];

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
            $q = $this->mi->get($id)->result();
        }else{
            $q = $this->mi->get()->result();
        }

        echo json_encode($q);
    }

    public function kirim_laporan()
    {      
        $this->header();
        $data = [];
        $q = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $status = false;
            $statusCode = 200;
            $msg = "Gagal mengajukan laporan";
            if (empty($this->input->post())) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {   
                  if ($this->cek_token()) {
                    $kategori_peng_id = $this->input->post('kategori_peng_id');
                    $judul = $this->input->post('judul');
                    $nama_pelapor = $this->input->post('nama_pelapor');
                    $mail = $this->input->post('mail');
                    $telp = $this->input->post('telp');
                    $keterangan = $this->input->post('keterangan');
                    $lat = $this->input->post('lat');
                    $lng = $this->input->post('lng');
                    $alamat = $this->input->post('alamat');
                    if (!empty($_FILES['img'])) {
                        $file = $this->upload('./my/img_pengaduan/',$_FILES['img']);
                    }
                    
                    $obj = [
                        'kategori_peng_id' => $kategori_peng_id,
                        'judul' => $judul,
                        'nama_pelapor' => $nama_pelapor,
                        'mail' => $mail,
                        'telp' => $telp,
                        'keterangan' => $keterangan,
                        'lat' => $lat,
                        'lng' => $lng,
                        'alamat' => $alamat,
                        'status' => 0,
                        'vendor_id' => 3, // vendor_id bisa dilihat dari database db_Smart Management Emergency  tabel vendor
                        'via' => 'Aplikasi'
                    ];
                    // Insert gambar 
                    if (empty($file)) {
                        $q = $this->mp->in($obj);
                    } else {
                        $q = $this->mp->in($obj);
                        $pengaduan_id = $this->db->insert_id();
                        $arr = [];
                        foreach ($file as $v) {
                            $i = [
                                'pengaduan_id' => $pengaduan_id,
                                'img' => 'my/img_pengaduan/'.$v,
                            ];
                            $this->mp->in_peng_img($i);
                        }
                    }
                    
                    if($q){
                        $data = $obj;
                        $msg = "Berhasil mengajukan laporan";
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

    public function simpan_data_diri()
    {      
        $this->header();
        $data = [];
        $q = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $status = false;
            $statusCode = 200;
            $msg = "Gagal menyimpan data diri";
            if (empty($this->input->post())) {
                $msg = "Tidak ada data yang dikirim";
                $statusCode = 410;
            }else{
                try {   
                  if ($this->cek_token()) {
                    $nama = $this->input->post('nama');
                    $telp = $this->input->post('telp');
                    $email = $this->input->post('email');
                    $obj = [
                        'nama' => $nama,
                        'telp' => $telp,
                        'email' => $email,
                        'aktif' => 1,
                    ];
                    $cek_nomor = $this->mpel->pelapor_where('*',['telp' => $obj['telp']]);
                    if ($cek_nomor->num_rows() > 0) {
                        $data = $cek_nomor->result();
                        $msg = "Menampilkan data dari nomor telepon yang dimasukan";
                        $status = true;
                    }else{
                        $this->mpel->in($obj);
                        $obj['id'] = $this->db->insert_id();
                        $data = $obj;
                        $msg = "Berhasil menyimpan data diri";
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
    public function kategori_pengaduan()
    {        
        $this->header();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $data = [];
            $status = false;
            $statusCode = 200;
            $msg = "Gagal mendapatkan data kategori pengaduan";

            try {   
              if ($this->cek_token()) {
                 $q = $this->mpengkateg->get('',['priority' => 1]);
                 if($q->num_rows() > 0){
                     $data = $q->result();
                     $msg = "Berhasil mengambil data kategori pengaduan";
                     $status = true; 
                 }else{
                    $msg = "Gagal mengambil data kategori pengaduan";
                    $status = false; 
                 }
              }
            } catch (Exception $error) {
                $statusCode = 417;
                $msg = $error->getMessage();
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
