<span style="font-size: 30px;font-weight: bold;">Блог</span><br><br><span id="error"></span><br><br>

<? 
 if ($wa=Weblog::getAllWeblogArticle()) {        
     $a = '<table id="allweblart">
    <tr><th colspan="5" style="text-align: center; background:none;">Список статей</th></tr>    
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Текст</th>
        <th>Дата создания</th>
        <th></th>
    </tr>';
        for ($i = 0; $i < count($wa); $i++) {
            $b.='<tr><td style="text-align: center;">' . $wa[$i]['id'].'</td>
         <td>' . $wa[$i]['name'] . '</td>
         <td>' . $wa[$i]['description'] . '</td>
         <td>' . $wa[$i]['dt'] . '</td>
         <td><span onclick="delweblogart(' . $wa[$i]['id'] . ')" style="cursor: pointer;">удалить</span></td></tr>';
        }
    $c='</table>';
    echo $a.$b.$c;
            

   
}

 ?> 
<div class="blockred">
    <?php If ($_GET['article_id']){
        $info=$tree_menu[$_GET['article_id']];
        echo '
            Изменить меню:<br>
            <form name="update" action="/adm/weblog/updatemenu" method="POST">
            
     <label>Название:<input name="name" size="30" maxlength="40" class="input" type="text" value="'.$info['short_name'].'"></label><br>	
     <label>Длинное название:<input name="full_name" size="30" maxlength="40" class="input" type="text" value="'.$info['full_name'].'"></label><br>
     <label>Родительское меню:<input name="parent_id" size="30" maxlength="40" class="input" type="text" value="'.$info['parent_id'].'"></label><br>
     <label>Позиция меню:<input name="position" size="30" maxlength="40" class="input" type="text" value="'.$info['position'].'"></label><br>
            <input name="update" type="submit" value="Изменить"> 
        </form>
<hr><br>
            ';
    }
    ?>
    
    Добавить статью:<br>
    <script>
    function delweblogart(a){
        $.ajax({
                url:"/adm/weblog/delweblogarticle",
                type:"POST",
                data:({is_ajax:1,id:a}),
                dataType:"json",
                async:true}).done(function(r){
                if(r.response.error){
                    alert(r.response.error);
                }
                 if(r.response.table){                     
                    //$('#prod_in_cart').html(r.response.table);
//                    $('#sum').html(r.response.total_sum);
                    
                }
                //onsubmit="ns(this); return false;"
            }); 
           
    }    
    function addwa(form){
            var data=$(form).serialize();
            data += '&is_ajax=1';
            $.ajax({url:"/adm/weblog/addweblogarticle",type:"POST",data:data,dataType:"json", async:true}).done(function(data){
                if(data.response.error){
                  $('#error').html(data.response.error);
                }
               
            });
            

        }
        
        </script>
<form onSubmit="addwa(this); return false;">
            
     <label>Загаловок статьи:<br><input name="name" size="30" maxlength="40" class="input" type="text" ></label><br>	
     <label>Текст статьи:<br><textarea name="description" cols="65" rows="10" class="input" ></textarea><br> </label><br>
     <input name="add" type="submit" value="Добавить"> 
        </form>
</div>
