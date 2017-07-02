<?php
$ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
if ($ajax) {

	$allowedDomains = array($dominio);
	
	$referer = $_SERVER['HTTP_REFERER'];
	
	$domain = parse_url($referer); //If yes, parse referrer
	
	if(in_array( $domain['host'], $allowedDomains)) {
		require_once("../functions.php");
	
		$clxtID 	= $_POST['clxtID'];
		$sql  		= "select * from checklist_x_tienda where clxtID = $clxtID";
		
	    $resultado = $db->rawQuery($sql);
		if($resultado){
			foreach ($resultado as $r) {
				$clxtTie = $r['clxtTie'];
				$clxtCL  = $r['clxtCL'];
				$clxtMM  = $r['clxtMM'];
				$clxtCom = $r['clxtCom'];
				$clxtEst = $r['clxtEst'];
				$clxtTs  = $r['clxtTS'];
			}
		}
	
	
		$to = get_user_mail($clxtMM);
		
		//$to = 'seodos@gmail.com';
		
		$tienda 	= get_tienda($clxtTie);
		$checklist 	= get_checklist_nom($clxtCL);
		$date 		= date('d/m/Y');
		$formato 	= get_formato(get_formato_tienda($clxtTie));
		$fecha 		= substr($clxtTs,8,2) . '/'. substr($clxtTs,5,2) .'/'. substr($clxtTs,0,4);
		$hora  		= substr($clxtTs,11,8);
						
		$subject = 'Checklist '.$clxtID.': '.$tienda.' - '.$checklist.' '.$date.'';
		$headers = "From: " . "<no-reply@iscrmktg.com> Adidas Retail Marketing" . "\r\n";
		$headers .= "CC: mc@seo2.cl\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

		$message  = '<html><head></head><body style="font-family: Helvetica, Arial, sans-serif;">';
		$message .= '<div><img src="http://iscrmktg.com/assets/img/cabeceramail.png"></div>';	
		
		$message .= '<div style="color: #000; height: 20px; line-height: 20px; text-transform: uppercase; font-weight: 100; padding-left:9px">';
	    $message .=  $tienda.' | '. $formato;
		$message .= '</div>';

		$message .= '<div style="line-height: 20px; height:20px; padding: 0 9px;">';
		$message .= '<h2 style="margin: 0; font-size: 15px; font-weight: lighter;"><strong>'. $checklist .'</strong> <span>'. $fecha .'</span></h2>';
		$message .= '</div>';

		$sql  		= "select * from checklist_detalle where clID = $clxtCL group by cldZona";
	    $resultado = $db->rawQuery($sql);
		if($resultado){
			foreach ($resultado as $r) {
				$cldID 	  = $r['cldID'];
				$cldZona  = $r['cldZona'];
				$message .= '<div style="padding: 25px 10px 5px; color: #2196f3; font-weight:lighter;border-bottom: 2px solid #2196f3;">';
				$message .= get_zona($cldZona).':';
				$message .= '</div>';
				
				$sql  		= "select * from checklist_detalle where clID = $clxtCL and cldZona = $cldZona";
			    $resultado = $db->rawQuery($sql);
				if($resultado){
					foreach ($resultado as $r) {
						$cldID 	 = $r['cldID'];
						$cldItem = $r['cldItem'];
						$cldCom  = $r['cldCom'];
						
						$sql  		= "select * from checklist_x_tienda_detalle where clxtID = $clxtID and clxtdClID = $clxtCL and clxtdClDID = $cldID";
					    $resultado = $db->rawQuery($sql);
						if($resultado){
							foreach ($resultado as $r) {
								$clxtdStatus 	= $r['clxtdStatus'];
								$clxtdCom 		= $r['clxtdCom'];	

								$message .= '<div style="border-bottom: 1px solid #ccc; position: relative;">';
								$message .= '<div style="font-size: 16px; padding: 10px 9px;color: #000;">';
								$message .= '<strong>'. $cldItem .'</strong>';
					
								if($clxtdStatus==1){
									$message .= ' <span class="statusOK" style="color: #5cb85c;font-size: 12px;">OK</span>';
								}elseif($clxtdStatus==2){
									$message .= ' <span class="statusNotOK" style="color: #d9534f;font-size: 12px;">Not OK</span>';
								}elseif($clxtdStatus==3){
									$message .= ' <span class="statusNoAplica" style="color: #333;font-size: 12px;">No aplica</span>';
								}
				
								$message .= '</div>';
								$message .= '<div style="padding-left:10px ">';
								$message .= '<p style="margin: 5px 0 10px; font-size: 12px;">'.$clxtdCom.'</p>';
								$message .= '</div>';

								// Fotos Adjuntas
								$message .= '<div class="row" id="fotitos" style="padding: 0 0 0 10px;">';
					
								$sql = "select * from checklist_x_tienda_detalle_fotos where clxtID = $clxtID and clxtdClID = $clxtCL and clxtdClDID = $cldID";
							    $resultado = $db->rawQuery($sql);
								if($resultado){
									foreach ($resultado as $r) {
										$clxtdfFile 	= $r['clxtdfFile'];
									
										$message .= '<div style="margin: 0 10px 10px 0;  width: 300px; border: 1px solid #ccc; padding: 5px">';
										$message .= '<img src="http://iscrmktg.com/resize3.php?img=ajax/uploads/'.$clxtdfFile.'&width=400&height=400&mode=fit" style="width: 100%; height: auto;">';
										$message .= '</div>';
									}
								}
								$message .= '<div style="clear:both;"></div>';
								$message .= '</div>';					
								$message .= '</div>';	
							}
						}			
					}
				}
			}
		}							
			
		$message .= '<div style="padding: 25px 10px 5px; color: #000; font-weight:lighter;border-bottom: 2px solid #000; margin-bottom:10px;">';
		$message .= 'Comentario y conclusiones:';
		$message .= '</div>';
		$message .= '<div style="border-bottom: 1px solid #000; position: relative;">';
		$message .= '<div style="padding-left:10px ">';
		$message .= '<p style="margin: 5px 0 10px; line-height:150%;">'.$clxtCom.'</p>';
		$message .= '<p><strong>'. get_user_nombre($clxtMM) .'</strong></p>';
		$message .= '</div>';					
		$message .= '</div>';				
		$message .= '</div>';
		$message .= '</body></html>';
	
 
		mail($to, $subject, $message, $headers);
	
		$data = Array (
			"clxtEst" 	=> 1
		);		
		$db->where("clxtID", $clxtID);
		$db->update('checklist_x_tienda', $data);
	
		echo 1;
	}else{
		echo 'Dominio / Host no autorizado';
	}
}else{
	echo 'El archivo no se puede llamar directamente.';
}
?>