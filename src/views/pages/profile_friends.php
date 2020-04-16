<!--<?php echo "<pre>"; print_r($loggedUser);echo "<pre>"; print_r($user); echo "isFollowing";print_r($isFollowing)?>-->

<?php $render('header', ['loggedUser' => $loggedUser]) ?>

    <section class="container main">
        <?php $render('sidebar',['activeMenu' =>'friends']) ?>
        <section class="feed">
            <?php $render('perfil-header',['user' => $user, 'loggedUser' => $loggedUser, 'isFollowing' => $isFollowing]); ?>
            <div class="row">
                <div class="column">
                    <div class="box">
                        <div class="box-body">
                            <div class="tabs">
                                <?php $activeTab = filter_input(INPUT_GET,'activeTab');
                                    if($activeTab != "seguidores"){
                                        $activeTab = "seguindo";
                                    }
                                ?>
                                <div class="tab-item <?=($activeTab=='seguidores') ? 'active' : '';?>" data-for="followers">
                                    Seguidores
                                </div>
                                <div class="tab-item <?=($activeTab=='seguindo') ? 'active' : '';?>"  data-for="following">
                                    Seguindo
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-body" data-item="followers">
                                    <div class="full-friend-list">
                                        <?php foreach($user->followers as $follower): ?>
                                            <div class="friend-icon">
                                                <a href="<?=$base; ?>/perfil/<?=$follower->id; ?>">
                                                    <div class="friend-icon-avatar">
                                                        <img src="<?=$base; ?>/media/avatars/<?=$follower->avatar; ?>" />
                                                    </div>
                                                    <div class="friend-icon-name">
                                                        <?=$follower->name; ?>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="tab-body" data-item="following">
                                <div class="full-friend-list">
                                        <?php foreach($user->following as $follower): ?>
                                            <div class="friend-icon">
                                                <a href="<?=$base; ?>/perfil/<?=$follower->id; ?>">
                                                    <div class="friend-icon-avatar">
                                                        <img src="<?=$base; ?>/media/avatars/<?=$follower->avatar; ?>" />
                                                    </div>
                                                    <div class="friend-icon-name">
                                                        <?=$follower->name; ?>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
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