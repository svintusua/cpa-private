<script>
    $('#menu ul li').css('border-top','4px solid rgba(0,0,0,0)');
    setTimeout(news(), 1000);    
</script>
    <div id="info_block_1">
        <div id="block_1">
            <div class="div_inp">
                <div id="info"> 
                    <span style="color:#898989;"><?=$name[0]?></span>
                    <span onclick="logout();" class="exit">Выход</span>
                </div>
                <?=$this->vars['info']?>
            </div>
        </div>
        <div id="block_2">
            <div class="div_inp"><p>Нашли баг, есть предложение по улучшению проекта? Напишите нам!</p><span onclick="login();" class="button">написать</span></div>                
        </div>
        <div id="block_3">
            <div class="div_inp">
                <p>Запущена BETA-версия!</p>
            </div>                
        </div>
        <div id="block_4">
            <div class="div_inp"><a href="/cabinet/gallery">Моя галерея</a></div>                
        </div>
        <div id="block_5">
            <div class="div_inp"><p>Мгновенное получение открыток</p></div>                
        </div>
    </div>
    <div id="info_block_2">
        <div id="block_6">
            <div class="div_inp"></div>                
        </div>
        <div id="block_7">
            <div class="div_inp"></div>                
        </div>
    </div>