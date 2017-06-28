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
		
		$clxtID 	 = $_POST['clxtID'];
		$clxtdClID 	 = $_POST['clxtdClID'];
		$clxtdClDID  = $_POST['clxtdClDID'];
		$clxtdCom 	 = $_POST['clxtdCom'];
		$data = Array (
			"clxtdCom" 	=> $clxtdCom
		);		
		
		$db->where("clxtID", $clxtID);
		$db->where("clxtdClID", $clxtdClID);
		$db->where("clxtdClDID", $clxtdClDID);
		$db->update('checklist_x_tienda_detalle', $data);
		
		$respuesta = '1';	

		echo $respuesta;
	}else{
		echo 'Dominio / Host no autorizado';
	}
}else{
	echo 'El archivo no se puede llamar directamente.';
}
?>