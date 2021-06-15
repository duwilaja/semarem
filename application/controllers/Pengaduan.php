<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaduan extends CI_Controller {
	
	public function __construct()
    {
		parent::__construct();
        if (!$this->session->userdata('id')) {
            redirect('Auth/login');
		}
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

}
