<?php
include "clases/class.perfiles.php";
$menu = new perfiles($bd);
$menu->procesar();

include('_include-index.php');
include 'clases/class.menu2.php'; 
$menu = new menu2( $bd, $seguridad ); ?>
<div id="copete">
	<span>Perfiles</span>
	<p>&nbsp;</p>
</div>