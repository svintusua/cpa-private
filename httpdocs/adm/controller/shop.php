<?php

class C_Shop extends Controller {

    protected $template = 'adm';
    
    public function getTypeProduct() {
        $categories = Store::typeProd();
        $a = '<table id="allweblart">
        <tr><th colspan="3" style="text-align: center; background:none;">Список типов товара</th></tr>    
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th></th>
            </tr>';

        for ($i = 0; $i < count($categories); $i++) {
            $b.='<tr><td>' . $categories[$i]['id'] . '</td><td>' . $categories[$i]['type'] . '</td><td><span class="del" onclick="' . 'del(' . $categories[$i]['id'] . ",'typeproduct' )" . '">удалить</span></td></tr>';
        }
        $c = "</table>";
        $this->addVar("tc", $a . $b . $c);
        parent::main();
    }

    public function getallcategory() {
        $categories = Store::category();
        $a = '<table id="allweblart">
        <tr><th colspan="3" style="text-align: center; background:none;">Список категорий</th></tr>    
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th></th>
            </tr>';

        for ($i = 0; $i < count($categories); $i++) {
            $b.='<tr><td>' . $categories[$i]['id'] . '</td><td>' . $categories[$i]['name'] . '</td><td><span class="del" onclick="' . 'del(' . $categories[$i]['id'] . ",'category' )" . '">удалить</span></td></tr>';
        }
        $c = "</table>";
        $this->addVar("tc", $a . $b . $c);
        parent::main();
    }

    public function getallsubcategory() {
        $subcategories = Shop::subcategory();
        $a = '<table id="allweblart">
        <tr><th colspan="4" style="text-align: center; background:none;">Список подкатегорий</th></tr>    
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Родительская категория</th>
                <th></th>
            </tr>';

        for ($i = 0; $i < count($subcategories); $i++) {
            $b.="<tr><td>" . $subcategories[$i]['id'] . "</td><td>" . $subcategories[$i]['name'] . '</td><td>' . $subcategories[$i]['category_name'] . '</td><td><span class="del" onclick="' .
                    'del(' . $subcategories[$i]['id'] . ",'subcategories' )" . '">удалить</span></td></tr>';
        }
        $c = "</table>";
        $this->addVar("tc", $a . $b . $c);
        parent::main();
    }

    public function getallproducts() {
        $products = Shop::products();
        $a = '<table id="allweblart">
        <tr><th colspan="7" style="text-align: center; background:none;">Список товаров</th></tr>    
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Цена</th>
                <th>Категория</th>
                <th>Картинка</th>
                <th></th>
            </tr>';

        for ($i = 0; $i < count($products); $i++) {
            $b.="<tr><td>" . $products[$i]['id'] . "</td><td>" . $products[$i]['name'] . '</td><td>' . $products[$i]['description'] . '</td><td>' . $products[$i]['price'] . '</td><td>' .
                    $products[$i]['subcategories_name'] . '</td><td><img src="/img/store/' . $products[$i]['img'] . '" style="width:50px;"></td><td><span class="del" onclick="' .
                    'del(' . $products[$i]['id'] . ",'$product' )" . '">удалить</span></td></tr>';
        }
        $c = "</table>";
        $this->addVar("tc", $a . $b . $c);
        parent::main();
    }

    public function appendData() {
        $errors = array();
        unset($_POST['is_ajax']);
        if (!($table = trim($_POST['tablename']))) {
            $errors[] = "Отсутствует название таблицы";
            $this->addVar("error", "Ошибка: " . join(" , ", $errors));
            return false;
        }
        unset($_POST['tablename']);

        if ($_FILES) {
            
            do {
            if(!$name=trim($_POST['name'])){
                $errors[] = "Отсутствует название товара";
            }
            if(!$description=trim($_POST['description'])){
                $errors[] = "Отсутствует описание товара";
            }
            if(!$price=trim($_POST['price'])){
                $errors[] = "Отсутствует цена товара";
            }
            if(!$subcategories_id=trim($_POST['subcategories_id'])){
                $errors[] = "Отсутствует id подкатегории";
            }
            if(!$type_id=trim($_POST['type_id'])){
                $errors[] = "Отсутствует id типа товара";
            }
//            if(filter_var($subcategories_id,FILTER_VALIDATE_INT)){
//                $errors[] = "Неверный id подкатегории";
//            }

            if($errors){
                break;
            }
            $data['name']=$name;
            $data['description']=$description;
            $data['price']=$price;
            $subcat['subcategories_id']=$subcategories_id;

            Shop::append($table, $data, true, $_FILES["img"],$subcat,$type_id);
            header('Location: /adm/shop');
            $this->addVar("ок", "Продукт добавлен");
        }while (false);
            if ($errors) {
                $this->addVar("error", "Ошибка: " . join(" , ", $errors));
            }
        } else {
            do {
                foreach ($_POST as $key => $value) {
                    $data[$key] = $value;
                }
                Shop::append($table, $data);
                $this->addVar("mes", "Созданно");
            } while (false);
            if ($errors) {
                $this->addVar("error", "Ошибка: " . join(" , ", $errors));
            }
        }
        parent::main();
    }

    public function del() {
        $errors = array();
        $fields = array();

        do {

            if (!($id = trim($_POST['id']))) {
                $errors[] = "Отсутствует id";
            }
            if (!($table = trim($_POST['table']))) {
                $errors[] = "Отсутствует название таблицы";
            }

            if ($errors) {
                break;
            }
            Shop::del($id, $table);
            $this->addVar("ok", "Удалено");
        } while (false);
        if ($errors) {
            $this->addVar("error", "Ошибка :" . join(" , ", $errors));
        }
        parent::main();
    }

    public function filingCategory() {
        $categories = Store::category();
        $a = '<select name="category_id">';

        for ($i = 0; $i < count($categories); $i++) {
            $b.='  <option value="' . $categories[$i]['id'] . '">' . $categories[$i]['name'] . '</option>';
        }
        $c = "</select>";
        $this->addVar("tc", $a . $b . $c);
        parent::main();
    }

    public function filingSubcategory() {
        $subcategories = Store::subCategory();
        $a = '<select name="subcategories_id">';

        for ($i = 0; $i < count($subcategories); $i++) {
            $b.='  <option value="' . $subcategories[$i]['id'] . '">' . $subcategories[$i]['name'] . '</option>';
        }
        $c = "</select>";
        $this->addVar("tc", $a . $b . $c);
        parent::main();
    }
    public function filingTypeProduct() {
        $subcategories = Store::typeProd();
        $a = '<select name="type_id">';

        for ($i = 0; $i < count($subcategories); $i++) {
            $b.='  <option value="' . $subcategories[$i]['id'] . '">' . $subcategories[$i]['type'] . '</option>';
        }
        $c = "</select>";
        $this->addVar("tc", $a . $b . $c);
        parent::main();
    }

    public function main() {
        $this->view = 'shop.php';
        parent::main();
    }

}
