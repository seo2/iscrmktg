<? 
	
session_start();
	if($_SESSION['todos']['Logged']){ 
 
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
?>

    <div class="container" id="argumentos">
	   
		<header>
		    <span><? if($paisID==7){ ?>Lojas<? }else{ ?>Tiendas<? } ?> <?= $formato; ?> <?php echo $canalDesc; ?></span>
	    </header>
		   
		    <div id="cajaposiciones" >
			    <div class="col-xs-12 col-md-6 col-md-offset-3" id="pedidohead">
					<div class="row">
				    	<div class="col-xs-9">
							<form class="horizontal-form" role="search">
								<div class="form-group">
									<select class="form-control" name="tieForm" id="formID" data-canal="<?php echo $canalID; ?>">
										<option value="">Filtrar por formato</option>
										<?
											if($_GET['tieform'] ){
												$tieForm = $_GET['tieform'];
											}else{
												$tieForm = 0;
											}
										$tema = $db->rawQuery('select * from formatos order by formDesc');
										if($tema){
											foreach ($tema as $t) {
										?>
										<option value="<?= $t['formID']; ?>" <? if($t['formID']==$tieForm){ ?>selected<? } ?>><?= $t['formDesc']; ?></option>
										<?		
											}
										}
										?>
									</select>
								</div>
							</form>
						</div>							
					
				    	<div class="col-xs-3 text-right">
					    	<?php if($usuTipo==1){ ?>
				    		<a href="formulario-tiendas.php?tieCanal=<?php echo $tieCanal; ?>" class="btn btn-default"><span class="hidden-xs"><? if($paisID==7){ ?>Adicionar<? }else{ ?>Agregar<? } ?> </span><i class="fa fa-plus-circle"></i></a>
				    		<?php } ?>
				    	</div>
					</div>
				</div>
			    
			<?
					
				if($_GET['tieform'] && $_GET['tieform'] >0){
					$formID = $_GET['tieform'];
					$sql0  = "select * from formatos where formID = $formID";
				}else{
					$sql0  = "select * from formatos order by formOrder";
				}

			
		  	$formatos = $db->rawQuery($sql0);
			if($formatos){
				foreach ($formatos as $f) {				
				$formID = $f['formID'];
				$sql  = "select * from tiendas where tieForm = $formID and paisID = $paisID and tieCanal = $canalID order by tieNom";
			  	$resultado = $db->rawQuery($sql);
				if($resultado){
					foreach ($resultado as $r) {
							if($r['tieEst']==1){ 
								$estado = 'off';
								$estDesc = 'Inactivo';						
							}else{ 
								$estado = 'on';
								$estDesc = 'Activo';
							} 
							$paises = '';
							$formID  = $r['formID'];
		    ?>   
		    
				<div class="col-xs-12 col-md-6 col-md-offset-3 posicion" id="tienda-<?= $r['tieID']; ?>">
					<div class="row">
						<div class="col-xs-2 col-sm-1">
							<a href="javascript:void(0)" data-camid="<?php echo $formID; ?>" data-estado="<?php echo $estado; ?>" class="cambiaEstado" data-toggle="tooltip" data-placement="right"  title="<?php echo $estDesc; ?>">
								<i class="fa fa-toggle-<?php echo $estado; ?>" aria-hidden="true"></i></span>
							</a>
						</div>
						<div class="col-xs-7 col-sm-8 postema nopadl nopadr">
							<?php if($usuTipo==1){ ?><a href="formulario-tiendas.php?tieID=<?= $r['tieID']; ?>"><?php } ?><?= $r['tieNom']; ?><?php if($usuTipo==1){ ?></a><?php } ?>
							<br><span><?= get_formato($r['tieForm']); ?></span>
							<? if($r['tieFono']){ ?>
							<br><span><strong>Usuario: </strong><?= get_user_nombre($r['tieFono']); ?></span>
							<? } ?>
						</div>
						<div class="col-xs-3 text-right posvotos">
							<?php if($usuTipo==1){ ?>
							<a href="formulario-tiendas.php?tieID=<?= $r['tieID']; ?>" class="btn btn-default"><i class="fa fa-edit"></i> <span class="hidden-xs">Editar</span></a> 
							<?php } ?>
						</div>
					</div>

				</div>
		    <? 		} 
			    } ?>
		    <? 		} 
			    } ?>
			    	
			    		    
		    </div>

	    	<div id="footer" class="blancobg">
		    	<div class="container">
			    	<div class="row">
						<div class="col-xs-12 col-md-6 col-md-offset-3 footer">
							
					    	<? 
								$back = 'maestros.php';
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




