<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class History extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->data['url'] = $_SERVER['REQUEST_URI'];
        $this->load->model('history_model');
        $this->load->model('hearthstone_model');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="form-error">', '</p>');
        $this->data['mainMenu']= $this->menu_model->getMainMenu();
        $this->data['langMenu']= $this->menu_model->getLangMenu();
        $this->data['session']=$this->session->all_userdata();
        if($this->session->userdata('logged_in')){$this->data['logged_in']=TRUE;}else{$this->data['logged_in']=FALSE;}
        $this->load->library('pagination');
    }
    
    function index(){
        redirect('history/view', 'refresh');
    }
    
    function view($uid="",$offset=0){
        if($this->session->userdata('logged_in')) { // L'utilisateur doit être connecté
            if($uid=="") $uid = $this->session->userdata('uid');
            $this->data['classes'] = $this->hearthstone_model->getClasses();

            $config['base_url'] = site_url('history/view/'.$uid);
            $config['total_rows'] = $this->history_model->countUserHistory($uid); 
            $config['per_page'] = 5;
            $config['uri_segment'] = 4;
            $config['use_page_numbers'] = FALSE;
            $config['prev_link'] = '&lt; '.$this->lang->line('newer_games');
            $config['next_link'] = $this->lang->line('oldest_games').' &gt;';                
            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';
            $config['prev_tag_open'] = '<li title="Previous page">';
            $config['prev_tag_close'] = '</li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="current"><a>';
            $config['cur_tag_close'] = '</a></li>';
            $config['next_tag_open'] = '<li title="Next page">';
            $config['next_tag_close'] = '</li>';
            $config['display_pages'] = FALSE;
            $config['last_link'] = FALSE;
            $config['first_link'] = FALSE;
            $this->pagination->initialize($config); 
            $this->data['pagination']=$this->pagination->create_links();
            $this->data['histories'] = $this->history_model->getUserHistory($uid,$config['per_page'],$offset);
            $this->data['current_history'] =$uid;
            $this->data['nbMonthGames'] = $this->history_model->getCurrentMonthGames($uid);
            $this->data['stats'] = $this->history_model->getUserStats($uid);
            $this->data['totalGames'] = $config['total_rows'];
            
            
            $this->data['page_title'] = 'history_view_page_title';
            $this->load->view('site/head',$this->data);
            $this->load->view('site/header');
            $this->load->view('history/view',$this->data);
            $this->load->view('site/footer');
        }else{ // Si l'utilisateur n'est pas connecté
            redirect('user/signin/mustSignIn');
        }
    }
    
     function submit(){
        if($this->session->userdata('logged_in')) { // L'utilisateur doit être connecté
            if($this->form_validation->run('history')){
                //  Le formulaire est valide
                $uid = $this->session->userdata('uid');
                $this->data['current_history'] =$uid;
                $user_class = $this->input->post('history_my_class_select');
                $user_deck = $this->input->post('history_my_deck_input');
                $oponent_class = $this->input->post('history_oponent_class_select');
                $oponent_deck = $this->input->post('history_oponent_deck_input');
                $result = $this->input->post('history_result');
                $gametype = $this->input->post('history_gametype');
                $comment = $this->input->post('history_comment_input');
                $rank = $this->session->userdata('rank');

                $this->history_model->addHistory($uid,$user_class,$user_deck,$oponent_class,$oponent_deck,$result,$gametype,$comment,$rank);         
                redirect('history/view', 'refresh');
            }else{
                //  Le formulaire est invalide
                $uid = $this->session->userdata('uid');
                $this->data['current_history'] =$uid;
                $this->data['classes'] = $this->hearthstone_model->getClasses();

                $config['base_url'] = site_url('history/view/'.$uid);
                $config['total_rows'] = $this->history_model->countUserHistory($uid);
                $config['per_page'] = 5;
                $config['uri_segment'] = 4;
                $config['use_page_numbers'] = FALSE;
                $config['prev_link'] = '&lt; '.$this->lang->line('previous');
                $config['next_link'] = $this->lang->line('next').' &gt;';                
                $config['full_tag_open'] = '<ul class="pagination">';
                $config['full_tag_close'] = '</ul>';
                $config['prev_tag_open'] = '<li title="Previous page">';
                $config['prev_tag_close'] = '</li>';
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = '<li class="current"><a>';
                $config['cur_tag_close'] = '</a></li>';
                $config['next_tag_open'] = '<li title="Next page">';
                $config['next_tag_close'] = '</li>';
                $config['display_pages'] = FALSE;
                $config['last_link'] = FALSE;
                $config['first_link'] = FALSE;
                $this->pagination->initialize($config); 
                $this->data['pagination']=$this->pagination->create_links();
                $this->data['histories'] = $this->history_model->getUserHistory($uid,$config['per_page'],0);
                $this->data['nbMonthGames'] = $this->history_model->getCurrentMonthGames($uid);
                $this->data['stats'] = $this->history_model->getUserStats($uid);
                $this->data['totalGames'] = $config['total_rows'];

                $this->data['page_title'] = 'history_view_page_title';
                $this->load->view('site/head',$this->data);
                $this->load->view('site/header');
                $this->load->view('history/view',$this->data);
                $this->load->view('site/footer');
            }
        }else{ // Si l'utilisateur n'est pas connecté
            redirect('user/signin/mustSignIn');
        }
    }
   
}
