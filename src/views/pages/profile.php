<!--<?php echo "<pre>"; print_r($user);echo "<pre>"; print_r($feed); ?>-->

<?php $render('header', ['loggedUser' => $loggedUser]) ?>
    <section class="container main">
        <?php $render('sidebar',['activeMenu' =>'profile']) ?>
        <section class="feed">
        <?php $render('perfil-header',['user' => $user, 'loggedUser' => $loggedUser, 'isFollowing' => $isFollowing]); ?>
            <div class="row">
                <div class="column side pr-5">
                    <div class="box">
                        <div class="box-body">
                            <div class="user-info-mini">
                                <img src="<?=$base;?>/assets/images/calendar.png" />
                                <?=date('d/m/Y', strtotime($user->birthdate)); ?> (<?=$user->ageYears;?> anos)
                            </div>
                            <?php if(!empty($user->city)): ?>
                                <div class="user-info-mini">
                                    <img src="<?=$base;?>/assets/images/pin.png" />
                                    <?=$user->city;?>, Brasil
                                </div>
                            <?php endif; ?>    
                            <?php if(!empty($user->work)): ?>
                                <div class="user-info-mini">
                                    <img src="<?=$base;?>/assets/images/work.png" />
                                    <?=$user->work;?>
                                </div>
                            <?php endif; ?>    
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-header m-10">
                            <div class="box-header-text">
                                Seguindo
                                <span>(<?=count($user->following); ?>)</span>
                            </div>
                            <div class="box-header-buttons">
                                <a href="<?=$base;?>/perfil/<?=$user->id;?>/amigos">ver todos</a>
                            </div>
                        </div>
                        <div class="box-body friend-list">
                            <?php foreach($user->following as $follower): ?>
                                <div class="friend-icon">
                                    <a href="<?=$base;?>/perfil/<?=$follower->id;?>">
                                        <div class="friend-icon-avatar">
                                            <img src="<?=$base;?>/media/avatars/<?=$follower->avatar; ?>" />
                                        </div>
                                        <div class="friend-icon-name">
                                            <?=$follower->name;?>
                                        </div>
                                    </a>
                                </div>                           
                            <?php endforeach; ?>   
                        </div>
                    </div>
                </div>
                <div class="column pl-5">
                    <div class="box">
                        <div class="box-header m-10">
                            <div class="box-header-text">
                                Fotos
                                <span>(<?=count($user->photos); ?>)</span>
                            </div>
                            <div class="box-header-buttons">
                                <a href="<?=$base; ?>/perfil/<?=$user->id; ?>/fotos">ver todos</a>
                            </div>
                        </div>
                        <div class="box-body row m-20">
                            <?php for($q=0; $q<4; $q++): ?>
                                <?php if(isset($user->photos[$q])): ?>
                                    <div class="user-photo-item">
                                        <a href="#modal-<?=$user->photos[$q]->id;?>" rel="modal:open">
                                            <img src="<?=$base;?>/media/uploads/<?=$user->photos[$q]->body;?>" />
                                        </a>
                                        <div id="modal-<?=$user->photos[$q]->id;?>" style="display:none">
                                        <img src="<?=$base;?>/media/uploads/<?=$user->photos[$q]->body;?>" />
                                        </div>
                                    </div>
                                <?php endif; ?> 
                            <?php endfor; ?>
                        </div>
                    </div>
                    <?php if($user->id == $loggedUser->id): ?>
                        <?=$render('feed-editor', ['user'=>$loggedUser]);?>
                    <?php endif; ?>
                    <?php foreach($feed['posts'] as $feedItem):?>
                        <?=$render('feed-item',['data' => $feedItem]);?>
                    <?php endforeach;?>
                    <div class="feed-pagination">
                        <?php for($q=0; $q < $feed['pageCount']; $q++):?>
                            <a class="<?=($q == $feed['currentPage']) ? 'active':'';?>" 
                            href="<?=$base;?>/perfil/<?=$user->id;?>?page=<?=$q;?>"><?=$q+1;?></a>
                        <?php endfor;?>
                    </div> 
                </div>
            </div>
        </section>
    </section>
 <?php $render('footer')?>; 
</body>
</html>