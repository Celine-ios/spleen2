<?php
include "clases/class.empresas.php";
$ob = new empresas($bd);
$ob->procesar();

include('_include-index.php');
include 'clases/class.menu2.php'; 
$menu = new menu2( $bd, $seguridad ); ?>
		<div id="main">
<div id="copete">
	<span>Empresas </span>
	<p>&nbsp;</p>
</div>

<?php
if( isset($ob->errr) && !empty($ob->errr) ){
	echo $ob->errr;
}