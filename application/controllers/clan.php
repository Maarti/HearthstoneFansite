<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clan extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->data['mainMenu']= $this->menu_model->getMainMenu();
        $this->data['langMenu']= $this->menu_model->getLangMenu();
        $this->data['session']=$this->session->all_userdata();
        if($this->session->userdata('logged_in')){$this->data['logged_in']=TRUE;}else{$this->data['logged_in']=FALSE;}
        $this->data['url'] = $_SERVER['REQUEST_URI'];
    }
    
    function index(){
        redirect('clan/view', 'refresh');
    }
    
    function view(){
        $this->data['page_title'] = 'clan_view_page_title';
        $this->load->view('site/head',$this->data);
        $this->load->view('site/header');
        $this->load->view('clan/view');
        $this->load->view('site/footer');
    }
}
