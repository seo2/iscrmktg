<? 
session_start();
	if($_SESSION['todos']['Logged']){ 
	
	//setcookie('id', $_SESSION['todos']['id']);
 
	$usuID = $_SESSION['todos']['id'];
	
	setcookie("id", $usuID, time()+3600, "/");
 
 }elseif($_COOKIE['id']) { 
 	$usuID = $_COOKIE['id'];
 }else{ ?>
 <script>
 		window.location.replace("index.php");
 </script>
	
<?  }  ?>
<? include('header.php');	?>
<?
	$cola = '';
	if($_GET['paisID']){
		$paisID = $_GET['paisID'];
		$cola = '&paisID='.$paisID;
	}


	function pedidos_x_tienda_x_rango_fecha($tieID,$ini,$fin){
		$db = MysqliDb::getInstance();
		$sql  = "SELECT sum(b.ptdValor) as valor FROM pedido_temporal a, pedido_temporal_detalle b WHERE a.ptTS>='$ini'  AND a.ptTS< '$fin' AND a.ptTie = $tieID AND b.ptID = a.ptID AND b.ptdEst >=7";
		$valor = 0;
	  	$c = $db->rawQuery($sql);
		if($c){
			foreach ($c as $p) {
				$valor = $p['valor'];
			} 
	    } 
	    
	    return $valor;
	    
	}


	function pedidos_x_formato_x_rango_fecha($formID,$ini,$fin,$paisID){
		$db = MysqliDb::getInstance();
	
		$total = 0;
		
		$tiendas_sql  = "SELECT * from tiendas where tieForm = $formID and paisID = $paisID";
	  	$tiendas = $db->rawQuery($tiendas_sql);
		if($tiendas){
			foreach ($tiendas as $t) {
				$tieID = $t['tieID'];
				$valor = 0;
				$sql  = "SELECT sum(b.ptdValor) as valor FROM pedido_temporal a, pedido_temporal_detalle b WHERE a.ptTS>='$ini'  AND a.ptTS< '$fin' AND a.ptTie = $tieID AND b.ptID = a.ptID AND b.ptdEst >=7";
				$valor = 0;
			  	$c = $db->rawQuery($sql);
				if($c){
					foreach ($c as $p) {
						$valor = $p['valor'];
					} 
			    } 
				$total = $total + $valor;   
			} 
	    } 
			    
	    return $total;
	    
	}

	
	function pedidos_x_rango_fecha($ini,$fin){
		$db = MysqliDb::getInstance();
		$sql  = "SELECT sum(b.ptdValor) as valor FROM pedido_temporal a, pedido_temporal_detalle b WHERE a.ptTS>='$ini'  AND a.ptTS< '$fin' AND b.ptID = a.ptID AND b.ptdEst >=7";
		$valor = 0;
	  	$c = $db->rawQuery($sql);
		if($c){
			foreach ($c as $p) {
				$valor = $p['valor'];
			} 
	    } 
	    
	    return $valor;
	    
	}


	if($_GET['desde']){
		$fecini  =  $_GET['desde']; 
		$fecfin  =  $_GET['hasta']; 
	}else{
	
		if($_GET['aaaa']){
			$anoactual =  $_GET['aaaa'];
		}else{
			$anoactual =  date("Y");
		}
		$proxano   = $anoactual +1;
		
		$fecini  =  $anoactual.'-01-01'; 
		$fecfin  =  $proxano.'-01-01'; 
	
		$fecini1  =	$anoactual.'-01-01 00:00:00'; 
		$fecfin1  = $anoactual.'-02-01 00:00:00';
		$fecini2  =	$anoactual.'-02-01 00:00:00'; 
		$fecfin2  = $anoactual.'-03-01 00:00:00';
		$fecini3  = $anoactual.'-03-01 00:00:00'; 
		$fecfin3  = $anoactual.'-04-01 00:00:00';
		$fecini4  = $anoactual.'-04-01 00:00:00'; 
		$fecfin4  = $anoactual.'-05-01 00:00:00';
		$fecini5  =	$anoactual.'-05-01 00:00:00'; 
		$fecfin5  = $anoactual.'-06-01 00:00:00';
		$fecini6  =	$anoactual.'-06-01 00:00:00'; 
		$fecfin6  = $anoactual.'-07-01 00:00:00';
		$fecini7  =	$anoactual.'-07-01 00:00:00'; 
		$fecfin7  = $anoactual.'-08-01 00:00:00';
		$fecini8  =	$anoactual.'-08-01 00:00:00'; 
		$fecfin8  = $anoactual.'-09-01 00:00:00';
		$fecini9  =	$anoactual.'-09-01 00:00:00'; 
		$fecfin9  = $anoactual.'-10-01 00:00:00';
		$fecini10 =	$anoactual.'-10-01 00:00:00'; 
		$fecfin10 = $anoactual.'-11-01 00:00:00';
		$fecini11 =	$anoactual.'-11-01 00:00:00'; 
		$fecfin11 = $anoactual.'-12-01 00:00:00';
		$fecini12 =	$anoactual.'-12-01 00:00:00'; 
		$fecfin12 = $proxano.'-01-01 00:00:00';
		
	}

	
	
	if($_GET['euro']==1){
		$factor = get_rate_exchange($paisID,$anoactual);
		$currency = '€';
		if($paisID==7){ 
			$titulo   = ' em Euros <small>Tasa de cambio: €1 = COP '.$factor.'</small>';
		}else{
			$titulo   = ' en Euros <small>Tasa de cambio: €1 = COP '.$factor.'</small>';
		}
	}else{
		$factor = '1';
		$currency = get_currency($paisID);
		
		if($paisID==7){ 
			$titulo = 'em moeda local <small>'.$currency.'</small>';
		}else{
			$titulo = 'en moneda local <small>'.$currency.'</small>';
		}
	}

?>

    <div class="container-fluid" id="argumentos">
	    
		<header>
		    <span>Dashboard</span>
	    </header>

	    <div id="cajaposiciones" >
		    
		    <div id="pedidohead">
			    <div class="row">
			    	<div class="col-xs-6">
						<h2><? if($paisID==7){ ?>Resumo por lojas<? }else{ ?>Resumen por Tiendas<? } ?> <?php echo $titulo; ?></h2> 
			    	</div>
			    	<div class="col-xs-6 text-right hide">
			  			<form method="get" id="formFechas" class="form-inline">
			  				<div class="form-group">
								<label>Desde:</label>
								<input type="date" class="form-control" name="desde" required value="<?= $fecini; ?>">
							</div>	
							<div class="form-group">
								<label>Hasta:</label>
								<input type="date" class="form-control" name="hasta" required value="<?= $fecfin; ?>">
							</div>	
							<div class="form-group">
								<button type="submit" class="btn btn-primary " ><i class="fa fa-refresh" aria-hidden="true"></i></button>
							</div>
			  			</form>
			    	</div>
			    	<div class="col-xs-6 text-right">
			  			<form method="get" id="formFechas" class="form-inline">
				  			
				  			
							<div class="form-group">
								<label for="exampleInputName2">Año</label>
								<select class="form-control" id="aaaa" name="aaaa">
								  <option value="2017" <? if($_GET['aaaa'] && $_GET['aaaa'] == '2017'){ ?>selected<? } ?>>2017</option>
								  <option value="2016" <? if($_GET['aaaa'] && $_GET['aaaa'] == '2016'){ ?>selected<? } ?>>2016</option>
								</select>
							</div>
				  			
				  			
							<div class="form-group">
								<a class="btn btn-primary" href="dashboard-excel.php?aaaa=<?= $anoactual; ?>" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a>
							</div>
				  			
				  			
							<div class="form-group">
								<?
								if($_GET['euro']==1){
								?>
								<a class="btn btn-primary" href="dashboard.php?aaaa=<?= $anoactual.$cola; ?>"><small><strong><?php echo get_currency($paisID); ?></strong></small></a>
								<?
								}else{
								?>
								<a class="btn btn-primary" href="dashboard.php?aaaa=<?= $anoactual.$cola; ?>&euro=1"><i class="fa fa-eur" aria-hidden="true"></i></a>
								<?
								}
								?>
							</div>
			  			</form>
			    	</div>
			    </div>
		    </div>
			<?
				
	/*
		
		ESTADOS:
		
		Solicitado: 			0 // creado por VM
		Para revisión: 			1 // A la espera de MM
		Objetado:				2 // Rechazado por MM
		Aprobado:				3 // Aprobado por MM --> traspasado a Proveedor --> para cotizar
		
		Cotizado:				4 // Recibido por Proveedor, ingresó precio y envió a MM
		Cotizacion Aprobada: 	5 // Cotización aprobada por MM --> Proveedor debe ingresar precio
		Ongoing:   				6 // Proveedor compromete fecha de entrega
		
		Entregado:				7 // Entregado por Proveedor
		Finalizado:				8 // Recepcionado por VM
		
	*/					
				
				
			
?>



					<div class="row">		
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">
									<table class="table table-bordered table-hover table-condensed dashboard" id="latabla">
									  <thead>
										  <tr >
										  	<? if($paisID==7){ ?>	
											  <th>Formatos / Lojas</th>
											  <th>% Sobre Total</th>
											  <th>% Sobre Formato</th>
											  <th>Total</th>
											  <th class="text-center">Jan</th>
											  <th class="text-center">Fev</th>
											  <th class="text-center">Mar</th>
											  <th class="text-center">Abr</th>
											  <th class="text-center">Mai</th>
											  <th class="text-center">Jun</th>
											  <th class="text-center">Jul</th>
											  <th class="text-center">Ago</th>
											  <th class="text-center">Set</th>
											  <th class="text-center">Out</th>
											  <th class="text-center">Nov</th>
											  <th class="text-center">Dez</th>
										  	<? }else{ ?>
											  <th>Formatos / Tiendas</th>
											  <th>% Sobre Total</th>
											  <th>% Sobre Formato</th>
											  <th>Total</th>
											  <th class="text-center">Ene</th>
											  <th class="text-center">Feb</th>
											  <th class="text-center">Mar</th>
											  <th class="text-center">Abr</th>
											  <th class="text-center">May</th>
											  <th class="text-center">Jun</th>
											  <th class="text-center">Jul</th>
											  <th class="text-center">Ago</th>
											  <th class="text-center">Sep</th>
											  <th class="text-center">Oct</th>
											  <th class="text-center">Nov</th>
											  <th class="text-center">Dic</th>
										  	<? } ?>	
										  </tr>
									  </thead>   
									  <tbody>
<?
	
	
				$sumaTotal = pedidos_x_rango_fecha($anoactual.'-01-01 00:00:00',$proxano.'-01-01 00:00:00')/$factor;
	
	
				$tipo_formato_sql  = "SELECT * from tipo_formato";
			  	$tipo_formato_sql = $db->rawQuery($tipo_formato_sql);
				if($tipo_formato_sql){
					foreach ($tipo_formato_sql as $f) {
						$tipforID 	= $f['tipforID'];
						$tipforDesc	= $f['tipforDesc'];
?>
										<tr class="formato">
											<td><strong><?= $tipforDesc; ?></strong></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
<?
						$formatos_sql  = "SELECT * from formatos where formTipo = $tipforID order by formOrder";
					  	$formatos = $db->rawQuery($formatos_sql);
					  	$TotalFormato = 0;
						if($formatos){
							foreach ($formatos as $f1) {
								$formID 	= $f1['formID'];
								$formato	= $f1['formDesc'];
								$TotalFormato = $TotalFormato + (pedidos_x_formato_x_rango_fecha($formID,$anoactual.'-01-01 00:00:00',$proxano.'-01-01 00:00:00',$paisID)/$factor);


				// Tiendas por formatos
	
				$tiendas_sql  = "SELECT * from tiendas where tieForm = $formID and paisID = $paisID  order by tieID";
			  	$tiendas = $db->rawQuery($tiendas_sql);
				if($tiendas){
					foreach ($tiendas as $t) {
						$tieID = $t['tieID'];
						$total 	= 0;
				// Pedidos por tienda
						$ini = $anoactual.'-01-01 00:00:00';
						$fin = $proxano.'-01-01 00:00:00';
						$pedidos_sql  = "SELECT * from pedido_temporal where ptTie = $tieID and ptTS>='$ini' AND ptTS< '$fin'";
					  	$pedidos = $db->rawQuery($pedidos_sql);
						if($pedidos){
							foreach ($pedidos as $p) {
								$ptID = $p['ptID'];
												
					// Detalle Pedidos
							$detalle_sql  = "SELECT * from pedido_temporal_detalle where ptID = $ptID and ptdEst >= 7";
						  	$detalle = $db->rawQuery($detalle_sql);
							if($detalle){
								foreach ($detalle as $d) {
									
									$total = $total + ($d['ptdValor']/$factor);
									
								} 
						    } 
								
								
								
							} 
					    } 
?>										  
										<tr class="tienda" id="tienda-<?= $tieID; ?>">
											<td class="text-right"><?= str_replace('Tienda','', $t['tieNom']) ; ?>
											<? if($t['tieForm']==7){ ?><small>(HC Evolucion)</small><? } ?>
											
											</td>
											<? 
											if($sumaTotal>0){
												$porcSobreTotal = round(($total / $sumaTotal)*100,0); 
											}else{
												$porcSobreTotal = 0;
											}	
											?>
											<td class="text-right"><?= $porcSobreTotal; ?>%</td>
											<? 
											if($TotalFormato>0){
												$porcSobreFormato = round(($total / $TotalFormato)*100,0); 
											}else{
												$porcSobreFormato = 0;
											}	
											?>
											<td class="text-right"><?= $porcSobreFormato; ?>%</td>
											<? if($_GET['euro']==1){ ?>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($total,2,',','.'); ?></td>
											<? }else{ ?>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($total,0,',','.'); ?></td>
											<? } ?>
											
											
											<?
											
												$ene =	pedidos_x_tienda_x_rango_fecha($tieID,$fecini1,$fecfin1) / $factor;
												$feb =	pedidos_x_tienda_x_rango_fecha($tieID,$fecini2,$fecfin2) / $factor;
												$mar = 	pedidos_x_tienda_x_rango_fecha($tieID,$fecini3,$fecfin3) / $factor;
												$abr = 	pedidos_x_tienda_x_rango_fecha($tieID,$fecini4,$fecfin4) / $factor;
												$may =	pedidos_x_tienda_x_rango_fecha($tieID,$fecini5,$fecfin5) / $factor;
												$jun =	pedidos_x_tienda_x_rango_fecha($tieID,$fecini6,$fecfin6) / $factor;
												$jul =	pedidos_x_tienda_x_rango_fecha($tieID,$fecini7,$fecfin7) / $factor;
												$ago =	pedidos_x_tienda_x_rango_fecha($tieID,$fecini8,$fecfin8) / $factor;
												$sep =	pedidos_x_tienda_x_rango_fecha($tieID,$fecini9,$fecfin9) / $factor;
												$oct =	pedidos_x_tienda_x_rango_fecha($tieID,$fecini10,$fecfin10) / $factor;
												$nov =	pedidos_x_tienda_x_rango_fecha($tieID,$fecini11,$fecfin11) / $factor;
												$dic =	pedidos_x_tienda_x_rango_fecha($tieID,$fecini12,$fecfin12) / $factor;
												
												$totform0  = $totform0 + $total;
												$totform1  = $totform1 + $ene; 
												$totform2  = $totform2 + $feb; 
												$totform3  = $totform3 + $mar; 
												$totform4  = $totform4 + $abr; 
												$totform5  = $totform5 + $may; 
												$totform6  = $totform6 + $jun; 
												$totform7  = $totform7 + $jul; 
												$totform8  = $totform8 + $ago; 
												$totform9  = $totform9 + $sep; 
												$totform10 = $totform10 + $oct;
												$totform11 = $totform11 + $nov;
												$totform12 = $totform12 + $dic;											
												
												$tot0  = $tot0 + $total;
												$tot1  = $tot1 + $ene;
												$tot2  = $tot2 + $feb;
												$tot3  = $tot3 + $mar;
												$tot4  = $tot4 + $abr;
												$tot5  = $tot5 + $may;
												$tot6  = $tot6 + $jun;
												$tot7  = $tot7 + $jul;
												$tot8  = $tot8 + $ago;
												$tot9  = $tot9 + $sep;
												$tot10 = $tot10 + $oct;
												$tot11 = $tot11 + $nov;
												$tot12 = $tot12 + $dic;
												if($_GET['euro']==1){
											?>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($ene,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($feb,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($mar,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($abr,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($may,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($jun,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($jul,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($ago,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($sep,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($oct,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($nov,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($dic,2,',','.'); ?></td>
											<?			
												}else{
											?>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($ene,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($feb,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($mar,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($abr,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($may,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($jun,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($jul,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($ago,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($sep,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($oct,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($nov,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($dic,0,',','.'); ?></td>
											<?		
												}											
											?>
										</tr>
							
										
		    <? 		} 
			    } 

							}
						}
						if($sumaTotal>0){
							$PorcTotal	  = round(($TotalFormato / $sumaTotal)*100,0);	
						}else{
							$PorcTotal	  = 0;	
						}	
			?>										  

										

	
										<tr class="totalformato" >
											
											<td class="text-right">Total Formato <?= $tipforDesc; ?>:</td>
											<td class="text-right"><?= $PorcTotal; ?>%</td>
											<td class="text-right"></td>
											<?
												if($_GET['euro']==1){
											?>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform0,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform1,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform2,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform3,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform4,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform5,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform6,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform7,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform8,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform9,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform10,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform11,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform12,2,',','.'); ?></td>
											<?			
												}else{
											?>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform0,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform1,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform2,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform3,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform4,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform5,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform6,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform7,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform8,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform9,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform10,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform11,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($totform12,0,',','.'); ?></td>
											<?		
												}											
											?>
										</tr>
										
										
		    <? 		
			    
			    
						$totform0  = 0;
						$totform1  = 0;
						$totform2  = 0;
						$totform3  = 0;
						$totform4  = 0;
						$totform5  = 0;
						$totform6  = 0;
						$totform7  = 0;
						$totform8  = 0;
						$totform9  = 0;
						$totform10 = 0;
						$totform11 = 0;
						$totform12 = 0;
			    
			    	} 
			    } ?>										
										<tr class="totales" >
											<td class="text-right">TOTAL:</td>
											<td></td>
											<td></td>
											<?
												if($_GET['euro']==1){
											?>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot0,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot1,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot2,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot3,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot4,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot5,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot6,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot7,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot8,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot9,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot10,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot11,2,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot12,2,',','.'); ?></td>
											<?			
												}else{
											?>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot0,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot1,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot2,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot3,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot4,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot5,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot6,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot7,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot8,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot9,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot10,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot11,0,',','.'); ?></td>
											<td class="text-right"><small><?= $currency; ?></small> <?= number_format($tot12,0,',','.'); ?></td>
											<?		
												}											
											?>
										</tr>										
									  </tbody>
								  </table>            
								</div>
							</div>
						</div><!--/col-->
					
					</div><!--/row-->			    
			    
				<div class="clear"></div>
		    </div>

	    	<footer>
		    	<? 
				if($_GET['paisID']){ ?>
		    	<a href="paises.php" id="btnvolver"><i class="fa fa-chevron-left"></i> <span><? if($paisID==7){ ?>Voltar<? }else{ ?>Volver<? } ?></span></button>
				<? }else{ ?>
		    	<a href="home.php" id="btnvolver"><i class="fa fa-chevron-left"></i> <span><? if($paisID==7){ ?>Voltar<? }else{ ?>Volver<? } ?></span></button>
				<? } ?>
	    	</footer>	    



   
        </div><!-- fin container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

	<script src="assets/js/tableExport.js">
	<script src="assets/js/jquery.base64.js">
		
		
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="//oss.maxcdn.com/jquery.form/3.50/jquery.form.min.js"></script>
    <script src="assets/js/formValidation.min.js"></script>
    <script src="assets/js/language/es_ES.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js"></script>
	<script src="assets/js/framework/bootstrap.min.js"></script>
    
	<script src="assets/js/jquery.validate.js"></script>
    
    <script src="assets/js/sweetalert.min.js"></script>
    <script src="assets/js/jquery.ddslick.min.js"></script>

    <script src="assets/js/visualapp.js?ver=2.4"></script>
   
   
<!--
	<script>
		$(document).ready(function(){
		    $('.datatable').DataTable({
			    "order": [],
			    "paging": false,
			    "language": {
					"thousands": "."
				 }
		    });
		});
	</script>
-->
    
    
  </body>
</html>