<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notif extends CI_Controller {

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
            'title' => 'Notifikasi',
            'header' => 'Notifikasi',
            'js' => 'page/notif/notif.js',
            'link_view' => 'notif/notif'
        ];
        $this->load->view('_main', $d);
    }
}