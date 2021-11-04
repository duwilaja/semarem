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

    public function proses_login_dahulukala()
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
	public function proses_login()
    {
		$where=array('u.username' => $this->input->post('username'),
                'u.password' => md5($this->input->post('password')),
				'p.backoff' => 'Y');
				
        $this->db->select("p.id as rowid,nama_petugas as nama,concat(nama_instansi,'/',unit) as pangkat,unit_id,p.instansi_id");
		$this->db->where($where);
		$this->db->join('users u', 'p.id = u.petugas_id', 'inner');
        $this->db->join('instansi i', 'i.id = p.instansi_id', 'inner');
        $this->db->join('unit unt', 'unt.id = p.unit_id', 'inner');
        $q = $this->db->get('petugas p');

        if ($q->num_rows() > 0) {
            $u = $q->row();
            $array = array(
                'id' => $u->rowid,
                'nama' => $u->nama,
                'pangkat' => $u->pangkat,
				'instansi' => $u->instansi_id 
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
