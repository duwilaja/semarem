<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_petugas extends CI_Controller {
	
	public function __construct()
    {
		parent::__construct();
		$this->load->model('MPetugas','mp');
	}

    public function get()
    {
        $q = $this->mp->get([['p.id','nama_petugas','hp','activity','nama_instansi','unit'],['p.aktif' => 1]])->result();

        echo json_encode($q);
    }

    public function in()
    {
        $msg = 'Gagal menambahkan data';
        $status = false;

        $nama_petugas = $this->input->post('nama_petugas');
        $hp = $this->input->post('hp');
        $instansi_id = $this->input->post('instansi_id');
        $unit_id = $this->input->post('unit_id');

        $obj = [
            'nama_petugas' => $nama_petugas,
            'hp' => $hp,
            'aktif' => 1,
            'instansi_id' => $instansi_id,
            'unit_id' => $unit_id,
            'activity' => 0,
            'ctddate' => date('Y-m-d'),
            'ctdtime' => date('H:i:s'),
            // 'ctdby' => $this->session->userdata('id')
            'ctdby' => 0
        ];

		$in = $this->mp->in($obj);
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
		$nama_petugas = $this->input->post('nama_petugas');
        $hp = $this->input->post('hp');
        $instansi_id = $this->input->post('instansi_id');
        $unit_id = $this->input->post('unit_id');

        $obj = [
            'nama_petugas' => $nama_petugas,
            'hp' => $hp,
            'instansi_id' => $instansi_id,
            'unit_id' => $unit_id,
        ];
		
		$up = $this->mp->up($obj,['id' => $id]);
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

    public function non()
    {
        $msg = 'Gagal menghapus data';
        $status = false;

		$id = $this->input->post('id');

        $obj = [
            'aktif' => 0
        ];
		
		$up = $this->mp->up($obj,['id' => $id]);
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

    public function dt()
    {
        echo $this->mp->dt();
    }
}
