<?php
include 'clases/class.usuarios.php';
$usu = new usuarios($bd);
$usu->procesarInformacion($_GET["tipo"],$_GET["id"]);

include('_include-index.php');
include 'clases/class.menu2.php'; 
$menu = new menu2( $bd, $seguridad ); ?>
<div id="copete">
	<span>Agregar/Modificar usuario</span>
	<p>&nbsp;</p>
</div>
