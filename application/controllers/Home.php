<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {


	public function index()
	{
		 $data['subview']="front/home";
		 $this->load->view('front/layouts/layout_main',$data);
	}
	 
 

}
