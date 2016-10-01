<?php

class C_New_goods extends Controller {
    protected $template = "partner";
	
	public function main() {
		$this->view = 'new_goods.php';
		$this->addVar("title", 'Новый товар');
		
		$cookie = Cookie::get("hash");
		if(isset($cookie) && !empty($cookie)){
			$info = User::getInfoByHash($cookie);
			if(filter_var($info['type'], FILTER_VALIDATE_INT)){
				$type_user = $info['type'];
			}else{
				header('Location: /');
			}	
			if($type_user != 2){
				header('Location: /');
			}			
		}else{
			header('Location: /');
		}
//		$offers = Partner::offersPartnerByHash($cookie);
                $offers = Partner::getNameIDoffersPartnerByHash($cookie);
		if($offers == NULL){
			$this->addVar("offers", '<option>У вас нет офферов</option>');
		}else{			
//			$offers_arr=explode(',',$offers['id']);
                        $offers_arr = $offers;
			$option_offer = '';
			foreach($offers_arr as $of_id){
				$option_offer .= '<option value="'.$of_id['id'].'">'.$of_id['name'].'</option>';
			}
		}
		$this->addVar("offers", $option_offer);
		$this->addVar("user_id", $info['id']);
		$traffs_ar=Order::traffs();
		$traffs = array();		
		foreach($traffs_ar as $v){
			$traffs[] = '<li><input type="checkbox" name="traffs['.$v['id'].']" id="traffs'.$v['id'].'"><label for="traffs'.$v['id'].'">'.$v['name'].'</label></li>';
		}		
		$chunk_traffs = array_chunk($traffs, 10);
		$this->addVar("traffs1", join('',$chunk_traffs[0]));
		$this->addVar("traffs2", join('',$chunk_traffs[1]));
		$category = Goods::getCategory();
		$c_option = '';
		foreach($category as $v){
			$c_option .= '<option value="'.$v['id'].'">'.$v['name'].'</option>';
		}
		$this->addVar("category", $c_option);
		parent::main();
	}	
	public function getOffersID(){
		$cookie = Cookie::get("hash");
		$offers = Partner::offersPartnerByHash($cookie);
		if($offers == NULL){
			$this->addVar("offers", '<option>У вас нет офферов</option>');
		}else{			
			$offers_arr=explode(',',$offers);
			$option_offer = '';
			foreach($offers_arr as $of_id){
				$option_offer .= '<option value="'.$of_id.'">'.$of_id.'</option>';
			}
		}
	}
	public function translit($str) {
		$rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', ' ');
		$lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya', '_');
		return str_replace($rus, $lat, $str);
	}
	public function uploadImg(){
		if(strripos($_SERVER['HTTP_REFERER'],'edit_goods') != false){
			$g_id = explode('=',$_SERVER['HTTP_REFERER'])[1];
		}else{
			$g_id = false;
		}
		$cookie = Cookie::get("hash");
		$info = User::getInfoByHash($cookie);
		$uploaddir = './img/goods/'.$info['id'].'/'; 
		if(!is_dir($uploaddir)){
			mkdir($uploaddir);
		}
		$ename = $this->translit($_FILES['uploadfile']['name']);
		$filename = $uploaddir.$ename;
		if (file_exists($filename)) {
			$this->output(array("response"=>'error',"text"=>"картинка с таким именим уже существует"));
		}
		$file = $uploaddir . basename($ename); 
		 
		$ext = substr($ename,strpos($ename,'.'),strlen($ename)-1); 
		$filetypes = array('.jpg','.gif','.bmp','.png','.JPG','.BMP','.GIF','.PNG','.jpeg','.JPEG');
		 
		if(!in_array($ext,$filetypes)){
			$this->output(array("response"=>'error',"text"=>"Данный формат файлов не поддерживается"));
		}else{ 
			if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
				if(isset($g_id) && !empty($g_id)){
					$q = 'UPDATE `goods` SET `img`="'.$ename.'" WHERE `id`='.$g_id;
					IOMysqli::query($q);
					header('Location: /');
				}
				
			  $this->output(array("response"=>'success',"img_name"=>$ename)); 
			} else {
				$this->output(array("response"=>'error',"text"=>"Ошибка при загрузке картинки"));
			}
		}
	}
	public function addGoods(){
		$fields = array();
		$errors = array();
		do{
			if(isset($_POST['name']) && !empty($_POST['name'])){
				$fields['name'] = $_POST['name'];
			}else{
				$errors[] = 'Укажите название товара';
			}
			if(isset($_POST['description']) && !empty($_POST['description'])){
				$fields['description'] = $_POST['description'];
			}else{
				$errors[] = 'Напишите описание товара';
			}
			if(isset($_POST['price']) && !empty($_POST['price'])){
				if(filter_var($_POST['price'],FILTER_VALIDATE_INT)){
					$fields['price'] = $_POST['price'];
				}else{
					$errors[] = 'Цена товара должна иметь числовое значение';
				}				
			}else{
				$fields['price'] = 0;
			}
			if(isset($_POST['purchase_price']) && !empty($_POST['purchase_price'])){
				if(filter_var($_POST['purchase_price'],FILTER_VALIDATE_INT)){
					$fields['purchase_price'] = $_POST['purchase_price'];
				}else{
					$errors[] = 'Закупочная цена товара должна иметь числовое значение';
				}				
			}else{
				$fields['purchase_price'] = 0;
				// $errors[] = 'Укажите закупочную цену товара';
			}
			if(isset($_POST['currency']) && !empty($_POST['currency'])){
				if(filter_var($_POST['currency'],FILTER_VALIDATE_INT)){
					$fields['currency'] = $_POST['currency'];
				}else{
					$errors[] = 'Неверный формат валюты';
				}				
			}else{
				$errors[] = 'Выберите валюту';
			}
			if(isset($_POST['offer_id']) && !empty($_POST['offer_id'])){
				if(filter_var($_POST['offer_id'],FILTER_VALIDATE_INT)){
					$fields['offer_id'] = $_POST['offer_id'];
				}else{
					$errors[] = 'Неверное значение ID оффера';
				}				
			}else{
				$errors[] = 'Выберите оффер';
			}
			$fields['count'] = $_POST['count'];
			$fields['weight'] = $_POST['weight'];
			$fields['height'] = $_POST['height'];
			$fields['width'] = $_POST['width'];
			$fields['long'] = $_POST['long'];
			$fields['barcode'] = $_POST['barcode'];
			$fields['category_id'] = $_POST['category_id'];
			isset($_POST['apical']) && !empty($_POST['apical']) ? $fields['apical'] = $_POST['apical'] : $fields['apical'] = 0;
			if(isset($_POST['img']) && !empty($_POST['img'])){
				$fields['img'] = $_POST['img'];
			}		
		
			if ($errors) {
				break;
			}
			$resp = Goods::addGoods($fields);

			if(filter_var($resp, FILTER_VALIDATE_INT)){
				$this->output(array("response"=>'success',"text"=>"Товар успешно добавлен. ID нового товара ".$resp));
			}else{
				$this->output(array("response"=>'error',"text"=>"Ошибка при добавлении товара"));
			}
			
		}while(false);
		if ($errors) {
            $this->output(array("response"=>'error',"text"=>"Ошибка :" . join(" , ", $errors)));
        }
	}
}