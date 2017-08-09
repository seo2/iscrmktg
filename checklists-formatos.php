<? 
	
session_start();
global $usuID;
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
$classbody='gradiente1';
	include('header.php');

	
?>

    <div class="container" id="posiciones">

	    
	    <header>
		    <span>Formato de Tiendas</span>
	    </header>
			<div class="row">
				
				<div class="col-sm-4 col-sm-offset-4 col-xs-10 col-xs-offset-1 cajita" >
					<br>
		<?
			$sql  = "select * from formatos";
		  	$resultado = $db->rawQuery($sql);
			if($resultado){
				foreach ($resultado as $r) {
	    ?>   
					<a href="checklists-tiendas.php?formID=<?= $r['formID']; ?>" class="btn btn-primary btn-lg btn-block"><?= $r['formDesc']; ?></a>
					<br>
	    <?  	} 
		    } ?>

						
						
						
				</div>
			</div>

	    	


	    	<div id="footer" class="blancobg">
		    	<div class="container">
			    	<div class="row">
						<div class="col-xs-12 col-md-6 col-md-offset-3 footer">
							
					    	<? 
								$back = "home.php";
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