<?php 
include('_include-index.php');
include 'clases/class.menu2.php'; 
$menu = new menu2( $bd, $seguridad ); ?>
    
<div id="main">
<div id="copete">
	<span>Pedidos </span>
	<p>&nbsp;</p>
</div>
<?php 
$id = (isset($_GET["id"]))?$_GET["id"]:0;
include "clases/class.empleados.php";
$obj = new empleados($bd);
if($id){
	$row = $obj->obtenerDatos($id);
}

		$db_server = '127.0.0.1:3306';
		$db_user = 'root';

			$conex = mysqli_connect($db_server,$db_user);

$qemp = mysqli_query("SELECT * FROM empresas WHERE id_empresa='".$row["id_empresa"]."'",$conex);
$aemp = mysqli_fetch_array($qemp,MYSQLI_ASSOC);
?>
<form name="carga" action="" method="post" enctype="multipart/form-data">
	<div style="text-align:center;">
		<p>
		<b>Empresa:</b> <?php echo $aemp["empresa"];?> &nbsp; 
		<b>Nombre:</b> <?php echo $row["nombre"];?> &nbsp; 
		<b>Apellido:</b> <?php echo $row["apellido"];?> &nbsp; 
		<b>Usuario:</b> <?php echo $row["user"];?> &nbsp; 
		<b>Clave:</b> <?php echo base64_decode($row["pass"]);?> &nbsp; 
		<b>Cantidad de Kits:</b> <?php echo $row["cantidad_kits"];?> &nbsp; <br />
		<b>Dirección entrega del premio:</b> <?php echo $row["direccion_entrega"];?> &nbsp; 
		<b>Crédito otorgado:</b> <?php echo ($row["cantidad_kits"] * $aemp["credito_inicial"] );?>
		</p>
	</div>
	<div align="center" style="padding:10px 0 0;">
				<table style="font-size:12px;border-left:1px solid #616264;border-top:1px solid #616264;" border="0" cellpadding="0" cellspacing="0">
					<thead>
						<tr>
							<td width="98" style="border-bottom:1px solid #616264;border-right:1px solid #616264;text-align:center;">&nbsp;</td>
							<td width="61" style="border-bottom:1px solid #616264;border-right:1px solid #616264;text-align:center;">COD</td>
							<td width="201" style="border-bottom:1px solid #616264;border-right:1px solid #616264;text-align:center;">PRODUCTO</td>
							<td width="74" style="border-bottom:1px solid #616264;border-right:1px solid #616264;text-align:center;">CRÉDITOS</td>
							<td width="81" style="border-bottom:1px solid #616264;border-right:1px solid #616264;text-align:center;">CANTIDAD</td>
							<td width="81" style="border-bottom:1px solid #616264;border-right:1px solid #616264;text-align:center;">SUBTOTAL</td>
						</tr>
					</thead>
					<tbody>
					<?php

						$db_server = '127.0.0.1:3306';
						$db_user = 'root';

							$conex = mysqli_connect($db_server,$db_user);


					$total = 0;
					$q = mysqli_query("SELECT * FROM carrito WHERE id_user='".$id."'",$conex);
					while( $row = mysqli_fetch_array($q,MYSQLI_ASSOC) ){
						$sql = "SELECT productos.*, categorias.path_images FROM productos INNER JOIN categorias ON productos.id_categoria = categorias.id_categoria  WHERE productos.id_producto='".$row["id_producto"]."'";
						$q2 = mysqli_query($sql,$conex);
						$v = mysqli_fetch_array($q2,MYSQLI_ASSOC);
						$v["subtotal_producto"] = ( $row["cantidad"] * $v["creditos"] );
						$total = $total + $v["subtotal_producto"];
					?>
						<tr>
							<td style="border-bottom:1px solid #616264;border-right:1px solid #616264;text-align:center;"><img src="../images/productos/<?php echo $v["path_images"];?>/<?php echo $v["codigo"];?>.jpg" height="40" alt="" /></td>
							<td style="border-bottom:1px solid #616264;border-right:1px solid #616264;text-align:center;"><?php echo $v["codigo"];?></td>
							<td style="border-bottom:1px solid #616264;border-right:1px solid #616264;padding:0 0 0 5px;"><?php echo $v["descripcion"];?></td>
							<td style="border-bottom:1px solid #616264;border-right:1px solid #616264;text-align:center;"><?php echo $v["creditos"];?></td>
							<td style="border-bottom:1px solid #616264;border-right:1px solid #616264;text-align:center;"><?php echo $row["cantidad"];?></td>
							<td style="border-bottom:1px solid #616264;border-right:1px solid #616264;text-align:center;"><?php echo $v["subtotal_producto"];?></td>
						</tr>
					<?php
					}
					?>	
						<tr>
							<td colspan="7" style="border-bottom:1px solid #616264;border-right:1px solid #616264;height:25px;"><b>Total:</b> <?php echo $total;?></td>
						</tr>
					</tbody>
				</table>
	</div>
	
	
</form>
