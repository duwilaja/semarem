<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	
	public function __construct()
    {
		parent::__construct();

        if (!$this->session->userdata('id')) {
            redirect('Auth/login');
		}
	}

    public function pengaduan()
    {
        $d = [
            'title' => 'List Pengaduan',
            'header' => 'Pengaduan',
            'js' => 'pengaduan/list_pengaduan.js',
            'link_view' => 'pengaduan/list_pengaduan'
        ];
        $this->load->view('_main', $d);
    }

}
