<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller {
	
	public function __construct()
    {
		parent::__construct();
        $this->load->model('MKategori','mk');
        if (!$this->session->userdata('id')) {
            redirect('Auth/login');
		}
	}

    // Input form pengaduan back office
    public function form_pengaduan()
    {
        $d = [
            'title' => 'Form Pengaduan',
            'header' => '',
            'js' => 'page/pengaduan/form_pengaduan.js',
            'link_view' => 'pengaduan/form_pengaduan',
        ];
        $this->load->view('_main', $d);
    }


}
