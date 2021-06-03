<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class MTask extends CI_Model{
    
    function __construct() {
      
    }
    
    public function task_assign($arr=[])
    {
       if (!empty($arr)){
            if (!empty($arr[0]) && $arr[0] != '') 
                $this->db->select($arr[0]);
        
            if (!empty($arr[1])) 
                $this->db->where($arr[1]);

            if (!empty($arr[2])) 
                $this->db->where_in($arr[2]);
        }
        
       $this->db->join('pengaduan p', 'p.id = ta.pengaduan_id', 'inner');   
       $q = $this->db->get('task_assign ta');
       return $q; 
    }

    public function task_kategori($select='',$id='',$return=false)
    {
        $q = '';
        if ($id != '') {
            if($select != ''){
                $this->db->select($select);
                if($return){
                    $q = $this->db->get_where('task_kategori',['id' => $id])->row()->task_kategori;
                }else{
                    $q = $this->db->get_where('task_kategori',['id' => $id]);
                }
            }
        }

        return $q;
    }

    public function set_status_task_assign($task_assign_id='',$status='',$lat='',$lng='')
    {
        $bool = false;
        if ($task_assign_id != '' && $status != '') {
            $q = $this->db->update('task_assign',['status' => $status,'lat' => $lat,'lng' => $lng],['id' => $task_assign_id]);
            if ($this->db->affected_rows() > 0) {
                $bool = true;
                $task_assign = $this->task_assign([
                    'ta.petugas_id,ta.task_id,ta.id',
                    ['ta.id' => $task_assign_id]
                ])->row();
                $this->in_task_log(
                    [
                        'petugas_id' => $task_assign->petugas_id,
                        'task_id' => $task_assign->task_id,
                        'lat' => $lat,
                        'lng' => $lng,
                        'task_assign_id' => $task_assign->id
                    ]
                );
            }
        }
        return $bool;
    }

    public function in_task_log($arr=[])
    {
        $bool = false;
        if (!empty($arr)) {
            $arr['ctddate'] = date('Y-m-d');
            $arr['ctdtime'] = date('H:i:s');
            $q = $this->db->insert('task_log',$arr);
            if ($this->db->affected_rows() > 0) {
                $bool = true;
            }
        }
        return $bool;
    }

    public function in_batch_task_img($obj=[])
    {
        $bool = false;
        if (!empty($obj)) {
            $obj['ctddate'] = date('Y-m-d');
            $obj['ctdtime'] = date('H:i:s');
            $this->db->insert('task_img',$obj);
            if ($this->db->affected_rows() > 0) {
                $bool = true;
            }
        }
        return $bool;
    }

    public function form_task_done($obj=[])
    {
        $bool = false;
        if (!empty($obj)) {
            $obj['ctddate'] = date('Y-m-d');
            $obj['ctdtime'] = date('H:i:s');
            $task_assign = $this->task_assign([
                'ta.petugas_id,ta.task_id,ta.id',
                ['ta.id' => $obj['task_assign_id']]
            ])->row();
            $obj['task_id'] = $task_assign->task_id;
            $this->db->insert('task_done',$obj);
            if ($this->db->affected_rows() > 0) {
                $bool = true;
            }
        }
        return $bool;
    }

}