<? if(isset($msg))
            echo $msg;?>
<section class="body">
    <div class="row">
        <div class="large-8 large-offset-2 small-10 small-offset-1 columns">
            <h3><?=lang('signup')?></h3>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="large-6 large-offset-3 small-8 small-offset-2 columns">                
            <form method="POST" action="<?=site_url('user/signup_submit')?>">
                <div class="row">
                  <div class="medium-6 columns">
                    <label><?=lang('pseudo')?>
                      <input type="text" name="user_pseudo_input" id="user_pseudo_input" placeholder="Pseudo" required="" value="<?=set_value('user_pseudo_input'); ?>"/>
                      <?=form_error('user_pseudo_input'); ?>
                    </label>
                  </div>
                    
                  <div class="medium-3 columns">
                    <label><?=lang('rank')?>
                        <select name="user_rank_select" id="user_rank_input">
                            <?for($i=25;$i>=1;$i--){
                               echo '<option value="'.$i.'" '.set_select('user_rank_select', $i).'>'.$i.'</option>
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
                                echo '<option value="'.$i.'" '.set_select('user_stars_select', $i).'>'.$i.'</option>
                                    ';
                            }?>  
                        </select>
                        <?=form_error('user_stars_select'); ?>
                    </label>
                  </div>
                  
                </div>
                
                <div class="row">
                  <div class="medium-6 columns">
                    <label><?=lang('password')?>
                      <input type="password" name="user_pass_input" id="user_pass_input" placeholder="<?=lang('password')?>" required="" />
                      <?=form_error('user_pass_input'); ?>
                    </label>
                  </div>
                    <div class="medium-6 columns">
                    <label><?=lang('confirm')?>
                      <input type="password" name="user_confirm_input" id="user_confirm_input" placeholder="<?=lang('confirm')?> <?=lang('password')?>" required="" />
                      <?=form_error('user_confirm_input'); ?>
                    </label>
                  </div>
                </div>
                <br/>

                 <div class="row">
                  <div class="medium-12 columns text-right">                      
                    <button type="submit" name="user_signup_submit" class="button small"><?=lang('submit')?></button> -
                    <?=lang('or').' <a href="'.site_url('user/signin').'">'.lang('signin').'</a>'?>
                  </div>
                </div>
            </form>
        </div>
    </div>  
</section>