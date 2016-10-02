<?php

class C_Mypostcard extends Controller{
    protected $template = 'cabinet';

    public function main() {
        if(!$_COOKIE['enter']){
            header('Location: /');  
          }
        $this->addVar("title", 'Мои открытки');
        $this->view = 'mypostcard.php';
        list($user_id)=  explode("-", $_COOKIE['enter']);
        $postcards=Postcard::listCardByID($user_id);
       
        if(is_string($postcards)){
           $this->addVar("postcard", '<p style="text-align:center;margin-top: 10px;">'.$postcards.'</p>'); 
        }else if(is_array($postcards)){
            foreach ($postcards as $card){
                $li.='<li><a href="/cabinet/edit?postcard_id='.$card['id'].'" title="Редактировать открытку">'.$card['name'].'</a><img src="/img/delete.png" onclick="deletepostcard('.$card['id'].',\''.$card['name'].'\')" title="удалить открытку '.$card['name'].'"></li>';
            }
            $this->addVar("postcard", '<ul id="list_card">'.$li.'</ul>'); 
        }
        
        parent::main();
    }
    public function delCard(){
        $errors=array();
        do{
            if(!$cid=$_POST['cid']){
                $errors[]="Отсутствует ID открытки";                
            }
            if(!$name=$_POST['name']){
                $errors[]="Отсутствует ID открытки";                
            }
            if($errors){
                break;
            }
            if(!filter_var($cid, FILTER_VALIDATE_INT)){
                $errors[]="Неверный тип ID открытки";
                break;
            }            
            if(Postcard::delPostCard($cid, $name)){
                $this->addVar("good", "ok");
            }                       
        }while(false);
        if ($errors) {
            $this->addVar("error", "Ошибка :" . join(" , ", $errors));
        }
        parent::main();
    }
}