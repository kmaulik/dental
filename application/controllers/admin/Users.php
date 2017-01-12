<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['admin/Admin_users_model', 'Users_model']);
        $this->load->library(['encryption', 'upload']);
    }

    /**
     * Function load view of users list.(HPA)
     */
    public function index() {        
        $data['subview'] = 'admin/users/index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in user list page
     */
    public function list_user() {        
        $final['recordsTotal'] = $this->Admin_users_model->get_users_count();
        $final['redraw'] = 1;
        // $final['recordsFiltered'] = $this->admin_users_model->get_users_result(TBL_USER,$select,'count');
        $final['recordsFiltered'] = $final['recordsTotal'];
    $final['data'] = $this->Admin_users_model->get_all_users();
        echo json_encode($final);

    }

    public function action($action, $user_id) {

        $where = 'id = ' . $this->db->escape($user_id);
        $check_user = $this->Admin_users_model->get_result('users', $where);
        if ($check_user) {
            if ($action == 'delete') {
                $update_array = array(
                    'is_deleted' => 1
                );
                $this->session->set_flashdata('success', 'User successfully deleted!');
            } elseif ($action == 'block') {
                $update_array = array(
                    'is_blocked' => 1
                );
                $this->session->set_flashdata('success', 'User successfully blocked!');
            } else {
                $update_array = array(
                    'is_blocked' => 0
                );
                $this->session->set_flashdata('success', 'User successfully unblocked!');
            }
            $this->Admin_users_model->update_record('users', $where, $update_array);
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        redirect('admin/users');
    }

    /**
     * @uses : Load view of users list
     * @author : HPA
     * */
    public function edit() {
        $session_data = $this->session->userdata('admin');
        $data['user_data'] = $this->Users_model->check_if_user_exist(['id' => $session_data['id'], 'role_id' => 1], false, true);
        if (empty($data['user_data'])) {
            redirect('admin/login');
        }        
        $user_id = $this->uri->segment(4);
        if (is_numeric($user_id)) {
            $where = 'id = ' . $this->db->escape($user_id);
            $check_user = $this->Admin_users_model->get_result('users', $where);
            if ($check_user) {
                $data['user_datas'] = $check_user[0];
                $data['title'] = 'Admin edit user';
                $data['heading'] = 'Edit user';                
            } else {
                show_404();
            }
        }
        if ($this->input->post()) {
            $this->form_validation->set_rules('fname', 'first name', 'trim|required');
            $this->form_validation->set_rules('lname', 'last name', 'trim|required');            
            $this->form_validation->set_rules('email_id', 'email', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $data['subview'] = 'admin/users/manage';
                $this->load->view('admin/layouts/layout_main', $data);
            } else {
                $update_array = $this->input->post(null);
                $this->Admin_users_model->update_record('users', $where, $update_array);
                $this->session->set_flashdata('success', 'User successfully updated!');
                redirect('admin/users');
            }
        }
        $data['subview'] = 'admin/users/manage';
        $this->load->view('admin/layouts/layout_main', $data);
    }

}
