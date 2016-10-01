<?php

class C_Weblog extends Controller {

    protected $template = 'adm';
    
    public function delWeblogArticle() {
        if (!($id = trim($_POST['id']))) {
            $errors[] = "Пустой ID";
        }
        If (!Weblog::deleteWeblogArticle($id)) {
                $errors[] = "Статья не добавлена";
            }
        
    }

    public function addWeblogArticle() {
        $errors = array();
        $fields = array();

        do {

            if (!($name = trim($_POST['name']))) {
                $errors[] = "Пустое название статьи";
            }

            if (!($description = trim($_POST['description']))) {
                $errors[] = "Пустое содержание статьи";
            }

            if ($errors) {
                break;
            }
            
            $name = strip_tags($name);
            $description = strip_tags($description);
            
            $fields["name"] = $name;
            $fields["description"] = $description;
            If (!Weblog::setArt($fields)) {
                $errors[] = "Статья не добавлена";
            }
        } while (false);
        if ($errors) {
            $this->addVar("error", "Ошибка :" . join(" , ", $errors));
        }
       header('Location: http://'.$_SERVER['HTTP_HOST'].'/adm/weblog');
        parent::main();
    }

    public function updateWeblogArticle() {
        if ($_POST) {

            $errors = array();
            $fields = array();

            do {

                if (!($short_name = trim($_POST['short_name']))) {
                    $errors[] = "Пустое название меню";
                }

                if (!($full_name = trim($_POST['full_name']))) {
                    $errors[] = "Пустое название меню";
                }

                if (!($position = trim($_POST['position']))) {
                    $errors[] = "Не указана позиция";
                }

                if ($errors) {
                    break;
                }
                $short_name = strip_tags($short_name);
                $full_name = strip_tags($full_name);

                if (!($parent_id = trim($_POST['parent_id']))) {
                    $parent_id = "0";
                }
                If (!filter_var($position, FILTER_VALIDATE_INT)) {
                    $errors[] = "Укажите правильную позицию";
                }

                $fields["short_name"] = $short_name;
                $fields["full_name"] = $full_name;
                $fields["parent_id"] = $parent_id;
                $fields["position"] = $position;
                
                               

//                if (!($id = Menu::nextId())) {
//                    $errors[] = "ID меню не получено";
//                }

                If (!Article::set($id, $fields)) {
                    $errors[] = "Меню не изменено";
                }
            } while (false);
            if ($errors) {
                $this->addVar("error", "Ошибка :" . join(" , ", $errors));
            }
            
            parent::main();
        }
    }

    public function main() {
        $this->view = 'weblog.php';
        parent::main();
    }

}