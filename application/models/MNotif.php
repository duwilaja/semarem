<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class MNotif extends CI_Model{
    
    private $t = 'notif';
    public $see = '*';

    function __construct() {
        
    }
    
    public function get($select='',$id='',$where='',$groupby='')
    {
        if ($select == '') {
            $select = $this->see;
        } 
        $this->db->select($select);
        
        if ($groupby != '') {
            $this->db->group_by($groupby);
        }

        if($id != ''){
            $q = $this->db->get_where($this->t,['id' => $id]);
        }else if($where != ''){
            $this->db->where($where);
            $q = $this->db->get($this->t);
        }else{
            $q = $this->db->get($this->t);
        }
        return $q;
    }

    public function dt($filter=[])
    {
          // Definisi
          $condition = [];
          $data = [];
  
          $CI = &get_instance();
          $CI->load->model('DataTable', 'dt');
  
          // Set table name
          $CI->dt->table = $this->t;
          // Set orderable column fields
          $CI->dt->column_order = [null,'msg','from_user','user_to'];
          // Set searchable column fields
          $CI->dt->column_search = ['info','msg'];
          // Set select column fields
          $CI->dt->select = $this->see;
          // Set default order
          $CI->dt->order = ['id' => 'desc'];

          // Fetch member's records
          if (!empty($filter['to_user'])) {
            $con = ['where','to_user',$filter['to_user']];
            array_push($condition,$con);  
          }

          if (isset($filter['start_date']) && isset($filter['end_date'])) {
            $con = ['where','ctddate >=',$filter['start_date']];
            array_push($condition,$con);   
            
            $con = ['where','ctddate <=',$filter['end_date']];
            array_push($condition,$con);   
          }

          $dataTabel = $this->dt->getRows($_POST, $condition);
  
          $i = @$_POST['start'];
          foreach ($dataTabel as $dt) {
              $i++;
              $data[] = array(
                  $i,
                  $dt->info.'<br>'.$dt->msg,
                  $this->get_user_name($dt->from_user,$dt->from_app),
                  $this->get_user_name($dt->to_user,$dt->to_app),
                  tgl_indo($dt->ctddate).' '.$dt->ctdtime,
                  $dt->read == 1 ? '<a href="#" onclick="read_notif('.$dt->id.')" class="btn btn-sm btn-success">Sudah dibaca</a>' : '<a href="#" onclick="read_notif('.$dt->id.')" class="btn btn-sm btn-secondary">Baca</a>'
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

    public function get_user_name($id='',$app='SM')
    {
        $name = '';
        // Back Office Korlantas
        if ($app == "SM") {
            $db2 = $this->load->database('sm',true);
            $q = $db2->get_where('persons',['rowid' => $id]);
            if ($q->num_rows() > 0) $name = $q->row()->nama;
        }else if($app == "APP_PETUGAS"){
            $q = $this->db->get_where('petugas',['id' => $id]);
            if ($q->num_rows() > 0) $name = $q->row()->nama_petugas;
        }

        return $name;
        
    }

}