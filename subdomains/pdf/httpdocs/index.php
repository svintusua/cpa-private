<?
error_reporting(-1);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
require_once("dompdf/dompdf_config.inc.php");

// $html =
// '<html><meta http-equiv="content-type" content="text/html; charset=utf-8" /><body>'.
// '<p>Теперь решим проблему с шрифтами в domPDF!</p>'.
// '</body></html>';
$dompdf = new DOMPDF(); 
$orders = json_decode($_GET['orders_id'], true);
$from = $_GET['from_name'];
if($_GET['blank_count'] == 1){
	$blank_type = $_GET['blank_type'];
	// foreach($orders as $v){
		$html = file_get_contents('http://cpa-private.biz/blanks/?orders_id='.$_GET['orders_id'].'&from_name='.$from.'&blank_type='.$blank_type);
		// var_dump($html);
		// exit;
		// $dompdf->load_html($html);
		// $dompdf->addpage();
	// }	
}else{
	// foreach($orders as $v){
		$html = file_get_contents('http://cpa-private.biz/blanks/?orders_id='.$_GET['orders_id'].'&from_name='.$from.'&blank_type=f7');

		$html .= file_get_contents('http://cpa-private.biz/blanks/?orders_id='.$_GET['orders_id'].'&from_name='.$from.'&blank_type=f112');
		
		// $dompdf->addpage();
	// }	
}


$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('blank_'.date('d-m-Y').'.pdf'); // Выводим результат (скачивание)

?>