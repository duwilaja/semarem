<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaduan extends CI_Controller {
	
	public function __construct()
    {
		parent::__construct();
        if (!$this->session->userdata('id')) {
            redirect('Auth/login');
		}
    $this->load->model('MPengaduan','mp');
	}

    public function list_pengaduan()
    {
        $d = [
            'title' => 'List Pengaduan',
            'header' => 'Pengaduan',
            'js' => 'page/pengaduan/list_pengaduan.js',
            'link_view' => 'pengaduan/list_pengaduan'
        ];
        $this->load->view('_main', $d);
    }

    public function eksekusi()
    {
        $id = $this->input->get('id');
        if ($id != '') {
            $d = [
                'title' => 'Eksekusi Pengaduan',
                'header' => 'Eksekusi',
                'js' => 'page/pengaduan/eksekusi.js',
                'link_view' => 'pengaduan/eksekusi'
            ];
            $this->load->view('_main', $d);
        }
    }

    public function detail()
    {
        $id = $this->input->get('id');
        if ($id == '') {
            $d = [
                'title' => 'Detail pengaduan',
                'header' => 'Detail Pengaduan',
                'js' => 'page/pengaduan/detail.js',
                'link_view' => 'pengaduan/detail'
            ];
            $this->load->view('_main', $d);
        }
    }

    public function dt_detail_peng()
    {
      echo $this->mp->dt_detail_pengaduan();
    }
    
    public function api_detail_petugas($ta_id='')
    {
       
      $this->db->select('ptgs.nama_petugas, ta.status, assign_from, ta.id, ta.petugas_id,ta.ctddate');
 
      $this->db->join('pengaduan p', 'p.id = ta.pengaduan_id', 'inner'); 
      $this->db->join('petugas ptgs', 'ptgs.id = ta.petugas_id', 'inner');   

      $this->db->where('ta.id',$ta_id);
      $q = $this->db->get('task_assign ta');
      echo json_encode($q->row());
    }

    public function api_detail_gambar_petugas($id_gambar='')
    {
      $this->db->select('id');
      $this->db->where('id',$id_gambar);
      $q = $this->db->get('task_img');
      echo json_encode($q->row());
    }
    
    // ======== Keterangan detail pengaduan (Pengaduan/detail/) =====
      public function detail_pengaduan($ta_id)
      {
        $this->db->select('keterangan,nama_pelapor,mail,telp');
        $this->db->where('ta.id',$ta_id);
        $q = $this->db->get('pengaduan ta');
        echo json_encode($q->row());
      }
    // ==============================================================
}
