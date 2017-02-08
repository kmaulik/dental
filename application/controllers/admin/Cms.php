<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Cms_model']);
        $this->load->library(['encryption', 'upload']);
        check_admin_login();
    }

    /**
     * Function load view of cms list.
     */
    public function index() {

        $data['subview'] = 'admin/cms/index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in cms list page
     */
    public function list_cms() {

        $final['recordsTotal'] = $this->Cms_model->get_cms_count();
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Cms_model->get_all_cms();
        echo json_encode($final);
        

    }

    /**
     * Function is used to perform action (Delete,Block,Unblock)
     */
    public function action($action, $cms_id) {

        $where = 'id = ' . decode($this->db->escape($cms_id));
        $check_cms = $this->Cms_model->get_result('cms_page', $where);
        if ($check_cms) {
            if ($action == 'delete') {
                $update_array = array(
                    'is_deleted' => 1
                    );
                $this->session->set_flashdata('message',['message'=>'Cms Page successfully deleted!','class'=>'success']);
                
            } elseif ($action == 'block') {
                $update_array = array(
                    'is_blocked' => 1
                    );
                $this->session->set_flashdata('message',['message'=>'Cms Page successfully blocked!','class'=>'success']);
                
            } else {
                $update_array = array(
                    'is_blocked' => 0
                    );
                $this->session->set_flashdata('message',['message'=>'Cms Page successfully unblocked!','class'=>'success']);
                
            }
            $this->Cms_model->update_record('cms_page', $where, $update_array);
        } else {
            $this->session->set_flashdata('message',['message'=>'Invalid request. Please try again!','class'=>'danger']);
                
        }
        redirect(site_url('admin/cms'));
    }

    /**
     *  Load view for Edit cms 
     * */
    public function edit() {

        $cms_id = decode($this->uri->segment(4));
        if (is_numeric($cms_id)) {
            $where = 'id = ' . $this->db->escape($cms_id);
            $check_cms = $this->Cms_model->get_result('cms_page', $where);
            if ($check_cms) {
                $data['record'] = $check_cms[0];
                $data['title'] = 'Admin Edit Cms Page';
                $data['heading'] = 'Edit Cms Page';                
            } else {
                show_404();
            }
        }
        if ($this->input->post()) {

             $update_array = [
                'slug'           => $this->input->post('slug'),
                'title'          => $this->input->post('title'),
                'seo_title'      => $this->input->post('seo_title'),
                'seo_keyword'    => $this->input->post('seo_keyword'),
                'seo_description'=> $this->input->post('seo_description'),
                'description'    => $this->input->post('description'),
                'css_style'      => $this->input->post('css_style'),
                'is_blocked'      => $this->input->post('is_blocked'),
            ];

            $result=$this->Cms_model->update_record('cms_page', $where, $update_array);
            if($result){
                $this->session->set_flashdata('message',['message'=>'Cms Page successfully updated!','class'=>'success']);
                
            }
            else{
                $this->session->set_flashdata('message',['message'=>'Error Into Update Cms Page!','class'=>'danger']);
                
            }               
            redirect('admin/cms');
            
        }
        $data['subview'] = 'admin/cms/manage';
        $this->load->view('admin/layouts/layout_main', $data);
    }

     /**
     * Load view for Add cms 
     * */

     public function add() {

         $data['title'] = 'Admin Add Cms Page';
         $data['heading'] = 'Add Cms Page';
         if ($this->input->post()) {

            $insert_array = [
            'slug'           => $this->input->post('slug'),
            'title'          => $this->input->post('title'),
            'seo_title'      => $this->input->post('seo_title'),
            'seo_keyword'    => $this->input->post('seo_keyword'),
            'seo_description'=> $this->input->post('seo_description'),
            'description'    => $this->input->post('description'),
            'css_style'      => $this->input->post('css_style'),
            'created_at'     => date("Y-m-d H:i:s a"),
            'is_blocked'      => $this->input->post('is_blocked'),
            ];

            $result=$this->Cms_model->insert_record('cms_page',$insert_array);
            if($result){
                $this->session->set_flashdata('message',['message'=>'Cms Page successfully Inserted!','class'=>'success']);
                
            }
            else{
                $this->session->set_flashdata('message',['message'=>'Error Into Insert Cms Page!','class'=>'danger']);
                
            }       
            redirect('admin/cms');
        }
        $data['subview'] = 'admin/cms/manage';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Check For Cms Title Already Exist or Not
     * */
    public function check_cms_title_exists($id = 0){
        if (array_key_exists('title', $_POST)) {
            if ($this->Cms_model->CheckExist($this->input->post('title'), $id) > 0)
                echo json_encode(FALSE);
            else
                echo json_encode(TRUE);
        }
    }

}
