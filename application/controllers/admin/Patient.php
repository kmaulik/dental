<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(array('Users_model','Country_model'));
	}

	public function index(){
		
	}

	public function add(){
		$data['country_list']=$this->Country_model->get_result('country');
        $data['subview']='admin/users/registration_patient';
        $this->load->view('admin/layouts/layout_main',$data);
	}



}

/* End of file Patient.php */
/* Location: ./application/controllers/admin/Patient.php */