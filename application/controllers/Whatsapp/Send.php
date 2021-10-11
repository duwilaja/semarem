<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send extends CI_Controller {
	
	public function __construct()
    {
		parent::__construct();
	}

    public function token()
    {
        $token= "E78TL6be6JYFIt3Zb7MMDGqbdcxxYZvjCH8F8eAC4s5kMUYQJo";
        return $token;
    }
    public function send_message($telpon='',$status='')
    {
        $telpon = '085893014133';//$this->input->post('telepon');
        $status = 1;//$this->input->post('status');
        $message =  '';
        if ($status == 1) {
            $message = "Laporan Anda Sudah Dikonfirmasi";
        }
        if ($status == 2) {
            $message = "Laporan Anda Sedang Ditangani";
        }
        if ($status == 4) {
            $message = "Laporan Anda Selesai Ditangani";
        }
        if (!$this->session->userdata('id')) {
            $data = [
                'result' => false,
                'data' => 'session Tidak Valid',
            ];
            echo json_encode($data);
		}else{
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.ruangwa.id/api/send_message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'token='.$this->token().'&number='.$telpon.'&message='.$message.'',
            ));
            $response = curl_exec($curl);    
            curl_close($curl);
            $data = [
                'result' => true,
                'data' => 'pesan terkirim'
                // 'data' => $response,
            ];
            echo json_encode($data);
        }

        
    }

}
