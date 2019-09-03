<?php

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=pedidos.xls");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Transfer-Encoding: binary ");


include 'include/php/config/config.php';
include 'clases/class.bbdd.php';
include 'clases/class.seguridad.php';

//$q = mysql_query("select empleados.*, empresas.empresa  from empleados INNER join  empresas on empleados.id_empresa =  empresas.id_empresa WHERE empleados.state = '1'");
$q = mysql_query("select empleados.*, empresas.empresa  from empleados INNER join  empresas on empleados.id_empresa =  empresas.id_empresa WHERE empleados.state = '1' ORDER BY fecha_pedido ASC");
$resp ="";
$resp .="<table border=1>\n";
$resp .="<tr style=\"\">\n";
$resp .="	<th>Empresa</th>\n";
$resp .="	<th>Usuario (dni)</th>\n";
$resp .="	<th>Nombre</th>\n";
$resp .="	<th>Apellido</th>\n";
$resp .="	<th>Fecha Pedido</th>\n";
$resp .="	<th>Detalle Productos Elegidos</th>\n";
$resp .="	<th>Total créditos utilizados/ confirmados</th>\n";
$resp .="	<th>Lugar de Entrega</th>\n";
$resp .="</tr>\n";
while( $a = mysql_fetch_array($q) ){
	$resp .="<tr style=\"\">\n";
	$resp .="	<td valign=\"top\">".$a['empresa']."</td>\n";
	$resp .="	<td valign=\"top\">".$a['user']."</td>\n";
	$resp .="	<td valign=\"top\">".$a['nombre']."</td>\n";
	$resp .="	<td valign=\"top\">".$a['apellido']."</td>\n";
	$resp .="	<td valign=\"top\">".$a['fecha_pedido']."</td>\n";
	//_______
		$total = 0;
		$_productos_elegidos = "<table border=1>";
		$_productos_elegidos .= "<tr>";
		$_productos_elegidos .= "	<th>Cod.</th>";
		$_productos_elegidos .= "	<th>Producto</th>";
		$_productos_elegidos .= "	<th align=\"center\">Cantidad</th>";
		$_productos_elegidos .= "</tr>";
		$qq = mysql_query("SELECT * FROM carrito WHERE id_user='".$a['id_empleado']."'");
		while( $row = mysql_fetch_array($qq) ){
			$sql = "SELECT productos.*, categorias.path_images FROM productos INNER JOIN categorias ON productos.id_categoria = categorias.id_categoria  WHERE productos.id_producto='".$row["id_producto"]."'";
			$q2 = mysql_query($sql);
			$v = mysql_fetch_array($q2);
			$v["subtotal_producto"] = ( $row["cantidad"] * $v["creditos"] );
			$total = $total + $v["subtotal_producto"];
				$_productos_elegidos .= "<tr>";
				$_productos_elegidos .= "<td>".$v["codigo"]."</td>";
				$_productos_elegidos .= "<td>".$v["descripcion"]."</td>";
				$_productos_elegidos .= "<td align=\"center\">".$row["cantidad"]."</td>";
				$_productos_elegidos .= "</tr>";
				/*
						<tr>
							<td style="border-bottom:1px solid #616264;border-right:1px solid #616264;text-align:center;"><img src="../images/productos/<?php echo $v["path_images"];?>/<?php echo $v["codigo"];?>.jpg" height="40" alt="" /></td>
							<td style="border-bottom:1px solid #616264;border-right:1px solid #616264;text-align:center;"><?php echo $v["codigo"];?></td>
							<td style="border-bottom:1px solid #616264;border-right:1px solid #616264;padding:0 0 0 5px;"><?php echo $v["descripcion"];?></td>
							<td style="border-bottom:1px solid #616264;border-right:1px solid #616264;text-align:center;"><?php echo $v["creditos"];?></td>
							<td style="border-bottom:1px solid #616264;border-right:1px solid #616264;text-align:center;"><?php echo $row["cantidad"];?></td>
							<td style="border-bottom:1px solid #616264;border-right:1px solid #616264;text-align:center;"><?php echo $v["subtotal_producto"];?></td>
						</tr>
				*/
				
		}
		$_productos_elegidos .= "</table>";
	//_______
	
	$resp .="	<td valign=\"top\">".$_productos_elegidos."</td>\n";
	$resp .="	<td valign=\"top\">".$total."</td>\n";
	$resp .="	<td valign=\"top\">".$a['direccion_entrega']."</td>\n";
	$resp .="</tr>\n";
}
$resp .="</table>\n";
echo $resp ;
?>
