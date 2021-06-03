<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MInstansi extends CI_Model {


    public $see = '*';
    private $id = 'id';
    private $t = 'instansi';

    public function get($id='',$where='',$query='',$limit='',$start='')
    {
        $q = false;

        if ($id != '') {
            $this->db->order_by('id', 'desc');
            $this->db->select($this->see);
           $q = $this->db->get_where($this->t, [$this->id => $id]);
        }elseif ($where != '') {
            $this->db->order_by('id', 'desc');
            $this->db->select($this->see);
           $q = $this->db->get_where($this->t, $where);
        }elseif ($query != '') {
            $q = $this->db->query($query);
        }elseif($limit != ''){
            $this->db->order_by('id', 'desc');
            $this->db->select($this->see);
            $q = $this->db->get_where($this->t,$where,$limit,$start);
        }else{
            $this->db->order_by('id', 'desc');
            $this->db->select($this->see);
           $q = $this->db->get($this->t);
        }

        return $q;
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

    public function del($id='')
    {
        $bool = false;
        if (!empty($id)) {
            $q = $this->db->delete($this->t,$id);
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
          $CI->dt->table = $this->t;
          // Set orderable column fields
          $CI->dt->column_order = [null,'nama_instansi'];
          // Set searchable column fields
          $CI->dt->column_search = ['nama_instansi'];
          // Set select column fields
          $CI->dt->select = $this->see;
          // Set default order
          $CI->dt->order = ['id' => 'desc'];

          // Fetch member's records
          $dataTabel = $this->dt->getRows($_POST, $condition);
  
          $i = @$_POST['start'];
          foreach ($dataTabel as $dt) {
              $i++;
              $data[] = array(
                  $i,
                  $dt->nama_instansi,
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