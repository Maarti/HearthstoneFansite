<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class History_model extends CI_Model
{
    public function addHistory($uid,$user_class,$user_deck,$oponent_class,$oponent_deck,$result,$gametype,$comment,$rank){
       $history = array(
            'history_user' => $uid ,
            'history_result' => $result,
            'history_user_class' => $user_class,
            'history_user_deck' => $user_deck,
            'history_oponent_class' => $oponent_class,
            'history_oponent_deck' => $oponent_deck,
            'history_gametype' => $gametype,
            'history_comment' => $comment,
            'history_rank' => $rank);
       if($gametype=='ranked'){
            $CI =& get_instance();
            $CI->load->model('user_model');
            $CI->user_model->updateStars($uid,$result);
       }
       return $this->db->insert('history', $history);
    }
    
    //Compte le nombre total de d'history pour un user (pour la pagination)
    public function countUserHistory($uid){
        return $this->db->where('history_user', $uid)->from('history')->count_all_results();
    }
    
     public function getUserHistory($uid,$limit,$offset){
        return $this->db->query('
            SELECT history_date, DATE_FORMAT(history_date,"%d %b") as date, history_result, history_user_class, history_user_deck, history_oponent_class, history_oponent_deck, history_gametype, history_comment, history_rank
            FROM history
            WHERE history_user = '.$uid.'
            ORDER BY history_date DESC
            LIMIT '.$limit.'
            OFFSET '.$offset)->result();
    }
    
    public function getCurrentMonthGames($uid){
        $where = "MONTH(history_date) = MONTH(CURDATE())";
        return $this->db->where('history_user', $uid)->where($where)->from('history')->count_all_results();
    }
    
    //Compte le nombre total de victoires en ranked pour un user
    public function countUserWin($uid){
        return $this->db->where('history_user', $uid)->where('history_result', 'win')->from('history')->count_all_results();
    }
    
    //Compte le nombre total de games en ranked pour un user
    public function countUserRankedWin($uid){
        return $this->db->where('history_user', $uid)->where('history_result', 'win')->where('history_gametype', 'ranked')->from('history')->count_all_results();
    }
    
    //Compte le nombre total de ranked pour un user
    public function countUserRanked($uid){
        return $this->db->where('history_user', $uid)->where('history_gametype', 'ranked')->from('history')->count_all_results();
    }
    
    public function getUserStats($uid){
        $query = $this->db->order_by('history_date', 'asc')
                        ->get_where('history', array('history_user' => $uid), 1)
                        ->result();
        if($query){
            $firstdate = $query[0]->history_date;
            $query2 = $this->db->query("SELECT DATEDIFF(CURDATE(),'".$firstdate."') as nbDays")->result();
            $nbJoursTotal = $query2[0]->nbDays;
            $nbJoursTotal++;
            $nbGamesTotal = $this->countUserHistory($uid);
            $nbRankedGamesTotal = $this->countUserRanked($uid);
            $nbRankedWinTotal = $this->countUserRankedWin($uid);
            $nbWinTotal = $this->countUserWin($uid);
            $stats = array( 'avgDayGames' => number_format($nbGamesTotal/$nbJoursTotal, 2, ',', ' '),
                            'winRatio' => number_format(($nbWinTotal/$nbGamesTotal)*100, 2, ',', ' '),
                            'winRankedRatio' => number_format(($nbRankedWinTotal/$nbRankedGamesTotal)*100, 2, ',', ' '));
        }else{
            $stats = array( 'avgDayGames' => '0,00',
                            'winRatio' => '0,00',
                            'winRankedRatio' => '0,00');
        }
        return $stats;
        
    }
 }
       
?>