<?php 
include('_include-index.php');	
include 'clases/class.menu2.php'; 
$menu = new menu2( $bd, $seguridad ); ?>
    
		<div id="main">
<div id="copete">
	<span>Importar</span>
	<p>&nbsp;</p>
</div>
<br />
<form name="carga" action="<?php echo $seguridad->obternerUrl("importarProcesar.php",array("id"=>1,"tipo"=>1)) ?>" method="post" enctype="multipart/form-data">
 	<div>
		<label>Excel:</label>
        <input type="file" name="excel" />
	</div>
	<div class="enviar">
        <input type="submit" value="Cargar" />
	</div>
</form>