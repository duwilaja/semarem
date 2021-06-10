<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_master extends CI_Controller {
	
	public function __construct()
    {
		parent::__construct();

        if (!$this->session->userdata('id')) {
            redirect('Auth/login');
		}
	}

    public function pengaduan_kategori()
    {
        $d = [
            'title' => 'Kategori Pengaduan',
            'header' => 'Kategori Pengaduan',
            'js' => 'page/pengaduan/peng_kategori.js',
            'link_view' => 'pengaduan/peng_kategori'
        ];
        $this->load->view('_main', $d);
    }

    public function task_kategori()
    {
        $d = [
            'title' => 'Task Kategori',
            'header' => 'Task Kategori',
            'js' => 'page/task/task_kategori.js',
            'link_view' => 'task/task_kategori'
        ];
        $this->load->view('_main', $d);
    }

    public function instansi()
    {
        $d = [
            'title' => 'Instansi',
            'header' => 'Instansi',
            'js' => 'page/instansi.js',
            'link_view' => 'instansi'
        ];
        $this->load->view('_main', $d);
    }

    public function unit()
    {
        $d = [
            'title' => 'Unit',
            'header' => 'Unit',
            'js' => 'page/unit.js',
            'link_view' => 'unit'
        ];
        $this->load->view('_main', $d);
    }

}
