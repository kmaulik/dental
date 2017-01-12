<?php

class LanguageLoader {

    function initialize() {
        $ci = & get_instance();
        $ci->load->helper('language');
        $ci->load->library('session');
        
        if ($ci->session->userdata('language') == FALSE) {
            $ci->session->set_userdata('language', 'english');
        }
        $language = $ci->session->userdata('language');
        $ci->lang->load('message', 'english');
        $ci->lang->load('other', 'english');
        if ($language == 'german') {
            $ci->lang->load('message', 'german');
            $ci->lang->load('other', 'german');
        }
    }

}
