
<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class API extends CI_Controller {

    private $email = 'admin@iotrans.id';
    private $password = 'iottrans2021';

    public function __construct()
    {
        parent::__construct();
    }

    function api_token()  // get token api
    {
        $curl = curl_init();
        $search = array("email" => $this->email, "password" => $this->password);
        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://api.solo.indicar.id/users/login",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            ),
        CURLOPT_POSTFIELDS => json_encode($search),    
        ));

        $response = curl_exec($curl);
        $data = json_decode($response, true);
        return $data;
    }

    function get_token() // ambil token terbaru
    {
        $t = [];

        $indicarKey = $this->db->get('indicar_key');

        if ($indicarKey->num_rows() > 0) {
            $x = $indicarKey->last_row('array');
            $exp = date('Y-m-d H:i:s', $x['exp_date']);
            if(date('Y-m-d H:i:s') > $exp){
                $t = $this->api_token();
                $this->db->insert('indicar_key', [
                    'token' => $t['token'],
                    'indicarToken' => $t['indicarToken'],
                    'exp_date' => $t['tokenExpired']
                ]);
            }else{
                $t = $x;
            }
        }else{
            $t = $this->api_token();
            $this->db->insert('indicar_key', [
                'token' => $t['token'],
                'indicarToken' => $t['indicarToken'],
                'exp_date' => $t['tokenExpired']
            ]);
        }
        
        $rsp = [
            'token' => $t['token'],
            'indicarToken' => $t['indicarToken']
        ];
        
        echo json_encode($rsp);
    }

    function get_http()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://api.solo.indicar.id/kendaraan/list",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",    
            // "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodHRwOi8vc2NoZW1hcy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR5L2NsYWltcy9uYW1laWRlbnRpZmllciI6IjE3MyIsImh0dHA6Ly9zY2hlbWFzLnhtbHNvYXAub3JnL3dzLzIwMDUvMDUvaWRlbnRpdHkvY2xhaW1zL25hbWUiOiJJT1QuS09STEFOVEFTQEdNQUlMLkNPTSIsIkFzcE5ldC5JZGVudGl0eS5TZWN1cml0eVN0YW1wIjoiYTZhNjI0YzMtZDhmYi00NzI4LTdlN2MtMzlmYjJlNjdkNjQyIiwiaHR0cDovL3NjaGVtYXMubWljcm9zb2Z0LmNvbS93cy8yMDA4LzA2L2lkZW50aXR5L2NsYWltcy9yb2xlIjoiQWRtaW5HcnVwIiwic3ViIjoiMTczIiwianRpIjoiYTY0NDZkM2ItNzcxNS00YWFlLWFjYzAtMGRkN2RmYTIwNjgyIiwiaWF0IjoxNjIwMTA1MzA4LCJ1c2VybmFtZSI6IklPVC5LT1JMQU5UQVNAR01BSUwuQ09NIiwiZnVsbG5hbWUiOiJJbmRpY2FyIERlbW8gIiwic3RhdHVzIjoiQWN0aXZlIiwicm9sZV9uYW1lIjoiQWRtaW5HcnVwLEFkbWluR3J1cCIsImV4cGlyZWQiOiIwNS8wNS8yMDIxIDA1OjE1OjA4IiwidHlwZV91c2VyIjoiQ3VzdG9tZXIiLCJ0ZW5hbnQiOiJEZWZhdWx0IiwiZ3JvdXAiOiJpb3Qua29ybGFudGFzQGdtYWlsLmNvbSxpb3Qua29ybGFudGFzQGdtYWlsLmNvbSIsImN1c3RvbWVyY29kZSI6IjhhYzhiYjY5MWI4OWFkNDk1Y2Q5NTkzZWZhMWZhMmRhIiwidGVuYW50Y29kZSI6IiIsInVzZXJjb2RlIjoiOTg5MDIzZDIwMTAxODU3ZjE4ZWU0OWU3NmYzNGRmZmUiLCJuYmYiOjE2MjAxMDUzMDgsImV4cCI6MTYyMDE5MTcwOCwiaXNzIjoiSW5kaUNhckJhY2tlbmQiLCJhdWQiOiJJbmRpQ2FyQmFja2VuZCJ9.RcuRItz7NOeN8CJppet7C35e-k__e1hQ_cmut-iyaJU"
            // $token
        ),
        ));

        $response = curl_exec($curl);
        $data = json_decode($response, true);
        return $data;
    }

    function crud($url,$CURLOPT_HTTPHEADER,$CURLOPT_POSTFIELDS)  // insert
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => $CURLOPT_HTTPHEADER,
        CURLOPT_POSTFIELDS => json_encode($CURLOPT_POSTFIELDS),    
        ));

        $response = curl_exec($curl);
        $data = json_decode($response, true);
        return $data;
    }

    function cek_token($type=""){  // cek exp date token
        date_default_timezone_set("Asia/Jakarta");
        $token = '';
        $indicarToken = '';
        $this->db->order_by('rowid', 'desc');
        $dt = $this->db->get('indicar_key',1);
        $datetime = date('Y-m-d H:i:s');
        $now = strtotime($datetime);
        $status = "";
        $exp = "";

        if($dt->num_rows() > 0){
            $dtx = $dt->row(); 
            $exp = $dtx->exp_date;
            $token = $dtx->token;
            if($type==1) $token = $dtx->indicarToken; //indicar
        } 
        if (!empty($exp)) {
            if ($exp <= $now) {
                $token = $this->in_token($type);
                $status = "Token Telah Diupdate";
            }else{
                $status = "Token belum expired";
            }   
        }else{
            $token = $this->in_token($type);
            $status = "Token Telah Ditambah";
        }
        $result = array(
            'status' => true,
            'ket' => $status,
            'token' => $token
        );
        return $result;

    }

    public function in_token($type='')
    {
        $data = $this->api_token();
        $token = $data['token'];
        $token_biasa = $token;
        if($type==1) $token = $data['indicarToken'];
        $indicarToken =$data['indicarToken'];
        $tokenExpired = $data['tokenExpired'];
        $status = "get Token Baru";
        $insert_token =  array(
            'token' => $token_biasa ,
            'indicarToken' => $indicarToken,
            'ctddate' =>  date('Y-m-d H:i:s'),
            'exp_date' => $tokenExpired
        );
        $this->db->insert('indicar_key',$insert_token);
        return $token;
    }

    


    public function dt_pengaduan()
    {
        $url = "http://api.solo.indicar.id/pengaduan/list";
        $search = array("limit" => "", "page" => "");
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6NiwibmFtYSI6InVzZXIyIiwiZW1haWwiOiJ1c2VyMkBnbWFpbC5jb20iLCJub2hwIjoiIiwicm9sZSI6IiIsInZhbGlkYXRlIjoiIiwiaWF0IjoxNjIwMjg0Mjc0LCJleHAiOjE2MjAzNzA2NzR9.ns2rM6pwNB59oQ3Z9h9sRmkNwadX2KyUHMf1Dzngrt0"
            ),
        CURLOPT_POSTFIELDS => json_encode($search),    
        ));

        $response = curl_exec($curl);
        $api = json_decode($response, true);
        $apis = $api['dataset'];
        foreach ($apis as $key => $val) {
            $data[] = array(
                $val['pengaduanid'],
                $val['judul'],
                $val['nama_kategori'],
                $val['latitude'],
                $val['longitude'],
                $val['nama_status'],
                '<div class="btn-group align-top">
                </div>',
                // '<div class="btn-group align-top">
                //    <a href="javascript:void(0)" title="Edit" onclick="f_edit('. $val['pengaduanid'].')"  class="btn btn-sm btn-outline-primary badge" ><i class="fa fa-edit"></i> Edit </a>
                //    <button class="btn btn-sm btn-outline-primary badge" type="button" data-toggle="modal" data-target="#f_detail"><i class="fa fa-eye"></i></button>
                //    <button class="btn btn-sm btn-outline-primary badge" onclick="f_delete('. $val['pengaduanid'].')" type="button"><i class="fa fa-trash"></i></button>
                // </div>',
            );
        }

        $output = array(
            "data" => $data
        );
        return json_encode($output);
    }
    
    public function dt_list_petugas()
    {
        $url = "http://api.solo.indicar.id/users/list/petugas";
        $search = array("search" => "", "=status" => "");
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6NiwibmFtYSI6InVzZXIyIiwiZW1haWwiOiJ1c2VyMkBnbWFpbC5jb20iLCJub2hwIjoiIiwicm9sZSI6IiIsInZhbGlkYXRlIjoiIiwiaWF0IjoxNjIwMjg0Mjc0LCJleHAiOjE2MjAzNzA2NzR9.ns2rM6pwNB59oQ3Z9h9sRmkNwadX2KyUHMf1Dzngrt0"
            ),
        CURLOPT_POSTFIELDS => json_encode($search),    
        ));

        $response = curl_exec($curl);
        $api = json_decode($response, true);
        $apis = $api['dataset'];
        foreach ($apis as $key => $val) {
            $data[] = array(
                $val['userid'],
                $val['nama'],
                $val['kendaraannama'],
                $val['kendaraannopol'],
                $val['nama_status'],
                '<div class="btn-group align-top">
                </div>',
                // '<div class="btn-group align-top">
                //    <a href="javascript:void(0)" title="Edit" onclick="f_edit('. $val['userid'].')"  class="btn btn-sm btn-outline-primary badge" ><i class="fa fa-edit"></i> Edit </a>
                //    <button class="btn btn-sm btn-outline-primary badge" type="button" data-toggle="modal" data-target="#f_detail"><i class="fa fa-eye"></i></button>
                //    <button class="btn btn-sm btn-outline-primary badge" onclick="f_delete('. $val['userid'].')" type="button"><i class="fa fa-trash"></i></button>
                // </div>',
            );
        }

        $output = array(
            "data" => $data
        );
        return json_encode($output);
    }

    public function dt_kendaraan()
    {
        $url = "http://api.solo.indicar.id/kendaraan/list";
        $search = array("search" => "", "=status" => "");
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6NiwibmFtYSI6InVzZXIyIiwiZW1haWwiOiJ1c2VyMkBnbWFpbC5jb20iLCJub2hwIjoiIiwicm9sZSI6IiIsInZhbGlkYXRlIjoiIiwiaWF0IjoxNjIwMjg0Mjc0LCJleHAiOjE2MjAzNzA2NzR9.ns2rM6pwNB59oQ3Z9h9sRmkNwadX2KyUHMf1Dzngrt0"
            ),
        CURLOPT_POSTFIELDS => json_encode($search),    
        ));

        $response = curl_exec($curl);
        $api = json_decode($response, true);
        $apis = $api['dataset'];
        $i=1;
        foreach ($apis as $key => $val) {
            $data[] = array(
                $i++,
                // $val['kendaraanid'],
                $val['kendaraannama'],
                $val['kendaraannopol'],
                $val['latitude'],
                $val['longitude'],
                '<div class="btn-group align-top">
                   <a href="javascript:void(0)" title="Edit" onclick="f_edit('. $val['kendaraanid'].')"  class="btn btn-sm btn-outline-primary badge" ><i class="fa fa-edit"></i> Edit </a>
                   <button class="btn btn-sm btn-outline-primary badge" type="button" data-toggle="modal" data-target="#f_detail"><i class="fa fa-eye"></i></button>
                   <button class="btn btn-sm btn-outline-primary badge" onclick="f_delete('. $val['kendaraanid'].')" type="button"><i class="fa fa-trash"></i></button>
                </div>',
            );
        }

        $output = array(
            "data" => $data
        );
        return json_encode($output);
    }

    public function refresh_pengaduan()
    {
        $url = "http://api.solo.indicar.id/pengaduan/update/status";
        $search = array("pengaduanid\r" => "any", "status\r" => "any");
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6NiwibmFtYSI6InVzZXIyIiwiZW1haWwiOiJ1c2VyMkBnbWFpbC5jb20iLCJub2hwIjoiIiwicm9sZSI6IiIsInZhbGlkYXRlIjoiIiwiaWF0IjoxNjIwMjg0Mjc0LCJleHAiOjE2MjAzNzA2NzR9.ns2rM6pwNB59oQ3Z9h9sRmkNwadX2KyUHMf1Dzngrt0"
            ),
        CURLOPT_POSTFIELDS => json_encode($search),    
        ));

        $response = curl_exec($curl);
        $api = json_decode($response, true);
        return json_encode($api);
    }


    function detail_kendaraan($kendaraanid)
    {
        $this->db->select('kendaraannama');
        $this->db->from('indicar_data_kendaraan');
        $this->db->where('kendaraanid', $kendaraanid);
        $data = $this->db->get()->result();

        return json_encode($data);
    }
    function tambah($url,$token,$table,$insert_api,$insert_db)
    {

        $CURLOPT_HTTPHEADER = array(
            "Content-Type: application/json",
            "Authorization: Bearer ".$token

        );
        $CURLOPT_POSTFIELDS = $insert_api;
        $rs1 = $this->crud($url,$CURLOPT_HTTPHEADER,$CURLOPT_POSTFIELDS);
        $rs2 = $this->db->insert($table, $insert_db);
        return json_encode($rs1);
    }

    function edit($where,$url,$token,$table,$update_api,$update_db)
    {
        $CURLOPT_HTTPHEADER = array(
            "Content-Type: application/json",
            "Authorization: Bearer ".$token

        );
        $CURLOPT_POSTFIELDS = $update_api;
        $rs1 = $this->crud($url,$CURLOPT_HTTPHEADER,$CURLOPT_POSTFIELDS);              
        $this->db->where($where);
        $rs2 = $this->db->update($table, $update_db);
        return json_encode($rs1);
    }

    public function proses_delete($kendaraanid)
    {
       $rs = $this->db->delete('indicar_data_kendaraan', array('kendaraanid' => $kendaraanid));

       return json_encode($rs);
    }

    // Realtime Indicar

    public function realtime_indicar()
    {
        $gt = $this->cek_token(1);
        $url = "https://www.indicar.id/platform/public/index.php/sysapi/vehicles/list";
        // $search = array("pengaduanid\r" => "any", "status\r" => "any");
        $search = [];
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Bearer ".$gt['token']
            ),
        CURLOPT_POSTFIELDS => json_encode($search),    
        ));

        $response = curl_exec($curl);
        $api = json_decode($response, true);
        
        if ($api['success'] == 0) {
            $this->in_token($type);
        }

        return json_encode($api);
    }
    
    
}