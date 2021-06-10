<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_pengaduan extends CI_Controller {
	
	public function __construct()
    {
		parent::__construct();
        $this->load->model('MPengaduan','mp');
	}

    public function dt()
    {
        $date = explode('-',$this->input->post('f_date_interval'));
        $filter = [
            'kategori' => $this->input->post('f_kategori_peng'),
            'start_date' => date("Y-m-d", strtotime($date[0])),
            'end_date' => date("Y-m-d", strtotime($date[1])),
            'status' => $this->input->post('f_status')
        ];

        echo $this->mp->dt_pengaduan($filter);
    }

    public function get_status()
    {
        $d = [
            ['id' => 0, 'status' => setStatusPengaduan2(0)],
            ['id' => 1, 'status' => setStatusPengaduan2(1)],
            ['id' => 2, 'status' => setStatusPengaduan2(2)],
            ['id' => 3, 'status' => setStatusPengaduan2(3)],
            ['id' => 4, 'status' => setStatusPengaduan2(4)]
        ];
        echo json_encode($d);
    }

}
