<?php

class C_Menu extends Controller {

    protected $template = 'adm';

    public function getListMenu() {
        $menu = Menu::getAll();
        $u = '<ul>';
        $ul = '</ul>';
        if (!$menu) {
            echo 'Пункты меню не найдены ' . mysql_error();
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

    public function addMenu() {
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

            if (!($id = Menu::nextId())) {
                $errors[] = "ID меню не получено";
            }

            If (!Menu::set($id, $fields)) {
                $errors[] = "Меню не добавлено";
            }
        } while (false);
        if ($errors) {
            $this->addVar("error", "Ошибка :" . join(" , ", $errors));
        }
        header('Location: http://test1.ru/adm/menu');
        parent::main();
    }

    public function getInfoMenu() {
        if(!($_GET['menu_id']) || !($item = Menu::get($_GET['menu_id']))){
           echo "Информация по пункту меню не получена";
        }
        return $item;
    }

    public function updateMenu() {
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

                If (!Menu::set($id, $fields)) {
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
        $tree_menu = Menu::getTreeMenu();
        $this->addVar("tree_menu", $tree_menu);
        $this->view = 'menu.php';
        parent::main();
    }

}