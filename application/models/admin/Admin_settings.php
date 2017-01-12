<?php

class Admin_settings extends CI_Model {

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
        $data=$query->result_array();
        $record='';
        foreach($data as $k=>$val){
            $record[$val['key']]=$val['val'];
        }
        return $record;
    }

}

?>