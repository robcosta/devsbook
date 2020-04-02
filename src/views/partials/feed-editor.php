<div class="box feed-new">
    <div class="box-body">
        <div class="feed-new-editor m-10 row">
            <div class="feed-new-avatar">
                <img src="<?=$base;?>/media/avatars/<?=$user->avatar;?>" />
            </div>
            <div class="feed-new-input-placeholder">O que você está pensando, <?=$user->name;?>?</div>
            <div class="feed-new-input" contenteditable="true"></div>
            <div class="feed-new-send">
                <img src="<?=$base;?>/assets/images/send.png" />
            </div>
            <form class="feed-new-form" method="POST" action="<?=$base;?>/post/new">
                <input type="hidden" name="body" />
                <input type="hidden" name="date" />
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    let feedInput = document.querySelector('.feed-new-input');
    let feedSubmit = document.querySelector('.feed-new-send');
    let feedForm = document.querySelector('.feed-new-form');
    //Retornando a data do sistema conforme o padrão do banco de dados
    let date = new Date();
    let Y = date.getFullYear();
    let m = 1 + date.getMonth();
    if(m<10){
        m="0"+m;
    }
    let d = date.getDate();
    if(d<10){
        d="0"+d;
    }
    let H = date.getHours();
    let i = date.getMinutes();
    let s = date.getSeconds()
    let localDate = Y + "-" + m + "-" + d + " " + H + ":" + i + ":" + s;
    feedSubmit.addEventListener('click', (obj) => {
        let value = feedInput.innerText;      
        if (value != '') {
            feedForm.querySelector('input[name=body]').value = value;
            //pega a data do computador do usuário
            feedForm.querySelector('input[name=date]').value = localDate;
            feedForm.submit();
        }
    });
    
</script>