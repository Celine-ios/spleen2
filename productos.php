<?php 
if( isset($_GET['buscar']) && !empty($_GET['buscar'])) {
	$sql = $_pagi_sql = "select * from productos WHERE descripcion LIKE '%".$_GET['buscar']."%' OR codigo LIKE '%".$_GET['buscar']."%' ";
} else {
	$sql = $_pagi_sql = "select * from productos ORDER BY id_producto DESC";
}

$_pagi_cuantos = 50;
include("include/php/paginator.inc.php");
?>
<?php 
include('_include-index.php');	
include 'clases/class.menu2.php'; 
$menu = new menu2( $bd, $seguridad ); ?>
    
		<div id="main">
<div id="copete">
	<span>Productos </span>
	<p>&nbsp;</p>
</div>
<br />
<div class="agregar">
	<a href="<?php echo $seguridad->obternerUrl("productosAgregar.php")?>"><img src="images/ico-agregar.gif" border="0"/></a>&nbsp;&nbsp;<a href="<?php echo $seguridad->obternerUrl("productosAgregar.php")?>">Agregar</a>
</div>
<br />
<div class="agregar" id="buscador">
<form action="" name="buscar" method="get">
	<img src="images/ico-fecha.gif" border="0" alt="" />
	<label>Buscar:</label>
	<input type="text" name="buscar" />&nbsp;<input name="enviar" type="submit" value="buscar" />
	<input type="hidden" name="link" value="<?php echo $_GET["link"];?>" />
</form>
</div>

<table class="listados" cellpadding="0" cellspacing="0">
	<tr class="cabecera">
		<td>Producto</td>
		<td class="delmod">&nbsp;</td>
		<td class="delmod">&nbsp;</td>
	</tr>
	<?php 
	$r = $bd->bbdd_query($sql);
	$i=0;
	while($row = $bd->bbdd_fetch($_pagi_result)) {
	?>
		<tr class="<?php  if($i%2) { ?>oscuro<?php  } else { ?>claro<?php  } ?>">
			<td><?php echo  $row["descripcion"]; ?></td>
			<td class="delmod"><a href="<?php echo $seguridad->obternerUrl("productosAgregar.php",array("id"=>$row["id_producto"],"tipo"=>1))?>"><img src="images/ico-editar.gif"/></a></td>
			<td class="delmod"><a href="<?php echo $seguridad->obternerUrl("productosProcesar.php",array("id"=>$row["id_producto"],"tipo"=>2))?>" onclick="return SEGURIDAD.verifBorrar();"><img src="images/ico-borrar.gif"/></a></td>
		</tr>	
	<?php 
		$i++;
	}
	if(!$bd->bbdd_num($r)){
	?>
	<tr>
		<td colspan="4"><?php  if(isset($_POST['enviar'])) { echo "No se encontro ning&uacute;n resultado."; } else { echo "No ingreso ning&uacute;n dato."; } ?></td>
	</tr>
	<?php }?>
</table>
<?php 
if($_pagi_totalPags != 1) {
	echo"<p>".$_pagi_navegacion."</p>";
} else {
	echo '';
}	
?>