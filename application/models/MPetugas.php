<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class MPetugas extends CI_Model{
    
    private $t = 'petugas';
    public $see = '*';

    function __construct() {
      
    }
    
    public function get($arr=[])
    {
       if (!empty($arr)){
            if (!empty($arr[0]) && $arr[0] != '') 
                $this->db->select($arr[0]);
        
            if (!empty($arr[1])) 
                $this->db->where($arr[1]);
        }
        
       $this->db->join('instansi i', 'i.id = p.instansi_id', 'inner');
       $this->db->join('unit unt', 'unt.id = p.unit_id', 'inner');
       $q = $this->db->get('petugas p');
       return $q; 
    }

    public function set_activity($petugas_id='',$activity='')
    {
        $bool = false;
        if ($petugas_id != '' && $activity != '') {
            $q = $this->db->update('petugas',['activity' => $activity],['id' => $petugas_id]);
            if ($this->db->affected_rows() > 0) {
                $bool = true;
            }
        }
        return $bool;
    }
    
    public function in($arr=[])
    {
        $bool = false;
        if (!empty($arr)) {
            $arr['ctddate'] = date('Y-m-d');
            $arr['ctdtime'] = date('H:i:s');
            $q = $this->db->insert($this->t,$arr);
            if ($this->db->affected_rows() > 0) {
                $bool = true;
            }
        }
        return $bool;
        
    }

    public function up($arr=[],$where='')
    {
        $bool = false;
        if (!empty($arr)) {
            $q = $this->db->update($this->t,$arr,$where);
            if ($this->db->affected_rows() > 0) {
                $bool = true;
            }
        }
        return $bool;
    }

    public function dt()
    {
          // Definisi
          $condition = [];
          $data = [];
  
          $CI = &get_instance();
          $CI->load->model('DataTable', 'dt');
  
          // Set table name
          $CI->dt->table = $this->t.' as p';
          // Set orderable column fields
          $CI->dt->column_order = [null,'nama_petugas','unit','nama_instansi','activity'];
          // Set searchable column fields
          $CI->dt->column_search = ['nama_petugas','unit','nama_instansi'];
          // Set select column fields
          $CI->dt->select = 'p.id as id,nama_instansi,unit,p.ctddate,p.ctdtime,nama_petugas,hp,activity';
          // Set default order
          $CI->dt->order = ['p.id' => 'desc'];

          //where
          $con = ['where','p.aktif',1];
          array_push($condition,$con);

          //join table
          $con = ['join','unit u','u.id = p.unit_id','left'];
          array_push($condition,$con);

          $con = ['join','instansi i','i.id = p.instansi_id','left'];
          array_push($condition,$con);

          // Fetch member's records
          $dataTabel = $this->dt->getRows($_POST, $condition);
  
          $i = @$_POST['start'];
          foreach ($dataTabel as $dt) {
              $i++;
              $data[] = array(
                  $i,
                  $dt->nama_petugas,
                  $dt->hp,
                  $dt->nama_instansi,
                  $dt->unit,
                  ($dt->activity == 0) ? 'Siap Bertugas' : (($dt->activity == 1) ? 'Istirahat' : (($dt->activity == 2) ? 'Sedang Menerima Tugas' : '')),
                  '<div class="btn-group-wrapper">
                    <div class="btn-group">
                        <button class="btn btn-warning" onclick="modal_edit('.$dt->id.')"><i class="fa fa fa-edit"></i></button>
                        <button class="btn btn-secondary" onclick="del('.$dt->id.')"><i class="fa fa-trash"></i></button>
                    </div>
                  </div>'
              );
          }
  
          $output = array(
              "draw" => @$_POST['draw'],
              "recordsTotal" => $this->dt->countAll($condition),
              "recordsFiltered" => $this->dt->countFiltered(@$_POST, $condition),
              "data" => $data,
          );
  
          // Output to JSON format
          return json_encode($output);
    }

}