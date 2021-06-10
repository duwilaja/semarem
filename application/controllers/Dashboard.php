<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	public function __construct()
    {
		parent::__construct();
        if (!$this->session->userdata('id')) {
            redirect('Auth/login');
		}
	}

    // view Dashboard pengaduan back office
    public function index()
    {
        $d = [
            'title' => 'Dashboard Pengaduan',
            'header' => '',
            'js' => 'page/dashboard/dashboard.js',
            'link_view' => 'dashboard/dashboard',
        ];
        $this->load->view('_main', $d);
    }


}
