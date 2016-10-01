<span style="font-size: 30px;font-weight: bold;">Статистика</span><br><br><br><br>
<?
//$stat=  Statistics::stats();
//
//$orders=  Statistics::orders();
////var_dump(count($orders['info_orders']));
////exit;
//for($i=0;$i<count($orders['info_orders']);$i++){
//    if($orders['info_orders'][$i]['id']=='1'){
//        $paid="оплачено";
//    }else{
//        $paid="не оплачено";
//    }
//    $tr='<tr><td><span onclick="openzak('.$orders['info_orders'][$i]['user_id'].');" style="cursor:pointer;">#'.$orders['info_orders'][$i]['id'].' - '.$orders['info_orders'][$i]['sum'].'руб ('.$paid.')</span></td><td id="'.$orders['info_orders'][$i]['user_id'].'"></td></tr>';
//}
////var_dump($v);
////exit;
////foreach ($v as $key => $value) {
////    $str.=$key.'~'.$value;
////}

?>
<script>
    function openzak(a){
    $.ajax({
        url: "/adm/infozak",
        type: "POST",
        data: {is_ajax: 1, uid: a},
        dataType: "json", async: true})
            .done(function(data) {
                if (data.response.error) {
                    alert(data.response.error);
                }
                else {
                    if (data.response.info) {
                        $('#'+a).html(data.response.info);

                    }
                }

            }
            );
    }
</script>
<!--<div class="blockred">
    <table style="width:100%">
        <tr>
            <td style="width:43%">

                    <span>Всего пользователей: <? echo $stat['all_users'];?></span><br>
                    <span>Зарегистрированны с сайта: <? echo $stat['ssite'].' ('.ceil($stat['$proc_ss']).'%)';?></span><br>
                    <span>Из вконтакте: <? echo $stat['vkontakte'].' ('.ceil($stat['$proc_vk']).'%)';?></span><br>
                    <span>Из facebook: <? echo $stat['facebook'].' ('.ceil($stat['$proc_fb']).'%)';?></span><br>
                    <span>Из twitter: <? echo $stat['twitter'].' ('.ceil($stat['$proc_tw']).'%)';?></span><br>
                    <div id="statistika" style="margin-top: 25px;width: 500px;height: 300px; position: relative;border: 1px solid;">
                        <div id="vk" style="background: grey;width: 50px;height: <?echo round($stat['$proc_ss']);?>%; position: absolute; bottom:0;"><span style="position: absolute; top: -20px; left: 0;text-align: center;"><? echo $stat['ssite'].' ('.round($stat['$proc_ss']).'%)';?></span></div>
                        <div id="vk" style="background: none repeat scroll 0% 0% red; height: <?echo round($stat['$proc_vk']);?>%; bottom: 0px; position: absolute; width: 50px; left: 100px;"><span style="position: absolute; top: -20px; left: 0;text-align: center;"><? echo $stat['vkontakte'].' ('.round($stat['$proc_vk']).'%)';?></span></div>
                        <div id="fb" style="background: none repeat scroll 0% 0% blue; height: <?echo round($stat['$proc_fb']);?>%; bottom: 0px; position: absolute; width: 50px; left: 200px;"><span style="position: absolute; top: -20px; left: 0;text-align: center;"><? echo $stat['facebook'].' ('.round($stat['$proc_fb']).'%)';?></span></div>
                        <div id="tw" style="background: none repeat scroll 0% 0% green; height: <?echo round($stat['$proc_tw']);?>%; bottom: 0px; position: absolute; width: 50px; left: 300px;"><span style="position: absolute; top: -20px; left: 0;text-align: center;"><? echo $stat['twitter'].' ('.round($stat['$proc_tw']).'%)';?></span></div>
                    </div>
                    <ul style="list-style:none;height: 50px;">
                        <li style="float:left;margin-left: 10px;"><span style="color: grey;background: grey;font-size: 20px;font-weight: bold;">- </span> <span>С сайта</span></li>
                        <li style="float:left;margin-left: 10px;"><span style="color: red;background: red;font-size: 20px;font-weight: bold;">- </span> <span>Вконтакте</span></li>
                        <li style="float:left;margin-left: 10px;"><span style="color: blue;background: blue;font-size: 20px;font-weight: bold;">- </span> <span>Facebook</span></li>
                        <li style="float:left;margin-left: 10px;"><span style="color: green;background: green;font-size: 20px;font-weight: bold;">- </span> <span>Twitter</span></li>
                    </ul>

            </td>
            <td style="vertical-align: top;">
                <span>Всего сформированно считов - <?=$orders['all_orders'];?></span><br>
                <table id="ord">
                    <?=$tr?>
                </table>
                    
            </td>
        </tr>       
    </table>
</div>-->