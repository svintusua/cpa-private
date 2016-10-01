<?php

class C_Main extends Controller {

    protected $template = "main";

    public function main() {
	$cookie = Cookie::get("hash");
	if(isset($cookie) && !empty($cookie)){
        User::redirect($cookie);
    }else{
		$arr = array(0,1,2,3,4,5,6,7,8,9);
		$capcha = "";
        for ($i = 0; $i < 4; $i++) {

            $index = rand(0, count($arr) - 1);
			$index2 = rand(0, count($arr) - 1);
            $capcha_u .= $arr[$index];
            $capcha_p .= $arr[$index2];
        }
		Cookie::set('capcha_u',$capcha_u);
		Cookie::set('capcha_p',$capcha_p);
		$this->addVar("capcha_u", $capcha_u);
		$this->addVar("capcha_p", $capcha_p);
		
		if(isset($_GET['refid']) && !empty($_GET['refid']) && filter_var($_GET['refid'], FILTER_VALIDATE_INT)){
			$refid = $_GET['refid'];
		}else{
			$refid = 0;
		}
		$this->addVar("refid", $refid);
	}
		
        parent::main();
//        User::temporaryUsers();
//    if(!$cookie = Cookie::get("enter")){
//        
//    }
//         if (!($email = trim($_POST['email'])) || !($password = trim($_POST['password']))) {
//             $email="";
//             $password="";
//             
//         }else{
//             return self::register();
//         }
    }

  

    public function auth() {
		$errors = array();
        do {
            if (!($email = $_POST['email'])) {
                $errors[] = "Пустой логин";
            }
            if (!($password = $_POST['password'])) {
                $errors[] = "Пустой пароль";
            }
            if ($errors) {
                break;
            }
//            $id = User::getIdByEmail($email);
//            if ($id) {
            if (!($user = User::enter($email, $password))) {
                $errors[] = "Неправильный логин или пароль";
                break;
            }else{
                $this->addVar("good", "1");
				$this->output(array("good"=>1));
            }
//            }
            
        } while (false);
        if ($errors) {
            $this->output(array("error"=>1,"text"=>"Ошибка :" . join(" , ", $errors)));
        }
        
        parent::main();
    }
    public function getComment() {
        $comments=Comment::get();
        if($comments){
            $this->addVar("comments", "ffdsfsdfsadfgsdfg");
        }
        parent::main();
    }
    public function addComment() {
        do {
            if (!($name = trim($_POST['name']))) {
                $errors[] = "Пустое имя";
            }
            if (!($message= trim($_POST['message']))) {
                $errors[] = "Пустое сообщение";
            }
            if ($errors) {
                break;
            }			
            $fields['name']=$name;
            $fields['message']=$message;
            $this->addVar("bad", "BAD");
            $p=Comment::set($fields);
            if($p==true){
                $this->addVar("good", "OK");
            }else{
                $this->addVar("bad", "BAD");
            }
        } while (false);
        if ($errors) {
            $this->addVar("error", "Ошибка :" . join(" , ", $errors));
        }
       
        parent::main();
    }
    
public function register() {
		
        $errors = array();
        $fields = array();
		$bad_email=array('trbvm.com','pecdo.com','yomail.info','dropmail.me','10mail.org','');
        do {
			$type_user=trim($_POST['type_user']);
			if($type_user == 1){
				if (!($rules = $_POST['rules']) || $_POST['rules'] != true) {
					$errors[] = "Не приняты правила работы с системой";
				}
			}
			if (!($email = trim($_POST['email']))) {
                $errors[] = "Пустой емайл";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Неправильный емейл";
            }
			if (!($about = trim($_POST['about']))) {
				$errors[] = "Вы не написали про себя";
			}
			
			
			if (!filter_var($type_user, FILTER_VALIDATE_INT)) {
                $errors[] = "Неопределен тип пользователя";
            }
			if($type_user == 2){
				if (!($phone = trim($_POST['phone']))) {
					$errors[] = "Вы не указали телефон";
				}
				$z=array('(',')',' ','+','-'); 
				$phone=str_replace($z,'', $phone);
				
				if (!filter_var($phone, FILTER_VALIDATE_INT)) {
					$errors[] = "Телефон некорректный";
				}
				$info["phone"] = $phone;
				if (!($surname = trim($_POST['middle_name']))) {
					$errors[] = "Вы не написали фамилию";
				}
				$info["surname"] = $surname;
				if (!($name = trim($_POST['first_name']))) {
					$errors[] = "Вы не написали имя";
				}
				$info["name"] = $name;
				if (!($lastname = trim($_POST['last_name']))) {
					$errors[] = "Вы не написали отчество";
				}
				$info["lastname"] = $lastname;
				if ($errors) {
					break;
				}
			}
			$pars_email=explode('@',$email);
			if(in_array($pars_email[1],$bad_email)){
				$errors[] = "Нельзя использовать 10 минутные почтовые ящики!";
			}
			
            if (!preg_match("/^[a-zA-Z0-9]{8,30}$/", trim($_POST['password']))) {
                $errors[] = "Неправильный пароль. Используйте цифры и латинские буквы от 8 до 30 символов!";
            } else {
                $password = trim($_POST['password']);
            }

            if ($errors) {
                break;
            }
			if(isset($_POST['refid']) && !empty($_POST['refid']) && filter_var($_POST['refid'], FILTER_VALIDATE_INT)){
               $fields['refid'] = $_POST['refid'];
            }
            $fields["email"] = $email;
            $fields["password"] = $password;
            $fields["type"] = $type_user;
            $info["about"] = $about;
		
           // list($id)=  explode("-", $_COOKIE['enter']);

            //$id = User::nextId();

            $true=User::set($fields, $info);
			if(is_array($true)){
				if($true[0]==true){
						$this->output(array("success"=>1,"text"=>$true[1]));
				}
			}else{
				$this->output(array("success"=>0,"text"=>$true));
			}
            

			
        } while (false);
        if ($errors) {
            //$this->addVar("error", "Ошибка :" . join(" , ", $errors));
            $this->output(array("error"=>1,"text"=>"Ошибка :" . join(" , ", $errors)));
        }


           // parent::main();

    }
	public function send_order(){
		$errors = array();
		do{
			if (!($name = trim($_POST['name']))) {
                $errors[] = "Пустое имя";
            }
			if (!($phone = trim($_POST['phone']))) {
                $errors[] = "Пустой телефон";
            }
			if ($errors) {
                break;
            }
			$your_intresting = trim($_POST['your_intresting']);
			$order_id = date('ymdHis');
			$ip=$_SERVER['REMOTE_ADDR'];
			$msg = '<html>
				<head>
				<meta charset="urf-8"/>
				<title>Заявка №'.$order_id.'</title>
				</head>
				<body>
				<p>№ заявки: <b>'.$order_id.'</b></p>
				<p>Имя: <b>'.$name.'</b></p>
				<p>Телефон: <b>'.$phone.'</b></p>
				<p>Интересует: <b>'.$your_intresting.'</b></p>
				<p>Дата заказа: <b>'.date('d.m.y. H:m').'</b></p>
				<p>IP: <b>'.$ip.'</b></p>
				</body>
				</html>';
			$email = 'agap91@bk.ru';
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers  .= "Content-type: text/html; charset=utf-8 \r\n";
			$headers .= "From: BUTTERFLY <no-reply@butterfly-design.ru>\r\n"; 
			if(mail($email, "Заявка", $msg, $headers)){
					//$this->addVar("success", 'Ваша заявка отправлена. В ближайшее время с вами свяжется наш менеджер');
					$this->output(array("success"=>1,"text"=>'Ваша заявка №'.$order_id.' отправлена. В ближайшее время с вами свяжется наш менеджер'));
				}else{
					$errors[] = "Ошибка при отправке заявки";
					break;
				}
		}while(false);
		if ($errors) {
			 $this->output(array("error"=>1,"text"=>"Ошибка :" . join(" , ", $errors)));
        }
	}
    public function recoverPassword() {
        $errors = array();
        $fields = array();

        do {
            if (!($email = trim($_POST['email']))) {
                $errors[] = "Пустой емайл";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Неправильный email";
            }
            if ($errors) {
                break;
            }

            $status = User::recover($email);
            switch ($status) {
                case 1:
                    $this->output(array("error"=>1,"text"=>"Ошибка! Такой Email не зарегистрирован. Проверьте правильность Email"));
                    break;
                case 2:
                   $this->output(array("error"=>1,"text"=>$status));
                    break;
                case 3:
                    $this->output(array("error"=>1,"text"=>$status));
                    break;
                case 4:
                    $this->output(array("error"=>1,"text"=>$status));
                    break;
                case 5:
                   $this->output(array("success"=>1,"text"=>"В ближайшее время Вам придем письмо с новым паролем"));
                    break;
            }			
        } while (false);
        if ($errors) {
			$this->output(array("error"=>1,"text"=>"Ошибка :" . join(" , ", $errors)));
        }

        parent::main();
    }
	
	public function postback(){
		Order::postback($_GET['user_id'],$_GET['offer_id'],'confirm',$_GET['click_id']);
	}
	
    public function goOut() {
        Cookie::deleteCookie("hash");
    }

}
