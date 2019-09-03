<?php
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=empleados.xls");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Transfer-Encoding: binary ");


include 'include/php/config/config.php';
include 'clases/class.bbdd.php';
include 'clases/class.seguridad.php';

$q = mysql_query("select empleados.*, empresas.empresa  from empleados INNER join  empresas on empleados.id_empresa =  empresas.id_empresa ORDER BY empresa ASC");
$resp ="";
$resp .="<table border=1>\n";
$resp .="<tr style=\"\">\n";
$resp .="	<th>Empresa</th>\n";
$resp .="	<th>Usuario</th>\n";
$resp .="	<th>Password</th>\n";
$resp .="	<th>Nombre</th>\n";
$resp .="	<th>Apellido</th>\n";
$resp .="	<th>Cantidad de Kits</th>\n";
$resp .="	<th>Lugar de Entrega</th>\n";
$resp .="</tr>\n";
while( $a = mysql_fetch_array($q) ){
	$resp .="<tr style=\"\">\n";
	$resp .="	<td>".$a['empresa']."</td>\n";
	$resp .="	<td>".$a['user']."</td>\n";
	$resp .="	<td>".base64_decode($a['pass'])."</td>\n";
	$resp .="	<td>".$a['nombre']."</td>\n";
	$resp .="	<td>".$a['apellido']."</td>\n";
	$resp .="	<td>".$a['cantidad_kits']."</td>\n";
	$resp .="	<td>".$a['direccion_entrega']."</td>\n";
	$resp .="</tr>\n";
}
$resp .="</table>\n";
echo $resp ;
?>
