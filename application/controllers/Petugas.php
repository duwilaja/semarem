<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Petugas extends CI_Controller {

	public function __construct()
    {
		parent::__construct();
        if (!$this->session->userdata('id')) {
            redirect('Auth/login');
		}
	}

    public function index()
    {
        $d = [
            'title' => 'Petugas',
            'header' => 'Petugas',
            'js' => 'page/petugas/petugas.js',
            'link_view' => 'petugas/petugas'
        ];
        $this->load->view('_main', $d);
    }
}