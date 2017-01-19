<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctor extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(array('Users_model','Country_model'));
	}

	public function index(){
	   $data['subview'] = 'admin/users/doctor_index';
        $this->load->view('admin/layouts/layout_main', $data);
	}

	public function add(){
		$data['country_list']=$this->Country_model->get_result('country');

		if($_POST){
			$rand=random_string('alnum',5);

            $data=array(
                'role_id' => $this->input->post('role_id'),
                'fname' => $this->input->post('fname'),
                'lname' => $this->input->post('lname'),
                'email_id' => $this->input->post('email_id'),
                'password' => $this->encrypt->encode($this->input->post('password')),
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'country_id' => $this->input->post('country_id'),
                'zipcode' => $this->input->post('zipcode'),
                'gender' => $this->input->post('gender'),
                'phone' => $this->input->post('phone'),
                'birth_date' => $this->input->post('birth_date'),
                'longitude' => $this->input->post('longitude'),
                'latitude' => $this->input->post('latitude'),
                'activation_code'  => $rand,
                'is_blocked' => '1', // 1 Means Aacount is Blocked
                'created_at'=>date('Y-m-d H:i:s')
                );
            
            $res=$this->Users_model->insert_user_data($data);

            if($res){

            	//------ For Email Template -----------
                /* Param 1 : 'Email Template Slug' , Param 2 : 'HTML Template File Name' */
                $html_content=mailer('account_activation','AccountActivation'); 
                $username= $this->input->post('fname')." ".$this->input->post('lname');
                $html_content = str_replace("@USERNAME@",$username,$html_content);
                $html_content = str_replace("@ACTIVATIONLINK@",base_url('registration/verification/'.$rand),$html_content);
                $html_content = str_replace("@EMAIL@",$this->input->post('email_id'),$html_content);
                $html_content = str_replace("@PASS@",$this->input->post('password'),$html_content);
                //--------------------------------------

                $email_config = mail_config();
                $this->email->initialize($email_config);
                $subject=config('site_name').' - Thank you for your registration';
                $this->email->from(config('contact_email'), config('sender_name'))
                            ->to($this->input->post('email_id'))
                            ->subject($subject)
                            ->message($html_content);
                $this->email->send();
                $this->session->set_flashdata('message', ['message'=>'Thank you for your registration, you will receive an activation link soon.','class'=>'success']);
                redirect('admin/doctor');
            }
		}
        $data['subview']='admin/users/doctor_registration';
        $this->load->view('admin/layouts/layout_main',$data);
	}

    public function edit($id){
        
        $id = decode($id);
        $data['country_list']=$this->Country_model->get_result('country');
        $data['doctor_data'] = $this->Users_model->get_data(['id'=>$id],true);        

        if($_POST){

            $data=array(                
                'fname' => $this->input->post('fname'),
                'lname' => $this->input->post('lname'),
                'email_id' => $this->input->post('email_id'),                
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'country_id' => $this->input->post('country_id'),
                'zipcode' => $this->input->post('zipcode'),
                'gender' => $this->input->post('gender'),
                'phone' => $this->input->post('phone'),
                'birth_date' => $this->input->post('birth_date'),
                'longitude' => $this->input->post('longitude'),
                'latitude' => $this->input->post('latitude'),                
                'updated_at'=>date('Y-m-d H:i:s')
            );

            $this->Users_model->update_user_data($id,$data);
            $this->session->set_flashdata('message', ['message'=>'Doctor successfully updated.','class'=>'success']);
            redirect('admin/doctor');
        }

        $data['subview']='admin/users/doctor_registration_edit';
        $this->load->view('admin/layouts/layout_main',$data);
    }

    public function block($id){
        $id = decode($id);
        $this->Users_model->update_user_data($id,['is_blocked'=>'1']);
        $this->session->set_flashdata('message', ['message'=>'Doctor Successfully blocked.','class'=>'success']);
        redirect('admin/doctor');
    }

    public function activate($id){
        $id = decode($id);
        $this->Users_model->update_user_data($id,['is_blocked'=>'0']);
        $this->session->set_flashdata('message', ['message'=>'Doctor Successfully activated.','class'=>'success']);
        redirect('admin/doctor');   
    }

    public function delete($id){
        $id = decode($id);
        $this->Users_model->update_user_data($id,['is_deleted'=>'1']);
        $this->session->set_flashdata('message', ['message'=>'Doctor Successfully deleted.','class'=>'success']);
        redirect('admin/doctor');
    }

    /**
     * Function is used to get result based on datatable in user list page
     */
    public function list_user() {
        $final['recordsTotal'] = $this->Users_model->get_doctors_count();
        $final['redraw'] = 1;        
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Users_model->get_all_doctors();
        echo json_encode($final);
    }
    
}

/* End of file Doctor.php */
/* Location: ./application/controllers/admin/Doctor.php */