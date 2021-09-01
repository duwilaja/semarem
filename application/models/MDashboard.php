<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MDashboard extends CI_Model {

    public function get_total($start='',$end='')
    {
        // $get_masuk = $this->db->get_where('pengaduan',array('ctddate >=' => $start, 'ctddate <=' => $end))->();
        $get_masuk =  $this->db->where('ctddate >=',$start)->where('ctddate <=', $end)->from("pengaduan")->count_all_results();
        $get_konfirmasi =  $this->db->where('ctddate >=',$start)->where('ctddate <=', $end)->where('status ', 0) ->from("pengaduan")->count_all_results();
        $get_proses =  $this->db->where('ctddate >=',$start)->where('ctddate <=', $end)->where('status ', 2) ->from("pengaduan")->count_all_results();
        $get_selesai =  $this->db->where('ctddate >=',$start)->where('ctddate <=', $end)->where('status ', 3) ->from("pengaduan")->count_all_results();

        $res_array = array(
            'masuk' => $get_masuk,
            'konfirmasi' => $get_konfirmasi,
            'proses' => $get_proses,
            'selesai' => $get_selesai
        ); 
        return $res_array;
    }

    public function get_vendor($start='',$end='')
    {
        // $get_masuk = $this->db->get_where('pengaduan',array('ctddate >=' => $start, 'ctddate <=' => $end))->();
        // $get_masuk =  $this->db->where('ctddate >=',$start)->where('ctddate <=', $end)->from("pengaduan")->count_all_results();
        $get0 =  $this->db->where('ctddate >=',$start)->where('ctddate <=', $end)->where('vendor_id ', 0) ->from("pengaduan")->count_all_results();
        $get1 =  $this->db->where('ctddate >=',$start)->where('ctddate <=', $end)->where('vendor_id ', 1) ->from("pengaduan")->count_all_results();
        $get2 =  $this->db->where('ctddate >=',$start)->where('ctddate <=', $end)->where('vendor_id ', 2) ->from("pengaduan")->count_all_results();

        $res_array = array(
            'vend_0' => $get0,
            'vend_1' => $get1,
            'vend_2' => $get2
        ); 
        return $res_array;
    }
    public function get_grafik_pengaduan($start='',$end='')
    {
        $get_masuk =  $this->db->where('ctddate >=',$start)->where('ctddate <=', $end)->from("pengaduan")->count_all_results();
        $get_konfirmasi =  $this->db->where('ctddate >=',$start)->where('ctddate <=', $end)->where('status ', 1) ->from("pengaduan")->count_all_results();
        $get_proses =  $this->db->where('ctddate >=',$start)->where('ctddate <=', $end)->where('status ', 2) ->from("pengaduan")->count_all_results();
        $get_selesai =  $this->db->where('ctddate >=',$start)->where('ctddate <=', $end)->where('status ', 4) ->from("pengaduan")->count_all_results();

		$series =  [
			'data' => [$get_masuk,$get_konfirmasi,$get_proses,$get_selesai],
		];
		
        return $series;
    }
    public function get_peng_kategori($start='',$end='')
    {
        $sql = "SELECT fk.peng_kategori as kategori ,COUNT(pk.kategori_peng_id) as total FROM pengaduan as pk LEFT join peng_kategori as fk on pk.kategori_peng_id=fk.id where ctddate >= '$start' and ctddate <= '$end'  GROUP by pk.kategori_peng_id order by total DESC LIMIT 3";
        $dt = $this->db->query($sql)->result();
        return $dt;
    }
	
}