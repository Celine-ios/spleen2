<?php
include 'clases/class.excel2.php';
$usu = new excel2($bd);
$usu->procesar();

include('_include-index.php');
include 'clases/class.menu2.php'; 
$menu = new menu2( $bd, $seguridad ); ?>
    
		<div id="main">
<div id="copete">
	<span>Importar (procesar)</span>
	<p>&nbsp;</p>
</div>
<?php
if( isset($usu->errr) && !empty($usu->errr) ){
	echo $usu->errr;
}
?>