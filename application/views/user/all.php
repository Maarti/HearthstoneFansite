<section class="body">
    <div class="row">
        <div class="medium-10 medium-offset-1 columns">
            <h3><?=lang('members_list')?></h3>
            <br/>
            <div class="row"><div class="medium-8 medium-offset-4 columns"><?=$pagination?></div></div>
            <div class="row">
                <div class="medium-10 medium-offset-2 columns">
                    <table class="users-table">
                        <thead>
                            <tr><th></th><th><?=lang('rank')?></th><th><?=lang('pseudo')?></th><th><?=lang('battletag')?></th><th><?=lang('clan')?></th><th><?=lang('last_connect_date')?></th></tr>
                        </thead>
                        <tbody>
                            <? $i = $offset;
                            foreach($users as $user){
                            $i++;?>
                             <tr onclick="document.location = '<?=site_url('user/profile/'.$user->user_id)?>';" style="cursor:pointer;">
                                <td class="user-all-number">#<?=$i?></i></td>
                                <td class="user-all-rank text-center"><?=$user->user_rank?></td>
                                <td class="user-all-pseudo"><?=$user->user_pseudo?></td>
                                <td class="user-all-battletag"><?=$user->user_battletag?></td>
                                <td><?=$user->user_clan?></td>
                                <td class="user-all-date text-right"><?=$user->lastconnect?></td>
                            </tr>
                            <?}?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</section>