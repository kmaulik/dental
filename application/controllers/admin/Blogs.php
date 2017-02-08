<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blogs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Blogs_model']);
        $this->load->library(['encryption', 'upload']);
        check_admin_login();
    }

    /**
     * Function load view of blog list.
     */
    public function index() {
     
        $data['subview'] = 'admin/blogs/index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in blog list page
     */
    public function list_blog() {
     
        $final['recordsTotal'] = $this->Blogs_model->get_blogs_count();
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Blogs_model->get_all_blogs();
        echo json_encode($final);
        

    }

    /**
     * Function is used to perform action (Delete,Block,Unblock)
     */
    public function action($action, $blog_id) {

        $where = 'id = ' . decode($this->db->escape($blog_id));
        $check_blog = $this->Blogs_model->get_result('blog', $where);
        if ($check_blog) {
            if ($action == 'delete') {
                $update_array = array(
                    'is_deleted' => 1
                    );
                $this->session->set_flashdata('message', ['message'=>'Blogs successfully deleted!','class'=>'success']);
            } elseif ($action == 'block') {
                $update_array = array(
                    'is_blocked' => 1
                    );
                $this->session->set_flashdata('message', ['message'=>'Blogs successfully blocked!','class'=>'success']);
            } else {
                $update_array = array(
                    'is_blocked' => 0
                    );
                $this->session->set_flashdata('message', ['message'=>'Blogs successfully unblocked!','class'=>'success']);
            }
            $this->Blogs_model->update_record('blog', $where, $update_array);
        } else {
            $this->session->set_flashdata('message', ['message'=>'Invalid request. Please try again!','class'=>'danger']);
        }
        redirect(site_url('admin/blogs'));
    }

    /**
     *  Load view for Edit blog 
     * */
    public function edit() {
        
        $blog_id = decode($this->uri->segment(4));
        if (is_numeric($blog_id)) {
            $where = 'id = ' . $this->db->escape($blog_id);
            $check_blog = $this->Blogs_model->get_result('blog', $where);
            if ($check_blog) {
                $data['record'] = $check_blog[0];
                $data['title'] = 'Admin edit blog';
                $data['heading'] = 'Edit blog';                
            } else {
                show_404();
            }
        }
        if ($this->input->post()) {
         
            //--------------- For Multiple File Upload  -----------
            $img_path='';
            $success=0;
            $unsuccess=0;
            if(isset($_FILES['img_path']['name']) && $_FILES['img_path']['name'][0] != NULL)
            {
                $location='uploads/blogs/';
                foreach($_FILES['img_path']['name'] as $key=>$data){
                    $res=$this->filestorage->FileArrayInsert($location,'img_path','image','10485760',$key); // 10 MB
                    if($res['status'] == '1'){
                        if($key == 0){
                            $img_path=$res['msg'];
                        }else{
                            $img_path=$img_path."|".$res['msg'];
                        }
                        $success =$success+1;
                    }
                    else{
                        $unsuccess= $unsuccess+1;
                    }
                }
                //--------- For Delete Old Image -------
                if($this->input->post('Himg_path') != '')
                {
                    $old_img=explode('|',$this->input->post('Himg_path'));
                    foreach ($old_img as $key => $img) {
                        $this->filestorage->DeleteImage($location,$img);
                    }
                }    
                
            }
            else{
                $img_path = $this->input->post('Himg_path');
            }
            //----------------------------------------
            $update_array = [
                'blog_title'        => $this->input->post('blog_title'),
                'blog_slug'         => $this->input->post('blog_slug'),
                'blog_description'  => $this->input->post('blog_description'),
                'img_path'          => $img_path,
                'is_blocked'        => $this->input->post('is_blocked'),
            ];

            $result=$this->Blogs_model->update_record('blog', $where, $update_array);
            if($result){
                 $msg='';
                 if($success != 0 || $unsuccess != 0)
                 {
                    $msg= "<br>".$success." File Uploaded Successfully <br>".$unsuccess." File Not Upload";
                 }   
                 $this->session->set_flashdata('message', ['message'=>'Blog successfully updated!'.$msg,'class'=>'success']);
            }
            else{
  
                 $this->session->set_flashdata('message', ['message'=>'Error Into Update Blog!','class'=>'danger']);
            }               
        redirect('admin/blogs');
    }
    $data['subview'] = 'admin/blogs/manage';
    $this->load->view('admin/layouts/layout_main', $data);
}

     /**
     * Load view for Add blog 
     * */

    public function add() {
        
        $data['title'] = 'Admin add blog';
        $data['heading'] = 'Add blog';
        if ($this->input->post()) {
            //--------------- For Multiple File Upload  -----------
            $img_path='';
            $success="0";
            $unsuccess="0";
            if(isset($_FILES['img_path']['name']) && $_FILES['img_path']['name'][0] != NULL)
            {
                $location='uploads/blogs/';
                foreach($_FILES['img_path']['name'] as $key=>$data){
                    $res=$this->filestorage->FileArrayInsert($location,'img_path','image','10485760',$key); // 10 MB
                    if($res['status'] == '1'){
                        if($key == 0){
                            $img_path=$res['msg'];
                        }else{
                            $img_path=$img_path."|".$res['msg'];
                        }
                        $success = $success+1;
                    }
                    else{
                        $unsuccess = $unsuccess+1;
                    }
                }   
            }
            //----------------------------------------
            $insert_array = [
                'blog_title'        => $this->input->post('blog_title'),
                'blog_slug'         => $this->input->post('blog_slug'),
                'blog_description'  => $this->input->post('blog_description'),
                'img_path'          => $img_path,
                'created_by'        => $this->session->userdata['admin']['id'],
                'is_blocked'        => $this->input->post('is_blocked'),
                'created_at'        => date("Y-m-d H:i:s a"),
            ];
            $result=$this->Blogs_model->insert_record('blog',$insert_array);
            if($result){
                 $msg= "<br>".$success." File Uploaded Successfully <br>".$unsuccess." File Not Upload";
                 $this->session->set_flashdata('message', ['message'=>'Blog successfully Inserted!'.$msg,'class'=>'success']);
            }
            else{
                 $this->session->set_flashdata('message', ['message'=>'Error Into Insert Blog!','class'=>'danger']);
            }       
            redirect('admin/blogs');
        }
        $data['subview'] = 'admin/blogs/manage';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Check For Blog Title Already Exist or Not
     * */
    public function check_blog_title_exists($id = 0){
        if (array_key_exists('blog_title', $_POST)) {
            if ($this->Blogs_model->CheckExist($this->input->post('blog_title'), $id) > 0)
                echo json_encode(FALSE);
            else
                echo json_encode(TRUE);
        }
    }

}
