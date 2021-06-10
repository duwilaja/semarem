<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
  
  class Bantuan {
    
    
    public function __construct() {
    
      $this->CI = &get_instance();
    
    }

    public function send_notif($judul='',$to='',$pesan='',$redirect='')
    {
       $this->CI->load->model('Notif','notif');
       $this->CI->notif->inNotif(
        $judul,
        $this->CI->session->userdata('karyawan_id'),
        $to,
        '<span class="label label-info">'.$judul.'</span></br>'.$pesan,
        $redirect);
    }
  }