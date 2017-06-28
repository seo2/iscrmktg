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
	
	
	if($_GET['provID'] ){
		$provID 	 	= $_GET['provID'];
		$sql  		= "select * from proveedores where provID = $provID";
		
	  	$resultado = $db->rawQuery($sql);
		if($resultado){
			foreach ($resultado as $r) {
				$provNom  = $r['provNom'];
				$provMail = $r['provMail'];
				$provEst  = $r['provEst'];
	 		} 
	    }		
	    if($paisID==7){
			$opcion = 'Editar';	
		}else{
			$opcion = 'Modificar';	
		} 
	}else{
	    if($paisID==7){
			$opcion = 'Adicionar';	
		}else{
			$opcion = 'Agregar';	
		} 
	}
	
	
?>

    <div class="container" id="argumentos">
	    
		<header>
		    <span></span>
	    </header>

		    <div id="cajaposiciones">
			    <div class="col-xs-12 col-md-6 col-md-offset-3" id="pedidohead">
			    	<h2><?= $opcion; ?> <? if($paisID==7){ ?>Fornecedor<? }else{ ?>Proveedor<? } ?></h2>
			    </div>
 
				<div class="col-xs-12 col-md-6 col-md-offset-3 posicion">
					<div class="row">
					
						<form action="ajax/graba-proveedor.php" method="post" accept-charset="utf-8" id="formProveedor">
							
							<div class="form-group">
								<label class="ptdCan"><? if($paisID==7){ ?>Nome<? }else{ ?>Nombre<? } ?>:</label>
								<input type="text" class="form-control" id="provNom" placeholder="" name="provNom" value="<?= $provNom; ?>">
								<input type="hidden" name="paisID" 	value="<?= $paisID; ?>">
								<? if($_GET['provID'] ){?>
								<input type="hidden" name="provID" 	value="<?= $provID; ?>">
								<? } ?>
							</div>
							
							<div class="form-group">
								<label class="ptdCan"><? if($paisID==7){ ?>E-mails de contato<? }else{ ?>Mails de contacto<? } ?></label>
								<input type="text" class="form-control" id="provMail" placeholder="<? if($paisID==7){ ?>Dividir e-mails com vírgula<? }else{ ?>Separar los correos por coma<? } ?>" name="provMail" value="<?= $provMail; ?>">
							</div>
	
							<div class="form-group">
								<label for="ptdGra"><? if($paisID==7){ ?>Status<? }else{ ?>Estado<? } ?>:</label>
								<select class="form-control" name="provEst" required id="provEst">
									<option value="0" <? if($provEst==0){ ?>selected<? } ?>><? if($paisID==7){ ?>Ativo<? }else{ ?>Activo<? } ?></option>
									<option value="1" <? if($provEst==1){ ?>selected<? } ?>><? if($paisID==7){ ?>Inativo<? }else{ ?>Inactivo<? } ?></option>
								</select>
							</div>			
							<hr>
							<div class="form-group text-right">
						    	<button type="submit" class="btn btn-primary" id="btngrabar"><i class="fa fa-floppy-o"></i> <? if($paisID==7){ ?>Salvar<? }else{ ?>Grabar<? } ?></button>
							</div>
							
						</form>
					
					</div>

				</div>
				<div class="clear"></div>
		    </div>

	    	<footer class="animated bounceInRight">
		    	<a href="javascript:window.history.back();" id="btnvolver"><i class="fa fa-chevron-left"></i> <span><? if($paisID==7){ ?>Voltar<? }else{ ?>Volver<? } ?></span></button>
	    	</footer>	    

   
<? include('footer.php'); ?>