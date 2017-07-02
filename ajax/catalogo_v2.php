<?php
require_once("../functions.php");

$db = new MysqliDb (DBHOST, DBUSER, DBPASS, DBNAME);

$camID  = $_POST["camID"];

/*
$resultado = $db->rawQuery('SELECT * FROM campana_v2  WHERE camID = ? and camEst = 0', Array ($camID));
if($resultado){
	foreach ($resultado as $r) {
		$camDesc 	= $r['camDesc'];
	}
}
*/

$camDesc = '';

$resultado = $db->rawQuery('SELECT * FROM catalogo_v2  WHERE camID = ? and camEst = 0', Array ($camID));
if($resultado){
	foreach ($resultado as $r) {
		$catID = $r["catID"];
		$form = $db->rawQuery("SELECT * FROM catalogo_x_formato_x_ISC WHERE catID = camID = $catID and camID = $camID group by formID");
		if($form){
			foreach ($form as $f) {
				$formID = $f['formID'];
				$camDesc .= '<strong>'.get_formato($formID).'</strong><br>';
				$res = $db->rawQuery("SELECT * FROM catalogo_x_formato_x_ISC WHERE catID = camID = $catID and camID = $camID and formID = $formID");
				if($res){
					foreach ($res as $isc) {
						$camDesc .= get_ISC_camp_nom_med($formID,$isc['iscID']).'<br>';
					}
				}	
				
				$camDesc .= '<br>';
			}
		}	
	    $json[] = array(
	    	'value' 		=> $r["catID"], 
	    	'text' 			=> $r["camDesc"],
	    	'description' 	=> $camDesc,
	    	'imageSrc' 		=> $r["camFile"]
	    );
	}
}

$opciones = array('ddData' => $json);

header("Content-Type: application/json", true);
echo json_encode($opciones);

?>