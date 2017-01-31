<?php

// error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Treatment_category extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Treatment_category_model']);
        $this->load->library('excel');
        $this->load->helper('download');
    }

    /**
     * Function load view of Treatment Category list.
     */
    public function index() {

        $data['subview'] = 'admin/treatment_category/index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in Treatment Category list page
     */
    public function list_treatment_category() {

        $final['recordsTotal'] = $this->Treatment_category_model->get_treatment_category_count();
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Treatment_category_model->get_all_treatment_category();
        echo json_encode($final);
    }

    /**
     * Function is used to perform action (Delete,Block,Unblock)
     */
    public function action($action, $cat_id) {

        $where = 'id = ' . decode($this->db->escape($cat_id));
        $check_cat = $this->Treatment_category_model->get_result('treatment_category', $where);
        if ($check_cat) {
            if ($action == 'delete') {
                $update_array = array(
                    'is_deleted' => 1
                    );
                $this->session->set_flashdata('message',['message'=>'Treatment Category successfully deleted!','class'=>'success']);
            } elseif ($action == 'block') {
                $update_array = array('is_blocked' => 1 );
                $this->session->set_flashdata('message',['message'=>'Treatment Category successfully blocked!','class'=>'success']);
            } else {
                $update_array = array('is_blocked' => 0 );
                $this->session->set_flashdata('message',['message'=>'Treatment Category successfully unblocked!','class'=>'success']);
            }
            $this->Treatment_category_model->update_record('treatment_category', $where, $update_array);
        } else {
            $this->session->set_flashdata('message',['message'=>'Invalid request. Please try again!','class'=>'danger']);
        }
        redirect('admin/treatment_category');
    }

    /**
     *  Load view for Edit Treatment Category 
     * */
    public function edit() {

        $cat_id = decode($this->uri->segment(4));
        if (is_numeric($cat_id)) {
            $where = 'id = ' . $this->db->escape($cat_id);
            $check_cat = $this->Treatment_category_model->get_result('treatment_category', $where);
            if ($check_cat) {
                $data['record'] = $check_cat[0];
                $data['title'] = 'Admin Edit Treatment Category';
                $data['heading'] = 'Edit Treatment Category';                
            } else {
                show_404();
            }
        }
        if ($this->input->post()) {

             $update_array = [
                'title'          => $this->input->post('title'),
                'code'          => $this->input->post('code'),
                'is_blocked'      => $this->input->post('is_blocked'),
            ];

            $result=$this->Treatment_category_model->update_record('treatment_category', $where, $update_array);
            if($result){
                $this->session->set_flashdata('message',['message'=>'Treatment Category successfully updated!','class'=>'success']);
            }
            else{
                $this->session->set_flashdata('message',['message'=>'Error Into Update Treatment Category!','class'=>'danger']);
            }               
            redirect('admin/treatment_category');
            
        }
        $data['subview'] = 'admin/treatment_category/manage';
        $this->load->view('admin/layouts/layout_main', $data);
    }

     /**
     * Load view for Add Treatment Category 
     * */

    public function add() {

        $data['title'] = 'Admin Add Treatment Category';
        $data['heading'] = 'Add Treatment Category';
        if ($this->input->post()) {

            $insert_array = [
            'title'          => $this->input->post('title'),
            'code'          => $this->input->post('code'),
            'created_at'     => date("Y-m-d H:i:s a"),
            'is_blocked'      => $this->input->post('is_blocked'),
            ];

            $result=$this->Treatment_category_model->insert_record('treatment_category',$insert_array);
            if($result){
                $this->session->set_flashdata('message',['message'=>'Treatment Category successfully Inserted!','class'=>'success']);
            }
            else{
                $this->session->set_flashdata('message',['message'=>'Error Into Insert Treatment Category!','class'=>'danger']);
            }       
            redirect('admin/treatment_category');
        }
        $data['subview'] = 'admin/treatment_category/manage';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Check For Treatment Category Title Already Exist or Not
     * */
    public function check_cat_title_exists($id = 0){
        if (array_key_exists('title', $_POST)) {
            if ($this->Treatment_category_model->CheckExist($this->input->post('title'), $id) > 0)
                echo json_encode(FALSE);
            else
                echo json_encode(TRUE);
        }
    }

    public function import(){

        if($_POST){

            $config['upload_path'] = './uploads/doc_category/';
            $config['allowed_types'] = 'csv|xls|xlsx';
            $config['max_size']  = '10000000000';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            
            if ( ! $this->upload->do_upload('import_csv')){
                $error = array('error' => $this->upload->display_errors());                
            } else {
                $data = array('upload_data' => $this->upload->data());
                $res = $this->read_excel($data['upload_data']['full_path']);
                $all_categories = $res['values'];
                // pr($all_categories,1);

                $all_ins = [];

                if(!empty($all_categories)){
                    foreach($all_categories as $category){
                        $insert_array = [
                            'code'=>$category['A'],
                            'title'=> $category['B'],
                            'created_at'     => date("Y-m-d H:i:s a"),
                            'is_blocked'      => '0',
                        ];
                        array_push($all_ins,$insert_array);                        
                    }   

                    if(!empty($all_ins)){
                        $this->db->insert_batch('treatment_category', $all_ins);
                    }
                    
                }

                $this->session->set_flashdata('message',['message'=>'All category imported successfully','class'=>'success']);
                redirect('admin/treatment_category/import');
            }
        }        

        $data['heading'] = 'Import Category';
        $data['subview'] = 'admin/treatment_category/import';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    public function read_excel($file){

        ob_clean();        
        //read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file);
        //get only the Cell Collection
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        //extract to a PHP readable array format        

        foreach ($cell_collection as $cell) {                


            $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

            //header will/should be in row 1 only. of course this can be modified to suit your need.            
            if ($row == 1 && !empty($data_value)) {
                $header[$row][$column] = $data_value;
            } else if(!empty($data_value)) {
                $arr_data[$row][$column] = $data_value;
            }
        }
        //send the data in an array format
        $data['header'] = $header;
        $data['values'] = $arr_data;

        return $data;
    }

    public function download_sample(){
        $path = $_SERVER['DOCUMENT_ROOT'].'/dental/uploads/sample.xlsx';        
        $data = file_get_contents($path); // Read the file's contents        
        $name = 'sample.xlsx';
        force_download($name, $data); 
    }

    public function create_excel(){
        //load our new PHPExcel library
        ob_clean();
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('test worksheet');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'This is just some text value');
        //change the font size
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        //merge cell A1 until D1
        $this->excel->getActiveSheet()->mergeCells('A1:D1');
        //set aligment to center for that merged cell (A1 to D1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $filename='just_some_random_name.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

}
