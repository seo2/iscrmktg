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
	include('header.php');
?>

    <div class="container" id="posiciones">
	    <? $titulo 	= 'Menú';
		   $tipo 	=  get_usertipo($_COOKIE['id']);
	    ?>
	    
	    <header>
		    <span><? if($paisID==7){ ?>Master<? }else{ ?>Maestros<? } ?></span>
	    </header>
			<div class="row">
				
				<div class="col-sm-4 col-sm-offset-4 col-xs-10 col-xs-offset-1 cajita" >
				
				<h1 class="logo animated fadeIn"><img src="assets/img/logo.png?ver=2"></h1>
				<p class="logo animated fadeInDown">Retail Marketing</p>

					<? if($tipo<3){ ?>
						<a href="campana.php" class="btn btn-primary btn-lg btn-block">ISC de Campañas</a>
						<br>
						<a href="formatos.php?piezas=1" class="btn btn-primary btn-lg btn-block">ISC Long Term</a>
						<hr>
					<? if($tipo<=2){ ?>
						<a href="maestro-tiendas.php" class="btn btn-primary btn-lg btn-block"><? if($paisID==7){ ?>Lojas<? }else{ ?>Tiendas<? } ?></a>
						<br>
						<a href="proveedores.php" class="btn btn-primary btn-lg btn-block"><? if($paisID==7){ ?>Fornecedores<? }else{ ?>Proveedores<? } ?></a>
						<br>
						<a href="usuarios.php" class="btn btn-primary btn-lg btn-block"><? if($paisID==7){ ?>Usuários<? }else{ ?>Usuarios<? } ?></a>
					<? } ?>
					<? if($paisID==1){ ?>
						<hr>
						<a href="checklists-maestro-zonas.php" class="btn btn-primary btn-lg btn-block">Zonas</a>
						<br>
						<a href="checklists-maestro-checklists.php" class="btn btn-primary btn-lg btn-block">Checklists</a>
						<? } ?>
					<? } ?>
				</div>
			</div>

	    	<footer class="animated bounceInRight">
		    	<a href="home.php" id="btnvolver"><i class="fa fa-chevron-left"></i> <span><? if($paisID==7){ ?>Voltar<? }else{ ?>Volver<? } ?></span></button>
	    	</footer>
<? include('footer.php'); ?>