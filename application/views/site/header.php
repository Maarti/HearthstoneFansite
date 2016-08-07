<header>
    
    <div class="fixed">
        <nav class="top-bar" data-topbar>
            <ul class="title-area">
                <li class="name">
                    <h1><a>Beta Version</a></h1>
                </li>
                <li class="toggle-topbar menu-icon"><a href="#"><span><?=lang('error_compatible')?></span></a></li>
            </ul> 
            <section class="top-bar-section"> 
                <!-- Right Nav Section --> 
                <ul class="right"> 
                    <?if($logged_in){ //Si l'utilisateur est connecté
                    $displayStars = '';
                    for($i=0;$i<$session['stars'];$i++){
                        $displayStars = $displayStars.' &#9733;';}
                    for($i=$session['stars'];$i<$session['maxStars'];$i++){
                        $displayStars = $displayStars.' &#9734;';}?>
                    
                    <li><a class="rank-and-stars"><span class="rank-and-stars"><?=lang('rank')?> <?=$session['rank']?> - <span class="user-stars"><?=$displayStars?></span></span></a></li>
                        <li><a href="<?=site_url('user/profile/'.$session['uid'])?>"><span class="user-pseudo"><?=$session['pseudo']?></span></a></li>  
                        <li><a href="<?=site_url('user/signout')?>"><?=lang('signout')?></a></li> 
                    <?}else{ //Si l'utilisateur n'est pas connecté'?>
                        <li><a href="<?=site_url('user/signup')?>"><?=lang('signup')?></a></li> 
                        <li><a href="<?=site_url('user/signin')?>"><?=lang('signin')?></a></li> 
                    <?}?>
                    <li class="has-dropdown">
                        <a href="#">Language</a>
                        <ul class="dropdown">
                            <?foreach ($langMenu as $id => $menu){
                                echo '<li><a href="'.site_url($menu['href']).'"><img src="'.base_url('assets/img/flag/'.$menu['flag'].'.png').'" alt="'.$menu['label'].' flag" height="11" width="16"> - '.$menu['label'].'</a></li>';
                            }?>
                        </ul>
                    </li>
                </ul> <!-- Left Nav Section --> 
<!--                <ul class="left"> 
                    <li><a href="#">Left Nav Button</a></li> 
                </ul>-->
            </section> 
        </nav> 
    </div>
    

    <h2>Maarti Fansite</h2>
    <br/><br/><br/><br/><br/>
    <div class="row">
  <div class="large-12 columns">
    <div xmlns="http://www.w3.org/1999/xhtml" class="navigation">
        <ul class="menu" id="menu">
            <?foreach ($mainMenu as $id => $menu){
                echo '<li class="menu-'.$id.'" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
                        <a itemprop="url" href="'.site_url($menu['href']).'" '.((strpos($url, $menu['href']) == true) ? ' class="menu-active"' : '').'>
                        <span itemprop="name">'.lang($menu['label']).'</span></a></li>';
            }
            ?>
        </ul>
    </div>
      </div>
</div>
</header>