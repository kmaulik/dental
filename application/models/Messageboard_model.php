<?php

class Messageboard_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    /**
     * @uses : This function is used get result from the table
     * @param : @table 
     * @author : HPA
     */
    public function get_result($table, $condition = null) {
        $this->db->select('*');
        if (!is_null($condition)) {
            $this->db->where($condition);
        }
        $query = $this->db->get($table);
        return $query->result_array();
    }

    /**
     * @uses : This function is used to update record
     * @param : @table, @data_id, @data_array = array of update  
     * @author : HPA
     */
    public function update_record($table, $condition, $data_array) {
        $this->db->where($condition);
        if ($this->db->update($table, $data_array)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * @uses : This function is used to insert record
     * @param : @table, @data_array = array of update  
     * @author : HPA
     */
    public function insert_record($table, $data_array) {
        if ($this->db->insert($table, $data_array)) {
            return 1;
        } else {
            return 0;
        }
    }

    

    /**
     * @uses : this function is used to count rows of message list
     * @param : @table 
     * @author : DHK
     */
    // public function get_message_count($table,$where) {
    //     $this->db->where($where);
    //     $res_data = $this->db->get($table)->num_rows();
    //     return $res_data;
    // }

    // public function get_message_result($table, $condition = null,$limit,$offset) {
    //     $this->db->select('*');
    //     if (!is_null($condition)) {
    //         $this->db->where($condition);
    //     }
    //     $this->db->order_by('id','desc');
    //     $this->db->limit($limit,$offset);
    //     $query = $this->db->get($table);
    //     return $query->result_array();
    // }


    /**
    *   Fetch RFP message List
    */
    public function get_rfp_message(){

        $where = [
                    'u.is_deleted' => 0,
                    'u.is_blocked' => 0,
                    'rfp.is_deleted' => 0,
                    'rfp.is_blocked' => 0,
                    'rb.is_deleted' => 0,
                    'rb.is_chat_started' => 1
                ];

        $this->db->select('u.id as user_id,u.avatar as user_avatar,u.fname,u.lname,rfp.id as rfp_id,rfp.title as rfp_title,rb.created_at as bid_date');
        $this->db->from('rfp');
        $this->db->join('rfp_bid rb','rfp.id = rb.rfp_id');
        if($this->session->userdata('client')['role_id'] == '4'){
            $this->db->join('users u','rfp.patient_id = u.id');
            $this->db->where('rb.doctor_id',$this->session->userdata('client')['id']);
        }
        else if($this->session->userdata('client')['role_id'] == '5'){
            $this->db->join('users u','rb.doctor_id = u.id');
            $this->db->where('rfp.patient_id',$this->session->userdata('client')['id']);
        }
        $this->db->where($where);
        $data=$this->db->get()->result_array();
        return $data;

    }

    /*
    * Fetch RFP Conversation between Patient & Doctor
    */
    public function fetch_messages($rfp_id,$user_id){
        
        $where = '((m.from_id='.$user_id.' and m.to_id='.$this->session->userdata('client')['id'].' and m.is_deleted_to = 0) or (m.to_id ='.$user_id.' and m.from_id='.$this->session->userdata('client')['id'].' and m.is_deleted_from = 0))';
        $this->db->select('m.*,u.id as user_id,CONCAT(u.fname," ",u.lname) as user_name,u.avatar as user_avatar');
        $this->db->from('messages m');
        $this->db->join('users u','m.from_id = u.id');
        $this->db->where('rfp_id',$rfp_id);
        $this->db->where($where);
        $this->db->order_by('id','asc');
        $data=$this->db->get()->result_array();
        return $data;
    }

}

?>