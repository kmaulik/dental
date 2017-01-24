<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends CI_Controller {

    public function __construct(){
    	parent::__construct();
		if(!isset($this->session->userdata['client']) && $this->session->userdata['client']['role_id'] != 5)redirect('login');
    }    

}
