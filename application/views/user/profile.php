<section class="body">
    <?if($logged_in){
        if($profile[0]->user_id==$session['uid']){?>
    <div class="row">
        <div class="medium-10 medium-offset-1 columns">
            <h3><?=lang('edit_profile')?></h3>
            <br/>
            <div class="medium-6 columns">
            <form method="POST" action="<?=site_url('user/editprofile_submit')?>">                
                  <div class="row">
                     
                    <div class="medium-3 columns">
                        <label><?=lang('rank')?>
                            <select name="user_rank_select" id="user_rank_input">
                                <?for($i=25;$i>=1;$i--){
                                   echo '<option value="'.$i.'" '.set_select('user_rank_select', $i).' '.(($i==$session['rank']) ? 'selected=""' : '').'>'.$i.'</option>
                                       ';
                                }?>  
                            </select>
                            <?=form_error('user_rank_select'); ?>
                        </label>
                    </div>
                    
                    <div class="medium-3 columns">
                        <label><?=lang('stars')?>
                          <select name="user_stars_select" id="user_stars_input">
                                <?for($i=0;$i<=5;$i++){
                                    echo '<option value="'.$i.'" '.set_select('user_stars_select', $i).' '.(($i==$session['stars']) ? 'selected=""' : '').'>'.$i.'</option>
                                        ';
                                }?>  
                            </select>
                            <?=form_error('user_stars_select'); ?>
                        </label>
                    </div>
                      
                  <div class="medium-6 columns">
                    <label><?=lang('battletag')?>
                      <input type="text" name="user_battletag_input" id="user_battletag_input" placeholder="Pseudo#1234" value="<?=$profile[0]->user_battletag?>"/>
                      <?=form_error('user_battletag_input'); ?>
                    </label>
                  </div>
                  
                  </div>
                 <div class="row">
                  <div class="medium-12 columns">                      
                    <button type="submit" name="user_editprofile_submit" class="button small right"><?=lang('submit')?></button>
                  </div>
                </div>
            </form>
                </div>
        </div>
    </div>
    <?}}?>
    <div class="row">
        <div class="medium-10 medium-offset-1 columns">
            <h3><?=$profile[0]->user_pseudo?></h3>
            <br/>
            <div class="row">
                <div class="medium-6 columns">
                    <table>
                        <tr><td><?=lang('rank')?></td><td><div class="rank rank<?=$profile[0]->user_rank?>" title="<?=lang('rank')?> <?=$profile[0]->user_rank?>"></div></td></tr>
                        <tr><td><?=lang('stars')?></td><td><?for($i=0;$i<$profile[0]->user_stars;$i++){
                                            echo ' &#9733;';}
                                        for($i=$profile[0]->user_stars;$i<$userMaxStars;$i++){
                                            echo ' &#9734;';}?></td></tr>
                        <tr><td><?=lang('battletag')?></td><td class="user-all-battletag" title="<?=lang('add_me_battlenet')?>"><?=$profile[0]->user_battletag?></td></tr>
                        <tr><td><?=lang('clan')?></td><td><?=$profile[0]->user_clan?></td></tr>
                        <tr><td><?=lang('register_date')?></td><td><?=$profile[0]->user_registerdate?></td></tr>
                        <tr><td><?=lang('last_connect_date')?></td><td><?=$profile[0]->user_lastconnect?></td></tr>
                        <tr><td colspan="2"><a href="<?=site_url('history/view/'.$profile[0]->user_id)?>"><?=lang('see_player_history')?></a></td></tr>
                    </table>
                </div>
                <div class="medium-6 columns">
                    <h4><?=lang('stats')?></h4>
                    <table>
                        <tr><td class="stat-label"><?=lang('stat_totalGames')?></td><td class="stat-value"><?=$totalGames?></td></tr>
                        <tr><td class="stat-label"><?=lang('stat_winRatio')?></td><td class="stat-value"><?=$stats['winRatio']?>%</td></tr>
                        <tr><td class="stat-label"><?=lang('stat_winRatioRanked')?></td><td class="stat-value"><?=$stats['winRankedRatio']?>%</td></tr>
                        <tr><td class="stat-label"><?=lang('stat_nbMonthGames')?></td><td class="stat-value"><?=$nbMonthGames?></td></tr>
                        <tr><td class="stat-label"><?=lang('stat_avgDayGames')?></td><td class="stat-value"><?=$stats['avgDayGames']?></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</section>