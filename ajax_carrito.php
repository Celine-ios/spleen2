<?php
session_start(); 
include("app/config.php");
$_limit_cantidad = 30;
$obj_cesta = new cesta();
$rows = $obj_cesta->lista_productos_cesta();
?>
				<div id="cont_tabla_carrito">
								<a href="kits.php" class="btn2">Volver al catálogo</a>
				<table id="tabla_carrito" border="" cellpadding="0" cellspacing="0">
					<thead>
						<tr>
							<td width="49">QUITAR</td>
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
							<td><a href="javascript:void(0);" onclick="del_prod(<?php echo $v["id_orden"];?>);"><img src="images/del.jpg" alt="" /></a></td>
							<td><img src="images/productos/<?php echo $v["image"];?>" height="40" alt="" /></td>
							<td><?php echo $v["codigo"];?></td>
							<td class="desc_prod"><?php echo utf8_encode($v["descripcion"]);?></td>
							<td><?php echo $v["precio"];?></td>
							<td>
								<select name="" onchange="cantidad(this,<?php echo $v["id_producto"];?>);">
								<?php
								if( $v["cantidad"] > $_limit_cantidad ){
									$_limit_cantidad_prod = $v["cantidad"];
								}else{
									$_limit_cantidad_prod = $_limit_cantidad;
								}
								for( $x = 1;$x<=$_limit_cantidad_prod;$x++){
									if( $v["cantidad"] == $x ){
										echo '<option selected>'.$x.'</option>';
									}else{
										echo '<option>'.$x.'</option>';
									}
								}
								?>
								</select>
							</td>
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
				<a href="javascript:void(0);" id="btn3" onclick="confirmar_pedido()">&nbsp;</a>