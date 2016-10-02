<?php
class C_Tamplates extends Controller {
    protected $template = 'adm';
	
	public function main() {
		$templates_info=Templates::getAllTemplates();
		foreach($templates_info as $info){
			$fields=array(
				'name'=>explode(',',$info['fields_name']),
				'code'=>explode(',',$info['fields_code']),
			);
			for($i=0;$i<count($fields['name']['fields_name'])){
				$fields_input[]='<input type="text" value="'.$fields['name'][$i]'"><span>=</span><input type="text" value="'.$fields['code'][$i]'">';
			}
			
			$tr='<td><span>'.$info['id'].'</span></td><td><img src="'.$info['preview'].'"></td>';
			
			
		}
        $this->view = 'gallery.php';
        parent::main();
    }
}