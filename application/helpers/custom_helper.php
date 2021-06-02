<?php

if (!function_exists('per_diagram_lingkaran')) {
	 function per_diagram_lingkaran($jml_all=0,$jml_bagi=0)
	{
		$satu_per = (1 / 100);
		$total_data = $jml_all;
		$jml_data = $jml_bagi;
		$proses_1 = $total_data * $satu_per;
		$total = $jml_data / $proses_1;
		return round($total,1);
	}
}

if (!function_exists('persen_nt')) {
	function persen_nt($awal='',$akhir=''){ //persen naik/turun
    if ($awal > $akhir) { // persen turun
      $h1 = ($awal - $akhir)/$awal;
      $h2 = $h1*100;
      return [round($h2,1),'naik'];
    }else{ //persen naik
      $selisih = $akhir - $awal;
      @$h = $selisih / $akhir;
      $xx = $h*100;
      return [round($xx,1),'turun'];
    }
  }
}

if (!function_exists('kordinat')) {
	function kordinat($kordinat=''){ //persen naik/turun
		$k = explode(',',$kordinat);
		return  [@(float)$k[0],@(float)$k[1]];
  	}
}

if (!function_exists('tgl_indo')) {
	function tgl_indo($tanggal){
        $bulan = array (
          1=>'Januari',
          'Februari',
          'Maret',
          'April',
          'Mei',
          'Juni',
          'Juli',
          'Agustus',
          'September',
          'Oktober',
          'November',
          'Desember'
        );
        $tgl = explode(' ',$tanggal);
        $pecahkan = explode('-', $tgl[0]);
        
        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun
       
        return @$pecahkan[2] . ' ' . @$bulan[ (int)$pecahkan[1] ] . ' ' . @$pecahkan[0];
   }
}

if (!function_exists('torp')) {
	function torp($v){
		$rp =  @stripos($v,',') ? $v  : @number_format($v,0,',',',');
		return 'Rp '.$rp;
	}
}

if (!function_exists('rangeDate')) {
	function rangeDate($start,$end){
		$date = [];
		$period = new DatePeriod(
			new DateTime($start),
			new DateInterval('P1D'),
			new DateTime($end)
		);
		
		foreach ($period as $key => $value) {
			array_push($date,$value->format('Y-m-d'));
		}
		
		return $date;
	}
}

if (!function_exists('mingguDepan')) {
	function mingguDepan($n='1 weeks'){
		$minggu_depan = rangeDate(date('Y-m-d'),date('Y-m-d',strtotime($n)));
		return $minggu_depan;
	}
}

if (!function_exists('mingguLalu')) {
	function mingguLalu($n='-1 weeks'){
		$minggu_lalu = rangeDate(date('Y-m-d'),date('Y-m-d',strtotime($n)));
		return $minggu_lalu;
	}
}

// Cek Data
if (!function_exists('cekData')) {
	function cekData($q,$field=''){
		if ($q->num_rows() > 0) {
			return $q->row()->$field;
		}else{
			return 0;
		}
	}
}

if (!function_exists('srlen')) {
	function srlen($n='')
	{
		$x = str_replace([0,1,2,3,4,5,6,7,8,9],['z%','x$','j#','k!','i`','u&','b*','a(','c)','f_'],$n);
		$okz= base64_encode($x);
		return $okz;
	}
}

if (!function_exists('srlde')) {
	function srlde($okj='')
	{
		$nama = base64_decode($okj);
		$x = str_replace(['z%','x$','j#','k!','i`','u&','b*','a(','c)','f_'],[0,1,2,3,4,5,6,7,8,9],$nama);
		return $x;
	}
}

if (!function_exists('setStatus')) {
	function setStatus($s='')
	{
		if ($s == 0) return "Tidak Aktif";
		if ($s == 1) return "Aktif";
	}
}

if (!function_exists('calcHours')) {
	function calcHours($startdate,$enddate)
	{
		$datetime1 = new DateTime($startdate);
		$datetime2 = new DateTime($enddate);
		$interval = $datetime1->diff($datetime2);
		$elapsed = $interval->format('%y years %m months %a days %h hours %i minutes %s seconds');
		return $elapsed;

	}
}

if (!function_exists('calc_minute')) {
	function calc_minute($startdate,$enddate)
	{
		$to_time = strtotime($enddate);
		$from_time = strtotime($startdate);
		// return round(abs($to_time - $from_time) / 60,2);
		$menit = round(abs($to_time - $from_time) / 60,2);
		return $menit*60;
	}
}

if (!function_exists('secondstoTime')) {
	function secondsToTime($durasi) {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$durasi");
        // print_r($dtF->diff($dtT));die();
        if ($dtF->diff($dtT)->format('%a') && $dtF->diff($dtT)->format('%h') && $dtF->diff($dtT)->format('%i') && $dtF->diff($dtT)->format('%s') != 0) {
            return $dtF->diff($dtT)->format('%a hari %h jam %i menit %s detik');
        }
        else if ($dtF->diff($dtT)->format('%a') && $dtF->diff($dtT)->format('%h') && $dtF->diff($dtT)->format('%i') != 0) {
            return $dtF->diff($dtT)->format('%a hari %h jam %i menit');
        }
        else if ($dtF->diff($dtT)->format('%a') && $dtF->diff($dtT)->format('%h') && $dtF->diff($dtT)->format('%s') != 0) {
            return $dtF->diff($dtT)->format('%a hari %h jam %s detik');
        }
        else if ($dtF->diff($dtT)->format('%a') && $dtF->diff($dtT)->format('%h') != 0) {
            return $dtF->diff($dtT)->format('%a hari %h jam');
        }
        else if ($dtF->diff($dtT)->format('%a') && $dtF->diff($dtT)->format('%i') && $dtF->diff($dtT)->format('%s') != 0) {
            return $dtF->diff($dtT)->format('%a hari %i menit %s detik');
        }
        else if ($dtF->diff($dtT)->format('%a') && $dtF->diff($dtT)->format('%i') != 0) {
            return $dtF->diff($dtT)->format('%a hari %i menit');
        }
        else if ($dtF->diff($dtT)->format('%a') && $dtF->diff($dtT)->format('%s') != 0) {
            return $dtF->diff($dtT)->format('%a hari %s detik');
        }
        else if ($dtF->diff($dtT)->format('%h') && $dtF->diff($dtT)->format('%i') && $dtF->diff($dtT)->format('%s') != 0) {
            return $dtF->diff($dtT)->format('%h jam %i menit %s detik');
        }
        else if ($dtF->diff($dtT)->format('%h') && $dtF->diff($dtT)->format('%s') != 0) {
            return $dtF->diff($dtT)->format('%h jam %s detik');
        }
        else if ($dtF->diff($dtT)->format('%h') && $dtF->diff($dtT)->format('%i') != 0) {
            return $dtF->diff($dtT)->format('%h jam %i menit');
        }
        else if ($dtF->diff($dtT)->format('%s') && $dtF->diff($dtT)->format('%i') != 0) {
            return $dtF->diff($dtT)->format('%i menit %s detik');
        }
        else if ($dtF->diff($dtT)->format('%s') != 0) {
            return $dtF->diff($dtT)->format('%s detik');
        }
        else if ($dtF->diff($dtT)->format('%i') != 0) {
            return $dtF->diff($dtT)->format('%i menit');
        }
        else if ($dtF->diff($dtT)->format('%h') != 0) {
            return $dtF->diff($dtT)->format('%h jam');
        }
        else if ($dtF->diff($dtT)->format('%a') != 0) {
            return $dtF->diff($dtT)->format('%a hari');
        }
    }

    if (!function_exists('setActivityPetugas')) {
        function setActivityPetugas($s='')
        {
            if ($s == 0) return "Siap Bertugas";
            if ($s == 1) return "Istirahat";
            if ($s == 2) return "Sedang Menerima Tugas";
        }
    }

    if (!function_exists('setStatusPengaduan')) {
        function setStatusPengaduan($s='')
        {
            if ($s == 0) return "Menuggu Konfirmasi";
            if ($s == 1) return "Konfirmasi & Menuju Lokasi";
            if ($s == 2) return "Tiba di Lokasi";
            if ($s == 3) return "Di Proses";
            if ($s == 4) return "Selesai";
        }
    }
    
}