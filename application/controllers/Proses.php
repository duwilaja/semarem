<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proses extends CI_Controller {
	
	public function __construct()
    {
		parent::__construct();
        $this->load->model('MPengaduan','mp');

        if (!$this->session->userdata('id')) {
            redirect('Auth/login');
		}
	}

    public function insert_pengaduan()
    {
        $query = $this->mp->insert_pengaduan();
        if($query) {
           echo json_encode($query);
        } else {
           echo json_encode($query);
        }
    }

}
