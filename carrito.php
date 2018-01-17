<?php
session_start(); 
include("app/config.php");
$ob_user = new user();
$ob_user->check_vigencia();
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
							<td class="desc_prod"><?php echo $v["descripcion"];?></td>
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
			</div>
		</div>
	</div>
	
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
function confirmar_pedido(){
	if( confirm("¿Estás seguro que querés confirmar el pedido? Recordá que una vez enviado este pedido tus créditos no utilizados se pondrán en cero.") ){
		window.location = "confirmacion.php";
	}
}

function cantidad(t,id_producto){
	var val = $(t).val();
	$.ajax({
        async:true,
        type: "POST",
        dataType: "html",
        contentType: "application/x-www-form-urlencoded",
        url:"ajax_change.php",
        data:"id_producto="+id_producto+"&cantidad="+val,
        success:res_change,
        timeout:4000,
        error:problemas
    });	 
}
function del_prod(x){
	$.ajax({
        async:true,
        type: "POST",
        dataType: "html",
        contentType: "application/x-www-form-urlencoded",
        url:"ajax_del.php",
        data:"id_producto="+x,
        success:res_del,
        timeout:4000,
        error:problemas
    });	 
}
function res_change(x){
	switch(x){
		case "1":
			refresh_credits();
			$("#bg_carrito").load("ajax_carrito.php");
		break;
		case "0":
			alert("No posee crédito disponible para agregar este producto.");
		break;
	}
}
function res_del(){
	refresh_credits();
	$("#bg_carrito").load("ajax_carrito.php");
}
function problemas(){
	alert("error");
}
function refresh_credits(){
	$("#ajax_creditos").load("ajax_puntos.php");
}
</script>
<!--[if IE 6]>
<script type="text/javascript" src="js/fixpng.js"></script>
<![endif]-->
</body>
</html>