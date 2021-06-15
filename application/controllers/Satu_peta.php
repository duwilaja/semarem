<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Satu_peta extends CI_Controller {

	public function __construct()
    {
		parent::__construct();
	}

    public function index()
    {
        $this->load->view('satu_peta');
    }
}