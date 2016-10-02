<span style="font-size: 30px;font-weight: bold;">Menu</span><br><br><span id="error"></span><br><br>
<? echo "Список меню: <br>";
 Menu::getTreeMenu($tree_menu);

        foreach ($tree_menu as $id=>$item){
            echo str_repeat('&nbsp;', $item['level']).'<a href="/adm/menu?menu_id=' . $id . '">' . $item['short_name'] . '</a><br>';
            
        }

 ?> 
<div class="blockred">
    <?php If ($_GET['menu_id']){
        $info=$tree_menu[$_GET['menu_id']];
        echo '
            Изменить меню:<br>
            <form name="update" action="/adm/menu/updatemenu" method="POST">
            
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
<form name="newmenu" action="/adm/menu/addmenu" method="POST">
            
     <label>Короткое название:<input name="short_name" size="30" maxlength="40" class="input" type="text" ></label><br>	
     <label>Длинное название:<input name="full_name" size="30" maxlength="40" class="input" type="text" ></label><br>
     <label>Родительское меню:<input name="parent_id" size="30" maxlength="40" class="input" type="text" ></label><br>
     <label>Позиция меню:<input name="position" size="30" maxlength="40" class="input" type="text" ></label><br>
            <input name="add" type="submit" value="Добавить"> 
        </form>
</div>
