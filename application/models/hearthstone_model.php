<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Hearthstone_model extends CI_Model
{
    public function getRank($nbstars){
        if($nbstars<=10){
            $totalstars=2;
            
        }elseif($nbstars<10){
            
        }elseif($nbstars<10){
        
        return array('rank' => $rank,
                     'stars' => $stars,
                     'totalstars'  => $totalstars);
    }return null;
    }
    
    public function getClasses(){
        $classes=array(
            'druid' =>    array(
                        'short' => 'druid_short',
                        'long' => 'druid_long',
                        'img'  => 'druid.png'
            ),  
            'hunter' =>   array(
                        'short' => 'hunter_short',
                        'long' => 'hunter_long',
                        'img'  => 'hunter.png'
            ),  
            'mage' =>     array(
                        'short' => 'mage_short',
                        'long' => 'mage_long',
                        'img'  => 'mage.png'
            ),  
            'paladin' =>  array(
                        'short' => 'paladin_short',
                        'long' => 'paladin_long',
                        'img'  => 'paladin.png'
            ),  
            'priest' =>   array(
                        'short' => 'priest_short',
                        'long' => 'priest_long',
                        'img'  => 'priest.png'
            ),  
            'rogue' =>    array(
                        'short' => 'rogue_short',
                        'long' => 'rogue_long',
                        'img'  => 'rogue.png'
            ),  
            'shaman' =>   array(
                        'short' => 'shaman_short',
                        'long' => 'shaman_long',
                        'img'  => 'shaman.png'
            ),  
            'warlock' =>  array(
                        'short' => 'warlock_short',
                        'long' => 'warlock_long',
                        'img'  => 'warlock.png'
            ),  
            'warrior' =>  array(
                        'short' => 'warrior_short',
                        'long' => 'warrior_long',
                        'img'  => 'warrior.png'
            ),  
        );
        return $classes;
    }
    
 }
       
?>