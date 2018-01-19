<?php 
include('_include-index.php');
include 'clases/class.menu2.php'; 
$menu = new menu2( $bd, $seguridad ); ?>
    
<div id="main">
<div id="copete">
	<span>Cambiar clave</span>
	<p>&nbsp;</p>
</div>
<?php
$id = (isset($_GET["id"]))?$_GET["id"]:0;
?>
<form action="<?php echo $seguridad->obternerUrl("usuariosProcesar.php",array("id"=>$id,"tipo"=>3,"volver"=>$_GET["volver"]))?>" method="POST">
	<div>
		<label>Clave (*):</label>
		<input type="password" name="clave1" value="" maxlength="10"/>
	</div>
	<div>
		<label>Repetir clave (*):</label>
		<input type="password" name="clave2" value="" maxlength="10"/>
	</div>
	<div class="enviar">
		<input type="Submit" value="Cargar">
	</div>
</form>