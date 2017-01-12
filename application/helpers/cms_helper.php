 <?php

function pr($data, $is_die = null) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    if (!empty($is_die)) {
        die();
    }
}

function qry($is_die = false) {
    $CI = & get_instance();
    echo $CI->db->last_query();
    if ($is_die == true) {
        die();
    }
}
 
function is_loggedin() {
    $CI = & get_instance();
    return $CI->session->userdata('loggedin');
}

// v! Custom Flash message to dispay flash message dynamically
// For use this func you need to set flash message in an array
// class 'danger' can be replace with success or primary
// $this->session->set_flashdata('message',['message'=>'my message','class'=>'danger']);
function my_flash($message){    
    $ret_str = '';
    if(!empty($message)){
        $ret_str .= '<div class="alert alert-'.$message['class'].' alert-styled-left alert-arrow-left alert-bordered">';
        $ret_str .= '<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>';
        $ret_str .= '<span class="text-semibold">'.$message['message'].'</span></div>';
    }
    return $ret_str;
}

function pagination_config() {

    $config['full_tag_open'] = '<div><ul class="pagination pagination-small pagination-centered">';
    $config['full_tag_close'] = '</ul></div>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    
    $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
    $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";

    $config['next_tag_open'] = "<li>";
    $config['next_tagl_close'] = "</li>";

    $config['prev_tag_open'] = "<li>";
    $config['prev_tagl_close'] = "</li>";

    $config['first_tag_open'] = "<li>";
    $config['first_tagl_close'] = "</li>";
    
    $config['last_tag_open'] = "<li>";
    $config['last_tagl_close'] = "</li>";
    $config['num_links'] = "10";

    return $config;
}

function mail_config() {

    $configs = array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.gmail.com',
        'smtp_port' => 465,
        'smtp_user' => 'demo.narola@gmail.com',
        'smtp_pass' => 'narola21',
        'transport' => 'Smtp',
        'charset' => 'utf-8',
        'newline' => "\r\n",
        'headerCharset' => 'iso-8859-1',
        'mailtype' => 'html'
    );

    return $configs;
}


/* For Encode ID  (DHK)
/* Param 1 : ID
*/
function encode($input) 
{
    return urlencode(base64_encode($input));
}

/* For Decode ID  (DHK)
/* Param 1 : ID
*/

function decode($input) 
{
    return base64_decode(urldecode($input));
}

