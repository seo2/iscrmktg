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
<? 
	include('header.php');
	
	$formID = $_GET['formID'];
	
	$formato = get_formato($formID);
	$total = 0;
	$faltan = 0;
?>

    <div class="container" id="argumentos" style="    padding-bottom: 100px;">
	        
		<header>
		    <span>Imágenes faltantes</span>
	    </header>
		   
		    <div id="cajaposiciones" >
			    <div class="col-xs-12 col-md-6 col-md-offset-3" id="pedidohead">
				    <div class="row">
				    	<div class="col-xs-6">
							<h2><?= $formato; ?></h2>
				    	</div>
				    	<div class="col-xs-6 text-right">
					    	<? if($usuTipo == 99){ ?>
				    	<a href="formulario-pieza_v3.php?formID=<?= $formID; ?>" class="btn btn-default"><span class="hidden-xs">Agregar </span><i class="fa fa-plus-circle"></i></a>
				    	<? } ?>
				    	</div>
				    </div>
			    </div>
			<?

				$sql  = "select * from instores_v3 where formID = $formID  and insEst = 0 order by insNomGen";

			  	$resultado = $db->rawQuery($sql);
				if($resultado){
					foreach ($resultado as $r) {
						$opciones = get_total_opciones_instores_v3($formID, $r['insID']);
					?>
					
					<?
				$pieID =  $r['insID'];
				if($usuTipo==99){
					$pieza = get_instore_desc_v3($formID,$pieID);	
				}else{
					$pieza = get_instore_nom_x_pais_v3($paisID, $formID, $pieID) ;
				}
				$insNomGen  = get_instore_gen_v3($formID, $pieID);
				$ruta 		= get_carpeta_ISC_v3($formID);
				$sql2  	= "select * from instores_opciones_v3 where formID = $formID and insID = $pieID and insOPEst = 0 order by insOpNom";
				
				$i = 0;
				$falta = 0;
			  	$resultado2 = $db->rawQuery($sql2);
				if($resultado2){
					foreach ($resultado2 as $r2) {
						$total++;
		    ?>   
		    			<?
								$existe  = 1;
								if($r2['insOpFoto']){ 
									$archivo = '/ajax/uploads/ISC/'.$r2['insOpFoto'];
								}else{
									$archivo = '/'.$ruta.quitatodo($insNomGen).quitatodo($r2["insOpNom"]).'.jpg';
									$raiz = 'http://iscrmktg.com';
								  	if(!is_url_exist($raiz.$archivo)){
										$archivo = '/'.$ruta.quitatodo($insNomGen).quitatodo($r2["insOpNom"]).'.png';
										if(!is_url_exist($raiz.$archivo)){
											$existe  = 0;
											$faltan++;
											$falta++;
										}
								  	}									
									
								}
								if($existe  == 0){
									$i++;
									
									if($i == 1){ 
										$ok = 1;
								?>
								
						
				<div class="col-xs-12 col-md-6 col-md-offset-3 posicion">		
					<div class="row">
						<div class="col-xs-12 postema">
							<a href="opciones_v3.php?pieID=<?= $r['insID']; ?>&formID=<?= $formID; ?>"><?= $r['insNomGen']; ?></a>
							<small><i class="fa fa-list" aria-hidden="true"></i> <?= $opciones ; ?></small>
							<? if($usuTipo<99){ ?>
							<br><small><?php echo get_instore_nom_x_pais_v3($paisID, $r['formID'], $r['insID']) ; ?></small>
							<? }else{ ?>
							<br><small><?php echo $r['insNomGes'] ; ?></small>
							<? } ?>
							<? if($usuTipo>99){ ?>
							<br><span><i class="fa fa-user" aria-hidden="true"></i> | <i class="fa fa-cog" aria-hidden="true"></i></span>
							<? } ?>
						</div>
					</div>
							<? } ?>
								
						<div class="col-xs-12 posicion">
							<div class="row">
								<?  if($r2['insOpCat']==0){ ?>
		<div class="col-xs-9 postema">
									<?= $r2['insOpNom']; ?><br>
									<small><?php echo $archivo; ?></small>
											
									<? }else{ ?>
									<small><i>Selecciona imagen del catálogo</i></small>
									<? } ?>
								</div>
								<div class="col-xs-3 text-right posvotos">
									<a href="formulario-pieza-opciones_v3.php?formID=<?= $formID; ?>&insID=<?= $pieID; ?>&insOpID=<?= $r2['insOpID']; ?>" class="btn btn-default">
									<? if($usuTipo==99){ ?>
										<i class="fa fa-edit"></i>
									<? }else{ ?>
										<i class="fa fa-eye"></i>
									<? } ?></a>
								</div>						
							</div>
		
						</div>
		    <? 			} 
			    	}
			    } 
			    if($ok == 1){ 
				    $ok = 0;
			    ?>
				
				</div>
				
				
		    <? 		}
										$i =0;
			    	} 
			    } ?>	    		    
		    </div>
		    	 
	    	<div id="footer" class="blancobg">
		    	<div class="container">
			    	<div class="row">
						<div class="col-xs-12 col-md-6 col-md-offset-3 text-center">
							<p>Total: <?php echo ($total-$faltan); ?> imágenes / Faltan <?php echo $faltan; ?> de <?php echo $total; ?></p>
						</div>
			    	</div>
			    	<div class="row">
						<div class="col-xs-12 col-md-6 col-md-offset-3 footer">
		
			    	<?

							$back = 'formatos.php?piezas=1&FW2017=1';
					?>							
							<div class="btn-group btn-group-lg btn-group-justified" role="group" aria-label="...">
							  <a href="<?php echo $back; ?>" 	class="btn btn-default"><i class="fa fa-chevron-left"></i> <? if($paisID==7){ ?>Voltar<? }else{ ?>Volver<? } ?></a>
							  <a href="home.php" 				class="btn btn-default"><i class="fa fa-home"></i> Home</a>
							  <a href="javascript:void();" 		class="btn btn-default" id="logoutBtn"><i class="fa fa-sign-out"></i> <? if($paisID==7){ ?>Sair<? }else{ ?>Salir<? } ?></a>
							</div>
				    	</div>
			    	</div>
		    	</div>
	    	</div>	    
   

		    
<? include('footer.php'); ?>