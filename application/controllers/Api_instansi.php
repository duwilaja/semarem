<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_instansi extends CI_Controller {
	
	public function __construct()
    {
		parent::__construct();
		$this->load->model('MInstansi','mi');
	}

    public function get()
    {
        $q = $this->mi->get()->result();

        echo json_encode($q);
    }

    public function in()
    {
        $msg = 'Gagal menambahkan data';
        $status = false;

        $nama_intansi = $this->input->post('nama_instansi');

        $obj = [
            'nama_instansi' => $nama_intansi,
            'ctddate' => date('Y-m-d'),
            'ctdtime' => date('H:i:s')
        ];

		$in = $this->mi->in($obj);
        if ($in != '') {
            $status = true;
            $msg = "Berhasil menambahkan data";
		}

		$response = [
			'msg' => $msg,
			'status' => $status
		];

		echo json_encode($response);
    }

    public function up()
    {
        $msg = 'Gagal mengupdate data';
        $status = false;

		$id = $this->input->post('id');
		$nama_intansi = $this->input->post('nama_instansi');

        $obj = [
            'nama_instansi' => $nama_intansi,
        ];
		
		$up = $this->mi->up($obj,['id' => $id]);
		if ($up != '') {
            $status = true;
            $msg = "Berhasil mengupdate data";	
		}

		$response = [
			'msg' => $msg,
			'status' => $status
		];

		echo json_encode($response);
	}

    public function del()
    {
        $msg = 'Gagal menghapus data';
        $status = false;

		$id = $this->input->post('id');
		
		$up = $this->mi->del(['id' => $id]);
		if ($up != '') {
            $status = true;
            $msg = "Berhasil menghapus data";	
		}

		$response = [
			'msg' => $msg,
			'status' => $status
		];

		echo json_encode($response);
    }
}
