<? 
	$usuID = 160;
	include('header.php');
	

	$camID 	 	= $_GET['camID'];
	$sql  		= "select * from campana_v2 where camID = $camID";
	
  	$resultado = $db->rawQuery($sql);
	if($resultado){
		foreach ($resultado as $r) {
			$camDesc = $r['camDesc'];
			$camEst = $r['camEst'];
 		} 
    }		
	$opcion = 'Modificar';	

	
	
?>

    <div class="container" id="argumentos">
	    
		<header>
		    <span></span>
	    </header>

	    <div id="cajaposiciones">
		    <div class="col-xs-12" id="pedidohead">
		    	<h2><?= $camDesc; ?></h2>
		    </div>
			<?
				$sql  = "select * from catalogo_x_formato where camID = $camID group by formID";
				$formatos = $db->rawQuery($sql);
				if($formatos){
					foreach ($formatos as $f) {
						$formID = $f['formID'];
						
		    ?> 	
		    <div class="col-xs-12" id="pedidohead">
		    	<h2><?= get_formato($f['formID']); ?></h2>
		    </div>
			<div class="col-xs-12 posicion">		
				<div class="row">	
					<?
						$sql  = "select * from catalogo_x_formato_x_ISC where camID = $camID and formID = $formID group by catID";
						$resultado = $db->rawQuery($sql);
						if($resultado){
							foreach ($resultado as $r) {
								$catID = $r['catID'];
								$sql  = "select * from catalogo_v2 where camID = $camID and catID = $catID";
								$resultado = $db->rawQuery($sql);
								if($resultado){
									foreach ($resultado as $r) {
				    ?>   
						<div class="col-xs-6" style="margin-bottom:10px;" >
							<div class="row">
								<div class="col-xs-4">
									<img src="resize2.php?img=<?= str_replace('../', '', $r['camFile']) ; ?>&width=200&height=200&mode=fit" class="img-responsive">
								</div>
								<div class="col-xs-8">
					<?
									$sql  = "select * from catalogo_x_formato_x_ISC where camID = $camID and catID = $catID and formID = $formID";
									$resultado = $db->rawQuery($sql);
									if($resultado){
										foreach ($resultado as $ic) { ?>
										<?php echo get_isc_camp($formID,$ic['iscID']); ?> <span class="medida"><small><?php echo get_isc_med($formID,$ic['iscID']); ?></small></span><br>
							    <? 		} 
								    } ?>															
								</div>
							</div>
						</div>
						    <? 		} 
							    } ?>
				    <? 		} 
					    } ?>
				</div>	

			</div>
			    <? 		} 
				    } ?>
			<div class="clear"></div>
	    </div>
    	<div id="footer" class="blancobg">
	    	<div class="container">
		    	<div class="row">
					<div class="col-xs-12 col-md-6 col-md-offset-3 footer">
						
				    	<? 
							$back = 'campana_v2.php';		
						?>
						<div class="btn-group btn-group-lg btn-group-justified" role="group" aria-label="...">
						  <a href="<?php echo $back; ?>" 	class="btn btn-default"><i class="fa fa-chevron-left"></i> Volver</a>
						  <a href="home.php" 				class="btn btn-default"><i class="fa fa-home"></i> Home</a>
						  <a href="javascript:void();" 		class="btn btn-default" id="logoutBtn"><i class="fa fa-sign-out"></i> Salir</a>
						</div>
			    	</div>
		    	</div>
	    	</div>
    	</div>	
		
	

   
<? include('footer.php'); ?>