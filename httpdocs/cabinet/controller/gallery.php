<?php
class C_Gallery extends Controller{
	protected $template = 'cabinet';
	
	public function main() {
		if(!$_COOKIE['enter']){
            header('Location: /');  
          }
		list($user_id)=explode('-',$_COOKIE['enter']);
		$email=User::getEmailByID($user_id);
		list($name)=explode('@',$email);
		$imgs=scandir(WWW_DIR.'/img/gallery/'.$name);                
		if(!is_array($imgs)){
			$this->addVar("gallery", "<p class='info'>У Вас еще нет готовых открыток<p>");  
		}else{	
			$div=array();         
                        unset($imgs[0]);
                        unset($imgs[1]);
			foreach($imgs as $img){                          
				list($img_name)=explode('.',$img);
                                  $vk=<<<html
                                    <script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script><div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki" data-yashareImage="http://hapcard.ru/img/gallery/$name/$img" data-yashareDescription="Я сделал открытку $img_name на HapCard.ru!" data-yashareTitle="Электронная открытка HapCard.ru"></div>
html;
				$div[]='<div class="thumbs">
							<div class="t_img"><img src="/img/gallery/'.$name.'/'.$img.'" alt="'.$img_name.'"></div>
							<div class="discription">
								<span >'.$img_name.'</span>
                                                                <a href="/postcard/'.$name.'/'.$img_name.'" target="_blank" class="link" title="Ссылка на открытку '.$img_name.'"><img src="/img/link.png" alt="Ссылка на открытку '.$img_name.'"></a>
                                                                <a href="/postcard/dowload.php?filename='.  urlencode('img/gallery/'.$name.'/'.$img_name.'.jpeg').'" target="_blank" class="link" title="Скачать картинку '.$img_name.'.jpeg"><img src="/img/download.png" alt="Скачать картинку '.$img_name.'.jpeg"></a>
                                                                <a href="/archives/'.$name.'/'.$img_name.'.zip" target="_blank" class="link" title="Скачать архив '.$img_name.'.zip"><img src="/img/zip.jpg" alt="Скачать архив '.$img_name.'.zip"></a>
								<div class="socseti">					
									<!--<span class="click-to-copy" onclick="copylink(\'/postcard/'.$name.'/'.$img_name.'\')">скопировать ссылку</span>-->
                                                                            '.$vk.'
								</div>
							</div>
						</div>';
			}
			$this->addVar("gallery", join('',$div));//join('',$div)
		}
        $this->view = 'gallery.php';
        $this->addVar("title", 'Галерея открыток');
		parent::main();
	}
}