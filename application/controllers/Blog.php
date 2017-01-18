<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

	 public function __construct() {
        parent::__construct();             
        $this->load->model(array('Blogs_model'));
    }
	public function index()
	{
		$this->load->library('pagination');
		$where = ['is_deleted' => 0 , 'is_blocked' => 0];
		 
		$config['base_url'] = base_url().'blog/index';
		$config['total_rows'] = $this->Blogs_model->get_blogs_front_count($where);
		$config['per_page'] = 5;
		$offset = $this->input->get('per_page');
		$config = array_merge($config,pagination_front_config());		
		$this->pagination->initialize($config);
		$data['blog_list']=$this->Blogs_model->get_front_result('blog',$where,$config['per_page'],$offset);	
		$data['subview']="front/blog/blog_list";
		$this->load->view('front/layouts/layout_main',$data);
	}

	public function blog_details($slug=''){
		$data['blog_details']=$this->Blogs_model->get_result('blog',['blog_slug' => $slug]);
		$data['prev']=$this->Blogs_model->get_result_prev_next('blog',['is_deleted' => 0 , 'is_blocked' => 0 , 'id > ' => $data['blog_details'][0]['id']],'asc');
		$data['next']=$this->Blogs_model->get_result_prev_next('blog',['is_deleted' => 0 , 'is_blocked' => 0 , 'id < ' => $data['blog_details'][0]['id']],'desc');
		$data['subview']="front/blog/blog_detail";
		$this->load->view('front/layouts/layout_main',$data);
	}
	 
 

}
