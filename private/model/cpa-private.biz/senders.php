<?

class Senders{	
	static public function getSendersByParentId($id){
		
		if(isset($id) && !empty($id) && filter_var($id, FILTER_VALIDATE_INT)){
                    if($id == 11){
                        $id .= ',28,46';
                    }
			$q = 'select * from senders where partner_id in ('.$id.')';
			return IOMysqli::table($q);
		}else{
			return false;
		}
	}
	
	static public function getSenderById($id){
		if(isset($id) && !empty($id) && filter_var($id, FILTER_VALIDATE_INT)){
			$q = 'select * from senders where id='.$id;
			return IOMysqli::row($q);
		}else{
			return false;
		}
	}
}