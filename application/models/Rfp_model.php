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
    public function search_rfp_count($search_data,$date_data,$category_data,$favorite_data) {
        
        //-------- For Multiple Category search --------------
        $str='';
        if($category_data != ''){
           foreach($category_data as $key=>$cat_id)
            {
                if($key == 0) {  
                    $str .="FIND_IN_SET($cat_id,teeth_category)";
                }else{
                    $str .=" OR FIND_IN_SET($cat_id,teeth_category)";
                }
            }
        }
        //-------- End Multiple Category search --------------

        $this->db->select('rfp.*,TIMESTAMPDIFF(YEAR, rfp.birth_date, CURDATE()) AS patient_age,TIMESTAMPDIFF(DAY,CURDATE(),rfp.rfp_valid_date) AS rfp_valid_days,u.id as user_id,u.avatar as avatar,rb.amount as bid_amt,count(rb_bid.rfp_id) as total_bid,rf.rfp_id as favorite_id, ( 3959 * acos( cos( radians(' . $this->session->userdata['client']['latitude'] . ') ) * cos( radians( rfp.latitude ) ) * cos( radians( rfp.longitude ) - radians(' . $this->session->userdata['client']['longitude'] . ') ) + sin( radians(' . $this->session->userdata['client']['latitude'] . ') ) * sin( radians( rfp.latitude ) ) ) ) AS distance');
        $this->db->from('rfp');
        $this->db->join('users u','rfp.patient_id = u.id');
        $this->db->join('rfp_favorite rf','rfp.id = rf.rfp_id and rf.doctor_id='.$this->session->userdata('client')['id'],'left');
        $this->db->join('rfp_bid rb','rfp.id = rb.rfp_id and rb.doctor_id='.$this->session->userdata('client')['id'],'left');
        $this->db->join('rfp_bid rb_bid','rfp.id = rb_bid.rfp_id','left');

        if ($search_data != '') {
            $this->db->having('title LIKE "%' . $search_data . '%" OR dentition_type LIKE "%'.$search_data.'%"', NULL);
        }
        if($date_data != ''){
            $date=explode(" ",$date_data);
            $this->db->where('date_format(rfp.created_at,"%Y-%m-%d") >=', $date[0]);
            $this->db->where('date_format(rfp.created_at,"%Y-%m-%d") <=', $date[2]);
        }
        if($category_data != ''){
            $this->db->where("(".$str.") != 0");
        }  

        //----------- For Favorite RFP Filter ---------
        if($favorite_data != '' && $favorite_data != 'All'){
            if($favorite_data == 'Include'){
                $this->db->where('rf.rfp_id is NOT NULL', NULL, FALSE);
            }elseif($favorite_data == 'Exclude'){
                $this->db->where('rf.rfp_id IS NULL', NULL, FALSE);
            }
        }


        $this->db->having('rfp.distance_travel >= distance',NULL); // For check Patient travel distance or not

        $this->db->where('rfp.status','3'); // For RFP Status Open (3) 
        $this->db->where('rfp.is_deleted','0');
        $this->db->where('rfp.is_blocked','0');

        $this->db->where('rfp.rfp_valid_date >= CURDATE()'); // For check rfp valid date >= curdate
        $this->db->group_by('rfp.id');
        $res_data = $this->db->get()->num_rows();
        return $res_data;
    }

    public function search_rfp_result($limit,$offset,$search_data,$date_data,$category_data,$sort_data,$favorite_data){
        
        
        //-------- For Multiple Category search --------------
        $str='';
        if($category_data != ''){
           foreach($category_data as $key=>$cat_id)
            {
                if($key == 0) {  
                    $str .="FIND_IN_SET($cat_id,teeth_category)";
                }else{
                    $str .=" OR FIND_IN_SET($cat_id,teeth_category)";
                }
            }
        }
        //-------- End Multiple Category search --------------

        $this->db->select('rfp.*,TIMESTAMPDIFF(YEAR, rfp.birth_date, CURDATE()) AS patient_age,TIMESTAMPDIFF(DAY,CURDATE(),rfp.rfp_valid_date) AS rfp_valid_days,u.id as user_id,u.avatar as avatar,rb.amount as bid_amt,count(rb_bid.rfp_id) as total_bid,rf.rfp_id as favorite_id, ( 3959 * acos( cos( radians(' . $this->session->userdata['client']['latitude'] . ') ) * cos( radians( rfp.latitude ) ) * cos( radians( rfp.longitude ) - radians(' . $this->session->userdata['client']['longitude'] . ') ) + sin( radians(' . $this->session->userdata['client']['latitude'] . ') ) * sin( radians( rfp.latitude ) ) ) ) AS distance');
        $this->db->from('rfp');
        $this->db->join('users u','rfp.patient_id = u.id');
        $this->db->join('rfp_favorite rf','rfp.id = rf.rfp_id and rf.doctor_id='.$this->session->userdata('client')['id'],'left');
        $this->db->join('rfp_bid rb','rfp.id = rb.rfp_id and rb.doctor_id='.$this->session->userdata('client')['id'],'left');
        $this->db->join('rfp_bid rb_bid','rfp.id = rb_bid.rfp_id','left');
        if ($search_data != '') {
            $this->db->having('title LIKE "%' . $search_data . '%" OR dentition_type LIKE "%'.$search_data.'%"', NULL);
        }
        if($date_data != ''){
            $date=explode(" ",$date_data);
            $this->db->where('date_format(rfp.created_at,"%Y-%m-%d") >=', $date[0]);
            $this->db->where('date_format(rfp.created_at,"%Y-%m-%d") <=', $date[2]);
        }

        if($category_data != ''){
            $this->db->where("(".$str.") != 0");
        } 

        //----------- For Favorite RFP Filter ---------
        if($favorite_data != '' && $favorite_data != 'All'){
            if($favorite_data == 'Include'){
                $this->db->where('rf.rfp_id is NOT NULL', NULL, FALSE);
            }elseif($favorite_data == 'Exclude'){
                $this->db->where('rf.rfp_id IS NULL', NULL, FALSE);
            }
        }

        $this->db->having('rfp.distance_travel >= distance',NULL); // For check Patient travel distance or not

        $this->db->where('rfp.status','3'); // For RFP Status Open (3)
        $this->db->where('rfp.is_deleted','0');
        $this->db->where('rfp.is_blocked','0');

        $this->db->where('rfp.rfp_valid_date >= CURDATE()'); // For check rfp valid date >= curdate
        $this->db->group_by('rfp.id');
        $this->db->order_by('rfp.id',$sort_data);
        $this->db->limit($limit,$offset);
        $query = $this->db->get();
        return $query->result_array();
    }


    /* --------------- For Doctor Profile RFP --------- */
    public function doctor_rfp_count($search_data,$date_data) {
        $this->db->select('rfp.*,u.id as user_id,u.avatar as avatar,rf.rfp_id as favorite_id');
        $this->db->from('rfp');
        $this->db->join('users u','rfp.patient_id = u.id');
        $this->db->join('rfp_bid','rfp_bid.rfp_id = rfp.id');
        $this->db->join('rfp_favorite rf','rfp.id = rf.rfp_id and rf.doctor_id='.$this->session->userdata('client')['id'],'left');
        if ($search_data != '') {
            $this->db->having('title LIKE "%' . $search_data . '%" OR dentition_type LIKE "%'.$search_data.'%"', NULL);
        }
        if($date_data != ''){
            $date=explode(" ",$date_data);
            $this->db->where('date_format(rfp.created_at,"%Y-%m-%d") >=', $date[0]);
            $this->db->where('date_format(rfp.created_at,"%Y-%m-%d") <=', $date[2]);
        }
        $this->db->where('rfp.status','3'); // For RFP Status Open (3)
        $this->db->where('rfp.is_deleted','0');
        $this->db->where('rfp.is_blocked','0');
        $this->db->where('rfp_bid.doctor_id',$this->session->userdata('client')['id']); // v! New Condition
        $res_data = $this->db->get()->num_rows();
        return $res_data;
    }

    public function doctor_rfp_result($limit,$offset,$search_data,$date_data,$sort_data){
        $this->db->select('rfp.*,u.id as user_id,u.avatar as avatar,
                         rf.rfp_id as favorite_id,
                         rfp_bid.status as rfp_won_status,rfp_bid.is_chat_started,rfp_bid.amount,rfp_bid.description as bid_desc');
        $this->db->from('rfp');
        $this->db->join('users u','rfp.patient_id = u.id');
        $this->db->join('rfp_bid','rfp_bid.rfp_id = rfp.id','left'); // v! New Condition
        $this->db->join('rfp_favorite rf','rfp.id = rf.rfp_id and rf.doctor_id='.$this->session->userdata('client')['id'],'left');
        
        if ($search_data != '') {
            $this->db->having('title LIKE "%' . $search_data . '%" OR dentition_type LIKE "%'.$search_data.'%"', NULL);
        }
        if($date_data != ''){
            $date=explode(" ",$date_data);
            $this->db->where('date_format(rfp.created_at,"%Y-%m-%d") >=', $date[0]);
            $this->db->where('date_format(rfp.created_at,"%Y-%m-%d") <=', $date[2]);
        }
        $this->db->where('rfp.status','3'); // For RFP Status Open (3)
        $this->db->where('rfp.is_deleted','0');
        $this->db->where('rfp.is_blocked','0');
        $this->db->where('rfp_bid.doctor_id',$this->session->userdata('client')['id']); // v! New Condition
        $this->db->order_by('rfp.id',$sort_data);
        $this->db->limit($limit,$offset);
        $query = $this->db->get();
        return $query->result_array();
    }

    // ------------------------------------------------------------------------

    /* --------------- For Patient List RFP Bid --------- */
    public function get_rfp_bid_data($rfp_id){

        $where=[
            'rb.rfp_id' => $rfp_id,
            'rfp.is_deleted' => 0,
            'rfp.is_blocked' => 0,
            'rb.is_deleted' => 0,
        ];
        $this->db->select('rfp.id,rfp.title,rfp.rfp_approve_date as rfp_approve_date,rfp.status as rfp_status,rb.id as rfp_bid_id,rb.doctor_id,rb.amount as bid_amount,rb.description,rb.status as bid_status,rb.is_chat_started,rb.created_at,u.fname,u.lname,u.avatar,rr.avg as avg_rating,rr.count1 as total_review');
        $this->db->from('rfp');
        $this->db->join('rfp_bid rb','rfp.id = rb.rfp_id');
        $this->db->join('users u','rb.doctor_id = u.id');
        $this->db->join('(SELECT avg(rating) AS avg, count(rating) AS count1,doctor_id FROM rfp_rating where is_deleted=0 and is_blocked=0 GROUP BY doctor_id) rr','rr.doctor_id = rb.doctor_id','LEFT');
        $this->db->where($where);
        $this->db->order_by('rb.id','desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    /* --------------- For User Rating --------- */
    public function get_user_rating($user_id){
        $this->db->select('rr.id as rating_id,rr.rating,rr.description as feedback,rr.doctor_comment,rr.doctor_id,rr.created_at,rfp.id as rfp_id,rfp.title as rfp_title,u.id as user_id,CONCAT(u.fname," ",u.lname) as user_name,u.avatar');
        $this->db->from('rfp_rating rr');
        $this->db->join('rfp','rr.rfp_id = rfp.id');
        $this->db->join('users u','rfp.patient_id = u.id');
        $this->db->where('rr.doctor_id',$user_id);
        $this->db->where('rr.is_deleted',0);
        $this->db->where('rr.is_blocked',0);
        $this->db->order_by('rr.id','desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    /* ----------------- For Get Overall Review & Average ------------- */
    public function get_overall_rating($user_id){

        $this->db->select('rr.doctor_id,avg(rr.rating) as avg_rating,count(rr.id) as total_rating');
        $this->db->where('rr.doctor_id',$user_id);
        $this->db->where('rr.is_deleted',0);
        $this->db->where('rr.is_blocked',0);
        $this->db->group_by('rr.doctor_id');
        $query = $this->db->get('rfp_rating rr');
        return $query->row_array();

    } 

    /*-------------- Payment list with payment details ----------- 
    /* Get RFP data with status (3 - open, 4 - Waiting for approval,5 - In-progress) and payment history For Dashboard Refund
    */
    public function get_payment_list_user_wise(){
        $this->db->select('rfp.id as rfp_id,rfp.title as rfp_title,CONCAT(rfp.fname," ",rfp.lname) as user_name,rfp.status as rfp_status,rfp.dentition_type as dentition_type,pt.id as payment_id,pt.payable_price as paid_price,pt.paypal_token as paypal_token,r.id as refund_id,r.status as refund_status');
        $this->db->from('payment_transaction pt');
        $this->db->join('rfp','pt.rfp_id = rfp.id');
        $this->db->join('refund r','pt.id = r.payment_id','left');
        $this->db->where_in('rfp.status',[3,4,5]); // 3,4 & 5 Means Open & Waiting for doctor approval & Pending (Winner) &  RFP
        $this->db->where('pt.user_id',$this->session->userdata['client']['id']);
        $this->db->order_by('pt.created_at','desc');
        $query = $this->db->get();
        return $query->result_array();
    } 

    // v! used in dashboard - get all favorite RFP
    public function get_user_fav_rfp($user_id,$limit,$offset=false){
        $this->db->select('rfp_favorite.*,rfp.title,rfp.dentition_type,rfp.created_at as rfp_created,users.avatar,rfp.img_path,
                           (select rfp_id from rfp_favorite where rfp_id=rfp.id AND doctor_id ='.$user_id.') as favorite_id,
                           rfp.id as rfp_id');
        $this->db->where(['rfp.status'=>'3','rfp.is_deleted'=>'0','rfp.is_blocked'=>'0','rfp_favorite.doctor_id'=>$user_id]); // conditions with rfp table
        $this->db->join('rfp','rfp.id=rfp_favorite.rfp_id');
        $this->db->where(['users.is_deleted'=>'0','users.is_blocked'=>'0']); // conidtion with users table
        $this->db->join('users','users.id=rfp.patient_id');
        $this->db->order_by('rfp_favorite.updated_at','desc');
        $this->db->limit($limit,$offset);
        $res = $this->db->get('rfp_favorite')->result_array();
        return $res;
    }
    
    public function get_user_won_rfp($user_id){
        $this->db->select('rfp_bid.*,rfp.title,rfp.dentition_type,rfp.created_at as rfp_created,rfp.status as rfp_status,rfp.treatment_plan_total,
                          users.fname,users.lname,users.email_id');
        $this->db->join('rfp','rfp.id=rfp_bid.rfp_id');
        $this->db->join('users','rfp.patient_id=users.id');
        $this->db->where(['rfp_bid.status'=>'2','rfp_bid.doctor_id'=>$user_id]);
        $res = $this->db->get('rfp_bid')->result_array();
        return $res;
    }

    /* -------------- For Display Active RFP In Dashboard @DHK------------------- */
    public function get_active_rfp_patient_wise(){
        $this->db->select('rfp.*,count(rb.rfp_id) as total_bid,min(rb.amount) as min_bid_amt,rr.rfp_id as is_rated');
        $this->db->join('rfp_bid rb','rfp.id = rb.rfp_id and rb.is_deleted=0','left');
        $this->db->join('rfp_rating rr','rfp.id = rr.rfp_id','left');
        $this->db->where_in('rfp.status',['3','4','5']); // Rfp Status 3,4,5 then display
        $this->db->where('rfp.patient_id',$this->session->userdata['client']['id']);
        $this->db->where('rfp.is_deleted',0);
        $this->db->where('rfp.is_blocked',0);
        $this->db->group_by('rb.rfp_id');
        $this->db->order_by('rfp.id','desc');
        $result = $this->db->get('rfp')->result_array();

        foreach($result as $key=>$res){
            $this->db->select('rb.*,u.id as user_id,CONCAT(u.fname," ",u.lname) as user_name,u.avatar,avg(rr.rating) as avg_rating,count(rr.doctor_id) as total_rating,( 3959 * acos( cos( radians(' . $res['latitude'] . ') ) * cos( radians( u.latitude ) ) * cos( radians( u.longitude ) - radians(' . $res['longitude'] . ') ) + sin( radians(' . $res['latitude'] . ') ) * sin( radians( u.latitude ) ) ) ) AS distance');
            $this->db->join('users u','rb.doctor_id = u.id');
            $this->db->join('rfp_rating rr','rb.doctor_id = rr.doctor_id','left');
            $this->db->where('rb.is_deleted',0);
            $this->db->where('rb.rfp_id',$res['id']);
            $this->db->group_by('rb.doctor_id');
            $data=$this->db->get('rfp_bid rb')->result_array();
            $result[$key]['bid_data']=$data;
        }
        return $result;
    } 

    /* ----------------------- Fetch RFP For Doctor Appointment (With RFP Status [5] & RFP Bid status [2]) ----------------------- */
    public function get_doctor_appointment_rfp($user_id){
        
        $this->db->select('rfp.id,rfp.title,rfp.appointment_schedule,rfp.appointment_comment,CONCAT(u.fname," ",u.lname) as user_name,u.phone,a.id as appointment_id,a.doc_id,a.doc_comments,a.is_cancelled,a.created_at');
        $this->db->join('users u','rfp.patient_id = u.id');
        $this->db->join('rfp_bid rb','rfp.id = rb.rfp_id');
        $this->db->join('appointments a','rfp.id = a.rfp_id and a.is_cancelled = 0','left');
        $this->db->where('rb.doctor_id',$user_id);
        $this->db->where('rb.status','2'); // RFP BID Status 2 means winner for this rfp
        $this->db->where('rb.is_deleted',0);
        $this->db->where('rfp.status','5'); // Status 5 Means Rfp is in In-progress so able to manage appointment by doctor
        $this->db->where('rfp.is_deleted',0);
        $this->db->where('rfp.is_blocked',0);
        $this->db->where('u.is_deleted',0);
        $this->db->where('u.is_blocked',0);
        $data=$this->db->get('rfp')->result_array();
        
        foreach($data as $key=>$app_data){
            $this->db->where('appointment_id',$app_data['appointment_id']);
            $data[$key]['appointment_schedule_arr']=$this->db->get('appointment_schedule')->result_array();
        }
     
        return $data;
    }

     /* ----------------------- Fetch RFP For Patient Appointment (With RFP Status [5]) ----------------------- */
    public function get_patient_appointment_rfp($user_id){
        $this->db->select('rfp.id,rfp.title,rfp.appointment_schedule,rfp.appointment_comment,CONCAT(u.fname," ",u.lname) as user_name,a.id as appointment_id,a.doc_id,a.doc_comments,a.is_cancelled,a.created_at');
        $this->db->join('appointments a','rfp.id = a.rfp_id');
        $this->db->join('users u','a.doc_id = u.id');
        $this->db->where('rfp.patient_id',$user_id);
        $this->db->where('rfp.status','5'); // Status 5 Means Rfp is in In-progress so able to manage appointment by doctor
        $this->db->where('rfp.is_deleted',0);
        $this->db->where('rfp.is_blocked',0);
        $this->db->where('a.is_cancelled',0);
        $this->db->where('u.is_deleted',0);
        $this->db->where('u.is_blocked',0);
        $data=$this->db->get('rfp')->result_array();

         foreach($data as $key=>$app_data){
            $this->db->where('appointment_id',$app_data['appointment_id']);
            $data[$key]['appointment_schedule_arr']=$this->db->get('appointment_schedule')->result_array();
        }
        
        return $data;
    }

    public function  return_status($rfp_id){

        $all_data = $this->db->get_where('billing_schedule',['rfp_id'=>$rfp_id])->result_array();

        
        if(!empty($all_data)){
            foreach($all_data as $a_data){

            }
        }
        return $all_data;
    }

}    
