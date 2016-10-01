<?php
class C_Main extends Controller {
     protected $template = 'adm';
     
     public function b(){
         if (!$_POST['query']){
             $this->addVar("error", "нет запроса");
         }else{
         var_dump($_POST['query']);
         exit;
         $rez=  IOMysqli::table($_POST['query']);
         $this->addVar("ok", $rez);
     }
     
     parent::main();
     }
     
     public function infoZak(){
         $error='';
         do{
             if(!($id=trim($_POST['uid']))){
                 $error='Отсутствует ID пользователя';
             }
             if ($error){
                 break;
             }             
             $info=  Statistics::infoAboutOrder($id);
             $fio='<span>'.$info[0]['firstname'].' '.$info[0]['lastname'].' - '.$info[0]['phone'].'</span><br>';
             $address='<span>'.$info[0]['address'].'</span><br>';
             for($i=0;$i<count($info);$i++){
                 $p.=$info[$i]['name'].'('.$info[$i]['sum'].' шт.);<br>';
             }
             $q=$fio.$address.'<p>'.$p.'</p>';
             $this->addVar("info", $q);
         }while(FALSE);
         if ($error) {
            $this->addVar("error", "Ошибка :" . $error);
        }
        parent::main();
     }

}
