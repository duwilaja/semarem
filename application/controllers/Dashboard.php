<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	public function __construct()
    {
		parent::__construct();
        $this->load->model('MDashboard','md');
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

	public function total($start='',$end='')
	{
		// $post_start= $this->input->post('start');
		// $post_end= $this->input->post('end');
        // if ($post_start == '') {
		// 	$get_start =  date("Y-m-d", strtotime("-7 day"));
		// 	$get_end = 	  date("Y-m-d");
		// }else{
		// 	$get_start = $post_start;
		// 	$get_end = $post_end;
		// }
        $get_start =  date("Y-m-d", strtotime("-7 day"));
        $get_end = 	  date("Y-m-d");
        $res_total =  $this->md->get_total($get_start,$get_end);
        echo json_encode($res_total);
	}

    public function vendor($start='',$end='')
	{
		// $post_start= $this->input->post('start');
		// $post_end= $this->input->post('end');
        // if ($post_start == '') {
		// 	$get_start =  date("Y-m-d", strtotime("-7 day"));
		// 	$get_end = 	  date("Y-m-d");
		// }else{
		// 	$get_start = $post_start;
		// 	$get_end = $post_end;
		// }
        $get_start =  date("Y-m-d", strtotime("-7 day"));
        $get_end = 	  date("Y-m-d");
        $res_vendor =  $this->md->get_vendor($get_start,$get_end);
        echo json_encode($res_vendor);
	}
    public function kategori($start='',$end='')
    {
        $get_start =  date("Y-m-d", strtotime("-7 day"));
        $get_end = 	  date("Y-m-d");
        $res_kategori =  $this->md->get_peng_kategori($get_start,$get_end);
        echo json_encode($res_kategori);
    }
    public function grafik_pengaduan($start='',$end='')
	{
		// $post_start= $this->input->post('start');
		// $post_end= $this->input->post('end');
        // if ($post_start == '') {
		// 	$get_start =  date("Y-m-d", strtotime("-7 day"));
		// 	$get_end = 	  date("Y-m-d");
		// }else{
		// 	$get_start = $post_start;
		// 	$get_end = $post_end;
		// }
        $get_start =  date("Y-m-d", strtotime("-7 day"));
        $get_end = 	  date("Y-m-d");
        $res_grafik =  $this->md->get_grafik_pengaduan($get_start,$get_end);
        echo json_encode($res_grafik);
	}


}
