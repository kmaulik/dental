<?php

class Rfp_model extends CI_Model {

     /**
     * @uses : this function is used to get result based on datatable in rfp list page
     * @param : @table 
     * @author : HPA
     */
    public function get_all_rfp() {        
        
        $this->db->select('id,title,CONCAT(fname," ",lname) as patient_name,dentition_type,status,DATE_FORMAT(created_at,"%d %b %Y <br> %l:%i %p") AS created_date,is_blocked', false);
        
        $admin_data = $this->session->userdata('admin');
        $role_id = $admin_data['role_id'];

        $this->db->where_not_in('status',['0']);
        $this->db->where('is_deleted !=', 1);
        
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('title LIKE "%' . $keyword['value'] . '%" OR patient_name LIKE "%'.$keyword['value'].'%" OR dentition_type LIKE "%'.$keyword['value'].'%"', NULL);
        }

        $this->db->order_by('status');
        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('rfp')->result_array();
        return $res_data;
    }

    /**
     * @uses : this function is used to count rows of rfps based on datatable in rfp list page
     * @param : @table 
     * @author : HPA
     */
    public function get_rfp_count() {
        $this->db->where('is_deleted !=', 1);

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);
        
        if (!empty($keyword['value'])) {
            $this->db->having('title LIKE "%' . $keyword['value'] . '%" OR patient_name LIKE "%'.$keyword['value'].'%" OR dentition_type LIKE "%'.$keyword['value'].'%"', NULL);
        }

        $res_data = $this->db->get('rfp')->num_rows();
        return $res_data;
    }


     /**
     * @uses : This function is used get result from the table
     * @param : @table 
     * @author : HPA
     */
    public function get_result($table, $condition = null,$single='') {
        $this->db->select('*');
        if (!is_null($condition)) {
            $this->db->where($condition);
        }
        $query = $this->db->get($table);
        if($single){
            return $query->row_array();
        }else{ 
            return $query->result_array();
        }
    }


     /**
     * @uses : This function is used to insert record
     * @param : @table, @data_array = array of update  
     * @author : HPA
     */
    public function insert_record($table, $data_array) {
        if ($this->db->insert($table, $data_array)) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

     /**
     * @uses : This function is used to update record
     * @param : @table, @record_id, @data_array = array of update  
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
     * @uses : This function is used to Delete record
     * @param : @table, @record_id
     * @author : DHK
     */
    public function delete_record($table, $condition) {
        $this->db->where($condition);
        if ($this->db->delete($table)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * @uses : this function is used to count rows of rfp based on  rfp list page
     * @param : @table , @where Condition
     * @author : HPA
     */
    public function get_rfp_front_count($table,$where) {
        $this->db->where($where);
        $res_data = $this->db->get($table)->num_rows();
        return $res_data;
    }

    public function get_rfp_front_result($table, $condition = null,$limit,$offset) {
        $this->db->select('*');
        if (!is_null($condition)) {
            $this->db->where($condition);
        }
        $this->db->order_by('id','desc');
        $this->db->limit($limit,$offset);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    /* --------------- For Doctor Search RFP --------- */
     public function search_rfp_count($search_data,$date_data) {
        $this->db->select('rfp.*,u.id as user_id,u.avatar as avatar,(select rfp_id from rfp_favorite where rfp_id=rfp.id AND doctor_id ='.$this->session->userdata('client')['id'].') as favorite_id');
        $this->db->from('rfp');
        $this->db->join('users u','rfp.patient_id = u.id');
        if ($search_data != '') {
            $this->db->where('title LIKE "%' . $search_data . '%" OR CONCAT(rfp.fname," ", rfp.lname) LIKE "%'.$search_data.'%" OR dentition_type LIKE "%'.$search_data.'%"', NULL);
        }
        if($date_data != ''){
            $date=explode(" ",$date_data);
            $this->db->where('date_format(rfp.created_at,"%Y-%m-%d") >=', $date[0]);
            $this->db->where('date_format(rfp.created_at,"%Y-%m-%d") <=', $date[2]);
        }
        $this->db->where('rfp.status','3'); // For RFP Status Open (3) 
        $this->db->where('rfp.is_deleted','0');
        $this->db->where('rfp.is_blocked','0');
        $res_data = $this->db->get()->num_rows();
        return $res_data;
    }

    public function search_rfp_result($limit,$offset,$search_data,$date_data,$sort_data){
        $this->db->select('rfp.*,u.id as user_id,u.avatar as avatar,(select rfp_id from rfp_favorite where rfp_id=rfp.id AND doctor_id ='.$this->session->userdata('client')['id'].') as favorite_id');
        $this->db->from('rfp');
        $this->db->join('users u','rfp.patient_id = u.id');
        if ($search_data != '') {
            $this->db->where('title LIKE "%' . $search_data . '%" OR CONCAT(rfp.fname," ", rfp.lname) LIKE "%'.$search_data.'%" OR dentition_type LIKE "%'.$search_data.'%"', NULL);
        }
        if($date_data != ''){
            $date=explode(" ",$date_data);
            $this->db->where('date_format(rfp.created_at,"%Y-%m-%d") >=', $date[0]);
            $this->db->where('date_format(rfp.created_at,"%Y-%m-%d") <=', $date[2]);
        }
        $this->db->where('rfp.status','3'); // For RFP Status Open (3)
        $this->db->where('rfp.is_deleted','0');
        $this->db->where('rfp.is_blocked','0');
        $this->db->order_by('rfp.id',$sort_data);
        $this->db->limit($limit,$offset);
        $query = $this->db->get();
        return $query->result_array();
    }


    /* --------------- For Patient List RFP Bid --------- */
    public function get_rfp_bid_data($rfp_id){

        $where=[
            'rb.rfp_id' => $rfp_id,
            'rfp.is_deleted' => 0,
            'rfp.is_blocked' => 0,
            'rb.is_deleted' => 0,
        ];
        $this->db->select('rfp.id,rfp.title,rb.id as rfp_bid_id,rb.doctor_id,rb.amount as bid_amount,rb.description,rb.status as bid_status,rb.is_chat_started,rb.created_at,u.fname,u.lname,u.avatar,rr.avg as rating,rr.count1 as total_review');
        $this->db->from('rfp');
        $this->db->join('rfp_bid rb','rfp.id = rb.rfp_id');
        $this->db->join('users u','rb.doctor_id = u.id');
        $this->db->join('(SELECT avg(rating) AS avg, count(rating) AS count1,doctor_id FROM rfp_rating where is_deleted=0 and is_blocked=0 GROUP BY doctor_id) rr','rr.doctor_id = rb.doctor_id','LEFT');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }

}    
