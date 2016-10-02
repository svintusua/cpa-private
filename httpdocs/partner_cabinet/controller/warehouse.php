<?php

class C_Warehouse extends Controller {

    protected $template = "partner";

	public function main() {
		$this->view = 'warehouse.php';
		$not_goods = '<table>
				<tr>
					<th>картинка</th>
					<th>название</th>
					<th>артикул</th>
					<th>ID оффера</th>
					<th>цена</th>
					<th>закупочная цена</th>
					<th>валюта</th>
					<th>вес</th>
					<th>габориты</th>
					<th>количество</th>				
				</tr>
				<tr class="notclick">
				<td colspan="10">у вас еще пока нет товаров</td>
				</tr>
				</table>';
		$this->addVar("title", 'Склад');		
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
		$this->addVar("user_id", $info['id']);
		$table = Goods::getGoodsInfoByUserId($info['id']);
		
		if(isset($table) && !empty($table)){
			$this->addVar("goods", $table);
		}else{
			$this->addVar("goods", $not_goods);
		}
		$offers = Partner::offersPartnerByHash($cookie);
		
		if($offers == NULL){
			$this->addVar("goods_option", '<option>У вас еще нет товаров</option>');
		}else{
			$goods_ar = Goods::getGoodsByOffer($offers);
			$goods_option = '';
			if(isset($goods_ar) && !empty($goods_ar)){
				foreach($goods_ar as $v){
					$goods_option .= '<option value="'.$v['id'].'">'.$v['id'].'</option>';
				}
				$this->addVar("goods_option", $goods_option);
			}else{
				$this->addVar("goods_option", '<option>У вас еще нет товаров</option>');
			}
		}
		
		parent::main();
	}	
	
	public function filter(){	
		$errors = array();	
		do{
			if(isset($_POST['goods_id']) && !empty($_POST['goods_id'])){
				if(!filter_var($_POST['goods_id'], FILTER_VALIDATE_INT)){
					$errors[]='Неверный формат артикула';
				}
			}
			if(isset($_POST['purchase_price_start']) && !empty($_POST['purchase_price_start'])){
				if(!filter_var($_POST['purchase_price_start'], FILTER_VALIDATE_INT)){
					$errors[]='Неверный формат цены';
				}
			}
			if(isset($_POST['purchase_price_end']) && !empty($_POST['purchase_price_end'])){
				if(!filter_var($_POST['purchase_price_end'], FILTER_VALIDATE_INT)){
					$errors[]='Неверный формат цены';
				}
			}
			if(isset($_POST['price_start']) && !empty($_POST['price_start'])){
				if(!filter_var($_POST['price_start'], FILTER_VALIDATE_INT)){
					$errors[]='Неверный формат цены';
				}
			}
			if(isset($_POST['price_end']) && !empty($_POST['price_end'])){
				if(!filter_var($_POST['price_end'], FILTER_VALIDATE_INT)){
					$errors[]='Неверный формат цены';
				}
			}
			if(isset($_POST['count']) && !empty($_POST['count'])){
				if(!filter_var($_POST['count'], FILTER_VALIDATE_INT)){
					$errors[]='Неверный формат остатка на складе';
				}
			}
			if(isset($_POST['name']) && !empty($_POST['name'])){
				if($_POST['name'] == 'undefined'){
					unset($_POST['name']);
				}
			}
			if($errors){
				break;
			}
			$table = Goods::filterGoods($_POST, Cookie::get("hash"));
			$this->output(array("response"=>'success',"text"=>$table));
			
		}while(false);
		if ($errors) {
            $this->output(array("response"=>'error',"text"=>"Ошибка :" . join(" , ", $errors)));
        }
	}
	
	public function deleteGoods(){
		if(isset($_POST['goods_ids']) && !empty($_POST['goods_ids'])){
			$orders = json_decode($_POST['goods_ids'], true);
			$resp = Goods::deleteGoods($orders);
			if($resp == true){
				$this->output(array("response"=>'success'));
			}else{
				$this->output(array("response"=>'error',"text"=>"Ошибка"));
			}
		}
	}
	public function setCategory(){
		if(isset($_POST['c_name']) && !empty($_POST['c_name'])){
			$resp = Goods::setCategory($_POST['c_name']);
			if(isset($resp) && !empty($resp) && filter_var($resp, FILTER_VALIDATE_INT)){
				$this->output(array("response"=>'success', 'option'=>'<option value="'.$resp.'" selected>'.$_POST['c_name'].'</option>'));
			}else{
				$this->output(array("response"=>'error',"text"=>"Ошибка при добавлении категории"));
			}			
		}else{
			$this->output(array("response"=>'error',"text"=>"Ошибка: отсутсвует название категории"));
		}
	}	
}