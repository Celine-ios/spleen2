<?php 
if(!empty($_POST['enviar']) && !empty($_POST['buscar'])) {
	//$sql = $_pagi_sql = "select * from empleados WHERE nombre LIKE '%".$_POST['buscar']."%'";
	$sql = $_pagi_sql = "select * from empleados WHERE nombre LIKE '%".$_POST['buscar']."%' AND state = '1'";
	//echo $sql; exit;
} else {
	$sql_temp = "select empleados.*, empresas.empresa  from empleados INNER join  empresas on empleados.id_empresa =  empresas.id_empresa WHERE empleados.state = '1' ";
	if( isset($_GET["col"]) && isset($_GET["order"])  ){
		$sql_temp .= " ORDER BY ".$_GET["col"]." ".$_GET["order"];
	}
	$sql = $_pagi_sql = $sql_temp;
}

$_pagi_cuantos = 20;
include("include/php/paginator.inc.php");
?>
<?php 
include('_include-index.php');	
include 'clases/class.menu2.php'; 
$menu = new menu2( $bd, $seguridad ); ?>
    
		<div id="main">
<div id="copete">
	<span>Pedidos </span>
	<p>&nbsp;</p>
</div>
<br />
<div class="agregar">
	<a href="exportar_pedidos.php"><img src="images/ico-ver.gif" border="0"/></a>&nbsp;&nbsp;<a href="exportar_pedidos.php">Exportar</a>
</div>
<br />
<div class="agregar" id="buscador">
<form action="<?php echo  $seguridad->obternerUrl("pedidos.php")?>" name="buscar" method="post">
	<img src="images/ico-fecha.gif" border="0" alt="" />
	<label>Buscar:</label>
	<input type="text" name="buscar" />&nbsp;<input name="enviar" type="submit" value="buscar" />
</form>
</div>

<table class="listados" cellpadding="0" cellspacing="0">
	<tr class="cabecera">
		<td>Empresa <a class="order_col" href="?link=<?php echo $_GET["link"];?>&col=empresa&order=asc">Asc</a> <a class="order_col" href="?link=<?php echo $_GET["link"];?>&col=empresa&order=desc">Desc</a></td>
		<td>Nombre <a class="order_col" href="?link=<?php echo $_GET["link"];?>&col=nombre&order=asc">Asc</a> <a class="order_col" href="?link=<?php echo $_GET["link"];?>&col=nombre&order=desc">Desc</a></td>
		<td>Apellido <a class="order_col" href="?link=<?php echo $_GET["link"];?>&col=apellido&order=asc">Asc</a> <a class="order_col" href="?link=<?php echo $_GET["link"];?>&col=apellido&order=desc">Desc</a></td>
		<td align="center">Cantidad de Kits <a class="order_col" href="?link=<?php echo $_GET["link"];?>&col=cantidad_kits&order=asc">Asc</a> <a class="order_col" href="?link=<?php echo $_GET["link"];?>&col=cantidad_kits&order=desc">Desc</a></td>
		<td class="delmod">&nbsp;</td>
	</tr>
	<?php 
	//echo $sql; exit;
	$r = $bd->bbdd_query($sql);
	$i=0;
	while($row = $bd->bbdd_fetch($_pagi_result)) {
	?>
		<tr class="<?php  if($i%2) { ?>oscuro<?php  } else { ?>claro<?php  } ?>">
			<td><?php 
			echo $row["empresa"];
			?></td>
			<td><?php echo $row["nombre"]; ?></td>
			<td><?php echo $row["apellido"]; ?></td>
			<td align="center"><?php echo $row["cantidad_kits"]; ?></td>
			<td class="delmod"><a href="<?php echo $seguridad->obternerUrl("pedidosAgregar.php",array("id"=>$row["id_empleado"],"tipo"=>1))?>"><img src="images/ico-editar.gif"/></a></td>
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
<style>
a.order_col{
font-size:10px;
color:#CCC;
}
</style>