<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();             
        // $this->load->model(array('Users_model'));
    }

    public function index() {
       
        $data['subview']="front/dashboard";
        $this->load->view('front/layouts/layout_main',$data);
    }

    

}
