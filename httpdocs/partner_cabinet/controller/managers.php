<?php

class C_Managers extends Controller {

    protected $template = "partner";
	
    public function main() {
		$this->view = 'managers.php';
		$this->addVar("title", 'Менеджеры');
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
		$q = 'select pi.user_id, pi.surname,pi.name,pi.lastname from `partner_info` as pi join `managers` as m on m.manager_id=pi.user_id where m.partner_id='.$info['id'];
		
		$m = Model::myQuery($q,3);
		if(isset($m) && !empty($m)){
			$m_option = '';
			foreach($m as $v){
				$m_option .= '<option value="'.$v['user_id'].'">'.$v['surname'].' '.$v['name'].' '.$v['lastname'].' ('.$v['user_id'].')</option>';
			}			
		}else{
			$m_option = '<option selected disabled>У вас еще нет менеджеров</option>';
		}
		$this->addVar("managers", $m_option);
		$this->addVar("partner_id", $info['id']);
        parent::main();
    }
	public function addManagers(){
		$errors = array();
		$filds = array();		
		do{
			if(isset($_POST['email']) && !empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				$filds['email'] = $_POST['email'];
			}else{
				$errors[] = 'неверный email';
			}
			
			if(isset($_POST['surname']) && !empty($_POST['surname'])){
				$filds['surname'] = $_POST['surname'];
			}else{
				$errors[] = 'отсутствует фамилия';
			}
			
			if(isset($_POST['lastname']) && !empty($_POST['lastname'])){
				$filds['lastname'] = $_POST['lastname'];
			}else{
				$errors[] = 'отсутствует отчество';
			}
			
			if(isset($_POST['name']) && !empty($_POST['name'])){
				$filds['name'] = $_POST['name'];
			}else{
				$errors[] = 'отсутствует имя';
			}
			
			if(isset($_POST['about']) && !empty($_POST['about'])){
				$filds['about'] = $_POST['about'];
			}else{
				$errors[] = 'отсутствует описание менеджера';
			}
			
			if(isset($_POST['tel']) && !empty($_POST['tel']) && filter_var($_POST['tel'], FILTER_VALIDATE_INT)){
				$filds['phone'] = $_POST['tel'];
			}else{
				$errors[] = 'отсутствует имя';
			}
			
			if(isset($_POST['partner_id']) && !empty($_POST['partner_id']) && filter_var($_POST['partner_id'], FILTER_VALIDATE_INT)){
				$partner_id = $_POST['partner_id'];
			}else{
				$errors[] = 'отсутствует уникальный ID партнера';
			}
			if($errors){
				break;
			}
			$response = Partner::addManager($partner_id, $filds);
			if($response == true){
				$this->output(array("response"=>'success',"text"=>"Менеджер добавлен!"));
			}else{
				$this->output(array("response"=>'error',"text"=>"Ошибка при добавлении менеджера"));
			}
		}while(false);
		if($errors){
			$this->output(array("response"=>'error',"text"=>"Ошибка :" . join(" , ", $errors)));
		}
	}
}
	
