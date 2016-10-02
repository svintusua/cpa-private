<span style="font-size: 30px;font-weight: bold;">Статьи</span><br><br><br><br>
<? 
 if ($article=Article::getAll()) {
     
    echo "Список меню: <br>";

    foreach ($articles as $id => $item) {
        echo '<a href="/adm/menu?articles_id=' . $id . '">' . $articles['title'] . '</a><br>';
    }
}

 ?> 
<div class="blockred">
    <?php If ($_GET['article_id']){
        $info=$tree_menu[$_GET['article_id']];
        echo '
            Изменить меню:<br>
            <form name="update" action="/adm/article/updatemenu" method="POST">
            
     <label>Короткое название:<input name="short_name" size="30" maxlength="40" class="input" type="text" value="'.$info['short_name'].'"></label><br>	
     <label>Длинное название:<input name="full_name" size="30" maxlength="40" class="input" type="text" value="'.$info['full_name'].'"></label><br>
     <label>Родительское меню:<input name="parent_id" size="30" maxlength="40" class="input" type="text" value="'.$info['parent_id'].'"></label><br>
     <label>Позиция меню:<input name="position" size="30" maxlength="40" class="input" type="text" value="'.$info['position'].'"></label><br>
            <input name="update" type="submit" value="Изменить"> 
        </form>
<hr><br>
            ';
    }
    ?>
    
    Добавить меню:<br>
<form name="newarticle" action="/adm/article/addarticle" method="POST">
            
     <label>Загаловок статьи:<br><input name="title" size="30" maxlength="40" class="input" type="text" ></label><br>	
     <label>Текст статьи:<br><textarea name="content" cols="65" rows="10" class="input" ></textarea><br> </label><br>
     <label><input type="radio" name="main" value="1"> Статья на главной странице</label><br>
     <input name="add" type="submit" value="Добавить"> 
        </form>
</div>
