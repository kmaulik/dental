<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct()
    {
        parent::__construct();
		if(!isset($this->session->userdata['client']))redirect('login');
    }	

    public function index() {
       
        $data['subview']="front/dashboard";
        $this->load->view('front/layouts/layout_main',$data);
    }

    

}
