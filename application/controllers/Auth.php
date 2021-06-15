<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	
	public function __construct()
    {
		parent::__construct();
        $this->load->model('MUsers','mu');
	}

    public function login()
    {
        $this->load->view('page/auth/login');
    }

    public function proses_login()
    {
        $arr = [
            "p.rowid,uid,upwd,p.nama,pangkat",
            [
                'a.uid' => $this->input->post('username'),
                'a.upwd' => md5($this->input->post('password'))
            ]
        ];
        $q = $this->mu->join_backoffice($arr);

        if ($q->num_rows() > 0) {
            $u = $q->row();
            $array = array(
                'id' => $u->rowid,
                'nama' => $u->nama,
                'pangkat' => $u->pangkat
            );
            
            $this->session->set_userdata( $array );
            redirect('Dashboard');
        }else{
            $this->session->set_flashdata('gagal', 'Username atau Password salah. mohon cek kembali username dan password yang anda masukan.');
            redirect('Auth/login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->unset_userdata('id');
        redirect('Auth/login');
    }

}
