<!--<?php echo "<pre>"; print_r($loggedUser);echo "<pre>"; print_r($user); echo "isFollowing";print_r($isFollowing)?>-->

<?php $render('header', ['loggedUser' => $loggedUser]) ?>
    <section class="container main">
        <?php $render('sidebar',['activeMenu' =>'photos']) ?>
        <section class="feed">
            <div class="row">
                <div class="box flex-1 border-top-flat">
                    <div class="box-body">
                        <div class="profile-cover" style="background-image: url('<?=$base;?>/media/covers/<?= $user->cover;?>');"></div>
                        <div class="profile-info m-20 row">
                            <div class="profile-info-avatar">
                                <img src="<?=$base; ?>/media/avatars/<?=$user->avatar;?>" />
                            </div>
                            <div class="profile-info-name">
                                <div class="profile-info-name-text"><?=$user->name;?></div>
                                <div class="profile-info-location"><?=$user->city;?></div>
                            </div>
                            <div class="profile-info-data row">
                                <div class="profile-info-item m-width-20">
                                    <?php if($user->id != $loggedUser->id): ?>
                                        <a class="button" href="<?=$base;?>/perfil/<?=$user->id;?>/follow"><?=($isFollowing) ? 'Deixar de Seguir' : 'Seguir';?></a>
                                    <?php endif; ?>
                                </div>
                                <div class="profile-info-item m-width-20">
                                    <div class="profile-info-item-n"><?=count($user->followers); ?></div>
                                    <div class="profile-info-item-s">Seguidores</div>
                                </div>
                                <div class="profile-info-item m-width-20">
                                    <div class="profile-info-item-n"><?=count($user->following); ?></div>
                                    <div class="profile-info-item-s">Seguindo</div>
                                </div>
                                <div class="profile-info-item m-width-20">
                                    <div class="profile-info-item-n"><?=count($user->photos); ?></div>
                                    <div class="profile-info-item-s">Fotos</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="column">
                    <div class="column">
                        <div class="box">
                            <div class="box-body">
                                <div class="full-user-photos">
                                    <?php if(count($user->photos) === 0): ?>
                                        Este usuário não possui fotos.
                                    <?php endif; ?>
                                    <?php foreach($user->photos as $photo): ?>
                                        <div class="user-photo-item">
                                            <a href="#modal-<?=$photo->id; ?>" rel="modal:open">
                                                <img src="<?=$base; ?>/media/uploads/<?=$photo->body; ?>" />
                                            </a>
                                            <div id="modal-<?=$photo->id; ?>" style="display:none">
                                                <img src="<?=$base; ?>/media/uploads/<?=$photo->body; ?>" />
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
<?php $render('footer')?>; 
</body>
</html>