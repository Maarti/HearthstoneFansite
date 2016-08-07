<section class="body">
    <? if(isset($msg) && isset($type)){?>
    <div class="row">
        <div class="medium-8 medium-offset-2 columns">
            <div data-alert class="alert-box <?=$type?> round text-center">
                <?=$msg?>
                <a href="#" class="close">&times;</a>
            </div>
        </div>
    </div>
    <?}?>
    <div class="row">
        <div class="large-8 large-offset-2 small-10 small-offset-1 columns">
            <h3><?=lang('signin')?></h3>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="large-6 large-offset-3 small-8 small-offset-2 columns">                
            <form method="POST" action="<?=site_url('user/signin_submit')?>">
                <div class="row">
                  <div class="medium-12 columns">
                    <label><?=lang('pseudo')?>
                      <input type="text" name="user_pseudo_input" id="user_pseudo_input" placeholder="<?=lang('pseudo')?>" required="" value="<?=set_value('user_pseudo_input'); ?>"/>
                      <?=form_error('user_pseudo_input'); ?>
                    </label>
                  </div> 
                </div>
                
                <div class="row">
                  <div class="medium-12 columns">
                    <label><?=lang('password')?>
                      <input type="password" name="user_pass_input" id="user_pass_input" placeholder="<?=lang('password')?>" required="" />
                      <?=form_error('user_pass_input'); ?>
                    </label>
                  </div>
                </div>
                <br/>

                 <div class="row">
                  <div class="medium-12 columns text-right">                      
                    <button type="submit" name="user_signin_submit" class="button small"><?=lang('submit')?></button> -
                    <?=lang('or').' <a href="'.site_url('user/signup').'">'.lang('signup').'</a>'?>
                  </div>
                </div>
              
            </form>
        </div>
    </div>  
</section>