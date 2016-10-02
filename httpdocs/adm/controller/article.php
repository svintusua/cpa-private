<?php

class C_Article extends Controller {

    protected $template = 'adm';

    public function getListMenu() {
        $menu = Article::getAll();
        $u = '<ul>';
        $ul = '</ul>';
        if (!$menu) {
            echo 'Статьи не найдены ' . mysql_error();
            exit;
        }

        for ($i = 0; $i < count($menu); $i++) {
            // $myrow = mysql_fetch_array($r);
            $sp.='<li> <a href=menu?menu_id=' . $menu[$i]['id'] . '>' . $menu[$i]['short_name'] . '</a> </li>';
        }
        $p = $u . $sp . $ul;
//            var_dump($p);
//            exit;
        return $p;
    }

    public function addArticle() {
        $errors = array();
        $fields = array();

        do {

            if (!($title = trim($_POST['title']))) {
                $errors[] = "Пустое название статьи";
            }

            if (!($content = trim($_POST['content']))) {
                $errors[] = "Пустое содержание статьи";
            }

            if ($errors) {
                break;
            }
            
            $title = strip_tags($title);
            $content = strip_tags($content);
            if(empty($_POST['main'])){
                $main='0';
            }else{
                 $main='1';
            }
            
            $fields["title"] = $title;
            $fields["content"] = $content;
            $fields["main"] = $main;
            if (!($id = Article::nextId())) {
                $errors[] = "ID меню не получено";
            }

            If (!Article::set($id, $fields)) {
                $errors[] = "Статья не добавлена";
            }
        } while (false);
        if ($errors) {
            $this->addVar("error", "Ошибка :" . join(" , ", $errors));
        }
       header('Location: http://'.$_SERVER['HTTP_HOST'].'/adm/article');
        parent::main();
    }

    public function getInfoMenu() {
        if(!($_GET['article_id']) || !($item = Article::get($_GET['article_id']))){
           echo "Информация по статье не получена";
        }
        return $item;
    }

    public function updateArticle() {
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
                
                if (!($info=$this->getInfoMenu())){
                    $errors[] = "ID меню не получено";    
                }
                $id=$_GET['menu_id'];
                

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
            header('Location: http://test1.ru/adm/menu');
            parent::main();
        }
    }

    public function main() {
        $tree_menu = Article::getArticle();
        $this->addVar("tree_menu", $tree_menu);
        $this->view = 'Article.php';
        parent::main();
    }

}