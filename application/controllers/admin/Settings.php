<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class settings extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model(['admin/Admin_settings']);
		check_admin_login();
	}		
    
    //===============================================================
	function index()
	{
		$data['heading'] = 'Site Settings';
		$data['record']=$this->Admin_settings->get_result('config');
		$data['subview'] = 'admin/settings/index';
        $this->load->view('admin/layouts/layout_main', $data);
	}
	
	//===============================================================
	function save(){
		$post_data = $this->input->post();
		foreach($post_data as $k=>$v)
		{
			if($v!='Save')
			$this->db->set('val',$v)->where('key',$k)->update('config');
		}
		$this->session->set_flashdata('message',['message'=>'Settings Saved Successfully.','class'=>'success']);
		redirect('admin/settings');
	}
	
}
?>