<?php 
if(!empty($_GET['enviar']) && !empty($_GET['buscar'])) {
	//$sql = $_pagi_sql = "select * from empleados WHERE nombre LIKE '%".$_POST['buscar']."%'";
	$sql_temp = "select empleados.*, empresas.empresa  from empleados INNER join  empresas on empleados.id_empresa =  empresas.id_empresa WHERE nombre LIKE '%".$_GET['buscar']."%'";
} else {
	//$sql = $_pagi_sql = "select * from empleados ORDER BY nombre ASC";
	$sql_temp = "select empleados.*, empresas.empresa  from empleados INNER join  empresas on empleados.id_empresa =  empresas.id_empresa ";
	
}
if( isset($_GET["col"]) && isset($_GET["order"])  ){
		$sql_temp .= " ORDER BY ".$_GET["col"]." ".$_GET["order"];
	}

$sql = $_pagi_sql = $sql_temp;

$_pagi_cuantos = 100;
include("include/php/paginator.inc.php");
?>
<?php 
include('_include-index.php');	
include 'clases/class.menu2.php'; 
$menu = new menu2( $bd, $seguridad ); ?>
    
		<div id="main">
<div id="copete">
	<span>Empleados </span>
	<p>&nbsp;</p>
</div>
<br />
<div class="agregar">
	<a href="<?php echo $seguridad->obternerUrl("empleadosAgregar.php")?>"><img src="images/ico-agregar.gif" border="0"/></a>&nbsp;&nbsp;<a href="<?php echo $seguridad->obternerUrl("empleadosAgregar.php")?>">Agregar</a>
</div>
<br />
<div class="agregar">
	<a href="exportar.php"><img src="images/ico-ver.gif" border="0"/></a>&nbsp;&nbsp;<a href="exportar.php">Exportar</a>
</div>
<br />
<div class="agregar" id="buscador">
<form action="" name="buscar" method="get">
	<img src="images/ico-fecha.gif" border="0" alt="" />
	<label>Buscar:</label>
	<input type="hidden" name="link" value="<?php echo $_GET["link"];?>" />
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
		<td class="delmod">&nbsp;</td>
	</tr>
	<?php 
	$r = $bd->bbdd_query($sql);
	$i=0;
	while($row = $bd->bbdd_fetch($_pagi_result)) {
	?>
		<tr class="<?php  if($i%2) { ?>oscuro<?php  } else { ?>claro<?php  } ?>">
			<td><?php 
			/*
			$qe=mysql_query("SELECT * FROM empresas WHERE id_empresa='".$row["id_empresa"]."'");
			if( mysql_num_rows($qe) > 0){
				$ae = mysql_fetch_array($qe);
				echo $ae["empresa"];
			}*/
			echo $row["empresa"];
			?></td>
			<td><?php echo $row["nombre"]; ?></td>
			<td><?php echo $row["apellido"]; ?></td>
			<td align="center"><?php echo $row["cantidad_kits"]; ?></td>
			<td class="delmod"><a href="<?php echo $seguridad->obternerUrl("empleadosAgregar.php",array("id"=>$row["id_empleado"],"tipo"=>1))?>"><img src="images/ico-editar.gif"/></a></td>
			<td class="delmod"><a href="<?php echo $seguridad->obternerUrl("empleadosProcesar.php",array("id"=>$row["id_empleado"],"tipo"=>2))?>" onclick="return SEGURIDAD.verifBorrar();"><img src="images/ico-borrar.gif"/></a></td>
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