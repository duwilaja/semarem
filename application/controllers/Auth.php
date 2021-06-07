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
        // $arr = ['u.username' => $username,'u.password' => md5($password),'p.aktif' => '1'];
        $arr = [
            "rowid,nrp,pwd",
            [
                'nrp' => $this->input->post('username'),
                'pwd' => md5($this->input->post('password'))
            ]
        ];
        $q = $this->mu->join_backoffice($arr);
        if ($q->num_rows() > 0) {
            $u = $q->row();
            $array = array(
                'id' => $u->rowid,
                'nrp' => $u->nrp
            );
            
            $this->session->set_userdata( $array );
            redirect('Main/pengaduan');
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
