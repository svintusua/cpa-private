<span style="font-size: 30px;font-weight: bold;">Администраторы</span><br><br><span id="error"></span><br><br>

<? 
 if ($admins=  Admins::allAdmins()) {        
     $a = '<table id="allweblart">
    <tr><th colspan="4" style="text-align: center; background:none;">Список администраторов</th></tr>    
    <tr>
        <th>ID</th>
        <th>Логин</th>
        <th>Дата регистрации</th>
        <th></th>
    </tr>';
        for ($i = 0; $i <= count($admins); $i++) {
            if (!$admins[$i]['id'])
                break;
            $b.='<tr><td style="text-align: center;">' . $admins[$i]['id'].'</td>
         <td>' . $admins[$i]['login'] . '</td>
         <td>' . $admins[$i]['dt'] . '</td>
         <td><span onclick="deladmin(' . $admins[$i]['id'] . ')" style="cursor: pointer;">удалить</span></td></tr>';
        }
    $c='</table>';
    echo $a.$b.$c;
            

   
}

 ?> 
<div class="blockred">
   
    Добавить администратора:<br>
    <script>
    function deladmin(a){
        $.ajax({
                url:"/adm/admins/deladministrator",
                type:"POST",
                data:({is_ajax:1,id:a}),
                dataType:"json",
                async:true}).done(function(r){
                if(r.response.error){
                    alert(r.response.error);
                }
                 if(r.response.ok){    
                     alert(r.response.ok);
                     window.location.reload();
                    //$('#prod_in_cart').html(r.response.table);
//                    $('#sum').html(r.response.total_sum);
                    
                }
                //onsubmit="ns(this); return false;"
            }); 
           
    }    

        
        function setadmin(form){
            var data=$(form).serialize();
            data += '&is_ajax=1';
            $.ajax({url:"admins/addadmin",type:"POST",data:data,dataType:"json", async:true}).done(function(data){
                if(data.response.error){
                    alert(data.response.error);
                }
                else{
                    if (data.response.mesreg){
                         alert(data.response.mesreg);
                        window.location.reload();
                    }
                }
            });

        }
        
        </script>
<form onSubmit="setadmin(this); return false;">
            
     <label>Login:<br><input name="login" size="30" maxlength="40" class="input" type="text" ></label><br>	
     <label>Password:<br><input name="password" size="30" maxlength="40" class="input" type="password"><br> </label><br>
     <input name="add" type="submit" value="Добавить"> 
        </form>
</div>
