<?
$ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
if ($ajax) {

	$allowedDomains = array('latam.armktg.cl', 'dev.armktg.cl', 'armktg.cl', 'www.armktg.cl','dev.iscrmktg.com','iscrmktg.com','www.http://iscrmktg.com');
	
	$referer = $_SERVER['HTTP_REFERER'];
	
	$domain = parse_url($referer); //If yes, parse referrer
	
	if(in_array( $domain['host'], $allowedDomains)) {
		
		require_once("../functions.php");
		
		date_default_timezone_set('America/Santiago');
				
		$clID 	 = $_POST['clID'];
		$cldZona = $_POST['cldZona'];
		$cldItem = $_POST['cldItem'];
		$cldCom  = $_POST['cldCom'];
		$cldEst  = $_POST['cldEst'];
		
		$data = Array (
			"clID" 		=> $clID,
			"cldZona" 	=> $cldZona,
			"cldItem" 	=> $cldItem,
			"cldCom" 	=> $cldCom,
			"cldEst" 	=> $cldEst
		);		
		
		if($_POST['cldID']){			
			$cldID = $_POST['cldID'];
			$db->where("clID", $clID);
			$db->where("cldID", $cldID);
			$db->update('checklist_detalle', $data);
			
			$respuesta = '2';	
		}else{
			
			$id = $db->insert ('checklist_detalle', $data);
			
			$respuesta = '1';		
		}
		
		echo $respuesta;
	}else{
		echo 'Dominio / Host no autorizado';
	}
}else{
	echo 'El archivo no se puede llamar directamente.';
}
?>