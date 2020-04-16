<!--<?php echo "<pre>"; print_r($loggedUser);echo "<pre>"; print_r($user); echo "isFollowing";print_r($isFollowing)?>-->

<?php $render('header', ['loggedUser' => $loggedUser]); ?>
    <section class="container main">
        <?php $render('sidebar',['activeMenu' =>'photos']); ?>
        <section class="feed">
        <?php $render('perfil-header',['user' => $user, 'loggedUser' => $loggedUser, 'isFollowing' => $isFollowing]); ?>
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