<?php 
if(!empty($_POST['enviar']) && !empty($_POST['buscar'])) {
	$sql = $_pagi_sql = "select * from empresas WHERE empresa LIKE '%".$_POST['buscar']."%'";
} else {
	$sql = $_pagi_sql = "select * from empresas ORDER BY empresa ASC";
}

$_pagi_cuantos = 100;
include("include/php/paginator.inc.php");
?>
<?php 
include('_include-index.php');	
include 'clases/class.menu2.php'; 
$menu = new menu2( $bd, $seguridad ); ?>
    
		<div id="main">
<div id="copete">
	<span>Empresas </span>
	<p>&nbsp;</p>
</div>
<br />
<div class="agregar">
	<a href="<?php echo $seguridad->obternerUrl("empresasAgregar.php")?>"><img src="images/ico-agregar.gif" border="0"/></a>&nbsp;&nbsp;<a href="<?php echo $seguridad->obternerUrl("empresasAgregar.php")?>">Agregar</a>
</div>
<br />
<div class="agregar" id="buscador">
<form action="<?php echo  $seguridad->obternerUrl("empresas.php")?>" name="buscar" method="post">
	<img src="images/ico-fecha.gif" border="0" alt="" />
	<label>Buscar:</label>
	<input type="text" name="buscar" />&nbsp;<input name="enviar" type="submit" value="buscar" />
</form>
</div>

<table class="listados" cellpadding="0" cellspacing="0">
	<tr class="cabecera">
		<td>Empresa</td>
		<td class="delmod">&nbsp;</td>
		<td class="delmod">&nbsp;</td>
	</tr>
	<?php 
	
	$r = $bd->bbdd_query($sql);
	$i=0;
	while($row = $bd->bbdd_fetch($_pagi_result)) {
	?>
		<tr class="<?php  if($i%2) { ?>oscuro<?php  } else { ?>claro<?php  } ?>">
			<td><?php echo  $row["empresa"]; ?></td>
			<td class="delmod"><a href="<?php echo $seguridad->obternerUrl("empresasAgregar.php",array("id"=>$row["id_empresa"],"tipo"=>1))?>"><img src="images/ico-editar.gif"/></a></td>
			<td class="delmod"><a href="<?php echo $seguridad->obternerUrl("empresasProcesar.php",array("id"=>$row["id_empresa"],"tipo"=>2))?>" onclick="return SEGURIDAD.verifBorrar();"><img src="images/ico-borrar.gif"/></a></td>
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