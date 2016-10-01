<?php

class C_Newpostcard extends Controller{
    protected $template = 'cabinet';

    public function main() {
        if(!$_COOKIE['enter']){
            header('Location: /');  
          }
        $this->addVar("title", 'Создать открытку');
        $this->view = 'newpostcard.php';
        $form='<form method="POST" onsubmit="newcart(this);return false;" class="form_newcard">'
                . '<fieldset class="input"><legend align="center">Название открытки</legend><input tupe="text" name="name"></fieldset>'
                . '<fieldset class="input select"><legend align="center">Тематика открытки</legend><select name="thematic" OnChange="template($(this).val())">';
        $thematics=  Postcard::getThematic();
        foreach ($thematics as $k=>$v){
            $options.='<option value="'.$k.'">'.$v.'</option>';
        }
        $templates=$this->templates(1);  
        $form.=$options;
        $form.='</select></fieldset>'
                . '<input tupe="text" name="tamplates_id" hidden="hidden">'
                . '<fieldset class="input tamp"><legend align="center">Шаблоны открыток</legend><div id="tamplates">'.$templates['divs'].'</div></fieldset>'
                . '<input type="submit" value="Создать" class="button"></form>';
        $this->addVar("formformnewcard", $form);
        parent::main();
    }
    public function templates($tid){
        $errors=array();
        do {
            if(!isset($tid) && empty($tid) && !filter_var($tid,FILTER_VALIDATE_INT)){
                 $errors[]='Неверный тип тематики';
            }else{
                $tamplates=  Postcard::getTemplateByThematicID($tid);
                if(!is_array($tamplates)){
                    $errors[]='Ошибка при получении данных';               
                }   
                if (isset($errors) && !empty($errors)) {
                    break;
                }
                foreach ($tamplates as $v){
                    $divs.='<div class="template" onclick="selecttamplate('.$v['id'].',event)"><span>'.$v['name'].'</span><div class="preview" style=\'background:url('.$v['preview'].') no-repeat;\'><div></div></div></div>';        
                }                                     
            }
        } while (false);
        
        (isset($errors) && !empty($errors)) ? $ret['errors']=join(" , ", $errors) : $ret['divs']=$divs;        
        return $ret;
        
    }    
    public function templatesJson(){
        if(!isset($_POST['tid']) && empty($_POST['tid']) && !filter_var($_POST['tid'],FILTER_VALIDATE_INT) ){
            $this->addVar("error", 'Отсутствует ID шаблона');
        }else{
            $tid=$_POST['tid'];
            $prov=$this->templates($tid); 
            if(isset($prov['errors']) && !empty($prov['errors'])){
                $this->addVar("error", "Ошибка :" . $prov['errors']);
            }else if(isset($prov['divs']) && !empty($prov['divs'])){
                $this->addVar("divs", $prov['divs']); 
            }
        }
        parent::main();
    }
    public function newcart(){
        do {
            if (!($name = $_POST['name'])) {
                $errors[] = "Пустое название открытки";
            }
            if (preg_match("/[а-яА-Я\s]/", trim($name))) {
                $errors[] = "Название открытки может состоять только из Латинских букв и цифр и знаков . , _ -";
            }
            if (!($thematic = $_POST['thematic'])) {
                $errors[] = "Отсутствует тематика открытки";
            }
            if (!($tamplates_id = $_POST['tamplates_id'])) {
                $errors[] = "Не выбран шаблон открытки";
            }
            if ($errors) {
                break;
            }
            list($user_id)=  explode('-', $_COOKIE['enter']);
            $postcard=  Postcard::setPostcard($user_id, $name, $thematic, $tamplates_id);
			if(filter_var($postcard,FILTER_VALIDATE_INT)){
				$this->addVar("good", '/cabinet/edit?postcard_id='.$postcard);
			}else{
				$errors[] = "Такая открытка уже существует. Измените имя открытки";	
				break;
			}
            
        } while (false);
        if ($errors) {
            $this->addVar("error", "Ошибка :" . join(" , ", $errors));
        }
        
        parent::main();
    }
    public function updateData(){
        unset($_POST['is_ajax']);
        $pid=$_POST['pid'];
        $img=$_POST['img'];
        if(!isset($img) && empty($img)){            
            $img=0;
        }
        unset($_POST['img']); 
        unset($_POST['pid']);        
        foreach ($_POST as $k=>$v){
            $p=Postcard::updateCard($pid, $k, $v,$img);
        }
        $this->addVar("pathindex", $p);
        parent::main();
    }
}