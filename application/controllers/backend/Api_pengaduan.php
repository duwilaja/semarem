<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_pengaduan extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MPengaduan','mp');
        $this->load->model('MTask','mt');
    }

    public function dt()
    {
        $date = explode('-',$this->input->post('f_date_interval'));
        $filter = [
            'kategori' => $this->input->post('f_kategori_peng'),
            'start_date' => date("Y-m-d", strtotime($date[0])),
            'end_date' => date("Y-m-d", strtotime($date[1])),
            'status' => $this->input->post('f_status'),
            'operator' => $this->input->post('operator')
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
    
    public function eksekusi()
    {
        $rsp = [
            'status' => false,
            'msg' => 'Data tidak dimasukan ke task'
        ];
        
        $pengaduan_id = $this->input->post('pengaduan_id');
        $tw = $this->mt->task_where([
            'pengaduan_id' => $pengaduan_id
        ]);

        if ($tw->num_rows() == 0) {
            
            $t = $this->mt->in_task([
                'pengaduan_id' => $pengaduan_id,
                'status' => 0,
                'operator' => $this->session->userdata('id')
            ]);
            $this->mp->up(['task_id' => $this->db->insert_id(),'operator' => $this->session->userdata('id')],['id' => $pengaduan_id]);
            if ($t) {
                $rsp['status'] = true;
                $rsp['msg'] = "Berhasil mengeksekusi pengaduan";
            }
        }
        echo json_encode($rsp);
    } 
    
    public function pengaduan($id='')
    {
        $rsp = [
            'status' => false,
            'msg' => "Gagal"
        ];
        
        $peng = $this->mp->pengaduan_id('id,keterangan,judul,task_id,nama_pelapor,mail,lat,lng,telp,kategori_peng_id,status,ctddate,ctdtime',$id);
        if ($peng->num_rows() > 0) {
            $peng = $peng->row();
            $peng_kategori = $this->mp->peng_kategori('peng_kategori',$peng->kategori_peng_id);
            if ($peng_kategori->num_rows() > 0) {
                $peng_kategori = $peng_kategori->row()->peng_kategori;
            }else{
                $peng_kategori = '';
            }
            
            $peng->peng_kategori = $peng_kategori;
            $peng->tanggal = tgl_indo($peng->ctddate);
            $peng->status_static = setStatusPengaduan2($peng->status); 
            
            $rsp['data'] = $peng;
            $rsp['status'] = true;
        }
        
        echo json_encode($peng);
        
    }
    
    public function assign_to()
    {
        
        $rsp = [
            'status' => false,
            'msg' => 'Gagal mendelegasikan tugas '
        ];
        
        $pengaduan_id = $this->input->post('pengaduan_id');
        $petugas_id = $this->input->post('petugas_id');

        
        $tw = $this->mt->task_where([
            'pengaduan_id' => $pengaduan_id,
        ]);

        if ($tw->num_rows() > 0) {
            $task  = $tw->row();
            $taw = $this->mt->task_assign_where('',[
                'pengaduan_id' => $pengaduan_id,
                'task_id' => $task->id,
                'petugas_id' => $petugas_id
            ]);

            if ($taw->num_rows() == 0) {

                $t = $this->mt->in_task_assign([
                    'task_id' => $task->id,
                    'pengaduan_id' => $pengaduan_id,
                    'status' => 0,
                    'petugas_id' => $petugas_id,
                    'assign_from' => @$this->session->userdata('id')                   
                ]);
                
                if ($t) {
                    $rsp['status'] = true;
                    $rsp['msg'] = "Berhasil mendelegasikan pengaduan ke petugas";
                }
            }else{
                $rsp['status'] = false;
                $rsp['msg'] = "Petugas yang anda tuju sudah didelegasikan ke pengaduan ini";
            }
        }
        
        echo json_encode($rsp);
    }

    public function peng_assign_list()
    { 
        $pengaduan_id = $this->input->post('pengaduan_id');
        $rsp = [
            'status' => false,
            'msg' => 'Gagal mendapatkan data daftar delegasi dari pengaduan '.$pengaduan_id
        ];

        $taw = $this->mt->task_assign_where('ta.id as tid,p.nama_petugas,p.instansi_id,i.nama_instansi,ta.status',['pengaduan_id' => $pengaduan_id]);
        if ($taw->num_rows() > 0 ) {
            $rsp['data'] = $taw->result();
            foreach ($rsp['data'] as $k => $v) {
                $rsp['data'][$k]->status_static = setStatusPengaduan($v->status);
            }
            $rsp['msg'] = "Berhasil mendapatkan data daftar petugas yang didelegasikan";
            $rsp['status'] = true;
        }

        echo json_encode($rsp);
    }

    public function peng_assign_where()
    { 
        $id = $this->input->get('id');
        $rsp = [
            'status' => false,
            'msg' => 'Gagal mendapatkan data'.$id
        ];

        $taw = $this->mt->task_assign_where('ta.id as tid,p.nama_petugas,p.instansi_id,i.nama_instansi,ta.status',['ta.id' => $id]);
        if ($taw->num_rows() > 0 ) {
            $rsp['data'] = $taw->result();
            foreach ($rsp['data'] as $k => $v) {
                $rsp['data'][$k]->status_static = setStatusPengaduan($v->status);
            }
            $rsp['msg'] = "Berhasil mendapatkan data petugas";
            $rsp['status'] = true;
        }

        echo json_encode($rsp);
    }

    public function peng_assign_log()
    { 
        $task_id = $this->input->post('task_id');

        $rsp = [
            'status' => false,
            'msg' => 'Gagal mendapatkan data log aktifitas penanganan pengaduan'
        ];

        $taw = $this->mt->task_assign_log($task_id);
        if ($taw->num_rows() > 0 ) {
            $rsp['data'] = $taw->result();
            foreach ($rsp['data'] as $k => $v) {
                $rsp['data'][$k]->status_static = setStatusPengaduan($v->status);
                $rsp['data'][$k]->tanggal = tgl_indo($v->ctddate);
                if ($v->status == 4) {
                    $rsp['data'][$k]->detail = $this->get_task_done($v->task_assign_id,$v->petugas_id);
                }
            }
            $rsp['msg'] = "Berhasil mendapatkan data log aktifitas penanganan pengaduan";
            $rsp['status'] = true;
        }

        echo json_encode($rsp);
    }

    public function get_task_done($id,$petugas_id)
    {
        $msg = "Gagal";
        $status = false;
        $rsp = [];
        $data = [];

        $q = $this->mt->task_assign([
            'ta.id,ta.task_id,ta.pengaduan_id,ta.petugas_id,p.lat,p.lng,p.judul,p.nama_pelapor,p.telp,p.mail,p.alamat,p.ctddate,p.ctdtime,ta.pengaduan_id,ta.status',
            ['ta.id' => $id,'ta.petugas_id' => $petugas_id,'ta.status' => 4]
        ]);
        if($q->num_rows() > 0){
                $data = $q->row();
                $data->tanggal = tgl_indo($data->ctddate);

                $data->status_name = setStatusPengaduan($data->status);
                $data->lat = (float)$data->lat;
                $data->lng = (float)$data->lng;
                $data->img_pengaduan = $this->mp->peng_img_peng_id('id,img',$pengaduan_id=$data->pengaduan_id)->result();
                $data->img_task_done = !empty($this->mt->task_img_task_assign_id('id,full_file',$data->id)) ? $this->mt->task_img_task_assign_id('id,full_file',$data->id)->result() : [];
                foreach (@$data->img_task_done as $k => $v) {
                    @$data->img_task_done[$k]->full_file = link_http().@$v->full_file;
                }

                $data->penanganan = $this->mt->lama_penanganan($this->input->post('task_assign_id'));
                $data->task_done = $this->mt->task_done([
                    'id as task_done_id,penyebab,tindakan,keterangan',
                    ['td.id' => $this->input->post('task_assign_id'),'petugas_id' => $this->input->post('petugas_id')]
                ])->row();

                $msg = "Berhasil mengambil detail task history petugas";
                $status = true; 
        }else{
            $msg = "Detail task history tidak ditemukan, harap cek kembali task_assign_id atau petugas_id";
        }

        $rsp = [
            'data' => $data,
            'msg' => $msg,
            'status' => $status
        ];

        return $rsp;
    }

    public function upsts_peng()
    {
        $rsp = [
            'status' => false,
            'msg' => 'Gagal update status'
        ];
        
        $pengaduan_id = $this->input->post('pengaduan_id');
        $status = $this->input->post('status');

        $tw = $this->mt->task_where([
            'pengaduan_id' => $pengaduan_id
        ]);

        if ($tw->num_rows() != 0) {
            
            $this->mp->up(['status' => $status],['id' => $pengaduan_id]);
            $this->db->update('task',['status' => $status],['pengaduan_id' => $pengaduan_id]);
                $rsp['status'] = true;
                $rsp['msg'] = "Berhasil update status";
        }
        echo json_encode($rsp);
    } 
}
