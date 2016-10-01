<?
class C_Main extends Controller {
	protected $template = "main";
	public function main() {
		if(isset($_GET['category']) && !empty($_GET['category']) && filter_var($_GET['category'], FILTER_VALIDATE_INT)){
			$goods = Store::getGoodsByCategory($_GET['category']);
		}else{
			$goods = Store::getGoodsByCategory(1);
		}
		if(isset($goods) && !empty($goods)){
			$this->addVar('goods',$goods);
		}else{
			$this->addVar('goods','Ошибка при отображении категории');
		}        	  
		parent::main();

    }

}