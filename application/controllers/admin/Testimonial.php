<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Testimonial_model']);
    }

    /**
     * Function load view of testimonial list.
     */
    public function index() {
     
        $data['subview'] = 'admin/testimonial/index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in testimonial list page
     */
    public function list_testimonial() {
     
        $final['recordsTotal'] = $this->Testimonial_model->get_testimonial_count();
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Testimonial_model->get_all_testimonial();
        echo json_encode($final);
        

    }

    /**
     * Function is used to perform action (Delete,Block,Unblock)
     */
    public function action($action, $testimonial_id) {

        $where = 'id = ' . decode($this->db->escape($testimonial_id));
        $check_testimonial = $this->Testimonial_model->get_result('testimonial', $where);
        if ($check_testimonial) {
            if ($action == 'delete') {
                $update_array = array(
                    'is_deleted' => 1
                    );
                $this->session->set_flashdata('message', ['message'=>'Testimonial successfully deleted!','class'=>'success']);
            } elseif ($action == 'block') {
                $update_array = array(
                    'is_blocked' => 1
                    );
                $this->session->set_flashdata('message', ['message'=>'Testimonial successfully blocked!','class'=>'success']);
            } else {
                $update_array = array(
                    'is_blocked' => 0
                    );
                $this->session->set_flashdata('message', ['message'=>'Testimonial successfully unblocked!','class'=>'success']);
            }
            $this->Testimonial_model->update_record('testimonial', $where, $update_array);
        } else {
            $this->session->set_flashdata('message', ['message'=>'Invalid request. Please try again!','class'=>'danger']);
        }
        redirect(site_url('admin/testimonial'));
    }

    /**
     *  Load view for Edit testimonial 
     * */
    public function edit() {
        
        $testimonial_id = decode($this->uri->segment(4));
        if (is_numeric($testimonial_id)) {
            $where = 'id = ' . $this->db->escape($testimonial_id);
            $check_testimonial = $this->Testimonial_model->get_result('testimonial', $where);
            if ($check_testimonial) {
                $data['record'] = $check_testimonial[0];
                $data['title'] = 'Admin edit testimonial';
                $data['heading'] = 'Edit testimonial';                
            } else {
                show_404();
            }
        }
        if ($this->input->post()) {
         
            //--------------- Upload Image -----------
            $avtar['msg']='';
            $path = "uploads/testimonial/";
            /**
            * Upload Image 
            * Param1 : Location
            * Param2 : HTML File ControlName
            * Param3 : Extension (image,pdf,excel,doc)
            * Param4 : Size Limit (In. Byte) (Ex. 2*1024*1024) 
            * Param5 : Old File Name (Optional) 
            * */
            $avtar = $this->filestorage->FileInsert($path, 'img_path', 'image', 2097152,$this->input->post('Himg_path'));
            //----------------------------------------
            if ($avtar['status'] == 0) {
               $this->session->set_flashdata('message', ['message'=> $avtar['msg'],'class'=>'danger']);
           }
           else{
            $update_array = [
                'auther'            => $this->input->post('auther'),
                'designation'       => $this->input->post('designation'),
                'description'       => $this->input->post('description'),
                'img_path'          => $avtar['msg'],
                'is_blocked'        => $this->input->post('is_blocked'),
            ];

            $result=$this->Testimonial_model->update_record('testimonial', $where, $update_array);
            if($result){
                 $this->session->set_flashdata('message', ['message'=>'Testimonial successfully updated!','class'=>'success']);
            }
            else{
  
                 $this->session->set_flashdata('message', ['message'=>'Error Into Update Testimonial!','class'=>'danger']);
            } 
        }               
        redirect('admin/testimonial');
    }
    $data['subview'] = 'admin/testimonial/manage';
    $this->load->view('admin/layouts/layout_main', $data);
}

     /**
     * Load view for Add testimonial 
     * */

     public function add() {
        
       $data['title'] = 'Admin add testimonial';
       $data['heading'] = 'Add testimonial';
       if ($this->input->post()) {
           
                //--------------- Upload Image Max 2 MB-----------
        $avtar['msg']='';
        $path = "uploads/testimonial/";
                /**
                * Upload Image
                * Param1 : Location
                * Param2 : HTML File ControlName
                * Param3 : Extension (image,pdf,excel,doc)
                * Param4 : Size Limit (In. Byte) (Ex. 2*1024*1024)  
                * Param5 : Old File Name (Optional) 
                * */
                $avtar = $this->filestorage->FileInsert($path, 'img_path', 'image', 2097152);
                //----------------------------------------
                if ($avtar['status'] == 0) {
                   $this->session->set_flashdata('message', ['message'=> $avtar['msg'],'class'=>'danger']);
               }
               else{
                $insert_array = [
                    'auther'            => $this->input->post('auther'),
                    'designation'       => $this->input->post('designation'),
                    'description'       => $this->input->post('description'),
                    'img_path'          => $avtar['msg'],
                    'is_blocked'        => $this->input->post('is_blocked'),
                    'created_at'        => date("Y-m-d H:i:s a"),
                ];
                $result=$this->Testimonial_model->insert_record('testimonial',$insert_array);
                if($result){
                     $this->session->set_flashdata('message', ['message'=>'Testimonial successfully Inserted!','class'=>'success']);
                }
                else{
                     $this->session->set_flashdata('message', ['message'=>'Error Into Insert Testimonial!','class'=>'danger']);
                }       
            }
            redirect('admin/testimonial');
        }
        
        $data['subview'] = 'admin/testimonial/manage';
        $this->load->view('admin/layouts/layout_main', $data);
    }

   

}
