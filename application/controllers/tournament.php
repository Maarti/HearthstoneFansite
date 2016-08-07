<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tournament extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->data['url'] = $_SERVER['REQUEST_URI'];
        $this->data['mainMenu']= $this->menu_model->getMainMenu();
        $this->data['langMenu']= $this->menu_model->getLangMenu();
        $this->data['session']=$this->session->all_userdata();
        if($this->session->userdata('logged_in')){$this->data['logged_in']=TRUE;}else{$this->data['logged_in']=FALSE;}
    }
    
    function index(){
        redirect('tournament/view', 'refresh');
    }
    
    function view(){
        $this->data['page_title'] = 'tournament_view_page_title';
        $this->load->view('site/head',$this->data);
        $this->load->view('site/header');
        $this->load->view('tournament/view');
        $this->load->view('site/footer');
    }
    
    function submit(){
        $data = $this->input->post('tournament-data');
        $o = json_decode($data);
        echo var_dump($o);
        echo var_dump($o->results[0]);
        
    }
    
}
