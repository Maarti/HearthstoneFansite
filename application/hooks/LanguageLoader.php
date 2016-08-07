<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LanguageLoader
{
    function initialize() {
        $ci =& get_instance();
        $ci->load->helper('language');
 
        $site_lang = $ci->session->userdata('site_lang');
        if ($site_lang) {
            $ci->config->set_item('language', $site_lang);
            $ci->lang->load('text',$ci->session->userdata('site_lang'));
        } else {
            $ci->lang->load('text','en');
        }
    }
}
