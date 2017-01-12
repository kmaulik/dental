<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct(){
		
		parent::__construct();  		
		$exceptional_url = array('admin','admin/login','user/facebook_callback','user/email_alert/set_email_alert');

		if(in_array(uri_string(), $exceptional_url) == FALSE){

			if(is_loggedin() == FALSE){
				$this->session->set_userdata('user_redirect',uri_string());
				$this->session->set_flashdata('message', ['message'=>'Login is required.','class'=>'alert alert-danger']);
				redirect('login');
			}			
		}
		
	}

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */