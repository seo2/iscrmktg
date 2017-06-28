<?php
$ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
if ($ajax) {

	$allowedDomains = array('latam.armktg.cl', 'dev.armktg.cl', 'armktg.cl', 'www.armktg.cl','dev.iscrmktg.com','iscrmktg.com','www.http://iscrmktg.com');
	
	$referer = $_SERVER['HTTP_REFERER'];
	
	$domain = parse_url($referer); //If yes, parse referrer
	
	if(in_array( $domain['host'], $allowedDomains)) {
		require_once("../functions.php");
		
		$clxtID 	= $_POST['clxtID'];
		
		$det = $db->rawQuery("select count(*) as total from checklist_x_tienda_detalle where clxtID = $clxtID and clxtdStatus = 0");
		if($det){
			foreach ($det as $d) {
				
				$total = $d['total'];
				
			}
		}		
		
		echo $total;
	}else{
		echo 'Dominio / Host no autorizado';
	}
}else{
	echo 'El archivo no se puede llamar directamente.';
}
?>