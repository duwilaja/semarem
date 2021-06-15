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
                    $q = @$this->db->get_where('task_kategori',['id' => $id])->row()->task_kategori;
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
                        'status' => $status,
                        'lat' => $lat,
                        'lng' => $lng,
                        'task_assign_id' => $task_assign->id
                    ]
                );
            }
        }
        return $bool;
    }

    public function task_where($where)
    {
        $q = $this->db->get_where('task', $where);
        return $q;
    }

    public function in_task($arr=[])
    {
        $bool = false;
        if (!empty($arr)) {
            $arr['ctddate'] = date('Y-m-d');
            $arr['ctdtime'] = date('H:i:s');
            $q = $this->db->insert('task',$arr);
            if ($this->db->affected_rows() > 0) {
                $bool = true;
            }
        }
        return $bool;
    }

    public function task_assign_where($select='ta.*',$where=[])
    {
        $this->db->select($select);
        $this->db->join('petugas p', 'p.id = ta.petugas_id', 'left');
        $this->db->join('instansi i', 'i.id = p.instansi_id', 'left');
        $q = $this->db->get_where('task_assign ta', $where);
        return $q;
    }

    public function in_task_assign($arr=[])
    {
        $bool = false;
        if (!empty($arr)) {
            $arr['ctddate'] = date('Y-m-d');
            $arr['ctdtime'] = date('H:i:s');
            $q = $this->db->insert('task_assign',$arr);
            if ($this->db->affected_rows() > 0) {
                $bool = true;
                $this->in_task_log(
                    [
                        'petugas_id' => $arr['petugas_id'],
                        'task_id' => $arr['task_id'],
                        'status' => 0,
                        'task_assign_id' => $this->db->insert_id()
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
            $arr['timestamp'] = date('Y-m-d H:i:s');
            $q = $this->db->insert('task_log',$arr);
            if ($this->db->affected_rows() > 0) {
                $bool = true;
            }
        }
        return $bool;
    }

    public function task_assign_log($task_id='')
    {
        $this->db->select('ta.petugas_id,ta.task_assign_id,p.nama_petugas,i.nama_instansi,p.instansi_id,ta.status,ta.ctddate,ta.ctdtime');
        $this->db->join('petugas p', 'p.id = ta.petugas_id', 'left');
        $this->db->join('instansi i', 'i.id = p.instansi_id', 'left');
        $this->db->order_by('ta.id', 'desc');
        $q = $this->db->get_where('task_log ta', ['ta.task_id' => $task_id]);
        return $q;
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

    public function task_done($arr=[])
    {
       if (!empty($arr)){
            if (!empty($arr[0]) && $arr[0] != '') 
                $this->db->select($arr[0]);
        
            if (!empty($arr[1])) 
                $this->db->where($arr[1]);

            if (!empty($arr[2])) 
                $this->db->where_in($arr[2]);
        }
        
       $q = $this->db->get('task_done td');
       return $q; 
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

    public function task_img_task_assign_id($select='',$task_assign_id='')
    {
        $q = [];
        if ($task_assign_id != '') {
            if($select != ''){
                $task_done = $this->task_done([
                    'td.id',
                    ['td.task_assign_id' => $task_assign_id]
                ]);
                if ($task_done->num_rows() > 0) {
                    $this->db->select($select);
                    $q = $this->db->get_where('task_img',['task_done_id' => $task_done->row()->id]);
                }
            }
        }

        return $q;
    }

    public function task_img_id($select='',$id='')
    {
        $q = [];
        if ($id != '') {
            if($select != ''){
                $this->db->select($select);
                $q = $this->db->get_where('task_img',['id' => $id]);
            }
        }

        return $q;
    }

    public function lama_penanganan($task_assign_id='')
    {
        $rsp = [
            'assign_date' => '',
            'action_date' => '',
            'done_date' => '',
            'calc' => 0
        ];

        $log_first = $this->db->get_where('task_log',['task_assign_id' => $task_assign_id,'status' => '0']);
        $log_action = $this->db->get_where('task_log',['task_assign_id' => $task_assign_id,'status' => '1']);
        $log_done = $this->db->get_where('task_log',['task_assign_id' => $task_assign_id,'status' => '4']);

        if ($log_done->num_rows() > 0 && $log_first->num_rows() > 0) {
            $log_firstx = $log_first->first_row();
            $log_done = $log_done->last_row();
            $rsp['done_date'] = $log_done->timestamp;
            $rsp['done_time'] = $log_done->ctdtime;
            $rsp['done_date_name'] = tgl_indo($log_done->ctddate);
            $rsp['calc'] = calc_minute($log_firstx->timestamp,$log_done->timestamp)/60;
        }

        if($log_first->num_rows() > 0){
            $log_first = $log_first->first_row();
            $rsp['assign_date'] = $log_first->timestamp;
            $rsp['assign_time'] = $log_first->ctdtime;
            $rsp['assign_date_name'] = tgl_indo($log_first->ctddate);
        } 

        if($log_action->num_rows() > 0){
            $log_action = $log_action->first_row();
            $rsp['action_date'] = $log_action->timestamp;
            $rsp['action_time'] = $log_action->ctdtime;
            $rsp['action_date_name'] = tgl_indo($log_action->ctddate);
        } 

        return $rsp;
    }

}