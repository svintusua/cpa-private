<?php
class C_Admins extends Controller{
     protected $template = 'adm';
     
     public function addAdmin() {
        $errors = array();
        do {

            if (!($login = trim($_POST['login']))) {
                $errors[] = "Отсутствует login";
            }

            if (!($password = trim($_POST['password']))) {
                $errors[] = "Отсутствует пароль";
            }
           

            if ($errors) {
                break;
            }
            
            $login = strip_tags($login);
            $password = strip_tags($password);
             
//            If (!Admins::regAdmin($login, $password)) {
//                $errors[] = "Администратор не добавлен";
//            }
            $mes=Admins::regAdmin($login, $password);
            $this->addVar("mesreg", $mes);
        } while (false);
        if ($errors) {
            $this->addVar("error", "Ошибка :" . join(" , ", $errors));
        }
        parent::main();
    }
    
    public function deladministrator($id){
         $errors = array();
        $fields = array();

        do {

            if (!($id = trim($_POST['id']))) {
                $errors[] = "Отсутствует id администратора";
            }

            if (!filter_var($id, FILTER_VALIDATE_INT)) {
                $errors[] = "Не правильный id";
            }

            if ($errors) {
                break;
            }
            
            Admins::delAdmin($id);
            $this->addVar("ok", "Администратор удален");
        } while (false);
        if ($errors) {
            $this->addVar("error", "Ошибка :" . join(" , ", $errors));
        }
        parent::main();
    }
    public function main() {
        $this->view = 'admins.php';
        parent::main();
    }
}
