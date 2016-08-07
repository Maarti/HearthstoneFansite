<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu_model extends CI_Model
{
    public function getMainMenu(){
        return array(
            1 => array(
                "href" => 'site/homepage',
                "label" => 'home',
                "disabled" => FALSE),
            2 => array(
                "href" => 'history/view',
                "label" => 'history',
                "disabled" => TRUE),
            3 => array(
                "href" => 'tournament/view',
                "label" => 'tournaments',
                "disabled" => FALSE),
            4 => array(
                "href" => 'user/all',
                "label" => 'members',
                "disabled" => FALSE),
            5 => array(
                "href" => 'clan/view',
                "label" => 'clans',
                "disabled" => FALSE)
            );
    }    
    
    public function getLangMenu(){
        return array(
            1 => array(
                "href" => 'site/lang/fr',
                "label" => 'Fr',
                "flag" => 'fr'),
            2 => array(
                "href" => 'site/lang/en',
                "label" => 'En',
                "flag" => 'gb'),
            3 => array(
                "href" => 'site/lang/de',
                "label" => 'De',
                "flag" => 'de'),
            4 => array(
                "href" => 'site/lang/es',
                "label" => 'Es',
                "flag" => 'es'),
            5 => array(
                "href" => 'site/lang/it',
                "label" => 'It',
                "flag" => 'it'),
            6 => array(
                "href" => 'site/lang/ru',
                "label" => 'Ru',
                "flag" => 'ru')
            );
    }    
   
    
 }
       
?>