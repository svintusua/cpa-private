<span style="font-size: 30px;font-weight: bold;">Галерея</span><br><br><span id="error"></span><br><br>


<div class="blockred">
   
    Добавить администратора:<br>
    <script>
    function uploadImg(form){
              var data=$(form).serialize();
            
            data += '&is_ajax=1';
             $.ajax({
                             url:"/adm/gallery/uploadimg",
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
        
        </script>
<form onSubmit="uploadImg(this); return false;">
       <table>  
     <tr><td>Картинки:</span></td><td> <input name="img[]" multiple='true' type="file"></td></tr>
     </table>
     <input name="add" type="submit" value="Добавить"> 
        </form>
</div>
