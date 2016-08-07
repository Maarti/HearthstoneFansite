<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
    'signup' => array(
            array(  'field' => 'user_pseudo_input',
                    'label' => 'lang:pseudo',
                    'rules' => 'required|min_length[2]|max_length[20]|regex_match[/^([-a-z_éèàêâùïüë ])+$/i]|xss_clean|callback_userPseudo_validator|htmlspecialchars'),
            array(  'field' => 'user_pass_input',
                    'label' => 'lang:password',
                    'rules' => 'required|min_length[2]|max_length[30]|xss_clean'),
            array(  'field' => 'user_confirm_input',
                    'label' => 'lang:confirm',
                    'rules' => 'required|matches[user_pass_input]|min_length[2]|max_length[30]|xss_clean'),
            array(  'field' => 'user_rank_select',
                    'label' => 'lang:rank',
                    'rules' => 'required|greater_than[0]|less_than[26]|xss_clean'),
             array( 'field' => 'user_stars_select',
                    'label' => 'lang:stars',
                    'rules' => 'required|greater_than[-1]|less_than[6]|xss_clean|callback_nbStars_validator')
            ),
    'signin' => array(
            array(  'field' => 'user_pseudo_input',
                    'label' => 'lang:pseudo',
                    'rules' => 'required|min_length[2]|max_length[20]|regex_match[/^([-a-z_éèàêâùïüë ])+$/i]|xss_clean|callback_userConnect_validator|htmlspecialchars'),
            array(  'field' => 'user_pass_input',
                    'label' => 'lang:password',
                    'rules' => 'required|min_length[2]|max_length[30]|xss_clean')
            ),
     'editprofile' => array(
            array(  'field' => 'user_rank_select',
                    'label' => 'lang:rank',
                    'rules' => 'required|greater_than[0]|less_than[26]|xss_clean'),
             array( 'field' => 'user_stars_select',
                    'label' => 'lang:stars',
                    'rules' => 'required|greater_than[-1]|less_than[6]|xss_clean|callback_nbStars_validator'),
             array( 'field' => 'user_battletag_input',
                    'label' => 'lang:battletag',
                    'rules' => 'min_length[2]|max_length[30]|xss_clean|htmlspecialchars')
            ),
    'history' => array(
            array(  'field' => 'history_my_class_select',
                    'label' => 'lang:class',
                    'rules' => 'required||max_length[10]|xss_clean'),
            array(  'field' => 'history_my_deck_input',
                    'label' => 'lang:my_deck',
                    'rules' => 'max_length[20]|xss_clean|htmlspecialchars'),
            array(  'field' => 'history_oponent_class_select',
                    'label' => 'lang:class',
                    'rules' => 'required||max_length[10]|xss_clean'),
            array(  'field' => 'history_oponent_deck_input',
                    'label' => 'lang:oponent_deck',
                    'rules' => 'max_length[20]|xss_clean|htmlspecialchars'),
            array(  'field' => 'history_result',
                    'label' => 'lang:result',
                    'rules' => 'required|max_length[4]|xss_clean'),
            array(  'field' => 'history_gametype',
                    'label' => 'lang:gametype',
                    'rules' => 'required|max_length[6]|xss_clean'),
            array(  'field' => 'history_comment_input',
                    'label' => 'lang:comment',
                    'rules' => 'max_length[40]|xss_clean|htmlspecialchars')
            )
  );
