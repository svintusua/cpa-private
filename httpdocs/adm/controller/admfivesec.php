<?php
class C_Admfivesec extends Controller{
     protected $template = 'adm';
     
     public function addQuestion() {
        $errors = array();
        do {
            if (!($question = trim($_POST['question']))) {
                $errors[] = "Отсутствует вопрос";
            }

            if ($errors) {
                break;
            }            
            $question = strip_tags($question);
            if(substr($question, -3)!="..."){
                $question=$question."...";
            }
            $mes=  Games::addAndDelandEditToAnswerfivesec("add", $question);
            if($mes!=false)
                $this->addVar("mes", "Вопрос добавлен");
        } while (false);
        if ($errors) {
            $this->addVar("error", "Ошибка :" . join(" , ", $errors));
        }
        parent::main();
    }
    
    public function delQuestion($id){
           $errors = array();
        do {
            if (!($qid = trim($_POST['qid']))) {
                $errors[] = "Отсутствует ID вопроса";
            }
            
            if(!filter_var($qid, FILTER_VALIDATE_INT)){
                $errors[] = "Неправильный ID";
            }

            if ($errors) {
                break;
            }            
            $qid = strip_tags($qid);

            $mes=  Games::addAndDelandEditToAnswerfivesec("del", "", $qid);
            if($mes!=false)
                $this->addVar("mes", "Вопрос удален");
        } while (false);
        if ($errors) {
            $this->addVar("error", "Ошибка :" . join(" , ", $errors));
        }
        parent::main();
    }
    
    public function editQuestion() {
        $errors = array();
        do {
            if (!($question = trim($_POST['question']))) {
                $errors[] = "Отсутствует вопрос";
            }
            
            if (!($old_question = trim($_POST['old_question']))) {
                $errors[] = "Отсутствует старый вопрос";
            }

            if ($errors) {
                break;
            }            
            $question = strip_tags($question);
            $old_question = strip_tags($old_question);
            
            if(substr($question, -3)!="..."){
                $question=$question."...";
            }
            $mes=  Games::addAndDelandEditToAnswerfivesec("edit", $question,0,$old_question);
            if($mes!=false)
                $this->addVar("mes", "Вопрос изменен");
        } while (false);
        if ($errors) {
            $this->addVar("error", "Ошибка :" . join(" , ", $errors));
        }
        parent::main();
    }
    public function main() {
        $this->view = 'admfivesec.php';
        parent::main();
    }
}
