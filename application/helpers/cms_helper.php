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

/* For Fetch config value using key (DHK)
/* Param 1 : $key value
*/
function config($key='')
{
    $CI =& get_instance();
    $CI->db->where('key',$key);
    $query = $CI->db->get('config');
    $res=$query->row_array();
    return isset($res['val'])?$res['val']:'';

}

/* For Fetch Email Content (DHK)
/* Param 1 : 
*/
function fetch_email_content($template_name)
{
    $CI =& get_instance();
    $CI->db->where('slug',$template_name);
    $query = $CI->db->get('email_template');
    $res=$query->row_array();
    if($res){
        $res=$res['description'];
    }else{
        $res='';
    }
    return $res;
}

/* For Email Template (DHK)
/* Param 1 :  $template_name => Field name 'slug_title'
/* Param 2 :  $template_file => HTML Template File Name
*/
function mailer($template_name,$template_file){

    $filename = base_url('public/email_templates/'.$template_file.'.html');
    $tpl = file_get_contents($filename, true);
    $content=fetch_email_content($template_name);
    $tpl = str_replace("@BODY@",$content,$tpl);
    $tpl = str_replace("@TPLURL@",base_url('public/email_templates/images'),$tpl);
    $tpl = str_replace("@BASEURL@",base_url(),$tpl);
    $tpl = str_replace("@FB@",config('facebook_link'),$tpl);
    $tpl = str_replace("@TWITTER@",config('twitter_link'),$tpl);
    $tpl = str_replace("@GPLUS@",config('gplus_link'),$tpl);
    $tpl = str_replace("@YOUTUBE@",config('youtube_link'),$tpl);
    $tpl = str_replace("@AEMAIL@",config('contact_email'),$tpl);
    return $tpl;

}



