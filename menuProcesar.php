<?php
include "clases/class.menu.php";
$menu = new menu($bd);
$menu->procesar();

include('_include-index.php');
include 'clases/class.menu2.php'; 
$menu = new menu2( $bd, $seguridad ); ?>
<div id="copete">
	<span>Menús</span>
	<p>&nbsp;</p>
</div>