<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model
{
    public function getUser($pseudo){
        return $this->db->get_where('user', array('user_pseudo' => $pseudo))->result();
    }
       public function getUserById($uid){
        return $this->db->get_where('user', array('user_id' => $uid), 1)->result();
    }
    
    // Met à jour la date de derniere connexion d'un utilisateur
    public function updateLastConnect($pseudo){
        $edit_this_user = array('user_lastconnect' => date("Y-m-d H:i:s"));
        $this->db->where('user_pseudo', $pseudo);
        return $this->db->update('user', $edit_this_user);
    }
    
    // Créer un utilisateur
    public function createUser($pseudo,$pass,$ip,$rank,$stars){
        $this->load->library('encrypt');
        $encrypted_pass = $this->encrypt->encode($pass);                      
        $user_register_datas_submited = array(
            'user_pseudo' => $pseudo ,
            'user_pass' => $encrypted_pass,
            'user_rank' => $rank,
            'user_stars' => $stars,
            'user_lastconnect' => date("Y-m-j H:i:s"),
            'user_ip' => $ip);
       log_message('info', 'User created : '.$pseudo);
       return $this->db->insert('user', $user_register_datas_submited);
    }
    
     // Savoir si un pseudo existe déjà dans la BDD
    public function userPseudoExists($pseudo){
        $query = $this->db->get_where('user', array('user_pseudo' => $pseudo));
        if ($query->num_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }
   
    // Savoir si une combinaison pseudo/pass est correcte
    // Renvoie 0 si pseudo n'existe pas
    // Renvoie 1 si combinaison correcte
    // Renvoie 2 si combinaison incorrecte
    public function passwordIsCorrect($pseudo,$pass){
        $this->load->library('encrypt');
        $realEncryptedPassword = $this->db->select('user_pass')
                        ->from('user')
                        ->where('user_pseudo',$pseudo)
                        ->where('user_deleted',0)
                        ->get()
                        ->result();
        if (empty($realEncryptedPassword)){
            return 0;
        }else{
            if ($this->encrypt->decode($realEncryptedPassword[0]->user_pass)==$pass) {
                return 1;
            } else {
                return 2; }
        }
    }
    
    // Retourne les infos nécessaires à la mise à jour du rang de l'utilisateur
    public function getLastRanked($uid){
        return $this->db->order_by('history_date', 'desc')
                        ->get_where('history', array('history_user' => $uid, 'history_gametype' => 'ranked'), 2)
                        ->result();
    }
  
    // Met à jour le nombre d'étoile et le rang d'un utilisateur en fonction d'une victoire ou défaite d'une ranked game
    public function updateStars($uid,$result){        
        $user = $this->getUserById($uid);
        $rank = $user[0]->user_rank;
        $stars = $user[0]->user_stars;
        $maxStars = $this->getMaxStars($rank);
                
        if($result=='win'){ // Si le resultat ACTUEL est une victoire, il faut verifier le resultat precedent pour savoir si on ajoute 1 ou 2 etoiles
            $lastRanked = $this->getLastRanked($uid);
            if(isset($lastRanked[0]) && isset($lastRanked[1])){ // Si il y a bien eu une ranked precedente
                if($lastRanked[0]->history_result=='win' && $lastRanked[1]->history_result=='win')
                    $lastResult = 'win';
                else 
                    $lastResult = 'loss';
            }else{          // S'il ny a pas eu de ranked précédente
                $lastResult = 'loss';
            }
            if($lastResult=='win' && $rank>5){ // Au dela du rang 5, il n'y a plus de bonus de victoires d'affilées (A VERIFIER)
                // 2 victoires d'affilées
                $stars+=2;
                if($stars>$maxStars){
                    $rank--;
                    $stars = $stars - $maxStars;
                }
            }else{
                // 1 victoire
                if($rank!=1 || $stars !=5){ // Si on est pas au max
                    $stars++;
                    if($stars>$maxStars){
                        $rank--;
                        $stars = $stars - $maxStars;
                    }
                }
            }                
        }else{  // Si le resultat ACTUEL est une défaite, on retire une etoile
            // 1 défaite
            if($rank < 21){ // sauf avant le rang 21
                $stars--;
                if($stars<0){
                    $rank++;
                    $stars = $this->getMaxStars($rank)-1;
                }
            }
        }       
        
        // On met à jour les variables de session
        $newSessionData = array(
                   'rank'  => $rank,
                   'stars' => $stars,
                   'maxStars' => $this->getMaxStars($rank));
        $this->session->set_userdata($newSessionData);
        
        // On met à jour la BDD
        $edit_this_user = array('user_rank' => $rank,
                                'user_stars' => $stars);
        $this->db->where('user_id', $uid);
        return $this->db->update('user', $edit_this_user);
    }
    
    // Retourne le nombre d'étoiles maxi par rang
    public function getMaxStars($rank){
        if($rank>20)
            return 2;
        elseif($rank>15)
            return 3;
        elseif($rank>10)
            return 4;
        else
            return 5;
    } 
    
    public function editUser($uid,$rank,$stars,$battletag){
        $edit_this_user = array('user_rank' => $rank,
                                'user_stars' => $stars,
                                'user_battletag' => $battletag);
        $this->db->where('user_id', $uid);
        // On met à jour les variables de session
        $newSessionData = array(
                   'rank'  => $rank,
                   'stars' => $stars,
                   'maxStars' => $this->getMaxStars($rank));
        $this->session->set_userdata($newSessionData);
        //On met à jour la BDD
        return $this->db->update('user', $edit_this_user);
    }
    
    public function countAllUsers(){
        return $this->db->where('user_deleted', 0)->from('user')->count_all_results();
    }
    
     public function getAllUsers($limit,$offset){
        //return $this->db->order_by('user_lastconnect', 'desc')->get_where('user', array('user_deleted' => 0),$limit,$offset)->result();
         return $this->db->query('
            SELECT user_id, user_rank, user_pseudo, user_battletag, user_clan, DATE_FORMAT(user_lastconnect,"%d %b %Y") as lastconnect
            FROM user
            WHERE user_deleted = 0
            ORDER BY user_lastconnect DESC
            LIMIT '.$limit.'
            OFFSET '.$offset)->result();
    }
    
 }
       
?>