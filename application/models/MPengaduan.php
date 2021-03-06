<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class MPengaduan extends CI_Model{
    
    function __construct() {
      
    }

    public function pengaduan_id($select='',$pengaduan_id='')
    {
        $q = [];
        if ($pengaduan_id != '') {
            if($select != ''){
                $this->db->select($select);
                $q = $this->db->get_where('pengaduan',['id' => $pengaduan_id]);
            }
        }

        return $q;
    }
    
    public function peng_img_peng_id($select='',$pengaduan_id='')
    {
        $q = [];
        if ($pengaduan_id != '') {
            if($select != ''){
                $this->db->select($select);
                $q = $this->db->get_where('peng_img',['pengaduan_id' => $pengaduan_id]);
            }
        }

        return $q;
    }

    public function peng_img_id($select='',$id='')
    {
        $q = [];
        if ($id != '') {
            if($select != ''){
                $this->db->select($select);
                $q = $this->db->get_where('peng_img',['id' => $id]);
            }
        }

        return $q;
    }

    public function peng_kategori($select='',$id='')
    {
        $q = [];
        if ($id != '') {
            if($select != ''){
                $this->db->select($select);
                $q = $this->db->get_where('peng_kategori',['id' => $id]);
            }
        }

        return $q;
    }

    public function dt_pengaduan($filter=[])
    {
          // Definisi
          $condition = [];
          $data = [];
  
          $CI = &get_instance();
          $CI->load->model('DataTable', 'dt');
          // Set table name
          $CI->dt->table = 'pengaduan as p';
          // Set orderable column fields
          $CI->dt->column_order = [null,'judul','nama_pelapor','keterangan','p.status','p.ctddate'];
          // Set searchable column fields
          $CI->dt->column_search = ['judul','nama_pelapor'];
          // Set select column fields
          $CI->dt->select = 'p.id,judul,kategori_peng_id,nama_pelapor,p.status,p.ctddate,p.keterangan,p.kategori_peng_static,p.input_peng';
          // Set default order
          $CI->dt->order = ['p.id' => 'desc'];

          if (isset($filter['kategori']) && $filter['kategori'] != '' ) {
                $con = ['where_in','kategori_peng_id',$filter['kategori']];
                array_push($condition,$con);              
          }
          
          if (isset($filter['start_date']) && isset($filter['end_date'])) {
            $con = ['where','ctddate >=',$filter['start_date']];
            array_push($condition,$con);   
            
            $con = ['where','ctddate <=',$filter['end_date']];
            array_push($condition,$con);   
          }

          if (isset($filter['status']) && $filter['status'] != '' ) {
            $con = ['where_in','status',$filter['status']];
            array_push($condition,$con);              
          }

          if (isset($filter['operator']) && $filter['operator'] != '' ) {
            $con = ['where','operator',$filter['operator']];
            array_push($condition,$con);              
          }
          //join table
        //   $con = ['join','peng_kategori pk','pk.id = p.kategori_peng_id','inner'];
        //   array_push($condition,$con);

          // Fetch member's records
          $dataTabel = $this->dt->getRows(@$_POST, $condition);
  
          $i = @$this->input->post('start');
          foreach ($dataTabel as $dt) {
              $i++;
              // untuk menampilkan data di datatable, harus berurut dengan data tablenya
              $data[] = array(
                  $i,
                  $this->set_dt_kasus($dt->judul,$dt->kategori_peng_id,$dt->kategori_peng_static),
                  $dt->keterangan,
                  $dt->nama_pelapor,
                  setStatusPengaduan2($dt->status),
                  tgl_indo($dt->ctddate),
                  $dt->input_peng,
                  $this->change_button($dt)
              );
          }
  
          $output = array(
              "draw" => @$this->input->post('draw'),
              "recordsTotal" => $this->dt->countAll($condition),
              "recordsFiltered" => $this->dt->countFiltered(@$this->input->post(), $condition),
              "data" => $data,
          );
  
          // Output to JSON format
          return json_encode($output);
    }


    private function change_button($dt)
    {
        if ($dt->status == 3) {
            // return '<a href="'.site_url('Pengaduan/eksekusi?id='.$dt->id).'" class="btn btn-sm btn-secondary" type="button"  data-original-title="btn btn-danger btn-xs" title="Detail Pengaduan">Detail</a>';
            
            // =========== detail keterangan pengaduan (Pengaduan/detail/6611)===================
              return '<a href="'.site_url('Pengaduan/detail/'.$dt->id).'" class="btn btn-sm btn-secondary" type="button"  data-original-title="btn btn-danger btn-xs" title="Detail Pengaduan">Detail</a>';
            // ==================================================================================

        }else{
            return '<a class="btn btn-sm btn-info" type="button" onclick="eksekusi('.$dt->id.')" data-original-title="btn btn-danger btn-xs" title="Eksekusi Pengaduan">Eksekusi</a>';
        }
    }

    public function set_dt_kasus($judul='',$kategori_peng_id='',$kategori_peng_static='')
    {
        $html = '';
        if ($this->get_peng_keteg_by_id($kategori_peng_id)) {
            $html .= '<label class="badge badge-light text-danger">'.$this->get_peng_keteg_by_id($kategori_peng_id).'</label>';
        }else{
            $html .= '<label class="badge badge-primary">'.$kategori_peng_static.'</label><br>';
        }
        $html .= '<p>'.$judul.'</p>';
        return $html;
    }

    public function get_peng_keteg_by_id($id='')
    {
        if ($id != '') {
            $this->db->where('id', $id);
            $q = $this->db->get('peng_kategori');
            if ($q->num_rows() > 0) {
                return $q->row()->peng_kategori;
            }
        }

        return false;
    }

    public function insert_pengaduan()
    {
        date_default_timezone_set("Asia/Jakarta");
        // var_dump($this->input->post('pengaduan'));
        // die();
        $data = array(
            'kategori_peng_id' => $this->input->post('kasus'),
            'input_peng' => $this->input->post('pengaduan'),
            'nama_pelapor' => $this->input->post('pelapor'),
            'telp' => $this->input->post('nohp'),
            'keterangan' => $this->input->post('ket'),
            'lat' => $this->input->post('lat'),
            'lng' => $this->input->post('lng'),
            'alamat' => $this->input->post('alamat'),
            'ctddate' => date('Y-m-d'),
            'ctdtime' => date('H:i:s'),
            'ctdby' => $this->session->userdata('id'),
            'status' => 0
        );
        // var_dump($data);
        $this->db->insert('pengaduan',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function in($arr=[])
    {
        $bool = false;
        if (!empty($arr)) {
            $arr['ctddate'] = date('Y-m-d');
            $arr['ctdtime'] = date('H:i:s');
            $q = $this->db->insert('pengaduan',$arr);
            if ($this->db->affected_rows() > 0) {
                $bool = true;
            }
        }
        return $bool;
    }

    public function up($arr=[],$where=[])
    {
        $bool = false;
        if (!empty($arr)) {
            $q = $this->db->update('pengaduan',$arr,$where);
            if ($this->db->affected_rows() > 0) {
                $bool = true;
            }
        }
        return $bool;
    }

    public function in_peng_img($obj=[])
    {
        $bool = false;
        if (!empty($obj)) {
            $obj['ctddate'] = date('Y-m-d');
            $obj['ctdtime'] = date('H:i:s');
            $this->db->insert('peng_img',$obj);
            if ($this->db->affected_rows() > 0) {
                $bool = true;
            }
        }
        return $bool;
    }


    public function dt_detail_peng($filter=[])
    {
          // Definisi
          $condition = [];
          $data = [];
  
          $CI = &get_instance();
          $CI->load->model('DataTable', 'dt');
          // Set table name
          $CI->dt->table = 'task_assign as ta';
          // Set orderable column fields
          $CI->dt->column_order = [null,'nama_petugas',null,'assign_from',null,null];
          // Set searchable column fields
          $CI->dt->column_search = ['nama_petugas'];
          // Set select column fields
          $CI->dt->select = 'p.nama_petugas, ta.status, ta.assign_from, ta.id, ta.petugas_id,ta.ctddate';
          // Set default order
          $CI->dt->order = ['ta.id' => 'ASC'];

          // if (isset($filter['kategori']) && $filter['kategori'] != '' ) {
          //       $con = ['where_in','kategori_peng_id',$filter['kategori']];
          //       array_push($condition,$con);              
          // }
          
          // if (isset($filter['start_date']) && isset($filter['end_date'])) {
          //   $con = ['where','ctddate >=',$filter['start_date']];
          //   array_push($condition,$con);   
            
          //   $con = ['where','ctddate <=',$filter['end_date']];
          //   array_push($condition,$con);   
          // }

          // if (isset($filter['status']) && $filter['status'] != '' ) {
          //   $con = ['where_in','status',$filter['status']];
          //   array_push($condition,$con);              
          // }

          // if (isset($filter['operator']) && $filter['operator'] != '' ) {
          //   $con = ['where','operator',$filter['operator']];
          //   array_push($condition,$con);              
          // }

          //join table
          $con = ['join','petugas p','p.id = ta.petugas_id','inner'];
          array_push($condition,$con);

          // Fetch member's records
          $dataTabel = $this->dt->getRows(@$_POST, $condition);
  
          $i = @$this->input->post('start');
          foreach ($dataTabel as $dt) {
              $i++;
              $data[] = array(
                  $i,
                  $dt->nama_petugas,
                  // ($dt->activity == 0) ? 'Siap Bertugas' : (($dt->activity == 1) ? 'Istirahat' : (($dt->activity == 2) ? 'Sedang Menerima Tugas' : '')),
                  ($dt->status == 0 ? 'Menuggu Konfirmasi' : ($dt->status == 1 ? 'Sudah di konfirmasi': ($dt->status == 2 ? 'Tiba dilokasi' : ($dt->status == 3 ? 'ditangani' : 'Selesai')))),
                  $dt->assign_from,
                  tgl_indo($dt->ctddate),
                  $dt->id,
                  '<button class="btn btn-primary" onclick="modal_detail('.$dt->id.')">Detail</button>'
              );
          }
  
          $output = array(
              "draw" => @$this->input->post('draw'),
              "recordsTotal" => $this->dt->countAll($condition),
              "recordsFiltered" => $this->dt->countFiltered(@$this->input->post(), $condition),
              "data" => $data,
          );
  
          // Output to JSON format
          return json_encode($output);
    }

    public function dt_detail_pengaduan($filter=[])
    {
          // Definisi
          $condition = [];
          $data = [];
  
          $CI = &get_instance();
          $CI->load->model('DataTable', 'dt');
          // Set table name
          $CI->dt->table = 'task_assign as ta';
          // Set orderable column fields
          $CI->dt->column_order = [null,'nama_petugas',null,'assign_from',null,null];
          // Set searchable column fields
          $CI->dt->column_search = ['nama_petugas'];
          // Set select column fields
          $CI->dt->select = 'p.nama_petugas, ta.status, ta.assign_from, ta.id, ta.petugas_id,ta.ctddate';
          // Set default order
          $CI->dt->order = ['ta.id' => 'ASC'];

          //join table
          $con = ['join','petugas p','p.id = ta.petugas_id','inner'];
          
          array_push($condition,$con);
          // ======= detail keterangan pengaduan (Pengaduan/detail/6611) =====================
            $con = ['where','ta.pengaduan_id',$this->input->post('pengaduan_id')];
            array_push($condition,$con);
          // ==================================================================================

          // Fetch member's records
          $dataTabel = $this->dt->getRows(@$_POST, $condition);
  
          $i = @$this->input->post('start');
          foreach ($dataTabel as $dt) {
              $i++;
              $id_btn = $dt->id.",".$dt->petugas_id;
              $data[] = array(
                  $i,
                  $dt->nama_petugas,
                  // ($dt->activity == 0) ? 'Siap Bertugas' : (($dt->activity == 1) ? 'Istirahat' : (($dt->activity == 2) ? 'Sedang Menerima Tugas' : '')),
                  ($dt->status == 0 ? 'Menuggu Konfirmasi' : ($dt->status == 1 ? 'Sudah di konfirmasi': ($dt->status == 2 ? 'Tiba dilokasi' : ($dt->status == 3 ? 'ditangani' : 'Selesai')))),
                  $dt->assign_from,
                  tgl_indo($dt->ctddate),
                  $dt->id,
                  '<button class="btn btn-primary" onclick="modal_detail('.$id_btn.')">Detail</button>'
              );
          }
  
          $output = array(
              "draw" => @$this->input->post('draw'),
              "recordsTotal" => $this->dt->countAll($condition),
              "recordsFiltered" => $this->dt->countFiltered(@$this->input->post(), $condition),
              "data" => $data,
          );
  
          // Output to JSON format
          return json_encode($output);
    }
}