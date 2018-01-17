<?php
session_start(); 
include("app/config.php");
$ob_user = new user();
$ob_user->check_vigencia(1);
$user = $ob_user->get_data_user();

$_title = "BeMarketing";
$_page = "carrito";
include("_head_html.inc.php");
$_limit_cantidad = 30;


$obj_cesta = new cesta();
$rows = $obj_cesta->lista_productos_cesta();
?>
	<div class="cont2">
		<div class="cont_kits">
			<?php include("_header.inc.php");?>
			<img id="pizarra_min" src="images/pizar1.png" alt="" />
			<div id="bg_carrito">
				<div id="cont_tabla_carrito">
				<table id="tabla_carrito" border="" cellpadding="0" cellspacing="0">
					<thead>
						<tr>
							<td width="98"></td>
							<td width="51">COD</td>
							<td width="201">PRODUCTO</td>
							<td width="74">CRÉDITOS</td>
							<td width="81">CANTIDAD</td>
							<td>SUBTOTAL</td>
						</tr>
					</thead>
					<tbody>
					<?php
					foreach( $rows as $v ){
					?>
						<tr>
							<td><img src="images/productos/<?php echo $v["image"];?>" height="40" alt="" /></td>
							<td><?php echo $v["codigo"];?></td>
							<td class="desc_prod"><?php echo $v["descripcion"];?></td>
							<td><?php echo $v["precio"];?></td>
							<td><?php echo $v["cantidad"];?></td>
							<td><?php echo $v["subtotal_producto"];?></td>
						</tr>
					<?php
					}
					?>	
					</tbody>
				</table>
				</div>
				<div id="subtotal"><?php echo $obj_cesta->subtotal;?></div>
				<div id="total"><?php echo $obj_cesta->subtotal;?></div>
			</div>
		</div>
	</div>
	
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">

</script>
<!--[if IE 6]>
<script type="text/javascript" src="js/fixpng.js"></script>
<![endif]-->
</body>
</html>