<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(['Testimonial_model']);
	}

	public function index(){

		$data['subview']="front/home";
		$data['all_testimonials'] = $this->Testimonial_model->fetch_testimonial();		
		$this->load->view('front/layouts/layout_main',$data);
	}
	 
 

}
