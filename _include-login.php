
<?php 
include('_include-index.php');	
include 'clases/class.menu2.php'; 
$menu = new menu2( $bd, $seguridad ); ?>
    
		<div id="main">
		<div id="copete">
	<span>Ingreso al sistema</span>
	<p>Bienvenido al administrador. Desde aca podrás manejar el sitio.</p>
</div><?php

if( $seguridad->estado == 3 ) { ?>
	<div id="error">
		<strong>Errores:</strong><br/>
		Usuario y/o password incorrectos
	</div><?php
} ?>

<form action="<?php echo $_SERVER[ 'PHP_SELF']; ?>?<?php echo $_SERVER[ 'QUERY_STRING' ]; ?>" method="POST" class="login"><?php
  if( isset( $error ) ) { ?>
		<div id="error">Usuario o contraseña inválidos</div><?php
  } ?>
	<h3>Complete sus datos de ingreso</h3>
	<div>
		<label>Usuario: </label>
		<input type="Text" value="" name="usuario"/>
	</div>
	<div>
		<label>Password: </label>
		<input type="Password" value="" name="pass"/>
	</div>
	<div class="enviar">
		<input type="Submit" value="Ingresar"/>
	</div>
</form>