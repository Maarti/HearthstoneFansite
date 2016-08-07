<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->data['mainMenu']= $this->menu_model->getMainMenu();
        $this->data['langMenu']= $this->menu_model->getLangMenu();
        $this->data['session']=$this->session->all_userdata();
        if($this->session->userdata('logged_in')){$this->data['logged_in']=TRUE;}else{$this->data['logged_in']=FALSE;}
        $this->data['url'] = $_SERVER['REQUEST_URI'];
    }
    
    function index(){
        redirect('site/homepage', 'refresh');
    }
    
    function homepage(){
        $this->data['page_title'] = 'site_homepage_page_title';
        $this->load->view('site/head',$this->data);
        $this->load->view('site/header');
        $this->load->view('site/homepage');
        $this->load->view('site/footer');
    }
    
    function lang($language = "en") {
        if($language != "fr" && $language != "en" && $language != "de" && $language != "es" && $language != "it" && $language != "ru")
            $language = 'en';
        $this->session->set_userdata('site_lang', $language);
        $this->config->set_item('language', $language);
        redirect($_SERVER['HTTP_REFERER']);
    }
}
