<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MKategori extends CI_Model {


    public $see = '*';
    private $id = 'id';
    private $t = 'peng_kategori';

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
          $CI->dt->column_order = [null,'peng_kategori'];
          // Set searchable column fields
          $CI->dt->column_search = ['peng_kategori'];
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
                  $dt->peng_kategori,
                  '<a href="javascript:void(0);" class="btn btn-warning" onclick="modal_edit('.$dt->id.')"><i class="fa fa-edit"></i></a>
                   <a href="javascript:void(0);" class="btn btn-danger" onclick="del('.$dt->id.')"><i class="fa fa-trash"></i></a>'
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