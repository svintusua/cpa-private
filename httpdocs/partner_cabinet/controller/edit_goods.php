<?php

class C_Edit_goods extends Controller {
    protected $template = "partner";
	
	public function main() {		
	
		$this->view = 'edit_goods.php';
		$this->addVar("title", 'Редактирование товара');
		
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
		$offers = Partner::offersPartnerByHash($cookie);                
//		$offers_arr=explode(',',$offers);
               		
		$this->addVar("offers", $option_offer);
		$goods_id = $_GET['goods_id'];
		$goods_info = Goods::getGoodsInfoById($goods_id, $offers);
                $offers_sel = Partner::getNameIDoffersPartnerByHash($cookie);
                $offers_arr = $offers;
		$option_offer = '';
		foreach($offers_sel as $of_id){
                    if($goods_info['offer_id'] == $of_id['id']){
                        $selected = 'selected';
                    }else{
                        $selected = '';
                    }
			$option_offer .= '<option value="'.$of_id['id'].'" '.$selected.'>'.$of_id['name'].'</option>';
		}
                $this->addVar("offers", $option_offer);
		if(isset($goods_info) && !empty($goods_info)){			
			$this->addVar("user_id", $info['id']);
			if($goods_info['img'] == 'no_img.png' ){
				$img = '../img/goods/'.$goods_info['img'];
			}else{
				$img = '../img/goods/'.$info['id'].'/'.$goods_info['img'];
			}
			$this->addVar("img", $img);
		}else{
			header('Location: /');
		}
		$category = Goods::getCategory();
		$c_option = '';
		foreach($category as $v){
			if($goods_info['category_id'] == $v['id']){
				$c_option .= '<option value="'.$v['id'].'" selected>'.$v['name'].'</option>';
			}else{
				$c_option .= '<option value="'.$v['id'].'">'.$v['name'].'</option>';
			}
		}
		$this->addVar("category", $c_option);
		$filles=array();
		
		//$filles=scandir(WWW_DIR.'img/goods/'.$info['id'].'/');
		$filles=scandir(WWW_DIR.'img/goods/'.$info['id'].'/');
		unset($filles[0]);
		unset($filles[1]);
		if(isset($filles) && !empty($filles)){			
			$img_all = '';
			foreach($filles as $v){
				$img_all .= '<img src="../img/goods/'.$info['id'].'/'.$v.'">';
			}
			$this->addVar("img_all", $img_all);
		}else{
			$this->addVar("img_all", 'Картинок нет');
		}
		if($goods_info['apical'] == 0){
			$apical_show = 1;			
			$a_table = Goods::getApicalByGoodsId($goods_id);		
			if($a_table != false){
			$tr = '';
				foreach($a_table as $v){				
					if($v['img'] == 'no_img.png' ){
						$img = '../img/goods/'.$v['img'];
					}else{
						$img = '../img/goods/'.$info['id'].'/'.$v['img'];
					}

						$tr .= '<tr data-goods_id="'.$v['id'].'">'.
							'<td><img src="'.$img.'" alt="'.$v['name'].'"></td>'.
							'<td>'.$v['name'].'</td>'.
							'<td>'.$v['id'].'</td>'.
							'<td>'.$v['price'].' руб.</td>'.
							'<td>'.$v['purchase_price'].' руб.</td>'.						
							// '<td>'.$v['count'].' шт.</td>'.
							'<td>'.$goods_info['count'].' шт.</td>'.
							'<td><span class="del" data-apical_id="'.$v['id'].'">удалить</span></td>'.
							'</tr>';
					
				}
				$this->addVar("apical", '<table class="a_table"><tr data-goods_id="0">
						<th>картинка</th>
						<th>название</th>
						<th>артикул</th>
						<th>цена</th>
						<th>закупочная цена</th>
						<th>остаток на складе</th>				
						<th></th>				
					</tr>'.$tr.'</table>');
			}else{
				$this->addVar("apical", '<table class="a_table"><tr data-goods_id="0">
						<th>картинка</th>
						<th>название</th>
						<th>артикул</th>
						<th>цена</th>
						<th>закупочная цена</th>
						<th>остаток на складе</th>		
					</tr><tr><td colspan="6">у этого товара нет апсейлов</td></tr></table>');
			}
		}else{
			$q = 'select count from goods where id='.$goods_info['apical'];
			$goods_info['count'] = IOMysqli::one($q);
			$apical_show = 0;
		}
		$this->addVar("apical_show", $apical_show);
		$this->addVar("goods_info", $goods_info);
		parent::main();
	}
	public function updateInfoGoods(){
		if(isset($_POST['goods_id']) && !empty($_POST['goods_id'])){
			$goods_id = $_POST['goods_id'];
			unset($_POST['goods_id']);
			unset($_POST['is_ajax']);
			$resp = Goods::updateInfoGoods($goods_id, $_POST);
			if(isset($resp) && !empty($resp)){
				$this->output(array("response"=>'success',"text"=>"Данные успешно обновлены"));
			}else{
				$this->output(array("response"=>'error',"text"=>"Ошибка при обновлении данных"));
			}
		}else{
			$this->output(array("response"=>'error',"text"=>"Отсутсвует ID товара"));
		}		
	}
	
	public function addLink(){
		if(isset($_POST['goods_id']) && !empty($_POST['goods_id']) && isset($_POST['link']) && !empty($_POST['link']) && filter_var($_POST['goods_id'],FILTER_VALIDATE_INT)){
			$resp = Goods::addDelLink($_POST['goods_id'],$_POST['link'],1);
			if($resp == true){
				$this->output(array("response"=>'success',"text"=>"Ссылка добавленна успешна"));
			}else{
				$this->output(array("response"=>'error',"text"=>"Ошибка при добавлении ссылки"));
			}
		}else{
			$this->output(array("response"=>'error',"text"=>"Отсутсвует ID товара или ссылка"));
		}
	}
	public function delApical(){
		if(isset($_POST['apical_id']) && !empty($_POST['apical_id']) && filter_var($_POST['apical_id'], FILTER_VALIDATE_INT)){
			$apical_id = $_POST['apical_id'];
			$resp = Goods::delGoods($apical_id);
			if($resp){
				$this->output(array("response"=>'success',"text"=>"Апсейл удален"));
			}else{
				$this->output(array("response"=>'error',"text"=>"Ошибка при удалении апсейла"));
			}
		}else{
			$this->output(array("response"=>'error',"text"=>"Отсутсвует ID товара"));
		}		
	}
}