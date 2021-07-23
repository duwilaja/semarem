<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_notif extends CI_Controller {
	
	public function __construct()
    {
		parent::__construct();
		$this->load->model('MNotif','mn');
	}

    public function get_notif()
    {
        $r = [
            'data' => [],
            'jml_data_read' => 0,
            'jml_data_non_read' => 0
        ];

        $q = $this->mn->get('id,info,msg,read','',[
            'to_user' => $this->session->userdata('id'),
            'read' => 0
        ]);

        $r['data'] = $q->result();
        $r['jml_data_read'] = $this->mn->get('id,info,msg','',[
            'to_user' => $this->session->userdata('id'),
            'read' => 1
        ])->num_rows();
        $r['jml_data_non_read'] = $q->num_rows();

        echo json_encode($r);
    }

    public function read_notif()
    {
        $r = [
            'msg' => "Notifikasi gagal dibaca",
            'status' => false
        ];
        
        $id = $this->input->post('id');

        $q = $this->mn->get('kode_info,data_id',$id);
        if ($q->num_rows() > 0) {
            $qq = $q->row();
            if ($qq->kode_info == "PENGADUAN") {
                $r['link'] = 'Pengaduan/eksekusi?id='.$qq->data_id;
            }
        }

        $this->mn->up([
            'read' => 1
        ],['id' => $id]);

        $x = $this->db->affected_rows();
        if ($x > 0) {
            $r['msg'] = "Notifikasi telah dibaca";
            $r['status'] = true;
        }

        echo json_encode($r);
    }

    public function my_notif_dt()
    {
        echo $this->mn->dt([
            'to_user' => $this->session->userdata('id')
        ]);
    }

}
