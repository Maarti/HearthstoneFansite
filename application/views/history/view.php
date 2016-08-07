<section class="body">
    <div class="row">
        <div class="medium-8 columns">
            <?if($logged_in){
            if($current_history==$session['uid']){?>
            <div class="row">
                <h3><?=lang('new_game')?></h3>
            </div>
            <div class="row">
                <?=validation_errors()?>
                <form method="POST" action="<?=site_url('history/submit')?>">
                <table >
                    <thead><tr><th colspan="2" class="text-center"><?=lang('me')?></th> <th></th> <th colspan="2" class="text-center"><?=lang('my_oponent')?></th></tr></thead> 
                    <tbody> 
                        <tr> 
                            <td>
                                <select name="history_my_class_select" id="history_my_class_select">
                                    <?foreach($classes as $key => $class){
                                        echo '<option value="'.$key.'" '.set_select('history_my_class_select', $key).'>'.lang($class['long']).'</option>
                                            ';
                                    }?>
                                </select>
                            </td> 
                            <td><input type="text" name="history_my_deck_input" id="history_my_deck_input" placeholder="<?=lang('my_deck')?>" value="<?=set_value('history_my_deck_input')?>" maxlength="20"></td> 
                            <td>Vs.</td>
                            <td><input type="text" name="history_oponent_deck_input" id="history_oponent_deck_input" placeholder="<?=lang('oponent_deck')?>" value="<?=set_value('history_oponent_deck_input')?>" maxlength="20"></td> 
                            <td>
                                <select name="history_oponent_class_select" id="history_oponent_class_select">
                                    <?foreach($classes as $key => $class){
                                        echo '<option value="'.$key.'" '.set_select('history_oponent_class_select', $key).'>'.lang($class['long']).'</option>
                                            ';
                                    }?>
                                </select>
                            </td> 
                        </tr>
                        <tr>
                            <td>
                                <input type="radio" name="history_result" value="win" id="win" <?=set_radio('history_result', 'win', TRUE)?>><label for="win"><?=lang('win')?></label><br/>
                                <input type="radio" name="history_result" value="loss" id="loss" <?=set_radio('history_result', 'loss')?>><label for="loss"><?=lang('loss')?></label>
                            </td>
                            <td>
                                <input type="radio" name="history_gametype" value="ranked" id="ranked" <?=set_radio('history_gametype', 'ranked', TRUE)?>><label for="ranked"><?=lang('ranked')?></label>
                                <input type="radio" name="history_gametype" value="arena" id="arena" <?=set_radio('history_gametype', 'arena')?>><label for="arena"><?=lang('arena')?></label><br/>
                                <input type="radio" name="history_gametype" value="casual" id="casual" <?=set_radio('history_gametype', 'casual')?>><label for="casual"><?=lang('casual')?></label>
                            </td>
                            <td colspan="2"><input name="history_comment_input" id="history_comment_input" type="text"  placeholder="<?=lang('comment')?>" value="<?=set_value('history_comment_input')?>" maxlength="40"></td> 
                            <td><button type="submit" name="history_submit" class="button small right"><?=lang('submit')?></button></td>
                        </tr>
                    </tbody> 
                </table>
                </form>
            </div>
            <?}}?>
            <?if($histories){?>
            <div class="row">
                <h3><?=lang('history')?></h3>
            </div>
            <div class="row">                
                <div class="row">
                    <div class="medium-9 medium-offset-3 columns">
                        <br/>
                        <?=$pagination?>
                    </div>
                </div>
                <div class="row">
                    <div class="medium-11 medium-offset-1 columns">
                        <table class="table-history">
                            <thead><tr><th></th><th class="text-center"><?=lang('me')?></th><th></th><th class="text-center"><?=lang('my_oponent')?></th><th></th></tr></thead>
                            <tbody>
                                <?foreach ($histories as $h){?>
                                <?
                                if($h->history_gametype=="ranked"){
                                    $type='<div class="rank rank'.$h->history_rank.'" title="'.lang('rank').' '.$h->history_rank.'"><div class="history-rank-date">'.$h->date.'</div></div>';
                                }elseif($h->history_gametype=="arena"){
                                    $type=lang('arena_game').'<br/><br/><span class="history-date">'.$h->date.'</span>';
                                }else{
                                    $type=lang('casual_game').'<br/><br/><span class="history-date">'.$h->date.'</span>';
                                }
                                $hero='<div class="portraits"><div class="hero '.$h->history_user_class.' '.(($h->history_result == 'win') ? 'is-active' : 'defeated').'" data-control="ordinal" data-slide-index="8"><div class="portrait"></div><p class="deck">'.$h->history_user_deck.'</p><div class="frame"></div></div></div>';
                                $oponent='<div class="portraits"><div class="hero '.$h->history_oponent_class.' '.(($h->history_result == 'win') ? 'defeated' : 'is-active').'" data-control="ordinal" data-slide-index="8"><div class="portrait"></div><p class="deck">'.$h->history_oponent_deck.'</p><div class="frame"></div></div></div>';
                                ?>
                                <tr>
                                    <td><div class="history-gametype"><?=$type?></div></td>
                                    <td title="<?=lang($h->history_user_class.'_long').' '.$h->history_user_deck?>"><?=$hero?>
                                    <td>Vs.</td>
                                    <td title="<?=lang($h->history_oponent_class.'_long').' '.$h->history_oponent_deck?>"><?=$oponent?></td>
                                    <td width="100%" class="clearfix"><?=(($h->history_comment == '') ? '' : '<div class="panel right"><p>&#8220; '.$h->history_comment.' &#8221;</p></div>')?></td>
                                </tr>  
                                <?}?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="medium-9 medium-offset-3 columns">
                        <?=$pagination?>
                    </div>
                </div>
            </div>
            <?}?>
        </div>
        <div class="medium-4 columns">
            <h3><?=lang('tips')?></h3>
                <ul class="tips">
                <?for($i=1;$i<=4;$i++){
                    echo '<li>'.lang('history-tip'.$i).'</li>';
                }?>
                </ul>
            <br/>
            <h3><?=lang('stats')?></h3>
            <table>
                <tr><td class="stat-label"><?=lang('stat_totalGames')?></td><td class="stat-value"><?=$totalGames?></td></tr>
                <tr><td class="stat-label"><?=lang('stat_winRatio')?></td><td class="stat-value"><?=$stats['winRatio']?>%</td></tr>
                <tr><td class="stat-label"><?=lang('stat_winRatioRanked')?></td><td class="stat-value"><?=$stats['winRankedRatio']?>%</td></tr>
                <tr><td class="stat-label"><?=lang('stat_nbMonthGames')?></td><td class="stat-value"><?=$nbMonthGames?></td></tr>
                <tr><td class="stat-label"><?=lang('stat_avgDayGames')?></td><td class="stat-value"><?=$stats['avgDayGames']?></td></tr>
            </table>
        </div>
    </div>  
</section>