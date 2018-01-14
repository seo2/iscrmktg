<?
$ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
if ($ajax) {

	require_once("../functions.php");
	$allowedDomains = array($dominio);
	
	$referer = $_SERVER['HTTP_REFERER'];
	
	$domain = parse_url($referer); //If yes, parse referrer
	
	if(in_array( $domain['host'], $allowedDomains)) {
			
		$paisID 	= $_POST['paisID'];
		$usuTipo 	= $_POST['usuTipo'];
		$usuNom 	= $_POST['usuNom'];
		$usuApe 	= $_POST['usuApe'];
		$usuProv 	= $_POST['usuProv'];
		$usuEst 	= $_POST['usuEst'];
		$formato 	= $_POST['formato'];
		if($_POST['usuVMMan']){ 
			$usuVMMan 	= $_POST['usuVMMan'];
		}else{
			$usuVMMan = 0;
		}
		$usuMail 	= $_POST['usuMail'];
		$usuCanal 	= $_POST['usuCanal'];
		
		if(isset($_POST['usuID'])){
			$usuID = $_POST['usuID'];
		
			$data = Array (
				"paisID" 	=> $paisID,
				"usuTipo" 	=> $usuTipo,
				"usuNom" 	=> $usuNom,
				"usuApe" 	=> $usuApe,
				"usuMail" 	=> $usuMail,
				"usuProv" 	=> $usuProv,
				"usuVMMan" 	=> $usuVMMan,
				"usuEst" 	=> $usuEst,
				"usuCanal" 	=> $usuCanal
			);		
			$db->where("usuID", $usuID);
			$db->update('usuario', $data);
			$respuesta = '2';	
		}else{
			$usuMail = $_POST['usuMail'];
			$usuPass = $_POST['usuPass'];
			$data = Array (
				"paisID" 	=> $paisID,
				"usuTipo" 	=> $usuTipo,
				"usuNom" 	=> $usuNom,
				"usuApe" 	=> $usuApe,
				"usuMail" 	=> $usuMail,
				"usuProv" 	=> $usuProv,
				"usuVMMan" 	=> $usuVMMan,
				"usuPass" 	=> md5($usuPass),
				"usuEst" 	=> $usuEst,
				"usuCanal" 	=> $usuCanal
			);	
			//print_r($data);
			$usuID = $db->insert ('usuario', $data);	
			$respuesta = '1';	
		}

		$db->where('usuID', $usuID);
		$db->delete('usuario_x_formato');
		
		for($i=0; $i<sizeof($formato);$i++){
			$data = Array (
				"paisID" 	=> $paisID,
				"usuID" 	=> $usuID, 
				"formID" 	=> $formato[$i]
			);	
			$id = $db->insert ('usuario_x_formato', $data);	
		}

		echo $respuesta;
	}else{
		echo 'Dominio / Host no autorizado';
	}
}else{
	echo 'El archivo no se puede llamar directamente.';
}

?>