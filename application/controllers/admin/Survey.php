<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(array('Survey_model'));

		// $class_methods = get_class_methods($this->router->fetch_class());
		// pr($class_methods,1);
	}

	public function index(){
        $data['subview'] = 'admin/survey/index';
        $this->load->view('admin/layouts/layout_main', $data);
	}

	public function add(){

		if($_POST){

			$ins_data = [
							'name'=>$this->input->post('survey_title'),
							'survey_desc'=>$this->input->post('survey_description'),
							'status'=>$this->input->post('status'),
							'created_at'=>date('Y-m-d H:i:s')
						];

			$id = $this->Survey_model->insert_survey($ins_data);

			if(is_int($id)){
				$this->session->set_flashdata('message',['message'=>'Survey successfully added.','class'=>'success']);
				redirect('admin/survey');
			}else{
				$this->session->set_flashdata('message',['message'=>'Something went wrong...!!','class'=>'danger']);
				redirect('admin/survey');
			}			
		}

		$data['subview'] = 'admin/survey/add';
        $this->load->view('admin/layouts/layout_main', $data);
	}

	public function edit($survey_id){
		
		$data['survey_data'] = $this->Survey_model->get_survey_data($survey_id);

		if($_POST){

			$ins_data = [
							'name'=>$this->input->post('survey_title'),
							'survey_desc'=>$this->input->post('survey_description'),
							'status'=>$this->input->post('status'),
							'created_at'=>date('Y-m-d H:i:s')
						];

			$id = $this->Survey_model->update_survey_data($survey_id,$ins_data);

			if(is_int($id)){
				$this->session->set_flashdata('message',['message'=>'Survey successfully updated.','class'=>'success']);
				redirect('admin/survey');
			}else{
				$this->session->set_flashdata('message',['message'=>'Something went wrong...!!','class'=>'danger']);
				redirect('admin/survey');
			}			
		}

		$data['subview'] = 'admin/survey/edit';
        $this->load->view('admin/layouts/layout_main', $data);
	}

	public function questions($survey_id){
		$data['survey_id'] = $survey_id;
		$data['all_survey_ques'] = $this->Survey_model->get_all_questions($survey_id);		
		$data['subview'] = 'admin/survey/questions_sort';
    	$this->load->view('admin/layouts/layout_main', $data);
	}

	public function delete_survey(){
		$survey_id = $this->input->post('survey_id');
		$this->Survey_model->delete($survey_id);
		$this->session->set_flashdata('message',['message'=>'Survey successfully deleted.','class'=>'success']);
		redirect('admin/survey');
	}

	public function test(){
		$this->load->view('admin/survey/test');	
	}

	// v! AJAX call to get list of survey list
	// ------------------------------------------------------------------------
	public function list_survey(){
		
        $final['recordsTotal'] = $this->Survey_model->get_survey_count();
        $final['redraw'] = 1;                       
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Survey_model->get_all_survey();
        echo json_encode($final);
	}

	// v! Get list of all questions
	// ------------------------------------------------------------------------
	public function list_questions(){

		$all_segments = $this->uri->segment_array();
		$last_segment = end($all_segments);

		$final['recordsTotal'] = $this->Survey_model->get_question_count($last_segment);
        $final['redraw'] = 1;                       
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Survey_model->get_all_questions($last_segment);
        echo json_encode($final);
	}

	//Save Question Order
	// ------------------------------------------------------------------------
	public function save_order(){
		$survey_order = $this->input->post('survey_order');
		$survey_id = $this->input->post('survey_id');

		$i=1;
		foreach($survey_order as $s_order){
			$this->Survey_model->update_ques_data($s_order,['ques_order'=>$i]);
			$i++;
		}

		echo json_encode('success');
	}

	public function add_question($survey_id){

		$data['survey_id'] = $survey_id;
		if($_POST){				
			pr($_POST,1);
		}

		$data['subview'] = 'admin/survey/ques_add';
        $this->load->view('admin/layouts/layout_main', $data);
	}

	public function delete_question(){
		$question_id = $this->input->post('question_id');
		$this->Survey_model->delete_ques($question_id);
		$this->session->set_flashdata('message',['message'=>'Survey Question successfully deleted.','class'=>'success']);
		redirect('admin/survey');
	}
}

/* End of file Survey.php */
/* Location: ./application/controllers/admin/Survey.php */