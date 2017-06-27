<? include('header.php'); ?>
    <div class="container" id="recuperar">
	    
	    <header>
		    <a href="login.php">
		    	<i class="fa fa-chevron-left"></i> 
		    </a>
		    <span>Recuperar Contraseña</span>
	    </header>
	    <form action="ajax/recuperar.php" method="post" accept-charset="utf-8" id="formRecuperar" class="seva">
    	
	    	<div class="row">
		    	<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
		    		<a href="javascript:void(0);" class="btn-fb"><i class="fa fa-facebook"></i> Iniciar con Facebook</a>
		    	</div>
	    	</div>
	    	<div class="row">
		    	<div class="col-xs-10 col-xs-offset-1">
			    	<div class="row">
				    	<h2 class="text-center"> Escribe tu email y te enviaremos<br>instrucciones para<br>una nueva contraseña</h2>
			    	</div>
					<div class="form-group">
						<input type="email" name="email" class="form-control" id="exampleInputName2" placeholder="Email">
					</div>
					<p class="text-center" id="terms">¿No tienes cuenta?<a href="registro.php"> Regístrate aquí</a>
					<p class="text-center" id="terms">¿Ya te acordaste?<a href="login.php"> Ingresa aquí</a>
					</p>
		    	</div>
	    	</div>
	    	
	    	<footer>
		    	<button type="submit" id="btnRecuperar"><span>Recuperar</span> <i class="fa fa-chevron-right"></i></button>
	    	</footer>
	    	
	    </form>
 

<!-- Modal voto -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
	      	<a href="javascript:void(0);" data-dismiss="modal" class="btn-close"><i class="fa fa-times"></i></a>
      		
      		<h3>Listo</h3>
      		<p>Revisa tu email, para recuperar tu contraseña.</p>
      </div>
    </div>
  </div>
</div>  

		 
 
    	
<? include('footer.php'); ?>