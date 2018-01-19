<?php

$login = new login();
$login->salir();

header( 'location: ' . $_SERVER[ 'PHP_SELF' ] );
?>
<div id="copete">
	<span>Salir</span>
	<p>Salio del sistema.</p>
</div>