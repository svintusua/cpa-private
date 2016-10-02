<?php

class C_Main extends Controller {

    protected $template = 'cabinet';
    public static $gamerstep = 0;
    public static $allquestion;
    public static $gamers;

    public function logout() {
        Cookie::delete('enter');
        header("Location: /");
    }

    public function main() {
        list($user_id) = explode('-', Cookie::get('enter'));
        if ($user_id=filter_var($user_id, FILTER_VALIDATE_INT)) {
            $information = Postcard::information($user_id);
            if (is_array($information)) {
                $info = '<div id="block_1_ul"><span>У вас:</span> <ul><li><span>всего открыток: <b>' . $information['all_postcartd'] . '</b></span></li>'
                        . '<li><span>готовых открыток: <b>' . $information['active_postcartd'] . '</b></span></li></ul></div>';
                $this->addVar("info", $info);
            } else {
                $this->addVar("info", $information);
            }            
        } else {
            $this->addVar("info", 'некоректные данные');            
        }
        $this->addVar("title", 'Мой кабинет');
        $this->view = 'main.php';
        parent::main();
    }
    public function comment(){
        $errors=array();
        do{
            if(!$subject=$_POST['subject']){
                $errors[]="Отсутствует тема сообщения";                
            }
            if(!$message=$_POST['message']){
                $errors[]="Отсутствует сообщение";                
            }
            if($errors){
                break;
            }
            list($user_id)=  explode('-', Cookie::get('enter'));
            $user_email=  User::getEmailByID($user_id);
            $msg = '<html>
            <head>
            <meta charset="urf-8"/>
            <title>Cообщение от пользователя</title>
            </head>
            <body>
            <p>Email: <b>'.$user_email.'</b></p>
            <p>'.$message.'</p>
            </body>
            </html>';
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers  .= "Content-type: text/html; charset=utf-8 \r\n";
            $headers .= "From: HapCard - сообщение от пользователя <no-reply@hapcard.ru>\r\n"; 
            $rrr=Smtpmails::smtpmail('agap91@bk.ru', $subject, $msg, $headers);
        if ($rrr===true) {
            $this->addVar("send", "Сообщение отправленно!");
        }                     
        }while(false);
        if ($errors) {
            $this->addVar("error", "Ошибка :" . join(" , ", $errors));
        }
        parent::main();
    }

}
