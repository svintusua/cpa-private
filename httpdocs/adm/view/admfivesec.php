<span style="font-size: 30px;font-weight: bold;">Отсвет за 5 секунд</span><br><br><span id="error"></span><br><br>

<? 
 if ($question= Games::getInfoGames("answerfivesec")) {
     $a = '<table id="allweblart">
    <tr><th colspan="4" style="text-align: center; background:none;">Список вопросов</th></tr>    
    <tr>
        <th>ID</th>
        <th>Вопрос</th>
        <th></th>

    </tr>';
        for ($i = 0; $i <= count($question); $i++) {
            if (!$question[$i]['id']) break;
            $b.='<tr><td style="text-align: center; color:red;">' . $question[$i]['id'].'</td>
         <td><input type='."'text'".' value="' . $question[$i]['question'] . '" onclick="inpval=this.value" onChange="action(0,'."'edit',this.value".')"></td>
         <td><span onclick="action(' . $question[$i]['id'].",'del'" . ')" style="cursor: pointer;">удалить</span></td></tr>';
//            if (!$question[$i+1]['id']){
//                break;
//            }else{
//            $b.'<td style="text-align: center; color:red;">' . $question[$i+1]['id'].'</td>
//         <td><input type='."'text'".' value="' . $question[$i+1]['question'] . '" onclick="inpval=this.value" onChange="action(0,'."'edit',this.value".')"></td>
//         <td><span onclick="action(' . $question[$i+1]['id'].",'del'" . ')" style="cursor: pointer;">удалить</span></td></tr>';
//            }
        }
    $c='</table>';
    echo "<div id='border'>".$a.$b.$c."</div>";
            
   
}

 ?> 
<div class="blockred">
   
    Добавить вопрос:<br>
    <script>
        var inpval="";
    function action(id,act,val){
        switch(act){
            case 'edit':
                path="admfivesec/editquestion";
                data=({is_ajax:1,question:val,old_question:inpval});
                break;
            case 'del':
                path="admfivesec/delquestion";
                data=({is_ajax:1,qid:id});
                break;
            case 'add':
                path="admfivesec/addquestion";
                var data=$(form).serialize();
                data += '&is_ajax=1';
                break;
        }
        $.ajax({
                url:path,
                type:"POST",
                data: data,
                dataType:"json",
                async:true}).done(function(r){
                if(r.response.error){
                    alert(r.response.error);
                }
                 if(r.response.mes){    
                     alert(r.response.mes);
                     window.location.reload();
                    //$('#prod_in_cart').html(r.response.table);
//                    $('#sum').html(r.response.total_sum);
                    
                }
                //onsubmit="ns(this); return false;"
            }); 
    }    
        function setquestion(form){
            var data=$(form).serialize();
            data += '&is_ajax=1';
            $.ajax({url:"admfivesec/addquestion",type:"POST",data:data,dataType:"json", async:true}).done(function(data){
                if(data.response.error){
                    alert(data.response.error);
                }
                else{
                    if (data.response.mes){
                         alert(data.response.mes);
                        window.location.reload();
                    }
                }
            });

        }
        
        </script>
<form onSubmit="setquestion(this); return false;">
            
     <label>Вопрос:<br><input name="question" size="30" class="input" type="text" ></label><br>
     <input type="submit" value="Добавить"> 
        </form>
</div>
