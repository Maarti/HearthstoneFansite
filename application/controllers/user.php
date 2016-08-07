<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->data['url'] = $_SERVER['REQUEST_URI'];
        $this->load->model('user_model');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="form-error">', '</p>');
        $this->data['mainMenu']= $this->menu_model->getMainMenu();
        $this->data['langMenu']= $this->menu_model->getLangMenu();
        $this->data['session']=$this->session->all_userdata();
        if($this->session->userdata('logged_in')){$this->data['logged_in']=TRUE;}else{$this->data['logged_in']=FALSE;}
    }
    
    function index(){
        redirect('user/all', 'refresh');
    }
    
    function signup(){
        if($this->session->userdata('logged_in')) { // Si l'utilisateur est déjà connecté
            redirect('', 'refresh');
        }else{
            $this->data['page_title'] = 'user_signup_page_title';
            $this->load->view('site/head',$this->data);
            $this->load->view('site/header');
            $this->load->view('user/signup');
            $this->load->view('site/footer');
        }
    }
    
    function signup_submit(){   
        if($this->form_validation->run('signup')){
            //  Le formulaire est valide
            $pseudo = $this->input->post('user_pseudo_input');
            $pass = $this->input->post('user_pass_input');
            $rank = $this->input->post('user_rank_select');
            $stars = $this->input->post('user_stars_select');            
            $ip=$this->input->ip_address();
           
            $this->user_model->createUser($pseudo,$pass,$ip,$rank,$stars);           
            redirect('user/signin/signUpSuccess', 'refresh');
        }else{
            //  Le formulaire est invalide
            $this->data['page_title'] = 'user_signup_page_title';
            $this->load->view('site/head',$this->data);
            $this->load->view('site/header');
            $this->load->view('user/signup');
            $this->load->view('site/footer');
        }
    }

    function userPseudo_validator($pseudo){  
        if ($this->user_model->userPseudoExists($pseudo)) {
            $this->form_validation->set_message('userPseudo_validator', $this->lang->line('error_pseudo_already_taken'));
            return FALSE;
        }else{
            return TRUE;
        }
    }
    
    function nbStars_validator($nbstars){  
        $rank = $this->input->post('user_rank_select');
        if ($nbstars>$this->user_model->getMaxStars($rank)) {
            $this->form_validation->set_message('nbStars_validator', $this->lang->line('error_nbstars_doesnt_match_rank'));
            return FALSE;
        }else{
            return TRUE;
        }
    }
    
    function signin($msg=''){
        if($this->session->userdata('logged_in')) { // Si l'utilisateur est déjà connecté
            redirect('', 'refresh');
        }else{
            switch ($msg) { // Gestion des messages à afficher en debut de page
                case 'signUpSuccess':
                    $this->data['msg']= $this->lang->line('signup_success');
                    $this->data['type'] = 'success';
                    break;
                case 'mustSignIn':
                    $this->data['msg']= $this->lang->line('must_signin');
                    $this->data['type'] = 'warning';
                    break;
            }
            $this->data['page_title'] = 'user_signin_page_title';
            $this->load->view('site/head',$this->data);
            $this->load->view('site/header');
            $this->load->view('user/signin');
            $this->load->view('site/footer');
        }
    }
    
    function signin_submit(){   
        if($this->form_validation->run('signin')){
            //  Le formulaire est valide
            $userinfo= $this->user_model->getUser($this->input->post('user_pseudo_input'));
           
            // On crée les variables de session
            $sessiondata = array(
                   'uid'  => $userinfo[0]->user_id,
                   'pseudo'=> $userinfo[0]->user_pseudo,
                   'rank'=>$userinfo[0]->user_rank,
                   'stars'=>$userinfo[0]->user_stars,
                   'maxStars'=>$this->user_model->getMaxStars($userinfo[0]->user_rank),
                   'clan'=>$userinfo[0]->user_clan,
                   'logged_in' => TRUE
               );
            $this->session->set_userdata($sessiondata);
            $this->data['session']=$this->session->all_userdata();
            
            // On enregistre les logs de la connection dans la DB
            $this->load->model('log_model');
            $ip=$this->input->ip_address();
            $uid=$userinfo[0]->user_id;
            $this->load->library('user_agent');
            if ($this->agent->is_browser()) {
                $agent = 'Browser - '.$this->agent->browser().' '.$this->agent->version();
            }elseif ($this->agent->is_robot()){
                $agent = 'Robot - '.$this->agent->robot();                
            }elseif ($this->agent->is_mobile()){
                $agent = 'Mobile - '.$this->agent->mobile();                
            }else{
                $agent = 'Unidentified User Agent';
            }
            $platform=$this->agent->platform();
            
            $this->log_model->createLog($uid,$ip,$agent,$platform);
            
            // On met à jour la date de dernière connexion de l'utilisateur
            $this->user_model->updateLastConnect($this->input->post('user_pseudo_input'));
            redirect('history/view', 'refresh');
        }else{
            //  Le formulaire est invalide
            $this->data['page_title'] = 'user_signin_page_title';
            $this->load->view('site/head',$this->data);
            $this->load->view('site/header');
            $this->load->view('user/signin');
            $this->load->view('site/footer');
        }
    }
    
    function userConnect_validator(){ 
        $inputPseudo = $this->input->post('user_pseudo_input');
        $inputPass = $this->input->post('user_pass_input');
            
        $checkPassword = $this->user_model->passwordIsCorrect($inputPseudo,$inputPass);
        if ($checkPassword==0){
            $this->form_validation->set_message('userConnect_validator', $this->lang->line('error_incorrect_pseudo'));
            return FALSE;
        }elseif($checkPassword==1){
            return TRUE;
        }else{
            $this->form_validation->set_message('userConnect_validator', $this->lang->line('error_incorrect_password'));
            return FALSE;
        }
    }
    
    function signout(){
        $this->session->unset_userdata($this->session->all_userdata());
        redirect('user/signin', 'refresh');
    }
    
    function profile($uid=""){
        if($this->session->userdata('logged_in')){
        if($uid=="") $uid = $this->session->userdata('uid');}
            
        $userData = $this->user_model->getUserById($uid);
        if($userData) {
            $this->load->model('history_model');
            $this->data['userMaxStars'] = $this->user_model->getMaxStars($userData[0]->user_rank);
            $this->data['profile'] = $userData;
            $this->data['nbMonthGames'] = $this->history_model->getCurrentMonthGames($uid);
            $this->data['stats'] = $this->history_model->getUserStats($uid);
            $this->data['totalGames'] = $this->history_model->countUserHistory($uid);
            $this->data['page_title'] = 'user_profile_page_title';
            $this->load->view('site/head',$this->data);
            $this->load->view('site/header');
            $this->load->view('user/profile');
            $this->load->view('site/footer');
            
        }else{ // si l'uid n'est pas correct
            redirect('', 'refresh');
        }
    }
    
    function editprofile_submit(){   
        if($this->session->userdata('logged_in')){
            if($this->form_validation->run('editprofile')){
                //  Le formulaire est valide
                $uid = $this->session->userdata('uid');
                $rank = $this->input->post('user_rank_select');
                $stars = $this->input->post('user_stars_select');
                $battletag=$this->input->post('user_battletag_input');
                $this->user_model->editUser($uid,$rank,$stars,$battletag);
                redirect('user/profile', 'refresh');
            }else{
                $userData = $this->user_model->getUserById($this->session->userdata('uid'));
                $this->data['profile'] = $userData;
                $this->data['page_title'] = 'user_profile_page_title';
                $this->load->view('site/head',$this->data);
                $this->load->view('site/header');
                $this->load->view('user/profile');
                $this->load->view('site/footer');
            }
        }else{ // Si l'utilisateur n'est pas connecté
            redirect('user/signin/mustSignIn');
        }
     }
     
     function all($offset=0){
        $this->load->library('pagination');
        $config['base_url'] = site_url('user/all');
        $config['total_rows'] = $this->user_model->countAllUsers(); 
        $config['per_page'] = 20;
        $config['uri_segment'] = 3;
        $config['use_page_numbers'] = FALSE;      
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
        $config['display_pages'] = TRUE;
        $config['last_link'] = TRUE;
        $config['first_link'] = TRUE;
        $this->pagination->initialize($config); 
        $this->data['pagination']=$this->pagination->create_links();
        $this->data['users'] = $this->user_model->getAllUsers($config['per_page'],$offset);
        $this->data['offset'] = $offset;
            
        $this->data['page_title'] = 'user_all_page_title';
        $this->load->view('site/head',$this->data);
        $this->load->view('site/header');
        $this->load->view('user/all');
        $this->load->view('site/footer');
     }
}
