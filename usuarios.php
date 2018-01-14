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
?>

    <div class="container" id="argumentos">
	    
	    
		<header>
		    <span><? if($paisID==7){ ?>Usuários<? }else{ ?>Usuarios<? } ?> <?php echo $canalDesc; ?></span>
	    </header>
		   
		    <div id="cajaposiciones" >
			    <div class="col-xs-12 col-md-6 col-md-offset-3" id="pedidohead">
				    <div class="row">
				    	<div class="col-xs-6">
							<h2><? if($paisID==7){ ?>Tudo<? }else{ ?>Todos<? } ?></h2>
				    	</div>
				    	<div class="col-xs-6 text-right">
				    		<a href="formulario-usuarios.php?canalID=<?php echo $canalID; ?>" class="btn btn-default"><span class="hidden-xs"><? if($paisID==7){ ?>Adicionar<? }else{ ?>Agregar<? } ?> </span><i class="fa fa-plus-circle"></i></a>
				    	</div>
				    </div>
			    </div>
			<?
				$sql  = "select * from usuario where paisID = $paisID and usuCanal = $canalID and usuTipo NOT IN(3,5) order by usuTipo, usuID";
				$resultado = $db->rawQuery($sql);
				if($resultado){
					foreach ($resultado as $r) {
							if($r['usuEst']==1){ 
								$estado = 'off';
								$estDesc = 'Inactivo';						
							}else{ 
								$estado = 'on';
								$estDesc = 'Activo';
							} 
		    ?>   
				<div class="col-xs-12 col-md-6 col-md-offset-3 posicion <?= $tipo; ?>" id="usuario-<?= $r['usuID']; ?>">
					<div class="row">
						<div class="col-xs-2 col-sm-1">
							<a href="javascript:void(0)" data-camid="<?php echo $formID; ?>" data-estado="<?php echo $estado; ?>" class="cambiaEstado" data-toggle="tooltip" data-placement="right"  title="<?php echo $estDesc; ?>">
								<i class="fa fa-toggle-<?php echo $estado; ?>" aria-hidden="true"></i></span>
							</a>
						</div>
						<div class="col-xs-7 col-sm-8 postema nopadl nopadr">
							<a href="formulario-usuarios.php?usuID=<?= $r['usuID']; ?>"><?= $r['usuNom']; ?> <?= $r['usuApe']; ?></a>
							<span><?= get_tipo_usuario_desc($r['usuTipo']); ?> <?php if($r['usuTipo']==3 && $r['usuVMMan']==1){ ?> Manager<? } ?>
							<br>
							<? if($r['usuTipo']==4){
								echo '<strong>'. get_proveedor_nombre($r['usuProv']).'</strong>';
							}?>
							<?php echo get_user_mail($r['usuID']); ?><br>
							<?	$formatos = '';
								$usuID = $r['usuID'];
								$sql2  = "select * from usuario_x_formato where paisID = $paisID and usuID = $usuID";
							  	$resultado2 = $db->rawQuery($sql2);
								if($resultado2){
									foreach ($resultado2 as $r2) {
										$formatos .= get_formato($r2['formID']) . ', ';
						    		} 
							 } ?>
							<span style="color:#0084D6;"><?php echo substr($formatos, 0,-2); ?></span>							
							
							</span>
						</div>
						<div class="col-xs-3 text-right posvotos">
							<a href="formulario-usuarios.php?usuID=<?= $r['usuID']; ?>" class="btn btn-default"><i class="fa fa-edit"></i> <span class="hidden-xs">Editar</span></a> 
						</div>
					</div>
				</div>
		    <? 		} 
			    } ?>
			<?
				$sql  = "select * from usuario where paisID = $paisID and usuTipo IN(3,5) order by usuTipo DESC";
				$resultado = $db->rawQuery($sql);
				if($resultado){
					foreach ($resultado as $r) {
							if($r['usuEst']==1){ 
								$estado = 'off';
								$estDesc = 'Inactivo';						
							}else{ 
								$estado = 'on';
								$estDesc = 'Activo';
							} 
		    ?>   
				<div class="col-xs-12 col-md-6 col-md-offset-3 posicion <?= $tipo; ?>" id="usuario-<?= $r['usuID']; ?>">
					<div class="row">
						<div class="col-xs-2 col-sm-1">
							<a href="javascript:void(0)" data-camid="<?php echo $formID; ?>" data-estado="<?php echo $estado; ?>" class="cambiaEstado" data-toggle="tooltip" data-placement="right"  title="<?php echo $estDesc; ?>">
								<i class="fa fa-toggle-<?php echo $estado; ?>" aria-hidden="true"></i></span>
							</a>
						</div>
						<div class="col-xs-7 col-sm-8 postema nopadl nopadr">
							<a href="formulario-usuarios.php?usuID=<?= $r['usuID']; ?>"><?= $r['usuNom']; ?> <?= $r['usuApe']; ?></a>
							<span><?= get_tipo_usuario_desc($r['usuTipo']); ?> <?php if($r['usuTipo']==3 && $r['usuVMMan']==1){ ?> Manager<? } ?>
							<br>
							<? if($r['usuTipo']==4){
								echo '<strong>'. get_proveedor_nombre($r['usuProv']).'</strong>';
							}?>
							<?php echo get_user_mail($r['usuID']); ?><br>
							<?	$formatos = '';
								$usuID = $r['usuID'];
								$sql2  = "select * from usuario_x_formato where paisID = $paisID and usuID = $usuID";
							  	$resultado2 = $db->rawQuery($sql2);
								if($resultado2){
									foreach ($resultado2 as $r2) {
										$formatos .= get_formato($r2['formID']) . ', ';
						    		} 
							 } ?>
							<span style="color:#0084D6;"><?php echo substr($formatos, 0,-2); ?></span>							
							
							</span>
						</div>
						<div class="col-xs-3 text-right posvotos">
							<a href="formulario-usuarios.php?usuID=<?= $r['usuID']; ?>" class="btn btn-default"><i class="fa fa-edit"></i> <span class="hidden-xs">Editar</span></a> 
						</div>
					</div>
				</div>
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




