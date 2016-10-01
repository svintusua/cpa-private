<span style="font-size: 30px;font-weight: bold;">Магазин</span><br><br><span id="error"></span><br><br>
<div id="infshop"></div>    
    
<div class="blockred">
    <script>
        categories(1);
       fc();
       fs();
       ft();
       function fc(){
           $.ajax({
                             url:"/adm/shop/filingCategory",
                             type:"POST",
                             data:({is_ajax:1,id:1}),
                             dataType:"json",
                             async:true}).done(function(r){
                              if(r.response.tc){    
                                  $('#selectcategory').html(r.response.tc);                    
                             }
                         }); 
       }
       function fs(){
           $.ajax({
                             url:"/adm/shop/filingSubcategory",
                             type:"POST",
                             data:({is_ajax:1,id:1}),
                             dataType:"json",
                             async:true}).done(function(r){
                              if(r.response.tc){    
                                  $('#selectsubcategory').html(r.response.tc);                    
                             }
                         }); 
       } 
       function ft(){
           $.ajax({
                             url:"/adm/shop/filingTypeProduct",
                             type:"POST",
                             data:({is_ajax:1,id:1}),
                             dataType:"json",
                             async:true}).done(function(r){
                              if(r.response.tc){    
                                  $('#selecttypeproduct').html(r.response.tc);                    
                             }
                         }); 
       } 
       
       function categories(a){
           switch (a){
               case 1:           
                        $.ajax({
                             url:"/adm/shop/getallcategory",
                             type:"POST",
                             data:({is_ajax:1,id:1}),
                             dataType:"json",
                             async:true}).done(function(r){
                              if(r.response.tc){    
                                  $('#infshop').html(r.response.tc);                    
                             }
                         }); 
                    break;
                case 2:
                     $.ajax({
                             url:"/adm/shop/getallsubcategory",
                             type:"POST",
                             data:({is_ajax:1,id:1}),
                             dataType:"json",
                             async:true}).done(function(r){
                              if(r.response.tc){    
                                  $('#infshop').html(r.response.tc);                    
                             }
                         }); 
                    break;
                case 3:
                     $.ajax({
                             url:"/adm/shop/getallproducts",
                             type:"POST",
                             data:({is_ajax:1,id:1}),
                             dataType:"json",
                             async:true}).done(function(r){
                              if(r.response.tc){    
                                  $('#infshop').html(r.response.tc);                    
                             }
                         }); 
                    break;
                    case 4:
                     $.ajax({
                             url:"/adm/shop/gettypeproduct",
                             type:"POST",
                             data:({is_ajax:1,id:1}),
                             dataType:"json",
                             async:true}).done(function(r){
                              if(r.response.tc){    
                                  $('#infshop').html(r.response.tc);                    
                             }
                         }); 
                    break;
            }
       }
       function it(a){
            switch (a){
                case 1:
                    $("#createcat").css("display","block");
                    $(".tpc").attr('id', 'tpselected');
                    $("#createsubcat").css("display","none");
                    $(".tpsc").attr('id', '');
                    $("#createproduct").css("display","none");
                    $(".tpp").attr('id', '');
                    $("#typeproduct").css("display","none");
                    $(".tptp").attr('id', '');
                    categories(1);
                    break;
                case 2:
                    $("#createsubcat").css("display","block");
                    $(".tpsc").attr('id', 'tpselected');
                    $("#createcat").css("display","none");
                    $(".tpc").attr('id', '');
                    $("#createproduct").css("display","none");
                    $(".tpp").attr('id', '');
                    $("#typeproduct").css("display","none");
                    $(".tptp").attr('id', '');
                    categories(2);
                    break;
                case 3:
                    $("#createproduct").css("display","block");
                    $(".tpp").attr('id', 'tpselected');
                    $("#createsubcat").css("display","none");
                    $(".tpsc").attr('id', '');
                    $("#createcat").css("display","none");
                    $(".tpc").attr('id', '');
                    $("#typeproduct").css("display","none");
                    $(".tptp").attr('id', '');
                    categories(3);
                    break;
                case 4:
                    $("#typeproduct").css("display","block");
                    $(".tptp").attr('id', 'tpselected');
                    $("#createsubcat").css("display","none");
                    $(".tpsc").attr('id', '');
                    $("#createcat").css("display","none");
                    $("#createproduct").css("display","none");
                    $(".tpc").attr('id', '');
                    $(".tpp").attr('id', '');
                    categories(4);
                    break;  
            }
        }
        function appenddata(form){
              var data=$(form).serialize();
            
            data += '&is_ajax=1';
             $.ajax({
                             url:"/adm/shop/appenddata",
                             type:"POST",
                             data:data,
                         dataType: "json",
                         async: true}).done(function(r) {
                         if (r.response.error) {
                             alert(data.response.error);
                         }
                         else {
                             if (r.response.mes) {
                                 alert(r.response.mes);
                                 window.location.reload();
                             }
                         }
                     }); 

        }
         function setsubcategory(form){
              var data=$(form).serialize();
            
            data += '&is_ajax=1';
            $.ajax({url:"/cart/updateinfouser",type:"POST",data:data,dataType:"json", async:true}).done(function(data){
                if(data.response.error){
                    $('#zaglushka').css('display','block');
                    $('#err').append(data.response.error);
                    $('#err').css('display','block');
                }
                else{
                    if (data.response.t){
                         $('#yyy').html(data.response.t);
                    }
                }
            });
        }
        function setproduct(form){
              var data=$(form).serialize();
            
            data += '&is_ajax=1';
            $.ajax({url:"/cart/updateinfouser",type:"POST",data:data,dataType:"json", async:true}).done(function(data){
                if(data.response.error){
                    $('#zaglushka').css('display','block');
                    $('#err').append(data.response.error);
                    $('#err').css('display','block');
                }
                else{
                    if (data.response.t){
                         $('#yyy').html(data.response.t);
                    }
                }
            });
        }
        function del(id,table){
            $.ajax({
                             url:"/adm/shop/del",
                             type:"POST",
                             data:({id:id,table:table}),
                         dataType: "json",
                         async: true}).done(function(r) {
                         if (r.response.error) {
                             alert(r.response.error);
                         }
                         if (r.response.ok) {
                                 alert(r.response.ok);
                                 window.location.reload();
                         }
                         
                     }); 
        }
    </script>    
    <table id="itemshop">
        <tr>
            <td style="width: 70%;"></td>
            <td id="tpselected" class="tpc" onclick="it(1)"><span class="ntc">Категории</span></td>
            <td class="tpsc" onclick="it(2)"><span class="ntc">Подкатегории</span></td>
            <td class="tpp" onclick="it(3)"><span class="ntc">Товары</span></td>
            <td class="tptp" onclick="it(4)"><span class="ntc">Типы продукции</span></td>
        </tr>
        <tr>
            <td colspan="4" id="tablecreate">
                <div id="createcat">
                    <form method="POST" onSubmit="appenddata(this); return false;" >
                        <table>
                        <tr><td><span>Название категории:</span></td><td><input name="name" size="15" maxlength="40" class="input" type="text" ></td></tr>                        
                        </table>
                        <input name="tablename" size="15" maxlength="40" class="input" type="text" value="category" hidden>
                        <input name="set" type="submit" value="Создать"> 
                    </form>
                </div>
                <div id="createsubcat">
                     <form method="POST" onSubmit="appenddata(this); return false;" >
                        <table>
                        <tr><td><span>Название подкатегории:</span></td><td><input name="name" size="15" maxlength="40" class="input" type="text" ></td></tr>
                        <tr><td><span>Родительская категория:</span></td><td id="selectcategory"></td></tr>                        
                        </table>
                        <input name="tablename" size="15" maxlength="40" class="input" type="text" value="subcategories" hidden>
                        <input name="add" type="submit" value="Создать"> 
                    </form>
                </div>
                <div id="createproduct">
                    <form method="POST" enctype="multipart/form-data" action="shop/appenddata">
                        <table>
                            <tr><td><span>Название:</span></td><td><input name="name" size="15" maxlength="40" class="input" type="text" ></td></tr>
                            <tr><td><span>Описание:</span></td><td><textarea rows="3" cols="45" name="description" size="15"></textarea></td></tr>
                            <tr><td><span>Цена:</span></td><td><input name="price" size="15" maxlength="40" class="input" type="text" ></td></tr>
                            <tr><td>Картинка:</span></td><td> <input name="img" type="file"></td></tr>
                            <tr><td><span>Категория:</span></td><td id="selectsubcategory"></td></tr>  
                            <tr><td><span>Тип товара:</span></td><td id="selecttypeproduct"></td></tr>
                        </table>
                        <input name="tablename" size="15" maxlength="40" class="input" type="text" value="product" hidden>
                        <input name="add" type="submit" value="Добавить">
                    </form>
                </div>
                <div id="typeproduct">
                    <form method="POST" onSubmit="appenddata(this); return false;" >
                        <table>
                        <tr><td><span>Название типа продукта:</span></td><td><input name="type" size="15" maxlength="40" class="input" type="text" ></td></tr>                        
                        </table>
                        <input name="tablename" size="15" maxlength="40" class="input" type="text" value="typeproduct" hidden>
                        <input name="set" type="submit" value="Создать"> 
                    </form>
                </div>
                
            </td>    
        </tr>
    </table>
</div>