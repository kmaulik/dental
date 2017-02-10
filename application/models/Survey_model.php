<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey_model extends CI_Model {

	public function __construct(){
		parent::__construct();	
	}
	
	public function get_survey_count(){

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('name LIKE "%' . $keyword['value'] . '%" OR survey_desc LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $this->db->where('is_deleted','0');
		$res = $this->db->get('survey')->num_rows();
		return $res;
	}

	public function get_all_survey(){
		$this->db->select('id,id AS test_id,name,survey_desc,status,DATE_FORMAT(created_at,"%d %b %Y <br> %l:%i %p") AS created_at', false);
        
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
        	$this->db->having('name LIKE "%' . $keyword['value'] . '%" OR survey_desc LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $this->db->where('is_deleted','0');
        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('survey')->result_array();
        return $res_data;
	}

	public function insert_survey($data){
		$this->db->insert('survey',$data);
		$last_id = $this->db->insert_id();
		return $last_id;
	}

    // v! To delete Survey here we are using flag('is_deleted') for that
    public function delete($survey_id){
        $this->db->where('id',$survey_id);
        $this->db->update('survey',['is_deleted'=>'1','status'=>'inactive']);
    }

    // v! Get Survey data id id is passed then it will take where cluse as id otherwise need to pass as key,value pair
    public function get_survey_data($data,$is_single=TRUE){
        if(is_array($data) == false){ $this->db->where('id',$data); }else{ $this->db->where($data); }
        $ret_data = $this->db->get('survey')->row_array();
        if($is_single == FALSE){
            $ret_data = $this->db->get('survey')->result_array();
        }
        return $ret_data;
    }

	public function update_survey_data($id, $data) {

        if (is_array($id)) {
            $this->db->where($id);
        } else {
            $this->db->where(['id' => $id]);
        }
        $this->db->update('survey', $data);
        $last_id = $this->db->affected_rows();
        return $last_id;
    }

    // ------------------------------------------------------------------------


    public function get_question_count($survey_id){
        $res_data = $this->db->get_where('survey_ques',['survey_id'=>$survey_id])->num_rows();
        return $res_data;
    }

    public function get_all_questions(){
        $this->db->select('id,id AS test_id,ques,opt_type,opt_choice,status,ques_order,is_required,DATE_FORMAT(created_at,"%d %b %Y <br> %l:%i %p") AS created_at', false);
        
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('name LIKE "%' . $keyword['value'] . '%" OR survey_desc LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $this->db->order_by('ques_order');
        $this->db->where('is_deleted','0');
        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('survey_ques')->result_array();
        return $res_data;
    }

    public function delete_ques($ques_id){
        $this->db->where('id',$ques_id);        
        $this->db->update('survey_ques',['is_deleted'=>'1']);
    }

    public function update_ques_data($id, $data) {

        if (is_array($id)) {
            $this->db->where($id);
        } else {
            $this->db->where(['id' => $id]);
        }
        $this->db->update('survey_ques', $data);
        $last_id = $this->db->affected_rows();
        return $last_id;
    }

    public function insert_question($data){
        $this->db->insert('survey_ques',$data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
}

/* End of file Survey_model.php */
/* Location: ./application/models/Survey_model.php */
