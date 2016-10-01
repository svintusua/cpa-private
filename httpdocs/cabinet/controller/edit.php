<?php
class C_Edit extends Controller{
    protected $template = 'cabinet';
    static public $postcard_id;
    public function main() {
        if(!$_COOKIE['enter']){
            header('Location: /');  
          }
        $this->view = 'edit.php';
        $this->addVar("title", 'Редактирование открытки');
        if(!$pid=$_GET['postcard_id']){
            
            echo '<div id="editerror"><span>Ошибка: Отсутствует открытка для редактирования</span></div><script>setTimeout(\'window.location="/cabinet";\',2000);</script>';
        }else{
            list($u_id)=explode("-", $_COOKIE['enter']);
            $this->addVar("postcard_id",$pid);
            if((Postcard::postcardBelongsUser($u_id, $pid))===false){
                header('Location: /');
                return false;
            }            
            if(Postcard::startedPostcard($pid)==true){
                header('Location: '.$_SERVER['name'].'/cabinet/gallery');
                return false;
            }
            $path=  Postcard::pathCard($pid);
            $t_id=  Postcard::tamplateIdByCard($pid);
            $field=  Postcard::tamplateFields($t_id);
            $this->addVar("text_fields",join("",$field['text']));
            if(is_string($path)){
               $this->addVar("loadfile", "<script>$('#postcard').attr('src','/".$path."');</script>"); 
               $imgs=scandir($path.'/img/');
               unset($imgs[0]);
               unset($imgs[1]);
               if(!is_array($imgs)){
                   $this->addVar("uploadedimg", "У Вас еще нет загруженных изображений");                   
               }else{
                   foreach ($imgs as $img){
                       $li.='<tr><td><div class="li"></div></td><td><span class="delete_img" onclick="delimg('.$pid.',\''.$img.'\');" title="удалить картинку">X</span></td><td>'.$img.'</td><td><div class="select_border"><select onchange="updatedata(this,1)">'.join("",$field['img']).'</select></div></td></tr>';
                   }
                   $this->addVar("uploadedimg", "<table>$li</table>"); 
               }
            }
        }
        parent::main();
    }
    
    public function uploadImg(){
       $pid=$_POST['pid'];
       $path=  Postcard::pathCard($pid);
        if ($_FILES) {
                if ($_FILES['image']['type'][0] == 'image/jpeg') {
                    //$src = imagecreatefromjpeg($file['tmp_name']);
                    $type=".jpg";
                }elseif ($_FILES['image']['type'][0] == 'image/png') {
                    ECHO 'ffffff';
                     //$src = imagecreatefrompng($file['tmp_name']);
                    $type=".png";
                }else{
                    $this->addVar("error", 'Не допустимый формат картинки. Можно испрользовать только картинки с расширениями .jpg и .png');
                    return false;
                }
                $fname=$_FILES['image']["name"][0];
                 $file_name = "$path/img/$fname";
                 
                if (!move_uploaded_file($_FILES['image']["tmp_name"][0], $file_name)) {
                    echo "Ошибка при сохранении $file_name {$_FILES['image']["name"][0]}";                    
                }else{
                    header('Location: /cabinet/edit?postcard_id='.$pid);
                }            
        }
    }
          
    public function deleteImg(){   
        $a=Postcard::deleteImg($_POST['pid'], $_POST['name']);
        if(!empty($a)){
            $this->addVar("good", 'Картинка удалена успешно');
        }else{
            $this->addVar("good", 'Ошибка при удалении');
        }
        
        parent::main();
    }
    
    public function activ(){
        $pid=$_POST['pid'];
        if(isset($pid) && !empty($pid) && $pid= filter_var($pid, FILTER_VALIDATE_INT)){                        
            $bool=Postcard::activPostcard($pid);            
            if($bool==false){
                $this->addVar("error", 'Ошибка при создании открытки');
            }else{
                $this->addVar("good", 'OK');
            }
        }else{            
            $this->addVar("error", 'Такая открытка не существует');
        }
        parent::main();
    }
}
